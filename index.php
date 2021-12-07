<?php
    session_start();

    class AuthenticatedUser{
        private $_login = "test";
        private $_password = "test";

        public function isUserAuth(){
            if(isset($_SESSION['user_auth'])){
                return $_SESSION['user_auth'];
            }
            else return false;
        }

        public function auth($login, $password){
            if($login == $this->_login && $password == $this->_password){
                $_SESSION['user_auth'] = true;
                $_SESSION['login'] = $login;
            }
            else{
                $_SESSION['user_auth'] = false;
                return false;
            }
        }

        public function getUserLogin(){
            if($this->isUserAuth()){
                return $_SESSION['login'];
            }
        }

        public function logOut(){
            $_SESSION = array();
            session_destroy();
        }
    }
    
    $auth = new AuthenticatedUser();

    if(isset($_POST['login'], $_POST['password'])){
        if($auth->auth($_POST['login'], $_POST['password']) === false){
            echo "<h2>Логил или пароль введен не правильно.</h2>";
        }
    }
    if(isset($_GET['exit'])){
        if($_GET['exit'] == 1){
            $auth->logOut();
            header("Location: ?exit=0");
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if($auth->isUserAuth()){
            echo "Здравствуйте " . $auth->getUserLogin();
            echo "<br><a href='?exit=1'>Выйти</a>";
        }
        else{
    ?>
    <form action="" method="post">
        <input type="text" name="login" placeholder="Введите ваш логин">
        <input type="password" name="password" placeholde="Введите ваш пароль">
        <button type="submit">Ввойти</button>
    </form>
    <?php
    }
    ?>
</body>
</html>