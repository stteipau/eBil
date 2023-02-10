<?php
function check($userStr, $passwdStr, $hashIt){
    $db = new mysqli("10.10.30.40","root","Kennwort0","website");
    print_r($db->connect_error);

    //$str = "SELECT * from LoginData WHERE LOWER(username) LIKE LOWER('".$userStr."');";
    $str = "SELECT * from LoginData WHERE LOWER(username) LIKE LOWER(?);";
    $stmt = $db->prepare($str);
    $stmt->bind_param("s", $userStr);
    $stmt->execute();

    $erg = $stmt->get_result();

    if($erg->num_rows > 0){
        $datensatz = $erg->fetch_assoc();
        //Vergleichen
        $inHash = $passwdStr;
        if($hashIt == true){
            $inHash = crypt($passwdStr,$datensatz['salt']);
        }

        if($inHash === $datensatz['pwHash']){
            $db->close();
            $stmt->close();
            return true;
        }
    }
    $db->close();
    $stmt->close();
    return false;
}
function pwReset($userStr, $passwdStr){
    $db = new mysqli("10.10.30.40","root","Kennwort0","website");
    print_r($db->connect_error);

    //Der Username muss theoretisch eingetragen sein (dennoch überprüfen mit der folgenden if)
    $str = "SELECT * from LoginData WHERE LOWER(username) LIKE LOWER(?);";
    $stmt = $db->prepare($str);
    $stmt->bind_param("s", $userStr);
    $stmt->execute();

    $erg = $stmt->get_result();

    if($erg->num_rows > 0){
        //Salt und PW ändern
        $newSalt = substr("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0, 63), 3);       //random salt generieren (mit länge 5)
        $inHash = crypt($passwdStr, $newSalt);
        //salt und pw in db schreiben
        $stmt = $db->prepare("UPDATE LoginData SET pwHash = ?, salt = ? WHERE LOWER(username) LIKE LOWER(?);");
        $stmt->bind_param("sss", $inHash, $newSalt, $userStr);
        $stmt->execute();
        $db->close();
        $stmt->close();
        $res = true;
    }else{
        $res = false;
    }
    $db->close();
    $stmt->close();
    return $res;
}
function getUserSalt($username){
    $db = new mysqli("10.10.30.40","root","Kennwort0","website");
    print_r($db->connect_error);

    $str = "SELECT * from LoginData WHERE LOWER(username) LIKE LOWER(?);";
    $stmt = $db->prepare($str);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $erg = $stmt->get_result();

    if($erg->num_rows > 0){
        $datensatz = $erg->fetch_assoc();
        $db->close();
        $stmt->close();
        return $datensatz['salt'];
    }
    $db->close();
    $stmt->close();
    return "false";
}


function fetchData($username, $date){
    $db = new mysqli("10.10.30.40","root","Kennwort0","website");       //Array ( [0] => Array ( [0] => damian [1] => 2022-11-16 [2] => Vorlage Sponsorengeld Anfrage ) [1] => Array ( [0] => ...
    print_r($db->connect_error);

    if($username == null && $date == null){
        //nach nichts filtern
        $erg = $db->query("SELECT * from Notes;");
    }else if($username == null){
        //nach datum filtern
        $str = "SELECT username, text from Notes WHERE date = ?;";
        $stmt = $db->prepare($str);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $erg = $stmt->get_result();
    }else if($date == null){
        //nach username filtern
        $str = "SELECT date, text from Notes WHERE username = ?;";
        $stmt = $db->prepare($str);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $erg = $stmt->get_result();
    }else{
        //nach beiden filtern
        $str = "SELECT text from Notes WHERE username = ? AND date = ?;";
        $stmt = $db->prepare($str);
        $stmt->bind_param("ss", $username, $date);
        $stmt->execute();
        $erg = $stmt->get_result();
    }
    $data = $erg->fetch_all();
    $db->close();
    if($stmt)$stmt->close();
    return $data;
}
?>