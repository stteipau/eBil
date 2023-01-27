<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>eBil</title>
        <link rel="stylesheet" href="src/style.css">
        <link rel="stylesheet" href="src/menu.css">

        <!--Für bootstrap-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!----------------->
        <?php
            require "src/functions.php";
        ?>
    </head>
    <body>
        <div class="header">

            <div class="acc_container" onclick="console.log(document.getElementById('acc_toggle').checked);">
                <input class="acc_toggle" id="acc_toggle" type="checkbox"/>
                <label for="acc_toggle" class="for_acc_toggle">
                    <?php
                        if(isset($_COOKIE['user']) && isset($_COOKIE['passwd']) &&  check($_COOKIE['user'],$_COOKIE['passwd'],false) && !isset($_POST['logout'])){
                            echo strtolower($_COOKIE['user']);
                        }else if(isset($_POST['user']) && isset($_POST['passwd']) && check($_POST['user'],$_POST['passwd'],true) && !isset($_POST['logout'])){
                            echo strtolower($_POST['user']);
                        }
                    ?>
                    <img class="acc_svg" src="src/icons/icon_account.svg">
                </label>

                <div class="login_window"><?php
                    if(isset($_POST['logout'])){//beim klick auf ausloggen Cookies löschen!
                        unset($_COOKIE['user']);
                        unset($_COOKIE['passwd']);
                        setcookie('user', null, -1, '/');
                        setcookie('passwd', null, -1, '/');
                    }

                    $pwPasst = false;
                    
                    if(isset($_COOKIE['user']) && isset($_COOKIE['passwd']) &&  check($_COOKIE['user'],$_COOKIE['passwd'],false)){
                        $pwPasst = true;
                    }else{
                        if(isset($_POST['user']) && isset($_POST['passwd']) && check($_POST['user'],$_POST['passwd'],true)){
                            //Passwort von Post passt!
                            setcookie('user', $_POST['user'], time()+ 60*60*24*1);
                            setcookie('passwd', crypt($_POST['passwd'],getUserSalt($_POST['user'])), time()+ 60*60*24*1);
                            $pwPasst = true;
                        }else{
                            if(isset($_POST['user']) && isset($_POST['passwd'])){
                                //Passwort stimmt nicht!
                                echo '<div style="color:#e60000;">Passwort oder Benutzername stimmt nicht</div>';
                            }
                        }
                    }
                    if($pwPasst == true){
                        //Passwort passt -> nur mehr auslogggen-Btn und resetPW-Btn ausgeben
                        $myfile = fopen("src/html/logoutAndReset.html", "r") or die("Unable to open file!");
                        echo fread($myfile,filesize("src/html/logoutAndReset.html"));
                    }else{
                        $myfile = fopen("src/html/loginWindow.html", "r") or die("Unable to open file!");
                        echo fread($myfile,filesize("src/html/loginWindow.html"));
                    }
                ?></div>
            </div>


        </div>
        <div class="hamburger-menu">
            <input id="menu__toggle" type="checkbox" />
            <label class="menu__btn" for="menu__toggle">
                <span></span>
            </label>

            <ul class="menu__box">
                <li><a class="menu__item" href="#">Home</a></li>
                <li><a class="menu__item" href="#">Produkt</a></li>
                <li><a class="menu__item" href="/notes.php">Tagebuch</a></li>
                <li><a class="menu__item" href="#">Entwicklung</a></li>
                <li><a class="menu__item" href="#">About us</a></li>
            </ul>
        </div>


    </body>
</html>

<style>
    body{
        background-color:#1e1e1e;
        color:#00e6ac;
        font-family:'Franklin Gothic Medium';
        margin:0;
    }
</style>
