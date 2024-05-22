<?php
session_start();
$_SESSION['pag'] = 'raportDeclaratii';
include 'functii.php';
VerificareOcolireLogin();
//if (VedeZoneLivrare() == FALSE) {die('Forbiden acces!');};
ConectareBd();
$filtruComenzi = SeteazaFiltreComenzi();
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

<body><?php 
 

include 'meniu.php';
$sqlStr = "SELECT 
  co.ID AS ID,
  co.IDClient AS IDClient, 
  COALESCE(de.Nume, cl.Nume) AS NumeClient,
  CASE
    WHEN IDClient > 10000 THEN 'performata'
    ELSE 'calitate'
  END AS TipDeclaratie,
  co.Nume AS Nume,
  co.Ferestre AS Ferestre,
  co.Usi AS Usi,  
  co.DataLivrare AS DataLivrare, 
  co.NrFactura AS NrFactura, 
  co.NrDeclCert AS NrDeclCert
  FROM comenzi AS co 
  LEFT JOIN dealeri AS de ON co.IDClient = de.ID
  LEFT JOIN clienti AS cl ON co.IDClient = cl.ID
  WHERE NrDeclCert > 0 AND DataLivrare >= '".UFDate($_SESSION['fiDeLa'])."'  AND DataLivrare <= '".UFDate($_SESSION['fiPaLa'])."'
  AND Anulata = 0 ORDER BY NrDeclCert ;";
$dateLucrare = $conbd->query($sqlStr);  
//echo '<br><br><br><br><br>'.$sqlStr;
?>

<div class="container-fluid underFirstNavbar"> 
    <h3 class="text-center">Raport certificate pe perioada: <?php echo $_SESSION['fiDeLa'].' - '.$_SESSION['fiPaLa'];?></h3>
    <table class="table table-hover table-striped table-condensed fixed-header">
     <thead>
        <tr>
          <th class="width05">Numar<br>certificat</th>
          <th class="width07">Data<br>certificat   </th>
          <th class="width10">Tip<br>certificat </th>
          <th class="width10">Nume<br>client           </th>  
          <th class="width10">Nume<br>comanda           </th>  
          <th class="width05">Numar<br>factura           </th>  
          <th class="width05">Numar<br>usi           </th>  
          <th class="width05">Numar<br>ferestre           </th>  
        </tr>
      </thead>
      <tbody><?php
      while ($row=$dateLucrare->fetch_assoc()){?>
        <tr>
          <td><?php echo $row['NrDeclCert'];?></td>
          <td><?php echo FDate($row['DataLivrare']);?></td>
          <td><?php echo $row['TipDeclaratie'];?></td>
          <td><?php echo $row['NumeClient'];?></td>
          <td><?php echo $row['Nume'];?></td>
          <td><?php echo $row['NrFactura'];?></td>
          <td><?php echo $row['Usi'];?></td>
          <td><?php echo $row['Ferestre'];?></td>	    
        </tr>
        <?php
        }?>
      </tbody>
    </table>
  </div>
</body>
<?php $conbd->close();?>
</html>