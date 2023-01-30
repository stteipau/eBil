<?php
function checkf($userStr,$passwdStr){
    $handle = fopen("src/loginData.txt", "r");
    if($handle){
        while (($line = fgets($handle)) !== false) {
            $username = explode(';',$line)[0];
            $passwd = explode("\n",explode(";",$line)[1])[0];
            if($username === $userStr && $passwd == $passwdStr){
                return true;
            }
        }
        fclose($handle);
    }
    return false;
}

function check($userStr,$passwdStr,$hashIt){
    $db = new mysqli("10.10.30.40","root","Kennwort0","website");
    print_r($db->connect_error);

    $str = "SELECT * from LoginData WHERE LOWER(username) LIKE LOWER('".$userStr."');";
    $erg = $db->query($str);

    if($erg->num_rows > 0){
        $datensatz=$erg->fetch_assoc();
        //Vergleichen
        $inHash = $passwdStr;
        if($hashIt == true){
            $inHash = crypt($passwdStr,$datensatz['salt']);
        }

        if($inHash === $datensatz['pwHash']){
            return true;
        }
    }

    return false;
}
function pwReset($userStr, $passwdStr){
    $db = new mysqli("10.10.30.40","root","Kennwort0","website");
    print_r($db->connect_error);

    //Der Username muss theoretisch eingetragen sein (dennoch überprüfen mit der folgenden if)
    $str = "SELECT * from LoginData WHERE LOWER(username) LIKE LOWER('".$userStr."');";
    $erg = $db->query($str) or die ($db->error);

    if($erg->num_rows > 0){
        //Salt und PW ändern
        $newSalt = substr("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0, 63), 3);       //random salt generieren (mit länge 5)
        $inHash = crypt($passwdStr, $newSalt);
        //salt und pw in db schreiben
        $db->query("UPDATE LoginData SET pwHash = '" . $inHash . "', salt = '" . $newSalt . "' WHERE LOWER(username) LIKE LOWER('" . $userStr . "');");
        return true;
    }else{
        return false;
    }
}
function getUserSalt($username){
    $db = new mysqli("10.10.30.40","root","Kennwort0","website");
    print_r($db->connect_error);

    $str = "SELECT * from LoginData WHERE LOWER(username) LIKE LOWER('".$username."');";
    $erg = $db->query($str);

    if($erg->num_rows > 0){
        $datensatz=$erg->fetch_assoc();
        return $datensatz['salt'];
    }
    return "xxx";
}


function fetchData($username, $date){
    $db = new mysqli("10.10.30.40","root","Kennwort0","website");       //Array ( [0] => Array ( [0] => damian [1] => 2022-11-16 [2] => Vorlage Sponsorengeld Anfrage ) [1] => Array ( [0] => ...
    print_r($db->connect_error);

    if($username == null && $date == null){
        //nach nichts filtern
        $erg = $db->query("SELECT * from Notes");
    }else if($username == null){
        //nach datum filtern
        $erg = $db->query("SELECT username, text from Notes WHERE date = '" . $date ."'");
    }else if($date == null){
        //nach username filtern
        $erg = $db->query("SELECT date, text from Notes WHERE username = '" . $username ."'");
    }else{
        //nach beiden filtern
        $erg = $db->query("SELECT text from Notes WHERE username = '" . $username ."' AND date = '" . $date ."'");
    }

    $data = $erg->fetch_all();
    return $data;
}
?>