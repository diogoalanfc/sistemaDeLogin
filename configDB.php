<?php

//Variáveis de conexão com o banco de dados

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "sistemaDelogin";

$conexão = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if($conexão->connect_error){
  //Se deu erro, mata a aplicação!
    die("Não foi possivel conectar ao banco de dados:" . $conexão->connect_error);
}else {
    //Só para dubug
    //echo"Conectado com sucesso!";
}

