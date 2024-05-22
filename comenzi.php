<?php
session_start();
$_SESSION['pag'] = 'comenzi';
include 'functii.php';
VerificareOcolireLogin();
if (VedeComenzi() == FALSE) {die('Forbiden acces!');};
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

  </head>  
<body><?php

include 'meniu.php';

$sqlStr = "SELECT 
  co.ID AS ID,
  co.Parinte AS Parinte,
  co.IDClient AS IDClient,
  co.CuMontaj AS CuMontaj,  
  co.CodIntern AS CodIntern,
  co.CodIntern2 AS CodIntern2,
  COALESCE(de.Nume, cl.Nume) AS NumeClient,
  co.Nume AS Nume,
  co.Valoare AS Valoare,
  co.Incasat AS Incasat,
  (co.Valoare - co.Incasat) AS RestPlata,
  (SELECT Nume FROM utilizatori AS ut WHERE ut.ID=co.IDResponsabil) AS Responsabil,
  co.Descriere AS Descriere, 
  co.Suprafata AS Suprafata,
  co.Greutate AS Greutate,
  co.Ferestre AS Ferestre,
  co.Usi AS Usi,  
  co.DataCreare AS DataCreare, 
  co.DataLivrare AS DataLivrare, 
  co.IDLivrare AS IDLivrare,
  co.AdresaLivrare AS AdresaLivrare,
  (SELECT Nume FROM livrare AS li WHERE li.ID = co.IDLivrare) AS TraseuLivrare,
  co.Anulata AS Anulata, 
  co.Stadiu AS Stadiu,
  co.NrDeclCert AS NrDeclCert
  FROM comenzi AS co 
  LEFT JOIN dealeri AS de ON co.IDClient = de.ID
  LEFT JOIN clienti AS cl ON co.IDClient = cl.ID
  WHERE co.ID > 0 AND co.Anulata = 0 
  ".$filtruComenzi."    
  ORDER BY Parinte DESC, CodIntern2 DESC;";
  $dateLucrare = $conbd->query($sqlStr);  
  //echo '<br><br><br><br><br>'.$sqlStr;
?>

<div class="container-fluid underFirstNavbar"> 
  <table class="table table-hover table-striped table-condensed fixed-header">
    <thead>
      <tr>
        <th class="width05">Cod<br>intern           </th>
        <th class="width05">Documente               </th>
        <!--<th class="width10">Nume<br>client          </th>-->
        <th class="width10">Nume<br>comanda         </th>
        <th class="width05">Valoare<br>comanda      </th>  
        <th class="width05">Incasat                 </th>  
        <th class="width05">Rest<br>plata      </th>  
        <!--<th class="width10">Responsabil<br>comanda	</th>-->
        <!--<th class="width10">Descriere<br>comanda    </th>-->
        <!--<th class="width05">Supr.                   </th>-->
        <!--<th class="width05">KG                      </th>-->
        <th class="width03">Fer.                    </th>
        <th class="width03">Usi                     </th>	
        <!--<th class="width05">Cu<br>Mont.             </th>-->	
        <th class="width07">Data<br>comanda         </th>
        <th class="width07">Data<br>livrare         </th>
        <!--<th class="width05">Adresa<br>livrare       </th>-->
        <th class="width05">Oras<br>livrare       </th>
        <th class="width07">Fisiere                  </th>
      </tr>
    </thead>
    <tbody> <?php
      $mp=0;
      $kg=0;	
      $f=0;
      $u=0;
      $val=0;
      $inc=0;
      $rest=0;
      while ($row = $dateLucrare->fetch_assoc()){?>
      <tr
        <?php         
        if($row['Anulata'] == 1){echo 'class="text-danger"';}
        else if(AreObservatii($row['ID'], $conbd, 1)){echo 'class="text-info "';};
        ?>>
        <td style="cursor: pointer; <?php echo FormatCell($row['Stadiu']);?>"
            onclick="ArataFormaMC(<?php echo $row['ID'];?>);"><?php
          echo ($row['CodIntern']); if ($row['CodIntern2'] != ""){echo ".".$row['CodIntern2'];} ?>
       </td>
        <td>
          <div class="btn-group btn-group-xs" role="group">
            <!-- butonul de modificare comanda -->           
<!--            <button
             type="button"
              title="Editeaza comanda"      
              class="btn btn-default <?php // if(ModificaComanda() == FALSE){echo ' hidden';}?>" 
              onclick="ArataFormaMC(<?php // echo $row['ID'];?>);">
              <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            </button>-->
              <!-- butoanele de tiparire -->
             <a 
               title="Previzualizeaza contract"      
                class="btn btn-default btn-xs <?php if(TiparesteContract() == FALSE or $row['IDClient'] < 10000){echo ' hidden';}?>"
                href="tiparesteContract.php?ID=<?php echo $row['ID'];?>">            
                <span class="glyphicon glyphicon-euro" aria-hidden="true"></span>
              </a>          
<!--              <a 
                title="Previzualizeaza aviz insotire"      
                class="btn btn-default btn-xs <?php if(TiparesteAvizInsotire() == FALSE){echo ' hidden';}?>"
                href="tiparesteAvizInsotire.php?ID=<?php echo $row['ID'];?>">            
                <span class="glyphicon glyphicon-road" aria-hidden="true"></span>
              </a>          -->
              <a 
                title="Previzualizeaza declaratii performanta"      
                class="btn btn-default btn-xs 
                  <?php if(TiparesteDeclaratii() == FALSE or $row['IDClient'] > 10000 or !($row['NrDeclCert'] > 0)){echo ' hidden';}?>"
                href="tiparesteDeclaratiiPerformanta.php?ID=<?php echo $row['ID'];?>">            
                <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
              </a>    
              <a 
                title="Previzualizeaza declaratii conformitate"      
                class="btn btn-default btn-xs 
                  <?php if(TiparesteDeclaratii() == FALSE or $row['IDClient'] < 10000 or !($row['NrDeclCert'] > 0)){echo ' hidden';}?>"
                href="tiparesteDeclaratiiConformitate.php?ID=<?php echo $row['ID'];?>">            
                <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
              </a>               
          </div>
          <!-- Modalul formei de impartire -->
          <div class="modal fade" 
               id="impartireComanda<?php echo $row['ID'];?>" 
               tabindex="-1" role="dialog" 
               aria-labelledby="myModalLabel<?php echo $row['ID'];?>">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Impartire comanda <?php echo $row['Nume'];?></h4>
                </div>
                <form class="form-horizontal">
                  <input type="hidden" id="CodComanda<?php echo $row['ID'];?>" value="<?php echo $row['ID'];?>" />
                <div class="modal-body">               
                  <div class="form-group">
                    <label for="Valoare" class="col-sm-3 control-label">Valoare:</label>
                    <div class="col-sm-3">
                      <input 
                      type="text" 
                      class="form-control" 
                      id="Valoare<?php echo $row['Valoare'];?>"
                      value="<?php echo $row['Valoare'];?>" />
                    </div>
                    <label for="Suprafata" class="col-sm-3 control-label">Suprafata:</label>
                    <div class="col-sm-3">
                      <input 
                      type="text" 
                      class="form-control" 
                      id="Suprafata<?php echo $row['ID'];?>"
                      value="<?php echo $row['Suprafata'];?>" />
                    </div>
                  </div> 
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
                  <button type="submit" class="btn btn-primary" onclick="updateData('imparteComanda', <?php echo $row['ID'];?>)">Salveaza</button>
                </div>
                </form>                
              </div>
            </div>
          </div>
          <!-- sfarsit modal forma de impartire -->        
        </td>
<!--        <td><?php
          //daca e dealer afiseaza nume dealer, daca client direct, numele clientului
//          if ($row['IDClient'] > 1000){
//            $query2 = $conbd->query("SELECT Nume FROM clienti WHERE ID='".$row['IDClient']."'");
//            $row2 = $query2->fetch_assoc();
//            $num = ($row2['Nume']);
//          }else{
//            $query2 = $conbd->query("SELECT Nume FROM dealeri WHERE ID='".$row['IDClient']."'");
//            $row2 = $query2->fetch_assoc();
//            $num = ($row2['Nume']);
//          }
//          echo ($num);?> 
        </td>-->
        <td><?php echo ($row['Nume']);                ?></td>
        <td><?php echo ($row['Valoare']);             ?></td>
        <td><?php echo ($row['Incasat']);             ?></td>
        <td><?php echo ($row['RestPlata']);           ?></td>
        <!--<td><?php //echo ($row['Responsabil']);         ?></td>-->
        <!--<td><?php //echo ($row['Descriere']);           ?></td>-->
        <!--<td><?php // echo ($row['Suprafata']);           ?></td>-->		
        <!--<td><?php // echo ($row['Greutate']);            ?></td>-->
        <td><?php echo ($row['Ferestre']);            ?></td>
        <td><?php echo ($row['Usi']);                 ?></td>	  
        <!--<td><span class="glyphicon <?php // echo GetInstallationGlyph($row['CuMontaj']);?>" aria-hidden="true"></span></td>-->		  
        <td><?php echo (FDate($row['DataCreare']));   ?></td>
        <td><?php echo (FDate($row['DataLivrare']));  ?></td>
        <!--<td><?php //echo ($row['AdresaLivrare']);       ?></td>-->
        <td><?php echo ($row['TraseuLivrare']);       ?></td>
        <td><?php include'butoaneFisiere.php';        ?></td>
      </tr><?php
      if($row['Anulata'] <> 1){
//        $mp=$mp+$row['Suprafata'];
//        $kg=$kg+$row['Greutate'];	  
        $f=$f+$row['Ferestre'];
        $u=$u+$row['Usi'];
        $val=$val+$row['Valoare'];
        $inc=$inc+$row['Incasat'];
        $rest=$rest+$row['RestPlata'];
      };
      }?>
    </tbody>     
  </table>
  <nav class="navbar navbar-default navbar-fixed-bottom">
    <div class="container-fluid">
      <table class="table table-condensed">
        <thead>
          <tr>
            <th class="width05">                    </th>
            <th class="width05">                    </th>
            <!--<th class="width10">                    </th>-->
            <th class="width10">Totaluri:           </th>
            <th class="width05"><?php echo $val;?>  </th>
            <th class="width05"><?php echo $inc;?>  </th>
            <th class="width05"><?php echo $rest;?>  </th>
            <!--<th class="width10">                    </th>-->
            <!--<th class="width10">                    </th>-->  
            <!--<th class="width05"><?php echo $mp;?>   </th>-->
            <!--<th class="width05"><?php // echo $kg;?>   </th>-->  
            <th class="width03"><?php echo $f;?>    </th>
            <th class="width03"><?php echo $u;?>    </th>  
            <!--<th class="width05">                    </th>-->  
            <th class="width07">                    </th>  
            <th class="width07">                    </th>      
            <!--<th class="width05">                    </th>--> 
            <th class="width05">                    </th>  
            <th class="width07">                    </th>  
          </tr>
        </thead>  
      </table>
    </div>
  </nav>    
</div>
</body>
</html>
<?php $conbd->close();?>