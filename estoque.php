<?php

require_once 'connection.php';

require_once 'header.php';

if(!isset($_SESSION)) {
    session_start();
}

abstractValidation::validatelogged();

?>


<body>
    <form action="" method="post">

        <select>
            
            <option>

            </option>
        </select>

    </form>
</body>
</html>