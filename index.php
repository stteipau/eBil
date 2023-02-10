<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>eBil</title>
        <link rel="stylesheet" href="src/style.css">
        <link rel="stylesheet" href="src/menu.css">
        <link rel="stylesheet" href="src/footer.css">

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
        <div class="main-space">
            <div class="menu__btn__background"></div>
            <div class="header text_align_center">
                <a class="header_logo" href="/">
                    <img src="src/logo.PNG">
                </a>
                <div class="acc_container">
                    <label for="acc_toggle" class="for_acc_toggle justify_space_around">
                        <div><?php
                            if(isset($_COOKIE['user']) && isset($_COOKIE['passwd']) &&  check($_COOKIE['user'],$_COOKIE['passwd'],false) && !isset($_POST['logout'])){
                                echo strtolower($_COOKIE['user']);
                            }else if(isset($_POST['user']) && isset($_POST['passwd']) && check($_POST['user'],$_POST['passwd'],true) && !isset($_POST['logout'])){
                                echo strtolower($_POST['user']);
                            }
                        ?></div>
                        <img class="acc_svg" src="src/icons/icon_account.svg">
                    </label>
                    <input class="acc_toggle" id="acc_toggle" type="checkbox"/>

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
            <div class="work_space">
            <!--=============================Content================================-->


            <!--===========================Content Ende=============================-->
            </div>
        </div>
        <div class="hamburger-menu">
            <input id="menu__toggle" type="checkbox" onchange="menuToggled(this.checked);"/>
            
            <label class="menu__btn" for="menu__toggle">
                <span></span>
            </label>
            <ul class="menu__box">
                <li><a class="menu__item" href="#">Home</a></li>
                <li><a class="menu__item" href="/produkt.php">Produkt</a></li>
                <li><a class="menu__item" href="/notes.php">Tagebuch</a></li>
                <li><a class="menu__item" href="/entwicklung.php">Entwicklung</a></li>
                <li><a class="menu__item" href="/aboutUs.php">About us</a></li>
            </ul>
        </div>
        <footer class="footer-ebil justify_space_around" id="footer">
            <div class="container">
                <div class="col-md-4 col-sm-6 col-lg-4 footer-item">
                    <a href="/">Impressum</a>
                </div>
                <div class="col-md-4 col-sm-6 col-lg-4 footer-item">
                    <a href="mailto:ebilmotorsdevelopment@gmail.com">Kontakt</a>
                </div>
                <div class="col-md-4 col-sm-6 col-lg-4 footer-item">
                    <a href="/aboutUs.php">About us</a>
                </div>
            </div>
        </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        function menuToggled(flag){
            if(flag){
                document.getElementById("footer").classList.add("footer-ebil-small");
            }else{
                document.getElementById("footer").classList.remove("footer-ebil-small");
            }
        }
    </script>
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
