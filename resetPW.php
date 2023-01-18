<html>

<head>
    <title>Passwort zurücksetzen</title>
</head>
<body>
    <form name="form" action="" method="post">
        <label>Benutzername</label>
        <input value="<?php echo $_COOKIE["user"];?>" name="user" id="user" required>
        <label> Altes Passwort: </label>
        <input type="text" name="oldPW" id="oldPW" required>
        <label> Neues Passwort: </label>
        <input type="text" name="newPW1" id="newPW1" required>
        <input type="text" name="newPW2" id="newPW2" required>
        <input type="submit" name="sub" id="sub" value="ändern">
    </form>
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
