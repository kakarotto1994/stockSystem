<?php 

require_once 'connection.php';

if(!isset($_SESSION)) {
    session_start();
}

if( isset($_SESSION['logado']) ){
	header('Location: index.php');
}

$mysqli = new mysqli($host, $user, $pass, $db);
if($mysqli->connect_errno) {
    die("ERRO $mysqli->connect_errno, $mysqli->connect_error");
}

if(isset($_POST['user']) || isset($_POST['pass'])) {
    if(strlen($_POST['user']) < 2 || strlen($_POST['pass']) == 0) {
        echo "Caracteres insuficientes para usuário ou senha";
    } else {
        $user = $mysqli->real_escape_string($_POST['user']);
        $pass = $mysqli->real_escape_string($_POST['pass']);
        
        $query = "SELECT * FROM usuario where login = '$user' AND senha = '$pass'";
        $stmt = $mysqli->query($query) or die("ERRO: ".$mysqli->error);

        if($stmt->num_rows > 0) {
            $usuario = $stmt->fetch_assoc();

            $_SESSION['logado'] = array(
                'id'=>$usuario['id'],
                'login' =>$user,
                'nome'=>$usuario["nome"]
                );

            
            header("Location: /index.php");
        } else {
            echo "Usuário ou senha incorretos";
        }
        
    }
} 
?>


<body>
    <h2>Área de login</h2>
    <form action="" method="POST">
    <p>
        <label>Login</label>
        <input type="text" name="user">
    </p>

    <p>
        <label for="pass">Senha</label>
        <input type="password" name="pass">
    </p>

    <button type="submit">Logar</button>

    </form>
</body>

</html>