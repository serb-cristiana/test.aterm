<?php
session_start();
$_SESSION['pag'] = 'useri';
include 'functii.php';
VerificareOcolireLogin();
if (VedeUtilizatori() == FALSE) {die('Forbiden acces!');};
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

$date = $conbd->query("SELECT * FROM utilizatori ORDER BY Activ DESC, Nume ASC");?>
  <div class="container-fluid underFirstNavbar"> 
    <table class="table table-hover table-striped table-condensed fixed-header">
      <thead>
        <tr>
          <th class="width02"></th>
          <th class="width05">Nume utilizator</th>
          <th class="width05">Nume partener </th>
          <th class="width03">Parola</th> 
          <th class="width05">Email</th> 
          <th class="width05">Numar telefon </th>
        </tr>
      </thead>
      <tbody><?php
        while ($row = $date->fetch_assoc()){?>
        <tr>
          <td class="<?php if ($row['Activ'] == 0){echo 'danger';};?>">

            <!------------------- butonul de modificare si forma modala care apare la apasarea lui -------------------------->         
            <a  type="button" class="btn btn-default btn-xs <?php if(ModificaUtilizatori() == FALSE){echo ' hidden';}?>" 
            data-toggle="modal" data-target="#modificareUser<?php echo $row['ID']; ?>"
            title="Editeaza user">
              <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            </a>      
            <!-- pentru modal creat la click de folosit la pagina principala <button class="btn-xs" onclick="updateData('updateUser', <?php //echo $row['ID'];?>)">Modal</button>-->
            
            <!-- Modal -->
            <div class="modal fade" 
                 id="modificareUser<?php echo $row['ID']; ?>" 
                 tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel<?php echo $row['ID']; ?>">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editare utilizator <?php echo $row['Nume'];?> partener <?php echo $row['Firma'];?></h4>
                    <div class="alert alert-danger collapse js-div-info">
                      <a href="#" class="close js-a-close">&times</a>
                      <strong class="js-info1">Eroare/Succes </strong><span> </span><span class="js-info2"></span>
                    </div>                    
                  </div>
                  <form class="form-horizontal">
                      <input type="hidden" id="ID<?php echo $row['ID']; ?>" value="<?php echo $row['ID']; ?>" />
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="Parola<?php echo $row['ID']; ?>" class="col-sm-4 control-label">Parola:</label>
                          <div class="col-sm-4">
                            <input type="password" class="form-control" id="Parola<?php echo $row['ID']; ?>" value="<?php echo $row['Parola']; ?>" />
                          </div>
                          <br>
                          <form class="form-horizontal">
                      <input type="hidden" id="ID<?php echo $row['ID']; ?>" value="<?php echo $row['ID']; ?>" />
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="Email<?php echo $row['ID']; ?>" class="col-sm-4 control-label">Email:</label>
                          <div class="col-sm-4">
                            <input type="email" class="form-control" id="Email<?php echo $row['ID']; ?>" value="<?php echo $row['Email']; ?>" />
                          </div>
                          <br>
                          <form class="form-horizontal">
                      <input type="hidden" id="ID<?php echo $row['ID']; ?>" value="<?php echo $row['ID']; ?>" />
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="Telefon<?php echo $row['ID']; ?>" class="col-sm-4 control-label">Telefon:</label>
                          <div class="col-sm-4">
                            <input type="telefon" class="form-control" id="Telefon<?php echo $row['ID']; ?>" value="<?php echo $row['Telefon']; ?>" />
                          </div>
                          <br>
                      <label>Activ
                          <input type="checkbox" 
                          id="Activ<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Activ'] == '1') {echo 'checked';}?>>
                        </label>
                    </div>
                    <div class="form-group">
                      <!--meniuri-->
                      <div class="col-sm-6 text-right">
                        <h4> Meniuri disponibile</h4>
                        <label>Vede comenzi
                          <input type="checkbox" 
                          id="VedeComenzi<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][1] == '1') {echo 'checked';}?>>
                        </label><br>              
                        <label>Vede doar comenzile proprii
                          <input type="checkbox" 
                          id="VedeDoarComenzileProprii<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][30] == '1') {echo 'checked';}?>>
                        </label><br>              
                        <label> Comanda noua
                          <input type="checkbox" 
                          id="ComandaNoua<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][2] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Modifica comanda
                          <input type="checkbox" 
                          id="ModificaComanda<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][3] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Tipareste contract
                          <input type="checkbox" 
                          id="TiparesteContract<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][4] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Tipareste declaratii
                          <input type="checkbox" 
                          id="TiparesteDeclaratii<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][19] == '1') {echo 'checked';}?>>
                        </label><br>                        
                        <label> Tipareste aviz insotire
                          <input type="checkbox" 
                          id="TiparesteAvizInsotire<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][28] == '1') {echo 'checked';}?>>
                        </label><br>                        
                        <label> Comanda noua pentru dealeri
                          <input type="checkbox" 
                          id="ComandaNouaPentruDealeri<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][5] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Vede utilizatori
                          <input type="checkbox" 
                          id="VedeUtilizatori<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][6] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Adauga utilizatori
                          <input type="checkbox" 
                          id="AdaugaUtilizatori<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][7] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Modifica utilizatori
                          <input type="checkbox" 
                          id="ModificaUtilizatori<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][8] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Vede dealeri
                          <input type="checkbox" 
                          id="VedeDealeri<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][9] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Adauga dealeri
                          <input type="checkbox" 
                          id="AdaugaDealeri<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][10] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Modifica dealeri
                          <input type="checkbox" 
                          id="ModificaDealeri<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][11] == '1') {echo 'checked';}?>>
                        </label><br>  
                        <label> Vede persoane fizice
                          <input type="checkbox" 
                          id="VedePF<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][9] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Adauga persoane fizice
                          <input type="checkbox" 
                          id="AdaugaPF<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][10] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Modifica persoane fizice
                          <input type="checkbox" 
                          id="ModificaPF<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][11] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Vede zone livrare
                          <input type="checkbox"
                          id="VedeZoneLivrare<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][12] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Adauga zone livrare
                          <input type="checkbox" 
                          id="AdaugaZoneLivrare<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][13] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Modifica zone livrare             
                          <input type="checkbox" 
                          id="ModificaZoneLivrare<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][14] == '1') {echo 'checked';}?>>
                        </label><br>               
                        <label> Vede productie
                          <input type="checkbox" 
                          id="VedeProductie<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][15] == '1') {echo 'checked';}?>>
                        </label><br>                           
                        <label> Vede comenzi asteptare
                          <input type="checkbox" 
                          id="VedeComenziAsteptare<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][16] == '1') {echo 'checked';}?>>
                        </label><br>                           
                        <label> Adauga comenzi asteptare
                          <input type="checkbox" 
                          id="AdaugaComenziAsteptare<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][17] == '1') {echo 'checked';}?>>
                        </label><br>                           
                        <label> Modifica comenzi asteptare
                          <input type="checkbox" 
                          id="ModificaComenziAsteptare<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][18] == '1') {echo 'checked';}?>>
                        </label><br>                           
                        <!-- ATENTIE!!! Mai sunt meniuri mai jos!!!!!-->  
                      </div>
                      <!--stadiu comenzi-->
                      <div class="col-sm-6 text-left">
                        <h4> Acces stadiu comenzi</h4>
                        <label> 
                          <input type="checkbox" 
                          id="DataLivrare<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][1] == '1') {echo 'checked';}?>>Modifica data livrare
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                        id="DatPTam<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][2] == '1') {echo 'checked';}?>>Bifeaza dat productie tamplarie
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="DatPUmp<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][3] == '1') {echo 'checked';}?>>Bifeaza dat productie umplutura 
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="DatPAcc<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][4] == '1') {echo 'checked';}?>>Bifeaza dat productie accesorii 
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="TermTam<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][5] == '1') {echo 'checked';}?>>Bifeaza terminat tamplarie
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="TermUmp<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][6] == '1') {echo 'checked';}?>>Bifeaza terminat umplutura
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="TermAcc<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][7] == '1') {echo 'checked';}?>>Bifeaza terminat accesorii
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="OkFin<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][8] == '1') {echo 'checked';}?>>Bifeaza OK financiar 
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="Facturat<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][9] == '1') {echo 'checked';}?>>Bifeaza facturat 
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="Livrat<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][10] == '1') {echo 'checked';}?>>Bifeaza livrat
                        </label><br> 
                        <label>
                          <input type="checkbox" 
                          id="AprobaComenziAsteptare<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][11] == '1') {echo 'checked';}?>> Aproba comenzi asteptare
                        </label><br>                         
                        <label>
                          <input type="checkbox" 
                          id="AnuleazaComenziAsteptare<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][12] == '1') {echo 'checked';}?>> Anuleaza comenzi asteptare
                        </label><br> 
                        <label>
                          <input type="checkbox" 
                          id="AnuleazaComenzi<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Drepturi'][13] == '1') {echo 'checked';}?>> Anuleaza comenzi
                        </label><br> 
                        <h4> Acces fisiere</h4>                      
                        <label> 
                          <input type="checkbox" 
                          id="IncarcaCFU<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][20] == '1') {echo 'checked';}?>>Incarca CFU
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="DescarcaCFU<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][21] == '1') {echo 'checked';}?>>Descarca CFU
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="IncarcaFactura<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][22] == '1') {echo 'checked';}?>>Incarca factura
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="DescarcaFactura<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][23] == '1') {echo 'checked';}?>>Descarca factura
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="StergeFactura<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][29] == '1') {echo 'checked';}?>>Sterge factura
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="IncarcaDovadaPlata<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][24] == '1') {echo 'checked';}?>>Incarca dovada plata
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                         id="DescarcaDovadaPlata<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][25] == '1') {echo 'checked';}?>>Descarca dovada plata
                       </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="IncarcaFisierDiverse<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][26] == '1') {echo 'checked';}?>>Incarca fisier diverse
                        </label><br>                        
                        <label> 
                          <input type="checkbox" 
                          id="DescarcaFisierDiverse<?php echo $row['ID'];?>"  
                          value="1"
                          <?php if ($row['Meniuri'][27] == '1') {echo 'checked';}?>>Descarca fisier diverse
                        </label><br>                                                                      
                      </div>                        
                    </div>                    
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
                    <button type="button" class="btn btn-primary" onclick="updateData('updateUser', <?php echo $row['ID'];?>)">Salveaza</button>
                  </div>
                </div>
                </form>                
                </div>
              </div>
            </div>
            <!------------------- sfarsit butonul de modificare si forma modala care apare la apasarea lui --------------------------> 
          </td>
          <td class="<?php if ($row['Activ'] == 0){echo 'danger';};?>"> <?php echo $row['Nume'];?>	</td>
          <td class="<?php if ($row['Activ'] == 0){echo 'danger';};?>"> <?php echo $row['Firma'];?>	</td>
          <td  class="<?php if ($row['Activ'] == 0){echo 'danger';};?>" 
          title="<?php if ($row['Parola'] == ''){echo 'Nu are parola!';}else{echo $row['Parola'];}?>">
            &#9956&#9762&#9760!          
          </td>	
          <td class="<?php if ($row['Activ'] == 0){echo 'danger';};?>"> <?php echo $row['Email'];?>	</td>  
          <td class="<?php if ($row['Activ'] == 0){echo 'danger';};?>"> <?php echo $row['Telefon'];?>	</td>
        </tr>          
        <?php }?>
      </tbody>  
   </table>
    <div id="idMyModal"></div>
  </div>
</body>
<?php $conbd->close();?>
</html>