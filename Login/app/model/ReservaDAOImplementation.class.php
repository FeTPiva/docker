<?php

namespace app\model;

use app\classes\Reserva;
use app\model\ReservaDAOInterface;
use app\model\ConexaoDB;

class ReservaDAOImplementation implements ReservaDAOInterface
{

    public function getAllReservas()
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_reserva");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       // var_dump($result);

        $arrayReserva = null;
        if ( $stmt->rowCount() > 0 ) {
            $arrayReserva = array();
            foreach ($result as $row) {
                $ReservaTemp = new Reserva( $row );
                array_push($arrayReserva, $ReservaTemp);
            }            
        };

        return $arrayReserva;
    }

    public function getReservaById( $idReserva )
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_reserva where idReserva = :idReserva");
        $stmt->bindParam(":idReserva", $idReserva);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $ReservaTemp = null;
        if ( $stmt->rowCount() > 0 ) {
            $ReservaTemp = new Reserva( $result[0] );
        };

        return $ReservaTemp;
    }

  
    public function createReserva( Reserva $reservaInstancia, $idQuarto, $cpfCliente)
    {
        $valorDia = NULL;

        $connDB2 = new ConexaoDB();
        $stmt2 = $connDB2->con->prepare("Select precoDia from tbl_quarto where idQuarto = :idQuarto");

        $stmt2->bindParam(":idQuarto", $idQuarto);
        $stmt2->execute();

                            
        //Recuperar o conteúdo da tabela
        while ($row = $stmt2->fetch(\PDO::FETCH_ASSOC)) {

              //Extrair a linha da tabela
            extract($row);
            $reserva_item = array(

                "precoDia" => $row['precoDia']
            );
             
        }
        $valorDia= $reserva_item['precoDia'];
        var_dump($valorDia);



        $connDB3 = new ConexaoDB();
        $stmt3 = $connDB3->con->prepare("SELECT idCliente from tbl_cliente where cpf = :cpf");
        $stmt3->bindParam(':cpf', $cpfCliente);
        $stmt3->execute();

                            
        //Recuperar o conteúdo da tabela
        while ($row2 = $stmt3->fetch(\PDO::FETCH_ASSOC)) {

              //Extrair a linha da tabela
            extract($row2);
            $cliente_item = array(
                "idCliente" => $row2['idCliente']
            );
             
        }
        var_dump($cliente_item);
        $idCliente= $cliente_item['idCliente'];
                 
      
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("INSERT INTO tbl_reserva (idClienteReserva, idQuartoReserva, precoTotal,
         dataDia, dataMes, dataAno, qntDias)
         VALUES (:idClienteReserva, :idQuartoReserva, :precoTotal,
          :dataDia, :dataMes, :dataAno, :qntDias)");
        
        $stmt->bindParam(':idQuartoReserva', $idQuartoReserva);
        $stmt->bindParam(':idClienteReserva', $idCliente);
        $stmt->bindParam(':dataDia', $dataDia);
        $stmt->bindParam(':dataMes', $dataMes);
        $stmt->bindParam(':dataAno', $dataAno);
        $stmt->bindParam(':qntDias', $qntDias);
        $qntDias = $reservaInstancia->getQntDias();
        $precoTotal = $qntDias*$valorDia; 
               
        $stmt->bindParam(':precoTotal', $precoTotal);
   
        $idQuartoReserva = $reservaInstancia->getIdQuarto();
        $idClienteReserva = $reservaInstancia->getIdCliente();
        $dataDia = $reservaInstancia->getDataDia();
        $dataMes = $reservaInstancia->getDataMes();
        $dataAno = $reservaInstancia->getDataAno();
      
        $stmt->execute();


    }

    public function deleteReservaById( $idReserva ):bool
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("DELETE FROM tbl_reserva where idReserva = :idReserva");
        $stmt->bindParam(":idReserva", $idReserva);

        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );

    }

    public function updateReservaById( $idReserva, Reserva $reservaInstancia, $idQuarto, $cpfCliente):bool
    {

        $valorDia = NULL;

        $connDB2 = new ConexaoDB();
        $stmt2 = $connDB2->con->prepare("Select precoDia from tbl_quarto where idQuarto = :idQuarto");

        $stmt2->bindParam(":idQuarto", $idQuarto);
        $stmt2->execute();
                            
        //Recuperar o conteúdo da tabela
        while ($row = $stmt2->fetch(\PDO::FETCH_ASSOC)) {

            //Extrair a linha da tabela
            extract($row);
            $reserva_item = array(

                "precoDia" => $row['precoDia']
            );
        }
        $valorDia= $reserva_item['precoDia'];
        
        $connDB3 = new ConexaoDB();
        $stmt3 = $connDB3->con->prepare("SELECT idCliente from tbl_cliente where cpf = :cpf");
        $stmt3->bindParam(':cpf', $cpfCliente);
        $stmt3->execute();
                            
        //Recuperar o conteúdo da tabela
        while ($row2 = $stmt3->fetch(\PDO::FETCH_ASSOC)) {

              //Extrair a linha da tabela
            extract($row2);
            $cliente_item = array(
                "idCliente" => $row2['idCliente']
            );
             
        }
        $idCliente= $cliente_item['idCliente'];
        

        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("UPDATE tbl_reserva SET idQuartoReserva = :idQuartoReserva, 
        dataDia = :dataDia, dataMes = :dataMes, dataAno = :dataAno, qntDias = :qntDias, 
        precoTotal = :precoTotal WHERE idReserva = $idReserva");
          
        $stmt->bindParam(':idQuartoReserva', $idQuartoReserva);
        $stmt->bindParam(':dataDia', $dataDia);
        $stmt->bindParam(':dataMes', $dataMes);
        $stmt->bindParam(':dataAno', $dataAno);
        $stmt->bindParam(':qntDias', $qntDias);
        $qntDias = $reservaInstancia->getQntDias();
        $precoTotal = $qntDias*$valorDia;
        $stmt->bindParam(':precoTotal', $precoTotal);

        
        $idQuartoReserva = $reservaInstancia->getIdQuarto();
        $dataDia = $reservaInstancia->getDataDia();
        $dataMes = $reservaInstancia->getDataMes();
        $dataAno = $reservaInstancia->getDataAno();
        
        
        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );        
    }
}