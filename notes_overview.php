<html>
<?php
require 'src/functions.php';
if(!check($_COOKIE['user'],$_COOKIE['passwd'],false)){
    header("Location:login.php");
    exit();
}
?>

<head>
    <title>Tagebuchübersicht eBil</title>
</head>

<?php
    //alle Möglichkeiten
    $bothFilter = fetchData("joseph", "2022-12-07");
    $userFilter = fetchData("joseph", null);
    $dateFilter = fetchData(null, "2022-12-07");
    $noFilter = fetchData(null, null);
?>



<style>
    body{
        background-color:#1e1e1e;
        color:#00e6ac;
        font-family:'Franklin Gothic Medium';
    }
</style>

</html>