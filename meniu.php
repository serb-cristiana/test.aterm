<?php
  //text filtre
  $textFiltre = SeteazaTextFiltre($conbd);
?>

<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"
         title="<?php echo $_SESSION['dbsize'];?>"><?php echo $_SESSION['producator'];?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle <?php if(!VedeComenzi() && !ComandaNoua()){echo 'hidden';};?>" 
             data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Comenzi <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if(!VedeComenzi()){echo 'hidden';};?>"><a href="comenzi.php">Comenzi</a></li>
    <!--         <li class="<?php if(!ComandaNoua()){echo 'hidden';};?>">
              <a href="#" data-toggle="modal" data-target="#adaugaComanda">Comanda noua</a> -->
            </li>            
            <li role="separator" class="divider"></li>
            <li class="<?php if(!VedeComenziAsteptare()){echo 'hidden';};?>"><a href="asteptare.php">Comenzi in asteptare</a></li>
            <li class="<?php if(!AdaugaComenziAsteptare()){echo 'hidden';};?>">
              <a href="#" data-toggle="modal" data-target="#adaugaComandaAsteptare">Comanda in asteptare noua</a>
            </li>            
            <li role="separator" class="divider"></li>
            <li class="<?php if(!VedeComenzi()){echo 'hidden';};?>"><a href="comenziAnulate.php">Comenzi anulate</a></li>             
            <li class="<?php if(!VedeComenziAsteptare()){echo 'hidden';};?>"><a href="asteptareAnulate.php">Comenzi in asteptare anulate</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle <?php if(EsteDealer()){echo 'hidden';};?>" 
             data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Administrare<span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if(!VedeUtilizatori()){echo 'hidden';};?>"><a href="useri.php">Utilizatori</a></li>
            <li class="<?php if(!AdaugaUtilizatori()){echo 'hidden';};?>"><a href="#" data-toggle="modal" data-target="#adaugaUser">Adaugă Utilizatori</a></li>           
            <li role="separator" class="divider"></li>            
            <li class="<?php if(!VedeDealeri()){echo 'hidden';};?>"><a href="dealeri.php">Parteneri</a></li>
            <li class="<?php if(!AdaugaDealeri()){echo 'hidden';};?>"><a href="#" data-toggle="modal" data-target="#adaugaDealer">Adaugă Parteneri</a></li>  
            <li role="separator" class="divider"></li>            
            <li class="<?php if(!VedePF()){echo 'hidden';};?>"><a href="persoanefizice.php">Persoane fizice</a></li>
            <li class="<?php if(!AdaugaPF()){echo 'hidden';};?>"><a href="#" data-toggle="modal" data-target="#adaugaPF">Adaugă Persoane fizice</a></li>          
            <li role="separator" class="divider"></li>            
            <li class="<?php if(!VedeZoneLivrare()){echo 'hidden';};?>"><a href="zoneLivrare.php">Zone livrare</a></li>
            <li class="<?php if(!AdaugaZoneLivrare()){echo 'hidden';};?>"><a href="#" data-toggle="modal" data-target="#adaugaZonaLivrare">Adaugă Zonă livrare</a></li>          
            <li role="separator" class="divider"></li>            
            <li class="<?php if(EsteDealer()){echo 'hidden';}?>"><a href="raportDeclaratii.php">Raport declaratii</a></li>
          </ul>
        </li> 
        <li class="<?php if(!VedeProductie()){echo 'hidden';};?>"><a href="productie.php">Productie</a></li>     
        <li class="dropdown">
          <a href="#" class="dropdown-toggle <?php if(EsteDealer()){echo 'hidden';};?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Reclamații <span class="caret"></span> </a>
          <ul class="dropdown-menu">
            <li class="<?php if(!VedeReclamatii()){echo 'hidden';};?>"><a href="reclamatii1.php">Reclamatii</a></li>
            <li class="<?php if(!AdaugaReclamatii()){echo 'hidden';};?>"><a href="#" data-toggle="modal" data-target="#adaugaReclamatii"> Adaugă Reclamatii</a></li>         
          </ul>
        </li> 
      </ul>
      <form class="navbar-form navbar-left">
        <div class="input-group">
          <input type="text" id="cautaNumeComanda" class="form-control" placeholder="Nume comanda">
          <span class="input-group-btn">
            <button type="button" class="btn btn-default" onclick="CautaNumeComanda()">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          </button>
          </span>
        </div>
      </form>         
      <ul class="nav navbar-nav navbar-right">
        <p class="nav navbar-text" rel="tooltip"
           data-toggle="tooltip" data-placement="left"
           title="<?php echo $textFiltre;?>">
          <span class="glyphicon glyphicon-filter" aria-hidden="true"></span>
        </p>  
        
        <li>
          <div class="btn-group">
            <button class="btn navbar-btn btn-default" onclick="updateData('anuleazaFiltre', '')">
            Anuleaza filtre
          </button>
          <button class="btn navbar-btn btn-default" data-toggle="modal" data-target="#filtre">
            Filtre comenzi
          </button>
          </div>  
        </li>
        <li><a href="logout.php">Logout <span class="glyphicon glyphicon-log-out"></span></a></li>        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<!-- Formularul actualizat pentru adăugarea unei reclamații -->
<div class="modal fade" id="adaugaReclamatii" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Adaugă Reclamație</h4>
                <div class="alert alert-danger collapse js-div-info">
                    <a href="#" class="close js-a-close">&times;</a>
                    <strong class="js-info1">Eroare/Succes</strong><span></span><span class="js-info2"></span>
                </div>
            </div>
            <form id="js-form-d" class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- Partea stângă (dealer) -->
                            <div class="form-group">
                                <label for="NumeComanda" class="col-sm-3 control-label">Nume comandă</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti numele comenzii reclamate" id="NumeComanda" name="NumeComanda">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="NumeDealer" class="col-sm-3 control-label">Nume dealer</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti numele dealerului" id="NumeDealer" name="NumeDealer">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Descriere" class="col-sm-3 control-label">Descriere</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti descrierea problemei" id="Descriere" name="Descriere">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="DataReclamatie" class="col-sm-3 control-label">Data reclamației</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="DataReclamatie" name="DataReclamatie">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MaterialVideo" class="col-sm-3 control-label">Material video</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="MaterialVideo" name="MaterialVideo">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MaterialPoze" class="col-sm-3 control-label">Material poze</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="MaterialPoze" name="MaterialPoze">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Renunță</button>
                    <button type="submit" class="btn btn-primary">Salvează</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Adăugarea reclamației în baza de date la trimiterea formularului
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conbd = new mysqli('localhost', 'root', '', 'atermro8');
    if ($conbd->connect_error) {
        die("Conexiunea la baza de date a eșuat: " . $conbd->connect_error);
    }

    $NumeComanda = $conbd->real_escape_string($_POST['NumeComanda']);
    $NumeDealer = $conbd->real_escape_string($_POST['NumeDealer']);
    $Descriere = $conbd->real_escape_string($_POST['Descriere']);
    $DataReclamatie = $_POST['DataReclamatie'];

    $MaterialVideoName = basename($_FILES["MaterialVideo"]["name"]);
    $MaterialPozeName = basename($_FILES["MaterialPoze"]["name"]);

    $targetMaterialVideo = $MaterialVideoName;
    $targetMaterialPoze = $MaterialPozeName;

    move_uploaded_file($_FILES["MaterialVideo"]["tmp_name"], $targetMaterialVideo);
    move_uploaded_file($_FILES["MaterialPoze"]["tmp_name"], $targetMaterialPoze);

    $query = "INSERT INTO reclamatii (NumeComanda, NumeDealer, Descriere, DataReclamatie, MaterialVideo, MaterialPoze) VALUES ('$NumeComanda', '$NumeDealer', '$Descriere', '$DataReclamatie', '$targetMaterialVideo', '$targetMaterialPoze')";

    if ($conbd->query($query) === TRUE) {
        echo '<script>alert("Reclamația a fost adăugată cu succes!");</script>';
    } else {
        echo '<script>alert("Eroare la adăugarea reclamației: ' . $conbd->error . '");</script>';
    }

    $conbd->close();
}
?>


<!------------------- inceput forma modala de adaugare comanda noua -------------------------->
<div class="modal fade" 
     id="adaugaComanda" 
     tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Comanda noua</h4>
        <div class="alert alert-danger collapse js-div-info">
          <a href="#" class="close js-a-close">&times</a>
          <strong class="js-info1">Eroare/Succes </strong><span> </span><span class="js-info2"></span>
        </div>
      </div>
      <div class="modal-body">   
        <div class="row">
          <form id="js-form-cn1" class="form-horizontal col-sm-6" enctype="multipart/form-data">
            <input type="hidden" id="idCA" value="0"/>
            <div class="form-group">
              <label for="Client" class="col-sm-4 control-label">Client:</label>
              <div class="col-sm-8">
                <select class="form-control" id="Client" name="Client">
                  <?php $clienti = $conbd->query ("SELECT ID, Nume FROM dealeri WHERE Activ=1 ORDER BY Nume;");?>
                  <option value="0">Client direct</option><?php
                  if(ComandaNouaPentruDealeri()){
                    while ($row5 = $clienti->fetch_assoc()){?>
                    <option value="<?php echo $row5['ID'];?>">
                     <?php echo $row5['Nume'];?>
                    </option><?php 
                    }                    
                  };?>
                </select>
              </div>
            </div>
            <fieldset class="dateCl">
              <div class="form-group" >
                <label for="NumeCl" class="col-sm-4 control-label">Nume:</label>
                <div class="col-sm-8">
                  <input 
                  type="text" class="form-control" 
                  id="NumeCl"
                  placeholder="Introduceti nume client"/>
                </div>
              </div> 
            </fieldset>  
            <fieldset class="dateCl">
              <div class="form-group" >
                <label for="AdresaCl" class="col-sm-4 control-label">Adresa:</label>
                <div class="col-sm-8">
                  <input 
                  type="text" class="form-control" 
                  id="AdresaCl"
                  placeholder="Introduceti adresa client"/>
                </div>
              </div> 
            </fieldset>  
            <fieldset class="dateCl">
              <div class="form-group" >
                <label for="TelFixCl" class="col-sm-4 control-label">Telefon:</label>
                <div class="col-sm-8">
                  <input 
                  type="text" class="form-control" 
                  id="TelFixCl"
                  placeholder="Introduceti nr. telefon"/>
                </div> 
              </div>            
            </fieldset>  
            <fieldset class="dateCl                                               hidden">
              <div class="form-group" >
                <label for="TelMobCl" class="col-sm-4 control-label">Telefon mobil:</label>
                <div class="col-sm-8">
                  <input 
                  type="text" class="form-control" 
                  id="TelMobilCl"
                  placeholder="Introduceti telefon mobil"/>
                </div> 
              </div>          
            </fieldset>  
            <fieldset class="dateCl">
              <div class="form-group" >
                <label for="CnpCl" class="col-sm-4 control-label">CNP:</label>
                <div class="col-sm-8">
                  <input 
                  type="text" class="form-control" 
                  id="CnpCl"
                  placeholder="Introduceti CNP client sau reprezentant"/>
                </div>
              </div> 
            </fieldset>  
            <fieldset class="dateCl">
              <div class="form-group" >
                <label for="CiCl" class="col-sm-4 control-label">CI:</label>
                <div class="col-sm-8">
                  <input 
                  type="text" class="form-control" 
                  id="CiCl"
                  placeholder="Introduceti CI client sau reprezentant"/>
                </div>
              </div> 
            </fieldset>  
            <fieldset class="dateCl">
              <div class="form-group" >
                <label for="ReprezCl" class="col-sm-4 control-label">Reprezentant PJ:</label>
                <div class="col-sm-8">
                  <input 
                  type="text" class="form-control" 
                  id="ReprezCl"
                  placeholder="Introduceti reprezentant societate"/>
                </div>
              </div> 
            </fieldset>  
            <fieldset class="dateCl">
              <div class="form-group" >
                <label for="CuiCl" class="col-sm-4 control-label">CUI:</label>
                <div class="col-sm-8">
                  <input 
                  type="text" class="form-control" 
                  id="CuiCl"
                  placeholder="Introduceti CUI societate"/>
                </div>
              </div> 
            </fieldset>  
            <fieldset class="dateCl">
              <div class="form-group" >
                <label for="RcCl" class="col-sm-4 control-label">RC:</label>
                <div class="col-sm-8">
                  <input 
                  type="text" class="form-control" 
                  id="RcCl"
                  placeholder="Introduceti RC societate"/>
                </div>
              </div> 
            </fieldset>  
            <fieldset class="dateCl">
              <div class="form-group" >
                <label for="e-mailCl" class="col-sm-4 control-label">e-mail:</label>
                <div class="col-sm-8">
                  <input 
                  type="text" class="form-control" 
                  id="e-mailCl"
                  placeholder="Introduceti e-mail"/>
                </div>
              </div> 
            </fieldset>  
          </form>
        
          <form id="js-form-cn2" class="form-horizontal col-sm-6" enctype="multipart/form-data">
            <div class="form-group">
              <label for="Nume" class="col-sm-4 control-label">Lucrare:</label>
              <div class="col-sm-8">
                <input 
                    type="text" class="form-control" disabled="disabled"
                id="Nume"
                placeholder="Nume comanda"/>
              </div>
            </div>
            <div class="form-group">
              <label for="NrContract" class="col-sm-4 control-label">Numar contract:</label>
              <div class="col-sm-8">
                <input 
                type="text" class="form-control" 
                id="NrContract"
                placeholder="Introduceti numar contract"/>
              </div>
            </div>            
            <div class="form-group">
              <label for="Valoare" class="col-sm-4 control-label">Valoare:</label>
              <div class="col-sm-8">
                <input 
                type="text" class="form-control" 
                id="Valoare"
                placeholder="Introduceti valoare comanda"/>
              </div>
           </div>
            <div class="form-group">
              <label for="Incasat" class="col-sm-4 control-label">Avans:</label>
             <div class="col-sm-8">
                <input 
                type="text" class="form-control" 
                id="Incasat"
                placeholder="Introduceti avansul incasat"/>
              </div>
           </div>            
            <div class="form-group">
              <label for="DataLivrare" class="col-sm-4 control-label">Livrare in:</label>
              <div class="col-sm-8">
                <div class="datepicker" id="dp">
                  <input type="text" class="form-control" 
                  id="DataLivrare"
                  placeholder="Alegeti data livrare"/>
                </div>
              </div>
            </div> 

           <div class="form-group">
              <label for="AdresaLivrare" class="col-sm-4 control-label">Livrare la:</label>
              <div class="col-sm-8">
                <input 
                type="text" class="form-control" 
                id="AdresaLivrare"
                placeholder="Introduceti adresa livrare"/>
              </div>
            </div>
            <div class="form-group">
              <label for="IDTraseuLivrare" class="col-sm-4 control-label">Oras livrare:</label>
              <div class="col-sm-8">
                <select class="form-control" id="IDTraseuLivrare" name="IDTraseuLivrare">
                  <?php $dateLivrare3 = $conbd->query ("SELECT ID, Nume FROM livrare;");?>
                  <option value="0" selected="selected">Alege oras de livrare</option><?php
                  while ($row2 = $dateLivrare3->fetch_assoc()){?>
                  <option value="<?php echo $row2['ID'];?>">
                    <?php echo $row2['Nume'];?>
                  </option><?php 
                  };?>
                </select>
              </div>
            </div>
            <div class="form-group hidden">
              <label for="Suprafata" class="col-sm-4 control-label">Suprafata:</label>
              <div class="col-sm-8">
                <input 
                type="text" class="form-control" 
                id="Suprafata"
                placeholder="Introduceti suprafata comanda"/>
              </div> 
            </div>                     

            <div class="form-group hidden">
              <label for="Greutate" class="col-sm-4 control-label">Greutate:</label>
              <div class="col-sm-8">
                <input 
                type="text" class="form-control" 
                id="Greutate"
                placeholder="Introduceti greutate comanda"/>
              </div>
            </div>
            <div class="form-group">
              <label for="Ferestre" class="col-sm-4 control-label">Ferestre:</label>
              <div class="col-sm-8">
                <input 
                type="text" class="form-control" 
                id="Ferestre"
                placeholder="Introduceti numar ferestre"/>
              </div>
            </div>
            <div class="form-group">
              <label for="Usi" class="col-sm-4 control-label">Usi:</label>
              <div class="col-sm-8">
                <input 
                type="text" class="form-control" 
                id="Usi"
                placeholder="Introduceti numar usi"/>
              </div>
            </div>   
            <div class="form-group">
              <label for="Descriere" class="col-sm-4 control-label">Descriere:</label>
              <div class="col-sm-8">
                <input 
                type="text" class="form-control" 
                id="Descriere"
                value="Tamplarie cu geam termoizolant."/>
              </div>
            </div>                     

            <div class="form-group">
              <label for="Observatii" class="col-sm-4 control-label">Observatii:</label>
              <div class="col-sm-8">
                <input 
                type="text" class="form-control" 
                id="Observatii"
                placeholder="Introduceti observatii"/>
              </div>
            </div> 
            
            <div class="form-group"> 
              <label class="col-sm-4 text-right"></label>
              <label class="radio-inline">
                <input type="radio" id="cuMontaj" name="Montaj" value="1" checked="checked"> Cu montaj
              </label>
              <label class="radio-inline">
                <input type="radio" id="faraMontaj" name="Montaj" value="0"> Fara montaj    
              </label>                   
            </div>                             
          </form>
          <form id="js-form-cn3" class="form-horizontal col-sm-12" enctype="multipart/form-data">
            <div class="form-group">
              <div <?php //echo AccesComanda();?>>
                <label for="uploadFileCo" class="col-sm-2 control-label">Fisier CFU:</label>
                <div class="col-sm-8">
                  <input <?php //echo AccesComanda();?>
                  type="file" class="form-control" 
                  id="uploadFileCo"
                  value="" />
                </div> 
                <div class="col-sm-2 text-left">
                  <label>
                   <input type="checkbox" 
                    id="FaraCFUCo"  
                    value="0"> Fara CFU
                  </label>
                </div> 
              </div>                    
            </div>             
          </form>          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
        <button type="button" class="btn btn-primary" onclick="updateData('adaugaComanda', '')">Salveaza</button>
      </div>             
    </div>
  </div>
</div>
<!------------------- sfarsit forma modala de adaugare comanda noua -------------------------->   

<!------------------- inceput forma modala de aprobare comanda asteptare -------------------------->
<div class="modal fade" 
     id="aprobaComanda" 
     tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="acaTitlu">Aproba comanda</h4>
        <div class="alert alert-danger collapse js-div-info">
          <a href="#" class="close js-a-close">&times</a>
          <strong class="js-info1">Eroare/Succes </strong><span> </span><span class="js-info2"></span>
        </div>
      </div>
      <div class="modal-body">        
        <form id="js-form-aca1" class="form-horizontal">
          <input type="hidden" id="idCA" value="0"/>
          <input type="hidden" id="clientCA" name="clientCA">
          <input type="hidden" id="dealerCA" name="dealerCA">
          <div class="form-group">
            <label for="acaNume" class="col-sm-4 control-label">Lucrare:</label>
            <div class="col-sm-8">
              <input 
              type="text" class="form-control" 
              id="acaNume"
              placeholder="Introduceti nume comanda"/>
            </div>
          </div>
          <div class="form-group">
            <label for="acaValoare" class="col-sm-4 control-label">Valoare:</label>
            <div class="col-sm-8">
              <input 
              type="text" class="form-control" 
              id="acaValoare"
              placeholder="Introduceti valoare comanda"/>
            </div>
          </div>
          <div class="form-group">
            <label for="acaIncasat" class="col-sm-4 control-label">Incasat:</label>
            <div class="col-sm-8">
              <input 
              type="text" class="form-control" 
              id="acaIncasat"
              placeholder="Introduceti suma incasata"/>
            </div>
          </div>
          <div class="form-group">
            <label for="acaDataLivrare" class="col-sm-4 control-label">Livrare in:</label>
            <div class="col-sm-8">
              <div class="datepicker" id="dp">
                <input type="text" class="form-control" 
                id="acaDataLivrare"
                placeholder="Alegeti data livrare"/>
              </div>
            </div>
          </div> 

          <div class="form-group">
            <label for="acaAdresaLivrare" class="col-sm-4 control-label">Livrare la:</label>
            <div class="col-sm-8">
              <input 
              type="text" class="form-control" 
              id="acaAdresaLivrare"
            placeholder="Introduceti adresa livrare"/>
            </div>
          </div>
          <div class="form-group">
            <label for="acaIDTraseuLivrare" class="col-sm-4 control-label">Oras livrare:</label>
            <div class="col-sm-8">
              <select class="form-control" id="acaIDTraseuLivrare" name="IDTraseuLivrare">
               <?php $dateLivrare3 = $conbd->query ("SELECT ID, Nume FROM livrare;");?>
                <option value="0" selected="selected">Alege oras de livrare</option><?php
                while ($row2 = $dateLivrare3->fetch_assoc()){?>
                <option value="<?php echo $row2['ID'];?>">
                  <?php echo $row2['Nume'];?>
                </option><?php 
                };?>
              </select>
            </div>
          </div>
          <div class="form-group hidden">
            <label for="acaSuprafata" class="col-sm-4 control-label">Suprafata:</label>
            <div class="col-sm-8">
              <input 
              type="text" class="form-control" 
              id="acaSuprafata"
              placeholder="Introduceti suprafata comanda"/>
            </div> 
          </div>                     

          <div class="form-group hidden">
            <label for="acaGreutate" class="col-sm-4 control-label">Greutate:</label>
            <div class="col-sm-8">
              <input 
              type="text" class="form-control" 
              id="acaGreutate"
              placeholder="Introduceti greutate comanda"/>
            </div>
          </div>
          <div class="form-group">
           <label for="acaFerestre" class="col-sm-4 control-label">Ferestre:</label>
            <div class="col-sm-8">
              <input 
              type="text" class="form-control" 
              id="acaFerestre"
              placeholder="Introduceti numar ferestre"/>
            </div>
          </div>
          <div class="form-group">
            <label for="acaUsi" class="col-sm-4 control-label">Usi:</label>
            <div class="col-sm-8">
              <input 
              type="text" class="form-control" 
              id="acaUsi"
              placeholder="Introduceti numar usi"/>
            </div>
          </div>   
          <div class="form-group">
            <label for="acaDescriere" class="col-sm-4 control-label">Descriere:</label>
            <div class="col-sm-8">
              <input 
              type="text" class="form-control" 
              id="acaDescriere"
              value="Tamplarie cu geam termoizolant."/>
            </div>
          </div>                     

          <div class="form-group">
            <label for="acaObservatii" class="col-sm-4 control-label">Observatii:</label>
            <div class="col-sm-8">
              <input 
              type="text" class="form-control" 
              id="acaObservatii"
              placeholder="Introduceti observatii"/>
            </div>
          </div> 

          <div class="form-group hidden"> 
            <label class="col-sm-4 text-right"></label>
            <label class="radio-inline">
              <input type="radio" id="acacuMontaj" name="acaMontaj" value="1" > Cu montaj
            </label>
            <label class="radio-inline">
              <input type="radio" id="acafaraMontaj" name="acaMontaj" value="0" checked="checked"> Fara montaj    
            </label>                   
         </div>   
        </form>
        <div class="text-center text-info" id="acaListaObservatii"></div>         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
        <button type="button" class="btn btn-primary" onclick="updateData('aprobaComanda', '')">Salveaza</button>
      </div>             
    </div>
  </div>
</div>
<!------------------- sfarsit forma modala de aprobare comanda asteptare -------------------------->  


<!------------------- inceput forma modala de adaugare comanda ASTEPTARE noua -------------------------->
<div class="modal fade" 
     id="adaugaComandaAsteptare" 
     tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Comanda in asteptare noua</h4>
        <div class="alert alert-danger collapse js-div-info">
          <a href="#" class="close js-a-close">&times</a>
          <strong class="js-info1">Eroare/Succes </strong><span> </span><span class="js-info2"></span>
        </div>
      </div>
      <div class="modal-body">   
        <div class="row">
          <form id="js-form-can1" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group"> 
              <div class="form-group">
                <label for="Client" class="col-sm-4 control-label">Nume persoană fizică</label>
                <div class="col-sm-6">
                <select class="form-control" id="Client" name="Client">
                  <?php $clienti = $conbd->query("SELECT ID, Nume FROM clienti WHERE Activ=1 ORDER BY Nume;");?>
                  <option value="0" <?php {echo 'selected';};?>>Alege persoană fizică</option><?php
                  while ($row = $clienti->fetch_assoc()){?>
                  <option value="<?php echo $row['ID'];?>">
                    <?php echo $row['Nume'];?>
                  </option><?php 
                  }?>
                </select>
                </div>
              </div>            
             <label for="Dealer" class="col-sm-4 control-label">Nume partener</label>
              <div class="col-sm-6">
                <fieldset <?php if(EsteDealer()){echo 'disabled';};?>>
                <select class="form-control" id="Dealer" name="Dealer">
                 <?php $dealeri = $conbd->query ("SELECT ID, Nume FROM dealeri WHERE Activ=1 ORDER BY Nume;");?>
                 <option value="0" <?php if($_SESSION['firma'][1] == '0'){echo 'selected';};?>>Alege partener</option><?php
                  while ($row8 = $dealeri->fetch_assoc()){?>
                  <option value="<?php echo $row8['ID'];?>" 
                    <?php if($_SESSION['firma'][1] == $row8['ID']){echo 'selected';};?>>
                    <?php echo $row8['Nume'];?>
                  </option><?php 
                  }?>
                </select>
                </fieldset>  
              </div>
            </div>
            <fieldset class="dateCoAs">
              <div class="form-group" >
                <label for="NumeCoAs" class="col-sm-4 control-label">Nume comanda</label>
                <div class="col-sm-6">
                  <input 
                  type="text" class="form-control" 
                  id="NumeCoAs"
                  placeholder="Introduceti nume comanda"/>
                </div>
              </div> 
            </fieldset> 
            <fieldset class="dateCoAs">  
              <div class="form-group">
                <label for="IDTraseuLivrareCoAs" class="col-sm-4 control-label">Oras livrare</label>
                <div class="col-sm-6">
                 <select class="form-control" id="IDTraseuLivrareCoAs" name="IDTraseuLivrareCoAs">
                    <?php $dateLivrare3 = $conbd->query ("SELECT ID, Nume FROM livrare;");?>
                    <option value="0" selected="selected">Alege oras de livrare</option><?php
                    while ($row2 = $dateLivrare3->fetch_assoc()){?>
                    <option value="<?php echo $row2['ID'];?>">
                     <?php echo $row2['Nume'];?>
                    </option><?php 
                    };?>
                  </select>
                </div>
              </div>            
            </fieldset> 
            <fieldset>
              <div class="form-group">
                <label for="ObservatiiCoAs" class="col-sm-4 control-label">Observatii</label>
                <div class="col-sm-6">
                  <input 
                 type="text" class="form-control" 
                  id="ObservatiiCoAs"
                  placeholder="Introduceti observatii"/>
                </div>
              </div> 
            </fieldset>
            <fieldset>    
              <div class="form-group">
                <div <?php //echo AccesComanda();?>>
                  <label for="uploadFileCoAs" class="col-sm-4 control-label">Fisier CFU</label>
                  <div class="col-sm-6">
                    <input <?php //echo AccesComanda();?>
                    type="file" class="form-control" 
                    id="uploadFileCoAs"
                    value="" />
                  </div> 
                  <div class="col-sm-2 text-left">
                    <label>
                      <input type="checkbox" 
                      id="FaraCFUCoAs"  
                      value="0"> Fara CFU
                    </label>
                  </div> 
                </div>                    
              </div> 
            </fieldset>
            
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
        <button type="button" class="btn btn-primary" onclick="updateData('adaugaComandaAsteptare', '')">Salveaza</button>
      </div>             
    </div>
  </div>
</div>
<!------------------- sfarsit forma modala de adaugare comanda ASTEPTARE noua -------------------------->  

<!-- Formularul actualizat pentru adăugarea unui partener -->
<div class="modal fade" id="adaugaDealer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Adauga partener</h4>
                <div class="alert alert-danger collapse js-div-info">
                    <a href="#" class="close js-a-close">&times;</a>
                    <strong class="js-info1">Eroare/Succes </strong><span> </span><span class="js-info2"></span>
                </div>
            </div>
            <form id="js-form-d" class="form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- Partea stângă (dealer) -->
                            <div class="form-group">
                                <label for="NumePartener" class="col-sm-3 control-label">Nume partener:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti numele partenerului" id="NumePartener">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Adresa" class="col-sm-3 control-label">Adresa sediu social:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti adresa sediului social" id="Adresa">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="CUI" class="col-sm-3 control-label">CUI:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti CUI" id="CUI">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="RC" class="col-sm-3 control-label">Registrul Comertului:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti numarul de inregistrare la RC" id="RC">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Banca" class="col-sm-3 control-label">Banca:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti numele bancii" id="Banca">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Cont" class="col-sm-3 control-label">Cont:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti numarul de cont" id="Cont">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="TelMobil" class="col-sm-3 control-label">Telefon:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti numarul de telefon" id="TelMobil">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label">E-mail:</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" placeholder="Introduceti adresa de e-mail" id="email">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- Partea dreaptă (responsabil) -->
                            <div class="form-group">
                                <label for="IDLivrare" class="col-sm-3 control-label">Oras livrare:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="IDLivrare" name="IDLivrare">
                                        <?php $dateLivrare3 = $conbd->query ("SELECT ID, Nume FROM livrare;");
                                        ?>
                                        <option value="0" selected="selected">Alege oras</option>
                                        <?php
                                        while ($row2 = $dateLivrare3->fetch_assoc()){
                                            ?>
                                            <option value="<?php echo $row2['ID'];?>">
                                                <?php echo $row2['Nume'];?>
                                            </option>
                                            <?php
                                        };
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Reprezentant" class="col-sm-3 control-label">Reprezentant:</label>
                                  <div class="col-sm-9">
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Introduceti numele reprezentantului"
                                    id="Reprezentant">
                                  </div>
                            </div>
                            <div class="form-group">
                                <label for="CNP" class="col-sm-3 control-label">CNP:</label>
                                  <div class="col-sm-9">
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Introduceti CNP pentru persoane fizice"
                                    id="CNP">
                                  </div>
                            </div>
                            <div class="form-group">
                            <label for="IDResponsabil" class="col-sm-3 control-label">Responsabil:</label>
                            <div class="col-sm-9">
                              <select class="form-control" id="IDResponsabil" name="IDResponsabil">
                                <?php $dateResponsabil = $conbd->query ('SELECT ID, Nume FROM utilizatori WHERE Firma = "'.$_SESSION['producator'].'" ORDER BY Nume;');?>
                                <option value="0" selected="selected">Alegeti responsabilul</option><?php
                                while ($row3 = $dateResponsabil->fetch_assoc()){?>
                                <option value="<?php echo $row3['ID'];?>">
                                <?php echo $row3['Nume'];?>
                                </option><?php 
                              };?>
                              </select>
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="CodPartener" class="col-sm-3 control-label">Cod Partener:</label>
                              <div class="col-sm-9">
                                <input 
                                type="text" 
                                class="form-control" 
                                placeholder="Introduceti cod partener"
                                id="CodPartener">
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
                    <button type="button" class="btn btn-primary" onclick="updateData('adaugaDealer', '')">Salveaza</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!------------------- sfarsit forma modala de adaugare partener --------------------------> 

<!-- Formularul actualizat pentru adăugarea unui client -->
<div class="modal fade" id="adaugaPF" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Adaugă persoană fizică</h4>
                <div class="alert alert-danger collapse js-div-info">
                    <a href="#" class="close js-a-close">&times;</a>
                    <strong class="js-info1">Eroare/Succes </strong><span> </span><span class="js-info2"></span>
                </div>
            </div>
            <form id="js-form-d" class="form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- Partea stângă (dealer) -->
                            <div class="form-group">
                                <label for="NumeClient" class="col-sm-3 control-label">Nume partener:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti numele partenerului" id="NumeClient">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="AdresaPF" class="col-sm-3 control-label">Adresa:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti adresa " id="AdresaPF">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="CUIPF" class="col-sm-3 control-label">CUI:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti CUI" id="CUIPF">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="RCPF" class="col-sm-3 control-label">Registrul Comertului:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti numarul de inregistrare la RC" id="RCPF">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="BancaPF" class="col-sm-3 control-label">Banca:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti numele bancii" id="BancaPF">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ContPF" class="col-sm-3 control-label">Cont:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti numarul de cont" id="ContPF">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="TelMobilPF" class="col-sm-3 control-label">Telefon:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Introduceti numarul de telefon" id="TelMobilPF">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="emailPF" class="col-sm-3 control-label">E-mail:</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" placeholder="Introduceti adresa de e-mail" id="emailPF">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- Partea dreaptă (responsabil) -->
                            <div class="form-group">
                                <label for="IDLivrarePF" class="col-sm-3 control-label">Oras livrare:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="IDLivrarePF" name="IDLivrare">
                                        <?php $dateLivrare3 = $conbd->query ("SELECT ID, Nume FROM livrare;");
                                        ?>
                                        <option value="0" selected="selected">Alege oras</option>
                                        <?php
                                        while ($row2 = $dateLivrare3->fetch_assoc()){
                                            ?>
                                            <option value="<?php echo $row2['ID'];?>">
                                                <?php echo $row2['Nume'];?>
                                            </option>
                                            <?php
                                        };
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="CNPPF" class="col-sm-3 control-label">CNP:</label>
                                  <div class="col-sm-9">
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Introduceti CNP pentru persoane fizice"
                                    id="CNPPF">
                                  </div>
                            </div>
                            <div class="form-group">
                            <label for="IDResponsabilPF" class="col-sm-3 control-label">Responsabil:</label>
                            <div class="col-sm-9">
                              <select class="form-control" id="IDResponsabilPF" name="IDResponsabil">
                                <?php $dateResponsabil = $conbd->query ('SELECT ID, Nume FROM utilizatori WHERE Firma = "'.$_SESSION['producator'].'" ORDER BY Nume;');?>
                                <option value="0" selected="selected">Alegeti responsabilul</option><?php
                                while ($row3 = $dateResponsabil->fetch_assoc()){?>
                                <option value="<?php echo $row3['ID'];?>">
                                <?php echo $row3['Nume'];?>
                                </option><?php 
                              };?>
                              </select>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
                    <button type="button" class="btn btn-primary" onclick="updateData('adaugaPF', '')">Salveaza</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!------------------- sfarsit forma modala de adaugare partener --------------------------> 


<!------------------- inceput forma modala de adaugare user -------------------------->
<div class="modal fade" 
     id="adaugaUser" 
     tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Adaugă utilizator</h4>
        <div class="alert alert-danger collapse js-div-info">
          <a href="#" class="close js-a-close">&times</a>
          <strong class="js-info1">Eroare/Succes </strong><span> </span><span class="js-info2"></span>
        </div>
      </div>
      <form id="js-form-u" class="form-horizontal">
      <div class="modal-body">               
        <div class="form-group">
          <label for="NumeUser" class="col-sm-2 control-label">Nume utilizator</label>
          <div class="col-sm-4">
            <input 
            type="text" 
            class="form-control" 
            placeholder="Introduceti nume utilizator"
            id="NumeUser">
          </div>
          <label for="Parola" class="col-sm-2 control-label">Parola</label>
          <div class="col-sm-3">
            <input 
            type="password" 
            class="form-control" 
            placeholder="Introduceti parola"
           id="Parola">
          </div>
          </div>
          <div class="form-group">
            <label for="Email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-4">
            <input 
            type="email" 
            class="form-control" 
            placeholder="Introduceti Email"
            id="Email">
          </div>
            <label for="Telefon" class="col-sm-2 control-label">Telefon</label>
            <div class="col-sm-3">
            <input 
            type="telefon" 
            class="form-control" 
            placeholder="Introduceti Telefon"
            id="Telefon">
          </div>
          </div>
       <div class="form-group">
         <label for="FirmaUser" class="col-sm-2 control-label">Nume partener</label>
         <div class="col-sm-4">
           <select class="form-control" id="FirmaUser" name="FirmaUser">
              <?php $firme = $conbd->query ("SELECT DISTINCT Nume FROM dealeri;");?>
              <option value="">Alege partenerul</option><?php
              while ($row = $firme->fetch_assoc()){?>
              <option value="<?php echo $row['Nume'];?>">
                <?php echo $row['Nume'];?>
              </option><?php 
              }?>
              <option value="<?php echo $_SESSION['producator'];?>">
                <?php echo $_SESSION['producator'];?>
              </option>
          </select>
         </div>
          <div class="col-sm-3 text-center">
            <label>
              <input type="checkbox" 
              id="Activ"  
              value="1" checked="checked">Activ
            </label>
         </div>  
       </div>
        <div class="form-group">
          <!--meniuri-->
          <div class="col-sm-6 text-right">
            <h4> Meniuri disponibile</h4>
            <label>Vede comenzi 
              <input type="checkbox" 
              id="VedeComenzi"  
              value="1">
            </label><br>               
            <label>Vede doar comenzile proprii 
              <input type="checkbox" 
              id="VedeDoarComenzileProprii"  
              value="1">
            </label><br>               
            <label> Comanda noua 
              <input type="checkbox" 
              id="ComandaNoua"  
              value="1">
            </label><br>               
            <label> Modifica comanda 
              <input type="checkbox" 
              id="ModificaComanda"  
              value="1">
            </label><br>               
            <label> Tipareste contract 
             <input type="checkbox" 
            id="TiparesteContract"  
              value="1">
            </label><br>               
            <label> Tipareste declaratii 
              <input type="checkbox" 
              id="TiparesteDeclaratii"  
              value="1">
            </label><br>               
            <label> Tipareste aviz insotire 
              <input type="checkbox" 
              id="TiparesteAvizInsotire"  
              value="1">
            </label><br>               
            <label> Comanda noua pentru dealeri
              <input type="checkbox" 
              id="ComandaNouaPentruDealeri"  
              value="1">
            </label><br>               
            <label> Vede utilizatori 
              <input type="checkbox" 
              id="VedeUtilizatori"  
              value="1">
            </label><br>               
            <label> Adauga utilizatori 
              <input type="checkbox" 
              id="AdaugaUtilizatori"  
              value="1">
            </label><br>               
            <label> Modifica utilizatori 
              <input type="checkbox" 
              id="ModificaUtilizatori"  
              value="1">
            </label><br>               
            <label> Vede dealeri 
              <input type="checkbox" 
              id="VedeDealeri"  
              value="1">
            </label><br>               
            <label> Adauga dealeri 
              <input type="checkbox" 
              id="AdaugaDealeri"  
              value="1">
            </label><br>               
            <label> Modifica dealeri 
              <input type="checkbox" 
              id="ModificaDealeri"  
              value="1">
            </label><br>
            <label> Vede persoane fizice
              <input type="checkbox" 
              id="VedePF"  
              value="1">
            </label><br>               
            <label> Adauga persoane fizice
              <input type="checkbox" 
              id="AdaugaPF"  
              value="1">
            </label><br>               
            <label> Modifica persoane fizice
              <input type="checkbox" 
              id="ModificaPF"  
              value="1">
            </label><br>                
            <label> Vede zone livrare 
              <input type="checkbox"
              id="VedeZoneLivrare"  
              value="1">
            </label><br>               
            <label> Adauga zone livrare 
              <input type="checkbox" 
              id="AdaugaZoneLivrare"  
              value="1">
            </label><br>               
            <label> Modifica zone livrare 
              <input type="checkbox" 
              id="ModificaZoneLivrare"  
              value="1">
            </label><br>               
            <label> Vede productie 
              <input type="checkbox" 
              id="VedeProductie"  
              value="1">
            </label><br>                           
            <label> Vede comenzi asteptare 
              <input type="checkbox" 
              id="VedeComenziAsteptare"  
              value="1">
            </label><br>                           
            <label> Adauga comenzi asteptare 
              <input type="checkbox" 
              id="AdaugaComenziAsteptare"  
              value="1">
            </label><br>                           
            <label> Modifica comenzi asteptare 
              <input type="checkbox" 
              id="ModificaComenziAsteptare"  
              value="1">
            </label><br>                           
            <label> Aproba comenzi asteptare 
              <input type="checkbox" 
              id="AprobaComenziAsteptare"  
              value="1">
            </label><br>                           
          </div>
          <!--stadiu comenzi-->
          <div class="col-sm-6 text-left">
          <h4> Acces stadiu comenzi</h4>
            <label> 
              <input type="checkbox" 
              id="ModDataLivrare"  
              value="1"
              > Modifica data livrare
            </label><br>                        
            <label> 
              <input type="checkbox" 
              id="DatPTam"  
              value="1"
              > Bifeaza dat productie tamplarie
            </label><br>                        
            <label> 
              <input type="checkbox" 
              id="DatPUmp"  
              value="1"
              > Bifeaza dat productie umplutura 
            </label><br>                        
            <label> 
              <input type="checkbox" 
              id="DatPAcc"  
              value="1"
              > Bifeaza dat productie accesorii 
            </label><br>                        
            <label> 
              <input type="checkbox" 
              id="TermTam"  
              value="1"
              > Bifeaza terminat tamplarie
            </label><br>                        
            <label> 
              <input type="checkbox" 
              id="TermUmp"  
              value="1"
              > Bifeaza terminat umplutura
            </label><br>                        
            <label> 
              <input type="checkbox" 
              id="TermAcc"  
              value="1"
              > Bifeaza terminat accesorii
            </label><br>                        
            <label> 
              <input type="checkbox" 
              id="OkFin"  
              value="1"
              > Bifeaza OK financiar 
            </label><br>                        
            <label> 
              <input type="checkbox" 
              id="Facturat"  
              value="1"
              > Bifeaza facturat 
            </label><br>                        
            <label> 
              <input type="checkbox" 
              id="Livrat"  
              value="1"
              > Bifeaza livrat
            </label><br>  
            <label> 
              <input type="checkbox" 
              id="AprobaComenziAsteptare"  
              value="1"
              > Aproba comenzi asteptare
            </label><br> 
            <label> 
              <input type="checkbox" 
              id="AnuleazaComenziAsteptare"  
              value="1"
              > Anuleaza comenzi asteptare
            </label><br>
            <label> 
              <input type="checkbox" 
              id="AnuleazaComenzi"  
              value="1"
              > Anuleaza comenzi
            </label><br>
            <h4> Acces fisiere</h4>
            <label> 
              <input type="checkbox" 
              id="IncarcaCFU"  
              value="1"
              > Incarca CFU
            </label><br>            
            <label> 
              <input type="checkbox" 
              id="DescarcaCFU"  
              value="1"
              > Descarca CFU
            </label><br>            
            <label> 
              <input type="checkbox" 
              id="IncarcaFactura"  
              value="1"
              > Incarca factura
            </label><br>            
            <label> 
              <input type="checkbox" 
              id="DescarcaFactura"  
              value="1"
              > Descarca factura
            </label><br>            
            <label> 
              <input type="checkbox" 
              id="StergeFactura"  
              value="1"
              > Sterge factura
            </label><br>            
            <label> 
              <input type="checkbox" 
              id="IncarcaDovadaPlata"  
              value="1"
              > Incarca dovada plata
            </label><br>            
            <label> 
              <input type="checkbox" 
              id="DescarcaDovadaPlata"  
              value="1"
              > Descarca DovadaPlata
            </label><br>            
            <label> 
              <input type="checkbox" 
              id="IncarcaFisierDiverse"  
              value="1"
              > Incarca fisier diverse
            </label><br>            
            <label> 
              <input type="checkbox" 
              id="DescarcaFisierDiverse"  
              value="1"
              > Descarca fisier diverse
            </label><br>            
          </div>                        
        </div>     
      </div>          
      <div class="modal-footer">
        <button type="button" id="brUser" class="btn btn-default" data-dismiss="modal">Renunta</button>
        <button type="button" class="btn btn-primary" onclick="updateData('adaugaUser')">Salveaza</button>
      </div>
    </form>                
    </div>
  </div>
</div>
<!------------------- sfarsit forma modala de adaugare user -------------------------->

<!------------------- inceput forma modala de adaugare zona livrare -------------------------->
<div class="modal fade" 
     id="adaugaZonaLivrare" 
     tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Adauga oras livrare</h4>
        <div class="alert alert-danger collapse js-div-info">
          <a href="#" class="close js-a-close">&times</a>
          <strong class="js-info1">Eroare/Succes </strong><span> </span><span class="js-info2"></span>
        </div>
      </div>
      <form id="js-form-zl" class="form-horizontal">
      <div class="modal-body">               
        <div class="form-group">
          <label for="NumeZona" class="col-sm-3 control-label">Nume oras:</label>
          <div class="col-sm-9">
            <input 
            type="text" 
            class="form-control" 
            placeholder="Introduceti nume oras"
            id="NumeZonaLivrare">
          </div>
        </div>

        <div class="form-group">
          <label for="Descriere" class="col-sm-3 control-label">Descriere traseu:</label>
          <div class="col-sm-9">
            <input 
            type="text" 
            class="form-control" 
            placeholder="Introduceti descriere traseu"
            id="Descriere">
          </div>
        </div>
        
        <div class="form-group">
          <label for="Distanta" class="col-sm-3 control-label">Distanta:</label>
          <div class="col-sm-9">
            <input 
            type="text" 
            class="form-control" 
            placeholder="Introduceti distanta"
            id="Distanta">
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
        <button type="button" class="btn btn-primary" onclick="updateData('adaugaZonaLivrare', '')">Salveaza</button>
      </div>
      </form>                
    </div>
  </div>
</div>
<!------------------- sfarsit forma modala de adaugare zona livrare --------------------------> 

<!------------------- inceput forma modala de adaugare filtre -------------------------->
<div class="modal fade" 
     id="filtre" 
     tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Seteaza filtre</h4>
       <div class="alert alert-danger collapse js-div-info">
          <a href="#" class="close js-a-close">&times</a>
          <strong class="js-info1">Eroare/Succes </strong><span> </span><span class="js-info2"></span>
        </div>
      </div>
      <form id="js-form-f" class="form-horizontal">
      <div class="modal-body">               
        <div class="form-group">
          <label for="fiTrLi" class="col-sm-4 control-label">Oras livrare:</label>
          <div class="col-sm-8">
            <select class="form-control" id="fiTrLi" name="fiTrLi">
              <?php $dateLivrare2 = $conbd->query ("SELECT ID, Nume FROM livrare ORDER BY Nume;");?>
              <option value="?">Fara...</option><?php
              while ($row6 = $dateLivrare2->fetch_assoc()){?>
              <option value="<?php echo $row6['ID'];?>" <?php if ($row6['ID'] == $_SESSION['fiTrLi']){echo 'selected';}?>>
                <?php echo $row6['Nume'];?>
              </option><?php 
              }?>
            </select>
          </div>
        </div> 

        <div class="form-group <?php if(EsteDealer() or VedeDoarComenzileProprii()){echo 'hidden';};?>">
          <label for="fiDeal" class="col-sm-4 control-label">Partener</label>
          <div class="col-sm-8">
            <?php $dateDealer = $conbd->query ("SELECT ID, Nume FROM dealeri ORDER BY Nume;");?>
            <select class="form-control" id="fiDeal" name="fiDeal">
              <option value="?">Fara...</option><?php
              while ($row3 = $dateDealer->fetch_assoc()){?>
             <option value="<?php echo $row3['ID']; ?>" <?php if($row3['ID'] == $_SESSION['fiDeal']){echo 'selected';}?>>
                <?php echo $row3['Nume'];?>
              </option><?php 
              }?>	 
            </select>
          </div>
        </div>   

        <div class="form-group <?php if(EsteDealer() or VedeDoarComenzileProprii()){echo 'hidden';};?>">
          <label for="fiResp" class="col-sm-4 control-label">Responsabil:</label>
          <div class="col-sm-8">
            <?php $dateResponsabil = $conbd->query ("SELECT ID, Nume FROM utilizatori WHERE Firma='".$_SESSION['producator']."' ORDER BY Nume ;");?>
            <select class="form-control" id="fiResp" name="fiResp">
              <option value="?">Fara...</option><?php
              while ($row7 = $dateResponsabil->fetch_assoc()){?>
              <option value="<?php echo $row7['ID']; ?>" <?php if($row7['ID'] == $_SESSION['fiResp']){echo 'selected';}?>>
                <?php echo $row7['Nume'];?>
              </option><?php 
              }?>	 
            </select>
          </div>
        </div>                        
        
        <div class="form-group">
          <label for="fiDeLa" class="col-sm-4 control-label">De la:</label>
          <div class="col-sm-2">
            <div class="datepicker" id="dp">
              <input type="text" class="form-control" 
              id="fiDeLa"
              value="<?php echo $_SESSION['fiDeLa'];?>" />
            </div>
          </div>
          <label for="fiPaLa" class="col-sm-2 control-label">Pana la:</label>
          <div class="col-sm-2">
            <div class="datepicker" id="dp">
              <input type="text" class="form-control" 
              id="fiPaLa"
              value="<?php echo $_SESSION['fiPaLa'];?>" />
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="radio-inline col-sm-6 text-right">
            <input type="radio" name="tipFiltruData" value="DataCreare" 
            <?php if ($_SESSION['tipFiltruData'] == 'DataCreare') {echo 'checked';}?>>dupa data creare
          </label>
          <label class="radio-inline col-sm-4 text-center">
            <input type="radio" name="tipFiltruData" value="DataLivrare"
            <?php if ($_SESSION['tipFiltruData'] == 'DataLivrare') {echo 'checked';}?>>dupa data livrare   
          </label> 
        </div>
        <div class="form-group">                               
          <label class="radio-inline col-sm-2"></label>
          <label class="radio-inline col-sm-3 text-right">
            <input type="radio" name="fiCuMo" value="1" 
            <?php if ($_SESSION['fiCuMo'] == '1') {echo 'checked';}?>>Cu montaj
          </label>
          <label class="radio-inline col-sm-3 text-center">
            <input type="radio" name="fiCuMo" value="0"
            <?php if ($_SESSION['fiCuMo'] == '0') {echo 'checked';}?>>Fara montaj    
          </label>                   
          <label class="radio-inline col-sm-3 text-left">
            <input type="radio" name="fiCuMo" value="?"
            <?php if ($_SESSION['fiCuMo'] == '?') {echo 'checked';}?>>Toate
          </label>                   
        </div>         
        <div class="form-group">                               
          <label class="radio-inline col-sm-2"></label>
          <label class="radio-inline col-sm-3 text-right">
            <input type="radio" name="fiCuFa" value="1" 
            <?php if ($_SESSION['fiCuFa'] == '1') {echo 'checked';}?>>Facturate
          </label>
          <label class="radio-inline col-sm-3 text-center">
            <input type="radio" name="fiCuFa" value="0"
            <?php if ($_SESSION['fiCuFa'] == '0') {echo 'checked';}?>>Nefacturate    
          </label>                   
          <label class="radio-inline col-sm-3 text-left">
            <input type="radio" name="fiCuFa" value="?"
            <?php if ($_SESSION['fiCuFa'] == '?') {echo 'checked';}?>>Toate
          </label>                   
        </div> 
        
        <div class="<?php if(EsteDealer()){echo 'hidden';};?>">
          <div class="form-group">                               
            <label class="radio-inline col-sm-4 text-right">Dat in productie tamplaria</label>
            <label class="radio-inline col-sm-2 text-right">
              <input type="radio" name="fiDatProdTamp" value="1" 
              <?php if ($_SESSION['fiDatProdTamp'] == '1') {echo 'checked';}?>>Da
            </label>
            <label class="radio-inline col-sm-2 text-center">
              <input type="radio" name="fiDatProdTamp" value="0"
              <?php if ($_SESSION['fiDatProdTamp'] == '0') {echo 'checked';}?>>Nu    
            </label>                   
            <label class="radio-inline col-sm-2 text-left">
              <input type="radio" name="fiDatProdTamp" value="?"
              <?php if ($_SESSION['fiDatProdTamp'] == '?') {echo 'checked';}?>>Toate
            </label>                   
          </div>         

          <div class="form-group">                               
            <label class="radio-inline col-sm-4 text-right">Dat in productie umplutura</label>
            <label class="radio-inline col-sm-2 text-right">
              <input type="radio" name="fiDatProdUmp" value="1" 
              <?php if ($_SESSION['fiDatProdUmp'] == '1') {echo 'checked';}?>>Da
            </label>
            <label class="radio-inline col-sm-2 text-center">
              <input type="radio" name="fiDatProdUmp" value="0"
              <?php if ($_SESSION['fiDatProdUmp'] == '0') {echo 'checked';}?>>Nu    
            </label>                   
            <label class="radio-inline col-sm-2 text-left">
              <input type="radio" name="fiDatProdUmp" value="?"
              <?php if ($_SESSION['fiDatProdUmp'] == '?') {echo 'checked';}?>>Toate
            </label>                   
          </div>         

          <div class="form-group">                               
            <label class="radio-inline col-sm-4 text-right">Dat in productie accesoriile</label>
            <label class="radio-inline col-sm-2 text-right">
              <input type="radio" name="fiDatProdAcc" value="1" 
              <?php if ($_SESSION['fiDatProdAcc'] == '1') {echo 'checked';}?>>Da
            </label>
            <label class="radio-inline col-sm-2 text-center">
              <input type="radio" name="fiDatProdAcc" value="0"
              <?php if ($_SESSION['fiDatProdAcc'] == '0') {echo 'checked';}?>>Nu    
            </label>                   
            <label class="radio-inline col-sm-2 text-left">
              <input type="radio" name="fiDatProdAcc" value="?"
              <?php if ($_SESSION['fiDatProdAcc'] == '?') {echo 'checked';}?>>Toate
            </label>                   
          </div>    

          <div class="form-group">                               
            <label class="radio-inline col-sm-4 text-right">Terminat tamplaria</label>
            <label class="radio-inline col-sm-2 text-right">
              <input type="radio" name="fiTermTamp" value="1" 
              <?php if ($_SESSION['fiTermTamp'] == '1') {echo 'checked';}?>>Da
            </label>
            <label class="radio-inline col-sm-2 text-center">
              <input type="radio" name="fiTermTamp" value="0"
              <?php if ($_SESSION['fiTermTamp'] == '0') {echo 'checked';}?>>Nu    
            </label>                   
            <label class="radio-inline col-sm-2 text-left">
              <input type="radio" name="fiTermTamp" value="?"
              <?php if ($_SESSION['fiTermTamp'] == '?') {echo 'checked';}?>>Toate
            </label>                   
          </div>         

          <div class="form-group">                               
            <label class="radio-inline col-sm-4 text-right">Terminat umplutura</label>
            <label class="radio-inline col-sm-2 text-right">
              <input type="radio" name="fiTermUmp" value="1" 
              <?php if ($_SESSION['fiTermUmp'] == '1') {echo 'checked';}?>>Da
            </label>
            <label class="radio-inline col-sm-2 text-center">
              <input type="radio" name="fiTermUmp" value="0"
              <?php if ($_SESSION['fiTermUmp'] == '0') {echo 'checked';}?>>Nu    
            </label>                   
            <label class="radio-inline col-sm-2 text-left">
              <input type="radio" name="fiTermUmp" value="?"
              <?php if ($_SESSION['fiTermUmp'] == '?') {echo 'checked';}?>>Toate
            </label>                   
          </div>         

          <div class="form-group">                               
            <label class="radio-inline col-sm-4 text-right">Terminat accesoriile</label>
           <label class="radio-inline col-sm-2 text-right">
              <input type="radio" name="fiTermAcc" value="1" 
              <?php if ($_SESSION['fiTermAcc'] == '1') {echo 'checked';}?>>Da
            </label>
            <label class="radio-inline col-sm-2 text-center">
              <input type="radio" name="fiTermAcc" value="0"
              <?php if ($_SESSION['fiTermAcc'] == '0') {echo 'checked';}?>>Nu    
            </label>                   
            <label class="radio-inline col-sm-2 text-left">
              <input type="radio" name="fiTermAcc" value="?"
              <?php if ($_SESSION['fiTermAcc'] == '?') {echo 'checked';}?>>Toate
            </label>                   
          </div>         

          <div class="form-group">                               
            <label class="radio-inline col-sm-4 text-right">Livrate partial</label>
            <label class="radio-inline col-sm-2 text-right">
              <input type="radio" name="fiLivrPart" value="1" 
              <?php if ($_SESSION['fiLivrPart'] == '1') {echo 'checked';}?>>Da
            </label>
            <label class="radio-inline col-sm-2 text-center">
              <input type="radio" name="fiLivrPart" value="0"
              <?php if ($_SESSION['fiLivrPart'] == '0') {echo 'checked';}?>>Nu    
            </label>                   
            <label class="radio-inline col-sm-2 text-left">
              <input type="radio" name="fiLivrPart" value="?"
              <?php if ($_SESSION['fiLivrPart'] == '?') {echo 'checked';}?>>Toate
            </label>                   
          </div>            
          
          <div class="form-group">                               
            <label class="radio-inline col-sm-4 text-right">Livrate</label>
            <label class="radio-inline col-sm-2 text-right">
              <input type="radio" name="fiLivr" value="1" 
              <?php if ($_SESSION['fiLivr'] == '1') {echo 'checked';}?>>Da
            </label>
            <label class="radio-inline col-sm-2 text-center">
              <input type="radio" name="fiLivr" value="0"
              <?php if ($_SESSION['fiLivr'] == '0') {echo 'checked';}?>>Nu    
            </label>                   
            <label class="radio-inline col-sm-2 text-left">
              <input type="radio" name="fiLivr" value="?"
              <?php if ($_SESSION['fiLivr'] == '?') {echo 'checked';}?>>Toate
            </label>                   
          </div>  
        </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
        <button type="button" class="btn btn-primary" onclick="updateData('seteazaFiltre', '')">Aplica</button>
      </div>
      </form>                
    </div>
  </div>
</div>
<!------------------- sfarsit forma modala de adaugare filtre --------------------------> 

<!------------------ Modalul butonului de modificare comanda --------------------------->        
<div class="modal fade text-center" 
     id="mc" 
     tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="mcTitlu1">
          Editare comanda .... din data de ....
        </h4>
        <h4 class="modal-title" id="mcTitlu2">
          Beneficiar ...
        </h4>
      </div>
      <div class="modal-body">   
      <form class="form-horizontal">
        <input type="hidden" id="mcIDComanda" value="..." />
        <input type="hidden" id="mcIDResponsabil" value="..." />
          <div class="form-group">
            <div <?php echo AccesComanda();?>>
              <label for="mcNume" class="col-sm-2 control-label">Lucrare:</label>
              <div class="col-sm-4">
                <input <?php echo AccesComanda();?>
                type="text" class="form-control" 
                id="mcNume"
                value="" />
              </div>                      
            </div>
            
            <div <?php echo AccesComanda();?>>
              <label for="mcAnulata" class="checkbox-inline">
                <input id="mcAnulata" type="checkbox" 
                <?php if(!AnuleazaC()){echo 'disabled';};?>>
                Anulata
              </label>               
            </div>
          </div> 
        
          <div class="form-group">
            <div <?php echo AccesComanda();?>>
              <label for="mcValoare" class="col-sm-2 control-label">Valoare:</label>
              <div class="col-sm-4">
                <input <?php echo AccesComanda();?>
                type="text" class="form-control" 
                id="mcValoare"
                value="..." />
              </div>              
            </div>                    
            
            <div <?php echo AccesComanda();?>>
              <label for="mcIncasat" class="col-sm-2 control-label">Incasat:</label>
              <div class="col-sm-4">
                <input <?php echo AccesComanda();?>
                type="text" class="form-control" 
                id="mcIncasat"
                value="..." />
              </div>              
            </div>
          </div>         

          <div class="form-group">            
            <label for="mcDataLivrare" class="col-sm-2 control-label">Livrare in:</label>
            <div class="col-sm-4">
              <div class="datepicker" id="dp">
                <input type="text" class="form-control"  <?php if(!DataLi()){echo 'disabled';};?>
                id="mcDataLivrare"
                value="..." />
              </div>
            </div>

            <div <?php echo AccesComanda();?>>
              <label for="mcAdresaLivrare" class="col-sm-2 control-label">Livrare la:</label>
              <div class="col-sm-4">
                <input <?php echo AccesComanda();?>
                type="text" class="form-control" 
                id="mcAdresaLivrare"
                value="..." />
              </div> 
            </div>  
          </div>                     

          <div class="form-group">            
            <div <?php echo AccesComanda();?>>
              <label for="mcIDLivrare" class="col-sm-2 control-label">Oras livrare:</label>
              <div class="col-sm-4">
                <select class="form-control" id="mcIDLivrare" name="mcIDLivrare" <?php echo AccesComanda();?>>
                  <?php $dl = $conbd->query ("SELECT ID, Nume FROM livrare ORDER BY Nume;");?>
                  <option value="0">Alege oras de livrare</option><?php
                  while ($r2 = $dl->fetch_assoc()){?>
                  <option value="<?php echo $r2['ID'];?>">
                    <?php echo $r2['Nume'];?>
                  </option><?php 
                  }?>
                </select>
              </div>
            </div>
            <div <?php echo AccesComanda();?>>
              <label for="mcSuprafata" class="col-sm-2 control-label">Suprafata:</label>
              <div class="col-sm-4">
                <input <?php echo AccesComanda();?>
                type="text" class="form-control" 
                id="mcSuprafata"
                value="..." />
              </div> 
            </div>
          </div>                     

          <div class="form-group">
            <div <?php echo AccesComanda();?>>
              <label for="mcGreutate" class="col-sm-2 control-label">Greutate:</label>
              <div class="col-sm-4">
                <input <?php echo AccesComanda();?>
                type="text" class="form-control" 
                id="mcGreutate"
                value="..." />
              </div>                      
            </div>
            <div <?php echo AccesComanda();?>>
              <label for="mcFerestre" class="col-sm-2 control-label">Ferestre:</label>
              <div class="col-sm-4">
                <input <?php echo AccesComanda();?>
                type="text" class="form-control" 
                id="mcFerestre"
                value="..." />
              </div>
            </div>
          </div>   

          <div class="form-group">            
            <div <?php echo AccesComanda();?>>
              <label for="mcUsi" class="col-sm-2 control-label">Usi:</label>
              <div class="col-sm-4">
                <input <?php echo AccesComanda();?>
                type="text" class="form-control" 
                id="mcUsi"
                value="..." />
              </div>
            </div>
            <div <?php echo AccesComanda();?>>
              <label class="radio-inline">
                <input <?php echo AccesComanda();?> type="radio" name="mcMontaj" value="1">Cu montaj
              </label>
              <label class="radio-inline">
                <input <?php echo AccesComanda();?> type="radio" name="mcMontaj" value="0">Fara montaj    
              </label>             
            </div>  
          </div>                     

          <div class="form-group">
            <div <?php echo AccesComanda();?>>
              <label for="mcDescriere" class="col-sm-2 control-label">Descriere:</label>
              <div class="col-sm-10">
                <input <?php echo AccesComanda();?>
                type="text" class="form-control" 
                id="mcDescriere"
                value="..." />
              </div>
            </div>
          </div> 
        
          <div class="form-group">
            <div <?php echo AccesComanda();?>>
              <label for="mcObservatie" class="col-sm-2 control-label">Obs. noua:</label>
              <div class="col-sm-10">
                <input <?php echo AccesComanda();?>
                type="text" class="form-control" 
                id="mcObservatie"/>
              </div>
            </div>
          </div> 
        
          <div class="text-center text-info" id="listaObservatii"></div>         
          <div class="form-group">                               
            <label id="mcLa1" class="checkbox-inline">
              <input id="mcIn1" type="checkbox" 
              <?php if(!DatPTam()){echo 'disabled';};?>>
              Dat in productie tamplarie
            </label>

            <label id="mcLa2" class="checkbox-inline">
             <input id="mcIn2" type="checkbox" 
              <?php if(!DatPUmp()){echo 'disabled';};?>>
              Dat in productie umplutura
            </label>

            <label id="mcLa3" class="checkbox-inline">
              <input id="mcIn3" type="checkbox" 
              <?php if(!DatPAcc()){echo 'disabled';};?>>
              Dat in productie accesoriile
            </label>                     
          </div>                    

          <div class="form-group">                               
            <label id="mcLa4" class="checkbox-inline">
              <input id="mcIn4" type="checkbox" 
              <?php if(!TerTam()){echo 'disabled';};?>>
              Terminat tamplarie
            </label>

            <label id="mcLa5" class="checkbox-inline">
              <input id="mcIn5" type="checkbox" 
              <?php if(!TerUmp()){echo 'disabled';};?>>
              Terminat umplutura
            </label>

            <label id="mcLa6" class="checkbox-inline">
              <input id="mcIn6" type="checkbox" 
              <?php if(!TerAcc()){echo 'disabled';};?>>
              Terminat accesoriile
            </label>                     
          </div>  

          <div class="form-group">                               
            <label id="mcLa7" class="checkbox-inline">
              <input id="mcIn7" type="checkbox" 
              <?php if(!OkFin()){echo 'disabled';};?>>
              OK financiar
            </label>

            <label id="mcLa8" class="checkbox-inline">
              <input id="mcIn8" type="checkbox" 
              <?php if(!Fact()){echo 'disabled';};?>>
              Facturat
            </label>

            <label id="mcLa10" class="checkbox-inline">
              <input id="mcIn10" type="checkbox" 
              <?php if(!Livr()){echo 'disabled';};?>>
              Livrat partial
            </label>             
          
            <label id="mcLa9" class="checkbox-inline">
              <input id="mcIn9" type="checkbox" 
              <?php if(!Livr()){echo 'disabled';};?>>
              Livrat
            </label>             
          </div>  
          <div class="form-group">                               
            <label for="mcStergeFactura" class="checkbox-inline">
              <input id="mcStergeFactura" type="checkbox" 
              <?php if(!StergeFactura()){echo 'disabled';};?>>
              Sterge factura
            </label> 
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
          <button id="mcSubmit" type="button" class="btn btn-primary <?php if(EsteDealer()){echo 'hidden';};?>" onclick="">Salveaza</button>
        </div>
      </form>                
      </div>
    </div>
  </div>
</div>
<!-- sfarsit modal de modificare comanda -->     

<!------------------ Modalul butonului de modificare comanda ASTEPTARE--------------------------->        
<div class="modal fade text-center" 
     id="mca" 
     tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="mcaTitlu1">
          Editare comanda .... din data de ....
        </h4>
        <h4 class="modal-title" id="mcaTitlu2">
          Beneficiar ...
        </h4>
      </div>
      <div class="modal-body">   
      <form class="form-horizontal">
        <input type="hidden" id="mcaIDComanda" value="..." />
        <input type="hidden" id="mcaIDResponsabil" value="..." />
          <div class="form-group">
          <div <?php echo AccesComanda();?>>
            <label for="mcaNume" class="col-sm-2 control-label">Lucrare:</label>
            <div class="col-sm-4">
              <input <?php echo AccesComanda();?>
              type="text" class="form-control" 
              id="mcaNume"
              value="" />
            </div>                      
          </div>
          <label for="mcaAnulata" class="checkbox-inline">
            <input id="mcaAnulata" type="checkbox" 
            <?php if(!AnuleazaCA()){echo 'disabled';};?>>
            Anulata
          </label>                     
        </div>  
          <div class="form-group">            
            <div <?php echo AccesComanda();?>>
              <label for="mcaIDLivrare" class="col-sm-2 control-label">Oras livrare:</label>
              <div class="col-sm-4">
                <select class="form-control" id="mcaIDLivrare" name="mcaIDLivrare" <?php echo AccesComanda();?>>
                  <?php $dca = $conbd->query ("SELECT ID, Nume FROM livrare ORDER BY Nume;");?>
                  <option value="0">Alege oras de livrare</option><?php
                  while ($r3 = $dca->fetch_assoc()){?>
                  <option value="<?php echo $r3['ID'];?>">
                    <?php echo $r3['Nume'];?>
                  </option><?php 
                  }?>
                </select>
              </div>
              <div class="form-group">                               
                <label for="mcaStergeFactura" class="checkbox-inline">
                  <input id="mcaStergeFactura" type="checkbox" 
                  <?php if(!StergeFactura()){echo 'disabled';};?>>
                  Sterge factura
                </label> 
              </div>              
            </div>
          </div>               
        <div class="form-group">
          <div <?php echo AccesComanda();?>>
            <label for="mcaObservatie" class="col-sm-2 control-label">Obs. noua:</label>
            <div class="col-sm-10">
              <input <?php echo AccesComanda();?>
              type="text" class="form-control" 
             id="mcaObservatie"/>
            </div>
          </div>
        </div> 
        <div class="text-center text-info" id="listaObservatiiCoAs"></div>  
          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
          <button id="mcaSubmit" type="button" class="btn btn-primary" onclick="">Salveaza</button>
        </div>
      </form>                
      </div>
    </div>
  </div>
</div>
<!-- sfarsit modal de modificare comanda ASTEPTARE--> 

<!------------------ Modalul butonului de incarcare fisiere--------------------------->        
<div class="modal fade text-center" 
     id="upload" 
     tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="uploadTitlu1">
          Incarca fisier pentru comanda....
        </h4>
        <h4 class="modal-title" id="uploadTitlu2">
          Beneficiar ...
        </h4>
        <div class="alert alert-danger collapse js-div-info">
          <a href="#" class="close js-a-close">&times</a>
          <strong class="js-info1">Eroare/Succes </strong><span> </span><span class="js-info2"></span>
        </div>
      </div>
      <div class="modal-body">   
      <form class="form-horizontal" enctype="multipart/form-data">
        <div class="form-group" id="divNrFactura">            
          <div>
            <label for="ufNrFactura" class="col-sm-2 control-label">Numar factura:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="ufNrFactura"/>
            </div> 
          </div>
          <label id="lblCuDeclaratii" for="ufCuDeclaratii" class="checkbox-inline col-sm-4">
            <input id="ufCuDeclaratii" type="checkbox" checked="checked">
            Genereaza certificate sau declaratii
          </label> 
        </div>  
        <div class="form-group" id="divValoareFactura">            
          <div>
            <label for="ufValoareFactura" class="col-sm-2 control-label">Valoare:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="ufValoareFactura"/>
            </div> 
          </div>
        </div>          
        <div class="form-group">
          <div <?php //echo AccesComanda();?>>
            <label for="uploadFile" class="col-sm-2 control-label">Fisier:</label>
            <div class="col-sm-8">
              <input <?php //echo AccesComanda();?>
              type="file" class="form-control" 
              id="uploadFile"
              value="" />
            </div>                      
          </div>                    
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>
          <button id="uploadSubmit" type="button" class="btn btn-primary" onclick="">Incarca</button>
        </div>
      </form>                
      </div>
    </div>
  </div>
</div>
<!-- sfarsit modal de incarcare fisiere-->