<html>
<head>

</head>

<body>

</body>

<?php

//echo "Hallo";
$user = "noah";
$arr = scandir("src/".$user);
//print_r($arr);
//echo count($arr);
for($i=0;$i<count($arr);$i++){
    //echo $arr[$i]."<br>";
    if(!is_dir($arr[$i])){
        //echo $arr[$i]."<br>";

        //Datei öffnen und in db Schreiben
        $filepath = "src/".$user."/".$arr[$i];

        $myfile = fopen($filepath, "r");
        $text = fread($myfile,filesize($filepath));
        if($text != ""){
            //echo $filepath."<br>";
            //echo $text;
            //echo $arr[$i]."<br>";
            echo "INSERT INTO Notes Values('".$user."','".explode(".",$arr[$i])[0]."','".$text."');";
            echo "<br>";
        }
    }
}


?>
</html>