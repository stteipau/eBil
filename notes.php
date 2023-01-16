<html>
  <?php
    require 'src/functions.php';
    if(!check($_COOKIE['user'],$_COOKIE['passwd'])){
      header("Location:login.php");
      exit();
    }
  ?>
  <head>
    <title>Tagebucheinträge eBil</title>
  </head>

  <body>
    <div class="space-between">
      <div class="date-choice-container">
        <div class="date-choice-text">Datum wählen:</div>
        <form name="form" action="" method="post">
          <input class="date-input" type="date" min="2022-11-16" value="<?php
              echo getCurrentDate();
            ?>" name="date" id="date">
          <br>
          <input class="loggout-btn date-search" type="submit" name="sub" id="sub" value="suchen">
        </form>
      </div>

      <div><img class="logo-img" src="src/logo.PNG"></div>
      
      <div class="info-container">
        <div class="logged-in-as">
          Angemeldet als:
          <div class="text-label"><?php echo strtolower($_COOKIE['user']);?></div>
        </div>
        <form name="form" action="" method="post">
          <input class="loggout-btn" type="submit" name="logout" id="logout" value="ausloggen">
        </form>
      </div>
    </div>

    <div class="workspace">
      <div class="container" style="margin-top:10px;">
        <div class="text">
          <?php echo getCurrentDate();?>
        </div>
      </div>
      <?php
        //echo 'text:'.$_POST['text'].'<br>';
        //echo 'cDate:'.$_POST['cDate'].'<br>';
        //echo 'date:'.$_POST['date'].'<br>';
        if(isset($_POST['text'])){
          $db = new mysqli("10.10.30.40","root","Kennwort0","website");
          $str = "SELECT * FROM Notes WHERE username='".$_COOKIE['user']."' and date='".getCurrentDate()."'";
          $erg = $db->query($str);
          if($erg->num_rows == 0){
              print_r($db->connect_error);
              $str = "INSERT INTO Notes VALUES(LOWER('". $_COOKIE['user']. "'),'".getCurrentDate() . "','".$_POST['text']."');";
              $erg = $db->query($str);
          }else if($erg->num_rows == 1){
              $str = "UPDATE Notes SET text='".$_POST['text']. "' WHERE username='".$_COOKIE['user']."' and date='".getCurrentDate()."';";
              $erg = $db->query($str);
          }
        }
        function getCurrentDate(){
          if(isset($_POST['date']) && DateTime::createFromFormat('Y-m-d', $_POST['date']) !== false && $_POST['date']>='2022-11-16'){
            return $_POST['date'];
          }else if(isset($_POST['cDate']) && DateTime::createFromFormat('Y-m-d', $_POST['cDate']) !== false && $_POST['cDate']>='2022-11-16'){
            return $_POST['cDate'];
          }else{
            return date("Y-m-d");
          }
          return "null";
        }
      ?>
      <form name="form" action="" method="post">
        <textarea class="tagebucheintrag" name="text" id="text" rows="30" cols="100"><?php
          //Richrige Dateipfad zusammenschuastern
            $db = new mysqli("10.10.30.40","root","Kennwort0","website");
            $str = "SELECT * FROM Notes WHERE username='".$_COOKIE['user']."' and date='".getCurrentDate()."'";
            $erg = $db->query($str);
            if($erg->num_rows > 0){
                $datensatz=$erg->fetch_assoc();
                echo $datensatz['text'];
            }
        ?></textarea>
        <input class="hidden" type="date" value="<?php echo getCurrentDate();?>" name="cDate" id="cDate">
        <br>
        <div class="container" style="margin-top:5px;"><input class="saveBtn" type="submit" value="Speichern" name="subText" id="subText"></div>
      </form>
    </div>
    
    <?php
      if(isset($_POST['logout'])){
        unset($_COOKIE['user']);
        unset($_COOKIE['passwd']);
        setcookie('user', null, -1, '/');
        setcookie('passwd', null, -1, '/');
        header("Location:login.php");
        exit();
      }
    ?>

    
    
  </body>

<script>

</script>

<style>
  .logo-img{
    width:300px;
  }
  .space-between{
    justify-content:space-between;
    display: flex;
  }
  .space-between>div{
    /*display:inline;*/
  }
  .tagebucheintrag{
    /*width:500px;
    height:500px;*/
    border-radius:5px;
    background-color:#666666;
    border:none;
    color:white;
    font-family:'Franklin Gothic Medium';
    margin-top:5px;
    width:100%;
    resize: none;
  }
  .tagebucheintrag:focus{
    outline:2px solid #00e6ac;
  }
  
  .workspace{
    width:70%;
    margin-left:15%;
  }


  .hidden{
    display:none;
  }


  body{
    background-color:#1e1e1e;
    color:#00e6ac;
    font-family:'Franklin Gothic Medium';
  }
  .text-label{
    background-color:#3c3c3c;
    width:auto;
    margin-bottom:5px;
    border-radius:5px;
    height:25px;
    line-height: 25px;
    text-align:center;
  }
  .logged-in-as{
    width:80%;
    margin-left:10%;
    margin-top:10px;
  }
  .info-container{
    /*float:right;*/
    background-color:#666666;
    border-radius:10px;
    border:2px solid #222222;
    /*padding:10px;*/
    width:15%;
    height:100px;
    
  }
  .date-choice-container{
    background-color:#666666;
    border-radius:10px;
    border:2px solid #222222;
    /*padding:10px;*/
    width:12%;
    height:90px;
  }
  .date-input{
    font-family:'Franklin Gothic Medium';
    background-color:#3c3c3c;;
    color:white;
    border:none;
    border-radius:5px;
    height:25px;
    width:80%;
    margin-left:10%;
    cursor:pointer;
  }
  .date-input:focus{
    outline:2px solid #00e6ac;
  }
  .date-search{
    font-family:'Franklin Gothic Medium';
    margin-top:5px;
  }
  .date-choice-text{
    width:80%;
    margin-left:10%;
    margin-top:5px;
  }
  .saveBtn{
    width:100%;
    height:40px;
    color:#00e6ac;
    border:none;
    border-radius:5px;
    background-color:#3c3c3c;
    font-family:'Franklin Gothic Medium';
    font-size:16px;
    cursor:pointer;
  }
  .saveBtn:hover{
    background-color:#4d4d4d;
  }
  .saveBtn:active{
    background-color:#595959;
  }
  .loggout-btn{
    color:#00e6ac;
    width:80%;
    margin-left:10%;
    border:none;
    border-radius:5px;
    height:30px;
    background-color:#3c3c3c;
    font-family:'Franklin Gothic Medium';
    font-size:16px;
    cursor:pointer;
  }
  .loggout-btn:hover{
    background-color:#4d4d4d;
  }
  .loggout-btn:active{
    background-color:#595959;
    margin-top:2.5px;
    /*width:195px;
    height:25px;*/
  }
  .container{
    background-color:#666666;
    border-radius:5px;
    width:150px;
    padding:5px;
  }
  .text{
    background-color:#3c3c3c;
    text-align:center;
    border-radius:5px;
    height:25px;
    line-height:25px;
  }
</style>
</html>

<!--

    Tagebuch bearbeiten
    <input type="date"  min="2022-11-16">
    <a class="link" href="http://10.10.30.40/tagebuch.php?user=<?php //echo $_GET['user'];?>">
      <div class="loginBtn">Eintrag Bearbeiten<div>
    </a>

-->