<?php
session_start();
$_SESSION['pag'] = 'productie';
include 'functii.php';
VerificareOcolireLogin();
if (VedeProductie() == FALSE) {die('Forbiden acces!');}
ConectareBd();
$filtruComenzi = SeteazaFiltreComenzi();

//gasire nr. linii tabel
$data = $_SESSION['DeLaDaLi'];
$dataSf = date('Y-m-d', strtotime($data.'+ 6 days'));
$sqlStr = '';
$sqlStr = $sqlStr.'SELECT MAX(linii) AS maxLinii FROM ';
$sqlStr = $sqlStr.' (SELECT COUNT(DataLivrare) AS linii FROM comenzi AS co';
$sqlStr = $sqlStr.' WHERE DataLivrare >= "'.$data.'" AND DataLivrare <= "'.$dataSf.'" ';
$sqlStr = $sqlStr.' '.$filtruComenzi.' ';
$sqlStr = $sqlStr.' GROUP BY DataLivrare) ';
$sqlStr = $sqlStr.' AS lc';
//echo '<br><br><br><br>'.$sqlStr;
$maxL = $conbd->query($sqlStr);
$row = $maxL->fetch_assoc();
$nrLinii = $row['maxLinii'];
//echo '<br><br><br><br>'.$filtruComenzi;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Production Management System</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- jQuery -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link href="css/pms.layout.css" rel="stylesheet" type="text/css">
    <link href="css/datepicker.css" rel="stylesheet" type="text/css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script language="JavaScript" type="text/javascript" src="js/pms.functions.js"></script>
    <script language="JavaScript" type="text/javascript" src="js/datepicker.js"></script>

    <!-- Data tables -->    
    <!--link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/dt-1.10.13/fh-3.1.2/datatables.min.css"/--> 
    <!--script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/dt-1.10.13/fh-3.1.2/datatables.min.js"></script-->    
  </head>  

<body>
  <?php include 'meniu.php';?>
 <div class="container-fluid underFirstNavbar"> 
  <table class="table table-condensed table-bordered fixed-header">
    <thead class="">
      <tr><?php?>
        <th style="border: 1px solid black;">
          <a href="#" onclick="ChangeWeek('previous');"><span class="glyphicon glyphicon-arrow-left"></span></a>
          Lu <?php echo FDate($data); $data = date('Y-m-d', strtotime($data.'+ 1 days'));?>
        </th>
        <th style="border: 1px solid black;">Ma  <?php echo FDate($data); $data = date('Y-m-d', strtotime($data.'+ 1 days'));?></th>
        <th style="border: 1px solid black;">Mi  <?php echo FDate($data); $data = date('Y-m-d', strtotime($data.'+ 1 days'));?></th>
        <th style="border: 1px solid black;">Jo  <?php echo FDate($data); $data = date('Y-m-d', strtotime($data.'+ 1 days'));?></th>
        <th style="border: 1px solid black;">Vi  <?php echo FDate($data); $data = date('Y-m-d', strtotime($data.'+ 1 days'));?></th>
        <th style="border: 1px solid black;">Sa  <?php echo FDate($data); $data = date('Y-m-d', strtotime($data.'+ 1 days'));?></th>
        <th style="border: 1px solid black;">
          Du  <?php echo FDate($data); $data = date('Y-m-d', strtotime($data.'+ 1 days'));?>
          <a href="#" onclick="ChangeWeek('next');"><span class="glyphicon glyphicon-arrow-right"></span></a>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php
        $data = $_SESSION['DeLaDaLi'];
        $mp   = array(0, 0, 0, 0, 0, 0, 0);
        $kg   = array(0, 0, 0, 0, 0, 0, 0);
        $fer  = array(0, 0, 0, 0, 0, 0, 0);
        $usi  = array(0, 0, 0, 0, 0, 0, 0);
        for($zi = 1; $zi <= 7; $zi++){        
        ?>        
        <td class="fara-padding" style="padding: 0px; border: 0px;">
          <table class="table table-condensed table-bordered fara-margin">
            <?php 
            $sqlStr = 'SELECT * FROM comenzi as co WHERE DataLivrare = "'.$data.'" '.$filtruComenzi.' AND Anulata=0 ORDER BY IDClient';
            //echo $sqlStr;
            $datePeZi = $conbd->query($sqlStr);
            $liniiOcupate = 0;
            while($row = $datePeZi->fetch_assoc()){?>
            <tr>
              <td style="cursor: pointer; border: 1px solid black; <?php echo FormatCell($row['Stadiu']);?>" 
                  <?php if(AreObservatii($row['ID'], $conbd, 1)){echo 'class="text-info "';}?>
                  onclick="ArataFormaMC(<?php echo $row['ID'];?>);"><?php
              echo $row['CodIntern'].' '.$row['CodIntern2'].' '.$row['Nume'];
              $mp[$zi - 1]  = $mp[$zi - 1]  + $row['Suprafata'];
              $kg[$zi - 1]  = $kg[$zi - 1]  + $row['Greutate'];
              $fer[$zi - 1] = $fer[$zi - 1] + $row['Ferestre'];
              $usi[$zi - 1] = $usi[$zi - 1] + $row['Usi'];
              $liniiOcupate++;
              ?>
              </td>
            </tr><?php
            }
            for($l=$liniiOcupate + 1; $l <= $nrLinii; $l++){
              echo '<tr><td style="border: 1px solid black;"> &nbsp </td></tr>';
            }
            ?>            
          </table>
        </td>
          <?php
          $data = date('Y-m-d', strtotime($data.'+ 1 days'));
        }        
        ?>          
      </tr>
    </tbody>       
  </table>
  <nav class="navbar navbar-default navbar-fixed-bottom">
    <div class="container-fluid">
      <table class="table table-condensed table-bordered">
        <thead>
          <tr>
            <?php
            for($i = 0; $i <= 6; $i++){
              echo '<th  style="border: 1px solid black;">'.$fer[$i]. ' fer, '.$usi[$i].' usi'.'</th>';
            }
            ?>
          </tr>
        </thead>  
      </table>
    </div>
</nav> 
</body>
<?php $conbd->close();?>
</html>