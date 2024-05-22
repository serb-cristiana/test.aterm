<?php
session_start();
$_SESSION['pag'] = 'asteptare';
include 'functii.php';
VerificareOcolireLogin();
if (VedeComenziAsteptare() == FALSE) {die('Forbiden acces!');};
ConectareBd();
$filtruComenzi = SeteazaFiltreComenzi();
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
<body><?php

include 'meniu.php';

$sqlStr = "
  SELECT co.ID, co.Nume AS Nume, co.IDDealer AS IDDealer, co.IDClient AS IDClient,  d.Nume AS NumeDealer, c.Nume AS NumeClient,
  co.DataCreare, co.DataAcceptare, l.Nume AS NumeLivrare,
  uc.Nume AS UtilizatorCreare, ua.Nume AS UtilizatorAcceptare
  FROM asteptare AS co 
  LEFT JOIN clienti AS c ON co.IDClient = c.ID 
  LEFT JOIN dealeri AS d ON co.IDDealer = d.ID 
  LEFT JOIN livrare AS l ON co.IDLivrare = l.ID 
  LEFT JOIN utilizatori AS uc ON co.IDResponsabil = uc.ID
  LEFT JOIN utilizatori AS ua ON co.IDUtilizatorAcceptare = ua.ID
  WHERE co.ID > 0 AND co.DataAcceptare IS NULL AND co.Anulata=0  
  ".$filtruComenzi."    
  ORDER BY co.ID DESC;";
 $dateLucrare = $conbd->query($sqlStr);  
?>
  
  <div class="container-fluid underFirstNavbar"> 
  <table class="table table-hover table-striped table-condensed fixed-header">
    <thead>
      <tr>
        <th class="width05">              </th>
        <th class="width05">Nr. crt.            </th>
        <th class="width15">Nume partener   </th>
        <th class="width15">Nume client   </th>
        <th class="width15">Nume comanda  </th>
        <th class="width15">Creata de     </th>
        <th class="width10">Creata in     </th>
        <th class="width15">Oras<br>livrare     </th>
        <th class="width07">Fisiere       </th>
      </tr>
    </thead>
    <tbody> <?php
      while ($row = $dateLucrare->fetch_assoc()){?>
      <tr <?php if(AreObservatii($row['ID'], $conbd, 0)){echo 'class="text-info "';};?>>
        <td>
          <div class="btn-group btn-group-xs" role="group">
           <!-- butonul de modificare comanda -->           
            <button
              type="button"
              title="Editeaza comanda asteptare"      
              class="btn btn-default <?php if(ModificaComenziAsteptare() == FALSE){echo ' hidden';}?>" 
              onclick="ArataFormaMCA(<?php echo $row['ID'];?>);">
              <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            </button>        
            <button
              type="button"
              title="Aproba comanda asteptare"      
              class="btn btn-default <?php if(AprobaCA() == FALSE){echo ' hidden';}?>" 
              onclick="AprobaCA(<?php echo $row['ID'];?>);">
              <span class="glyphicon glyphicon-share" aria-hidden="true"></span>
            </button>        
          </div>          
        </td>
        <td><?php echo $row['ID'];                  ?></td>
        <td><?php echo $row['NumeDealer'];          ?></td>
        <td><?php echo $row['NumeClient'];          ?></td>
        <td><?php echo $row['Nume'];                ?></td>
        <td><?php echo $row['UtilizatorCreare'];    ?></td>
        <td><?php echo FDate($row['DataCreare']);   ?></td>
        <td><?php echo $row['NumeLivrare'];         ?></td>
        <td>
          <?php include 'butoaneFisiere.php'?>
        </td>
      </tr><?php
      }?>
    </tbody>     
  </table>
</div>
</body>
</html>
<?php $conbd->close();?>