<?php

require_once 'connection.php';

require_once 'header.php';

if(!isset($_SESSION)) {
    session_start();
}

abstractValidation::validatelogged();
const TABLE_NAME = 'produtos';


?>

<body>
    <p> Bem vindo <?php echo $_SESSION['logado']['nome']; ?> </p>
</body>
</html>