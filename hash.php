<form name="form" action="" method="post">
    <div>Passwort:</div>
    <input type="text" name="passwd" id="passwd">
    <div>Salt:</div>
    <input type="text" name="salt" id="salt">
    <br>
    <input type="submit">
</form>
<?php
    if(isset($_POST['passwd']) && isset($_POST['salt'])){
        echo "Passwort:".$_POST['passwd']."<br>";
        echo "Salt:".$_POST['salt']."<br>";
        echo "Hash:".crypt($_POST['passwd'],$_POST['salt']);
    }

?>
