<html>

<head>
    <title>Passwort zurücksetzen</title>
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
        margin-top:4px;
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
        cursor:pointer;
    }
</style>
<body>
<a href="http://10.10.30.40/">
    <img class="logo-img" src="src/logo.PNG">
</a>

<div class="container">
    <form name="form" action="" method="post">
        <div class="text-tag" style="margin-top:10px">Benutzername</div>
        <input class="text-input" value="<?php echo $_COOKIE["user"];?>" name="user" id="user" required>

        <div class="text-tag"> Altes Passwort: </div>
        <input class="text-input" type="password" name="oldPW" id="oldPW" required>

        <div class="text-tag" style="margin-top:15px"> Neues Passwort: </div>
        <input class="text-input" type="password" name="newPW1" id="newPW1" required>
        <div class="text-tag">Passwort wiederholen:</div>
        <input class="text-input" type="password" name="newPW2" id="newPW2" required>
        <input style="margin-top:12px;" class="login-btn" type="submit" name="sub" id="sub" value="Bestätigen">
    </form>
    <div>
</body>

<?php
require 'src/functions.php';
//username per POST übergeben
if(isset($_POST["oldPW"]) && isset($_POST["newPW1"]) && isset($_POST["newPW2"]) && isset($_POST["user"])){
    $oldPW = $_POST["oldPW"];
    $newPW1 = $_POST["newPW1"];
    $newPW2 = $_POST["newPW2"];
    $username = $_POST["user"];

    //altes PW richtig?
    if(check($username, $oldPW)){
        //neue PW's gleich?
        if(strcmp($newPW1, $newPW2) == 0){
            //Passwort reset
            if(pwReset($username, $newPW1)){
                echo "Passwort wurde erfolgreich zurückgesetzt!";
            }else{
                echo "Es ist ein Fehler aufgetreten!";
            }
        }else{
            echo "PW'S UNGLEICH!";
        }
    }else{
        echo "FALSCHES PW!";
    }
}
?>

</html>
