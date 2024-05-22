<?php
session_start();
$_SESSION['pag'] = 'clienti';
include 'functii.php';
VerificareOcolireLogin();
if (VedePF() == FALSE) {die('Forbiden acces!');};
ConectareBd();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Production Management System Administrator - Persoane Fizice</title>

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
  
  </head>
<body><?php

include 'meniu.php';

$date = $conbd->query("SELECT d.ID AS ID, d.Nume AS Nume, "
  . "d.Adresa AS Adresa, d.TelMobil AS TelMobil, "
  . "d.CNP AS CNP, d.CUI AS CUI, d.RC AS RC, d.email AS email, "
  . "d.Banca AS Banca, d.Cont AS Cont, d.Activ AS Activ, d.IDLivrare AS IDLivrare, "
  . "d.IDResponsabil AS IDResponsabil, u.Nume AS Responsabil, l.Nume AS OrasLivrare  "
  . "FROM clienti AS d "
  . "LEFT JOIN livrare AS l ON d.IDLivrare = l.ID "
  . "LEFT JOIN utilizatori AS u ON d.IDResponsabil = u.ID "
  . "ORDER BY d.Activ DESC, d.Nume ASC");?>
  
  <div class="container-fluid underFirstNavbar"> 
    <table class="table table-hover table-striped table-condensed fixed-header">
      <thead>
        <tr>
          <th class="width02"></th>
          <th class="width15">Nume client </th>
          <th class="width10">Oras<br>livrare    </th>
          <th class="width10">Adresa<br>livrare    </th>
          <th class="width10">Telefon </th>  
          <th class="width20">E-mail          </th>
          <th class="width10">Responsabil    </th>
        </tr>
      </thead>
      <tbody><?php    
      while ($row=$date->fetch_assoc()){?>
        <tr class="<?php if ($row['Activ'] == 0){echo 'danger';};?>">
          <td>
          <!------------------- butonul de modificare si forma modala care apare la apasarea lui -------------------------->
            <a class="btn btn-default btn-xs <?php if(ModificaPF() == FALSE){echo ' hidden';}?>" 
              title="Editeaza pf"      
              data-toggle="modal" data-target="#modificarePF<?php echo $row['ID']; ?>">
              <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            </a>
          <!-- Modal -->
          <div class="modal fade" 
              id="modificarePF<?php echo $row['ID']; ?>" 
              tabindex="-1" role="dialog" 
              aria-labelledby="myModalLabel<?php echo $row['ID']; ?>">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editare client <?php echo $row['Nume']; ?></h4>
                  <div class="alert alert-danger collapse js-div-info">
                    <a href="#" class="close js-a-close">&times</a>
                    <strong class="js-info1">Eroare/Succes </strong><span> </span><span class="js-info2"></span>
                  </div>                    
                </div>
                
                <form class="form-horizontal">
                  <input type="hidden" id="ID<?php echo $row['ID']; ?>" value="<?php echo $row['ID']; ?>" />
                  <div class="modal-body">    
                    <div class="form-group">
                      <label for="Adresa" class="col-sm-3 control-label">Adresa:</label>
                      <div class="col-sm-3">
                        <input 
                          type="text" 
                          class="form-control" 
                          id="Adresa<?php echo $row['ID']; ?>"
                          value="<?php echo $row['Adresa']; ?>" />
                      </div>
                      <label for="CUI" class="col-sm-3 control-label">CUI:</label>
                      <div class="col-sm-3">
                        <input 
                          type="text" 
                          class="form-control" 
                          id="CUI<?php echo $row['ID']; ?>"
                          value="<?php echo $row['CUI']; ?>" />
                      </div>
                    </div> 

                    <div class="form-group">
                      <label for="RC" class="col-sm-3 control-label">Registrul Comertului:</label>
                      <div class="col-sm-3">
                        <input 
                          type="text" 
                          class="form-control" 
                          id="RC<?php echo $row['ID']; ?>"
                          value="<?php echo $row['RC']; ?>" />
                      </div>
                      <label for="Banca" class="col-sm-3 control-label">Banca:</label>
                      <div class="col-sm-3">
                        <input 
                          type="text" 
                          class="form-control" 
                          id="Banca<?php echo $row['ID']; ?>"
                          value="<?php echo $row['Banca']; ?>" />
                      </div>
                    </div> 

                    <div class="form-group">
                      <label for="Cont" class="col-sm-3 control-label">Cont:</label>
                      <div class="col-sm-3">
                        <input 
                          type="text" 
                          class="form-control" 
                          id="Cont<?php echo $row['ID']; ?>"
                          value="<?php echo $row['Cont']; ?>" />
                      </div>
                      <label for="TelMobil" class="col-sm-3 control-label">Telefon:</label>
                      <div class="col-sm-3">
                        <input 
                          type="text" 
                          class="form-control" 
                          id="TelMobil<?php echo $row['ID']; ?>"
                          value="<?php echo $row['TelMobil']; ?>" />
                      </div>                      
                    </div> 

                    <div class="form-group">
                      <label for="email" class="col-sm-3 control-label">E-mail:</label>
                      <div class="col-sm-3">
                        <input 
                          type="email" 
                          class="form-control" 
                          id="email<?php echo $row['ID']; ?>"
                          value="<?php echo $row['email']; ?>" />
                      </div>
                      <label for="IDLivrare" class="col-sm-3 control-label">Oras livrare:</label>
                      <div class="col-sm-3">
                        <select class="form-control" id="IDLivrare<?php echo $row['ID']; ?>" name="IDLivrare<?php echo $row['ID']; ?>">
                          <?php $dd = $conbd->query ("SELECT ID, Nume FROM livrare ORDER BY Nume;");?>
                          <option value="0">Alege oras de livrare</option><?php
                          while ($rd = $dd->fetch_assoc()){?>
                          <option value="<?php echo $rd['ID']; ?>"  <?php if($rd['ID'] == $row['IDLivrare']){echo 'selected';};?>>
                            <?php echo $rd['Nume']; ?>
                          </option><?php 
                          }?>
                        </select>
                      </div>
                    </div> 

                    <div class="form-group">
                      <label for="CNP" class="col-sm-3 control-label">CNP:</label>
                      <div class="col-sm-3">
                        <input 
                          type="text" 
                          class="form-control" 
                          id="CNP<?php echo $row['ID']; ?>"
                          value="<?php echo $row['CNP']; ?>" />
                      </div>
                    </div>   

                    <div class="form-group">
                      <label for="IDResponsabil" class="col-sm-3 control-label">Responsabil:</label>
                      <div class="col-sm-3">
                        <select class="form-control" id="IDResponsabil<?php echo $row['ID']; ?>" name="IDResponsabil<?php echo $row['ID']; ?>">
                          <?php $dd = $conbd->query ('SELECT ID, Nume FROM utilizatori WHERE Firma="'.$_SESSION['producator'].'" ORDER BY Nume;');?>
                          <option value="0">Alege responsabil...</option><?php
                          while ($rd = $dd->fetch_assoc()){?>
                          <option value="<?php echo $rd['ID']; ?>"  <?php if($rd['ID'] == $row['IDResponsabil']){echo 'selected';};?>>
                            <?php echo $rd['Nume']; ?>
                          </option><?php 
                          }?>
                        </select>
                      </div>
                    </div>  

                    <div class="form-group">
                      <div class="col-sm-offset-6 col-sm-6">
                        <label>Activ
                          <input type="checkbox" 
                            id="mdActiv<?php echo $row['ID']; ?>"  
                            value="1"
                            <?php if ($row['Activ'] == '1') {echo 'checked';}?>>
                        </label>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
                    <button type="button" class="btn btn-primary" onclick="updateData('updatePF', <?php echo $row['ID']; ?>)">Salveaza</button>
                  </div>
                </form>                
              </div>
            </div>
          </div>
    
          </td>
          <td><div><?php echo  $row['Nume'];?>            </div></td>
          <td><div><?php echo  $row['OrasLivrare'];?>     </div></td>
          <td><div><?php echo  $row['Adresa'];?>     </div></td>
          <td><div><?php echo  $row['TelMobil'];?>        </div></td>	  
          <td><div><?php echo  $row['email'];?>           </div></td>
          <td><div><?php echo  $row['Responsabil'];?>    </div></td>   
        </tr>
      <?php
      }?>
      </tbody>
    </table>
  </div>
</body>
<?php $conbd->close();?>
</html>