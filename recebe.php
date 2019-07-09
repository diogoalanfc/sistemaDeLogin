<?php // início de um script PHP.
//
//Importando as configurações do banco de dados
require_once 'configDB.php';

//Limpando os dados de entrada POST
function verificar_entrada($entrada){
    $saída = trim($entrada);//Remove aspas
    $saída = htmlspecialchars($saída);//Remove HTML
    $saída = stripcslashes($saída);//Remove barras
    return$saída;
}

if(isset($_POST['action'])&& $_POST['action'] == 'registro'){
    
    $nomeCompleto = verificar_entrada($_POST['nomeCompleto']);
    $nomeUsuário = verificar_entrada($_POST['nomeUsuario']);
    $emailUsuário = verificar_entrada($_POST['emailUsuario']);
    $senhaUsuário = verificar_entrada($_POST['senhaUsuario']);
    $senhaUsuárioConfirmar = verificar_entrada($_POST['senhaUsuarioConfirmar']);
    $criado = date("Y-m-d");//Cria Ano-mês-dia
    
    //Gerar um hash para as senhas
    $senha = sha1 ($senhaUsuário);
    $senhaConfirmar = sha1 ($senhaUsuárioConfirmar);
    
    //echo "Hash: " . $senha;
    
    //Conferencia de senha no back-end, no caso do javascript estar desabilitado
    if($senha != $senhaConfirmar){
        echo 'As senhas não conferem';
        exit();
    }else {
        //Verificando se o usuário existe no banco de dados
        //Usando MySQLi prepared statment
        $sql = $conexão-> prepare ("SELECT nomeUsuario , email FROM " . "usuario WHERE nomeUsuario = ? OR ". " email = ?");//Evitar SQL injection
        $sql->bind_param("ss", $nomeUsuário, $emailUsuário);
        $sql->execute();//Método do objeto$sql
        $resultado = $sql ->get_result();//Tabela do banco
        $linha = $resultado->fetch_array(MYSQLI_ASSOC);
        if ($linha['nomeUsuario'] == $nomeUsuário){
            echo "Nome {$nomeUsuário} indisponivel. ";
        }elseif ($linha['email'] == $emailUsuário) {
            echo "Email {$emailUsuário} indisponivel. "; 
            } else {
                //Preparar a inserção no banco de dados
                $sql = $conexão->prepare("insert into usuario (nome, nomeUsuario, email, senha, criado)values(?, ?, ?, ?, ?)");
                $sql->bind_param("sssss", $nomeCompleto, $nomeUsuário, $emailUsuário, $senha, $criado);
                if($sql->execute()){
                    echo "Cadastrado com sucesso!";
                }else{
                    echo "Algo deu errado. Por favor ,tente novamente.";
                }
            } 
    }    
    
    echo 
    $nomeCompleto . "" . $nomeUsuário . "" . $emailUsuário . "" . $senhaUsuário . "" . $senhaUsuárioConfirmar . "" . $criado;
    
    
    
}

