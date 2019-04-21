<?php

namespace app\model;

use \PDO;

class ConexaoDB {
    
    private $nomeServer;
	private $usuario;
	private $senha;
	private $dataBase;
    private $charset;
    public 	$con;

    function __construct() {
        $this->con = null;

        $this->nomeServer = "localhost";
		$this->usuario = "root";
		$this->senha = "senha666";
        $this->dataBase = "hotel";
        $this->charset = 'utf8mb4';
        $dsn = "mysql:host=$this->nomeServer;dbname=$this->dataBase;charset=$this->charset";


        $this->con = new PDO($dsn, $this->usuario, $this->senha);
	}
}

?>

