<?php
session_start();
$_SESSION['pag'] = 'zoneLivrare';
include 'functii.php';
VerificareOcolireLogin();
if (VedeZoneLivrare() == FALSE) {die('Forbiden acces!');};
ConectareBd();
?>

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
$date = $conbd->query("SELECT * FROM livrare ORDER BY Nume");?>
<div class="container-fluid underFirstNavbar"> 
    <table class="table table-hover table-striped table-condensed fixed-header">
      <thead>
        <tr>
          <th class="width03"></th>
          <th class="width10">Țara    </th>
          <th class="width10">Nume oras    </th>
          <th class="width15">Descriere traseu </th>
          <th class="width05">Distanta            </th>  
        </tr>
      </thead>
      <tbody><?php
      while ($row=$date->fetch_assoc()){?>
        <tr>
          <td>
            <!------------------- butonul de modificare si forma modala care apare la apasarea lui -------------------------->
            <a class="btn btn-default btn-xs <?php if(ModificaZoneLivrare() == FALSE){echo ' hidden';}?>" 
            data-toggle="modal" data-target="#modificareZonaLivrare<?php echo $row['ID']; ?>" 
            title="Editeaza zona livrare">
              <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            </a>
            <!-- Modal -->
            <div class="modal fade js-modificareZonaLivrare" 
                 id="modificareZonaLivrare<?php echo $row['ID']; ?>" 
                 tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel<?php echo $row['ID']; ?>">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editare oras <?php echo $row['Nume'];?> din <?php echo $row['Tara'];?></h4>
                    <div class="alert alert-danger collapse js-div-info">
                      <a href="#" class="close js-a-close">&times</a>
                      <strong class="js-info1">Eroare/Succes </strong><span> </span><span class="js-info2"></span>
                    </div>                    
                  </div>
                  <form class="form-horizontal">
                    <input type="hidden" id="ID<?php echo $row['ID'];?>" value="<?php echo $row['ID'];?>" />
                  <div class="modal-body">               
                    <div class="form-group">
                      <label for="Descriere" class="col-sm-2 control-label">Descriere traseu:</label>
                      <div class="col-sm-6">
                        <input 
                        type="text" 
                        class="form-control" 
                        id="Descriere<?php echo $row['ID'];?>"
                        value="<?php echo $row['Descriere'];?>" />
                      </div>
                      <label for="Distanta" class="col-sm-2 control-label">Distanta:</label>
                      <div class="col-sm-2">
                        <input 
                        type="text" 
                        class="form-control" 
                        id="Distanta<?php echo $row['ID'];?>"
                        value="<?php echo $row['Distanta'];?>" />
                      </div>
                    </div>  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
                    <button type="button" class="btn btn-primary" onclick="updateData('updateZonaLivrare', <?php echo $row['ID'];?>)">Salveaza</button>
                  </div>
                  </form>                
                </div>
              </div>
            </div>
            <!------------------- sfarsit butonul de modificare si forma modala care apare la apasarea lui -------------------------->       
          </td>
          <td><?php echo $row['Tara'];?></td>     
          <td><?php echo $row['Nume'];?></td>
          <td><?php echo $row['Descriere'];?></td>
          <td><?php echo $row['Distanta'];?></td>	    
        </tr>
        <?php
        }?>
      </tbody>
    </table>
  </div>
</body>
<?php $conbd->close();?>
</html>