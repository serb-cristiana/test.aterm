<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Production Management System Administrator - Dealeri</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  
    <!-- jQuery -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link href="css/pms.layout.css" rel="stylesheet" type="text/css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script language="JavaScript" type="text/javascript" src="js/pms.functions.js"></script>
  </head>
<body>

<div class="container"><br><br><br><br>
  <?php    
  $utilizator = $_POST['utilizator'];
  $parola = $_POST['parola'];
  //Extragere date conectare MYSQL
  $date_conectare = file_get_contents('connect.php');
  echo $date_conectare;
  $date_con = explode("|", $date_conectare);
  $adresa_server = $date_con[1];
  $_SESSION['adresa_server']=$adresa_server;
  $user_mysql=$date_con[3];
  $_SESSION['user_mysql']=$user_mysql;
  $pass_mysql=$date_con[5];
  $_SESSION['pass_mysql']=$pass_mysql;
  $bd_mysql=$date_con[7];
  $_SESSION['bd_mysql']=$bd_mysql;
  $producator=$date_con[9];
  $_SESSION['producator']=$producator;
  $_SESSION['dbsize'] = $date_con[11] / (1024*1024);
  if($utilizator && $parola){
    $conbd = new mysqli($adresa_server, $user_mysql, $pass_mysql, $bd_mysql);
    $sqlStr = "SELECT * FROM utilizatori WHERE nume='".$conbd->real_escape_string($utilizator)."'";
    $result = $conbd->query($sqlStr);
    if($result->num_rows != 0){
      while ($row = $result->fetch_assoc()){
        //extragere user si parola aplicatie din tabela utilizatori
        $user = $row['Nume'];
        $id = $row['ID'];
        $firma = $row['Firma'];	  
        $pass = $row['Parola'];
        $activ = $row['Activ'];
        $Drepturi = $row['Drepturi'];
        $Meniuri = $row['Meniuri'];
      }
      //verificare user si parola introduse cu cele din tabela MYSQL
      if($utilizator==$user && $parola==$pass){ 
        if ($activ != 1){//daca utilizatorul e inactiv
          die('Inactiv user!');
        }  
        $_SESSION['nume'] = $utilizator;
        $_SESSION['idUtilizator'] = $id;
        $sqlStr = "SELECT ID FROM dealeri WHERE Nume='".$firma."'";    
        $result = $conbd->query($sqlStr);
        if($result->num_rows == 0){
          $id = 0;
        }else{
          while($row = $result->fetch_assoc()){
            $id = $row['ID'];      
          };
        }; 
        $arr = array($firma, $id);
        $_SESSION['firma'] = $arr;     
        $_SESSION['Drepturi'] = $Drepturi.'00000';
        $_SESSION['Meniuri'] = $Meniuri.'00000';      
        $dbsize = 0;
        $sqlStr2 = 'SHOW TABLE STATUS';
        $result2 = $conbd->query($sqlStr2);
        while($row2 = $result2->fetch_assoc()){
          $dbsize += $row2["Data_length"] + $row2["Index_length"];
        };
        $_SESSION['dbsize'] = round($dbsize / (1024*1024), 2).' din '.$_SESSION['dbsize'].' Mb';                
        if($_SESSION['Meniuri'][1] == '1'){ //pagina principala, comenzi  ????sa pun include functii.php?????
          echo '<script type="text/javascript">
                window.top.location.href = "comenzi.php";
                </script>';                  
        }elseif($_SESSION['Meniuri'][15] == '1'){ //pagina productie
          echo '<script type="text/javascript">
                window.top.location.href = "productie.php";
                </script>';
        }elseif($_SESSION['Meniuri'][6] == '1'){ //pagina utilizatori
          echo '<script type="text/javascript">
                window.top.location.href = "useri.php";
                </script>';
        }elseif($_SESSION['Meniuri'][9] == '1'){ //pagina dealeri
          echo '<script type="text/javascript">
                window.top.location.href = "dealeri.php";
                </script>';
        }elseif($_SESSION['Meniuri'][12] == '1'){ //pagina zone livrare
          echo '<script type="text/javascript">
                window.top.location.href = "zoneLivrare.php";
                </script>';
        }else{
          die('Forbiden acces!');
        };                
      }else{//daca parola e incorecta   
        echo '<div class="alert alert-danger text-center">
              <strong>Parola incorecta!</strong> 
              <br><a href="index.html">Inapoi</a>
              </div>';
      }            
    }else{//daca nu exista utilizatorul
      echo '<div class="alert alert-danger text-center">
            <strong>Utilizator inexistent!</strong> 
            <br><a href="index.html">Inapoi</a>
            </div>';
    }
  }else{//daca nu a fost introdus utilizator sau parola
    echo '<div class="alert alert-danger text-center">
          <strong>Introduceti utilizator si parola!</strong> 
          <br><a href="index.html">Inapoi</a>
          </div>';      
  }?>
</div>
</body>
</html>