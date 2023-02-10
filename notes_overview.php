<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tagebuchübersicht Ebil</title>
        <link rel="stylesheet" href="src/style.css">
        <link rel="stylesheet" href="src/menu.css">
        <link rel="stylesheet" href="src/footer.css">
        <link rel="stylesheet" href="src/notes_overviewStyle.css">

        <!--Für bootstrap-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!----------------->
        <?php
            require "src/functions.php";
        ?>
    </head>
    <body class="body">
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
                <div class="filter_box_container container justify_center">
                    <div class="filter_box col-xs-12 col-sm-10 col-md-8 col-lg-8">
                        <form name="form" action="" method="post">
                            <div class="justify_center">
                                <div class="filter_item">
                                    <div>Benutzer:</div>
                                    <div class="justify_center">
                                        <select class="name_selector" name="name_filter" id="name_filter" selected="<?php echo $_POST['name_filter'];?>">
                                            <option value="all">Alle</option>
                                            <option value="paul" <?php if($_POST['name_filter'] === "paul")echo 'selected';?>>Paul</option>
                                            <option value="joseph" <?php if($_POST['name_filter'] === "joseph")echo 'selected';?>>Joseph</option>
                                            <option value="jonas" <?php if($_POST['name_filter'] === "jonas")echo 'selected';?>>Jonas</option>
                                            <option value="noah" <?php if($_POST['name_filter'] === "noah")echo 'selected';?>>Noah</option>
                                            <option value="damian" <?php if($_POST['name_filter'] === "damian")echo 'selected';?>>Damian</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter_item">
                                    <div>Datum:</div>
                                    
                                    <div class="justify_center container">
                                        <div class="row justify_space_betweenn">
                                            <input class="date_filter col-xs-11 col-sm-11 col-md-6 col-lg-6" type="date"  name="date_filter" id="date_filter" value="<?php echo $_POST['date_filter'];?>">
                                            <div class="company_button reset_date_button col-xs-11 col-sm-11 col-md-5 col-lg-5" onclick="document.getElementById('date_filter').value='';">Datum zurücksetzen</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="justify_center">
                                <input type="submit" class="company_button filter_submit" value="suchen"> 
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="overview_table">
                    <table>
                        <tr>
                            <th>Datum</th>
                            <th>Schüler</th>
                            <th>Inhalt</th>
                        </tr>
                        <?php
                            if(!check($_COOKIE['user'],$_COOKIE['passwd'],false)){
                                header("Location:login.php");
                                exit();
                            }

                            if(isset($_POST['date_filter']) && $_POST['date_filter']!="" && isset($_POST['name_filter']) && $_POST['name_filter'] != "all"){
                                //bestimmter benutzer zu bestimmten datum

                                $data = fetchData($_POST['name_filter'], $_POST['date_filter']);                        
                                if($data[0][0]){
                                    //echo $data[0][0]."<br>";
                                    echo "<tr>";
                                        echo "<td>".$_POST['name_filter']."</td>";
                                        echo "<td>".$_POST['date_filter']."</td>";
                                        echo "<td>".$data[0][0]."</td>";
                                    echo "</tr>";
                                }else{
                                    echo "Keine Daten Gefunden!";
                                }
                            }else if(isset($_POST['date_filter']) && $_POST['date_filter']!=""){
                                //von bestimmten Datum Anzeigen
                                $data = fetchData(null,$_POST['date_filter']);
                                if(count($data)>0){
                                    for($i=0;$i<count($data);$i++){
                                        echo "<tr>";
                                            echo "<td>".$_POST['date_filter']."</td>";
                                            echo "<td>".$data[$i][0]."</td>";
                                            echo "<td>".$data[$i][1]."</td>";
                                        echo "</tr>";
                                    }
                                }else{
                                    echo "Keine Daten Gefunden!";
                                }
                            }else if(isset($_POST['name_filter']) && $_POST['name_filter'] != "all"){
                                //nur von einem Bestimmten Benutzer anzeigen
                                $data = fetchData($_POST['name_filter'], null);
                                if(count($data)>0){
                                    for($i=0;$i<count($data);$i++){
                                        echo "<tr>";
                                            echo "<td>".$data[$i][0]."</td>";
                                            echo "<td>".$_POST['name_filter']."</td>";
                                            echo "<td>".$data[$i][1]."</td>";
                                        echo "</tr>";
                                    }
                                }else{
                                    echo "Keine Daten Gefunden!";
                                }
                            }else{
                                //alle Anzeigen
                                $data = fetchData(null, null);;
                                
                                for($i=0;$i<count($data);$i++){
                                    //echo $data[$i][0].":".$data[$i][1]."-->".$data[$i][2]."<br>";
                                    echo "<tr>";
                                        echo "<td>".$data[$i][1]."</td>";
                                        echo "<td>".$data[$i][0]."</td>";
                                        echo "<td>".$data[$i][2]."</td>";
                                    echo "</tr>";
                                }
                                
                            }
                        ?>
                    </table>
                </div>
                
                

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
    
</style>
