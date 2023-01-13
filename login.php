<html><!--#2aeaa8;#1e1e1e-->
    <head>
        <title>Login eBil</title>
    </head>
    <style>
        body{
            background-color:#1e1e1e;
            color:#00e6ac;
            font-family:'Franklin Gothic Medium';
        }
        .login-btn{
            color:#00e6ac;
            width:200px;
            border:none;
            border-radius:5px;
            height:30px;
            background-color:#3c3c3c;
            font-family:'Franklin Gothic Medium';
            font-size:16px;
            cursor:pointer;
        }
        .login-btn:hover{
            background-color:#4d4d4d;
        }
        .login-btn:active{
            background-color:#595959;
            margin-top:2.5px;
            width:195px;
            height:25px;
        }
        .text-tag{
            width:250px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            font-size:20px;
            text-align:left;
        }
        .text-input{
            background-color:#3c3c3c;
            border-radius:5px;
            height:30px;
            width:250px;
            color:white;
            border:none;
            display: block;
            margin-left: auto;
            margin-right: auto;
            font-family:'Franklin Gothic Medium';
            font-size:15px;
        }
        .text-input:focus{
            border:none;
            outline:none;
            border:2px solid #0c0c0d;
            border-left:2px solid #18181a;
            border-top:2px solid #18181a;
        }
        .container{
            background-color:#666666;
            border-radius:10px;
            width:400px;
            height:300px;
            position: absolute;
            left: 50%;
            top: 50%;
            margin-left: -200px;
            margin-top: -250px;
            border:2px solid #222222;
            text-align:center;
        }
        .logo-img{
            width:200px;
        }
    </style>
    <body>
        <img class="logo-img" src="src/logo.PNG">
        <div class="container">
            <form name="form" action="" method="post">
                <div class="text-tag" style="margin-top:30px;">Benutzername:</div>
                <input class="text-input" type="text" name="user" id="user" value=""><br>
                <div class="text-tag">Kennwort:</div>
                <input class="text-input" type="password" name="passwd" id="passwd" value="">
                <br>
                <input class="login-btn" type="submit" value="Login">
            </form>
            
            <?php
                require 'src/functions.php';
                //echo "Hallo!";
                if(check($_COOKIE['user'],$_COOKIE['passwd'])){
                    echo "Hilfe";
                    header("Location:notes.php");
                    exit();
                }else{
                    //echo "Hilfe2";
                    setcookie('user', $_POST['user'], time()+ 60*60*24*1);
                    setcookie('passwd', $_POST['passwd'], time()+ 60*60*24*1);
                    if(check($_POST['user'],$_POST['passwd'])){
                        header("Location:notes.php");
                        exit();
                    }else{
                        if(isset($_POST['user']) && isset($_POST['passwd'])){
                            echo '<div style="color:#e60000;">Passwort oder Benutzername stimmt nicht</div>';
                        }
                    }
                }     
                
                //echo 'Inhalt des Post:'.$_POST['passwd'].'+'.$_POST['user'];
                //echo '<br>';
                //fwrite($myFile, "\n");
                //echo file_get_contents($filePath);
                //fclose($filePath);
                //echo 'Hallo Welt<br>';

            ?>
        </div>
        

    </body>
</html>


<!--
attribut action="index.php"
postet di informationen dorthin!!!!

-> wichtig für "angemeldet bleiben"-Button

-->