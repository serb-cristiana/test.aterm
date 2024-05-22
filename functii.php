<?php

function ConectareBd(){
    global $conbd;
    $conbd = new mysqli($_SESSION['adresa_server'], $_SESSION['user_mysql'], $_SESSION['pass_mysql'], $_SESSION['bd_mysql']);
}

function SeteazaFiltreComenzi(){
  //traseu livrare
  if($_SESSION['pag'] == 'comenzi' or $_SESSION['pag'] == 'comenziAnulate' || $_SESSION['pag'] == 'productie'){ //daca e ptr. lista comenzi sau productie
    if((!isset($_SESSION['fiTrLi'])) or ($_SESSION['fiTrLi'] == '?')){
      $filtru_traseu_livrare = '';
      $_SESSION['fiTrLi'] = '?';
    }else{
      $filtru_traseu_livrare = "AND co.IDLivrare='".$_SESSION['fiTrLi']."'";
    }
  }else if($_SESSION['pag'] == 'asteptare' || $_SESSION['pag'] == 'asteptareAnulate'){ //daca e ptr. lista comenzi asteptare sau anulate
    $filtru_traseu_livrare = '';
  }else{
    $filtru_traseu_livrare = '';
  }

  //dealer
  if((!isset($_SESSION['fiDeal'])) or ($_SESSION['fiDeal'] == '?')){
    $filtru_pe_dealer = '';
    $_SESSION['fiDeal'] = '?';
  }else{
   if($_SESSION['pag'] == 'comenzi' || $_SESSION['pag'] == 'comenziAnulate' || $_SESSION['pag'] == 'productie'){      
      $filtru_pe_dealer = "AND IDClient='".$_SESSION['fiDeal']."'";
    }else if($_SESSION['pag'] == 'asteptare' || $_SESSION['pag'] == 'asteptareAnulate'){
      $filtru_pe_dealer = "AND IDDealer='".$_SESSION['fiDeal']."'";      
    }else{
      $filtru_pe_dealer = '';
    }
  }  

  //responsabil
  if((!isset($_SESSION['fiResp'])) or ($_SESSION['fiResp'] == '?')){
    $filtru_pe_responsabil = '';
    $_SESSION['fiResp'] = '?';
  }else{
    $filtru_pe_responsabil = "AND co.IDResponsabil='".$_SESSION['fiResp']."'";
  }
  
  //tip filtru data
  if(!isset($_SESSION['tipFiltruData'])){
    $_SESSION['tipFiltruData'] = 'DataCreare';
  }
  
  //data creare sau livrare / livrare
  if($_SESSION['pag'] == 'comenzi' or $_SESSION['pag'] == 'comenziAnulate' || $_SESSION['pag'] == 'raportDeclaratii'){ //daca e ptr. lista comenzi sau declaratii
    if(!isset($_SESSION['fiDeLa'])){
      $_SESSION['fiDeLa'] = date('d.m.Y', strtotime(date('d.m.Y').'-30 day'));
    }
    $filtru_de_la_data_creare = "AND ".$_SESSION['tipFiltruData']." >= '".UFDate($_SESSION['fiDeLa'])."'";
    if(!isset($_SESSION['fiPaLa'])){
      $_SESSION['fiPaLa'] = date('d.m.Y');
    }
    $filtru_pana_la_data_creare = "AND ".$_SESSION['tipFiltruData']." <= '".UFDate($_SESSION['fiPaLa'])."'";
    $filtru_data_livrare = "";
  }else if($_SESSION['pag'] == 'asteptare' || $_SESSION['pag'] == 'asteptareAnulate'){ //daca e ptr. lista comenzi asteptare
    if(!isset($_SESSION['fiDeLa'])){
      $_SESSION['fiDeLa'] = date('d.m.Y', strtotime(date('d.m.Y').'-30 day'));
    }
    $filtru_de_la_data_creare = "AND DataCreare >= '".UFDate($_SESSION['fiDeLa'])."'";
    if(!isset($_SESSION['fiPaLa'])){
      $_SESSION['fiPaLa'] = date('d.m.Y');
    }
    $filtru_pana_la_data_creare = "AND DataCreare <= '".UFDate($_SESSION['fiPaLa'])."'";
    $filtru_data_livrare = "";
  }else if($_SESSION['pag'] == 'productie'){ //daca e ptr. productie    
    if(!isset($_SESSION['DeLaDaLi'])){    
      $_SESSION['DeLaDaLi'] = date('Y-m-d', strtotime('-'.(date('w')-1).' days'));
    }    
    $filtru_de_la_data_creare = "";
    $filtru_pana_la_data_creare = "";
  }else{
    $filtru_de_la_data_creare = "";
    $filtru_pana_la_data_creare = "";    
  }
  
  //filtru cu montaj
  if($_SESSION['pag'] == 'comenzi' or $_SESSION['pag'] == 'comenziAnulate' || $_SESSION['pag'] == 'productie'){ //daca e ptr. lista comenzi sau productie
    if((!isset($_SESSION['fiCuMo'])) or ($_SESSION['fiCuMo'] == '?')){
      $filtru_montaj = "";
      $_SESSION['fiCuMo'] = '?';
    }else{
      $filtru_montaj = "AND CuMontaj='".$_SESSION['fiCuMo']."'";
    }
  }else if($_SESSION['pag'] == 'asteptare' || $_SESSION['pag'] == 'asteptareAnulate'){ //daca e ptr. lista comenzi sau productie
    $filtru_montaj = "";
  }else{
    $filtru_montaj = "";
  }
  
  //filtru facturat/nefacturat/toate
  if((!isset($_SESSION['fiCuFa'])) or ($_SESSION['fiCuFa'] == '?')){
    $filtru_factura = "";
    $_SESSION['fiCuFa'] = '?';
  }else if($_SESSION['fiCuFa'] == 1){
    $filtru_factura = 'AND NrFactura > ""';
  }else if($_SESSION['fiCuFa'] == 0){
    $filtru_factura = 'AND NOT (NrFactura > "")';
  }else{
    $filtru_factura = "";
  }
  
  //filtru DatProdTamp/nedate/toate
  if((!isset($_SESSION['fiDatProdTamp'])) or ($_SESSION['fiDatProdTamp'] == '?')){
    $filtru_DatProdTamp = "";
    $_SESSION['fiDatProdTamp'] = '?';
  }else if($_SESSION['fiDatProdTamp'] == 1){
    $filtru_DatProdTamp = 'AND SUBSTRING(Stadiu, 2, 1) = "1"';
  }else if($_SESSION['fiDatProdTamp'] == 0){
    $filtru_DatProdTamp = 'AND SUBSTRING(Stadiu, 2, 1) = "0"';
  }else{
    $filtru_DatProdTamp = "";
  }
  
  //filtru DatProdUmp/nedate/toate
  if((!isset($_SESSION['fiDatProdUmp'])) or ($_SESSION['fiDatProdUmp'] == '?')){
    $filtru_DatProdUmp = "";
    $_SESSION['fiDatProdUmp'] = '?';
  }else if($_SESSION['fiDatProdUmp'] == 1){
    $filtru_DatProdUmp = 'AND SUBSTRING(Stadiu, 3, 1) = "1"';
  }else if($_SESSION['fiDatProdUmp'] == 0){
    $filtru_DatProdUmp = 'AND SUBSTRING(Stadiu, 3, 1) = "0"';
  }else{
    $filtru_DatProdUmp = "";
  }
  
    //filtru DatProdAcc/nedate/toate
  if((!isset($_SESSION['fiDatProdAcc'])) or ($_SESSION['fiDatProdAcc'] == '?')){
    $filtru_DatProdAcc = "";
    $_SESSION['fiDatProdAcc'] = '?';
  }else if($_SESSION['fiDatProdAcc'] == 1){
    $filtru_DatProdAcc = 'AND SUBSTRING(Stadiu, 4, 1) = "1"';
  }else if($_SESSION['fiDatProdAcc'] == 0){
    $filtru_DatProdAcc = 'AND SUBSTRING(Stadiu, 4, 1) = "0"';
  }else{
    $filtru_DatProdAcc = "";
  }

    //filtru TermTamp/neterminate/toate
  if((!isset($_SESSION['fiTermTamp'])) or ($_SESSION['fiTermTamp'] == '?')){
    $filtru_TermTamp = "";
    $_SESSION['fiTermTamp'] = '?';
  }else if($_SESSION['fiTermTamp'] == 1){
    $filtru_TermTamp = 'AND SUBSTRING(Stadiu, 5, 1) = "1"';
  }else if($_SESSION['fiTermTamp'] == 0){
    $filtru_TermTamp = 'AND SUBSTRING(Stadiu, 5, 1) = "0"';
  }else{
    $filtru_TermTamp = "";
  }
  
  //filtru TermUmp/neterminate/toate
  if((!isset($_SESSION['fiTermUmp'])) or ($_SESSION['fiTermUmp'] == '?')){
    $filtru_TermUmp = "";
    $_SESSION['fiTermUmp'] = '?';
  }else if($_SESSION['fiTermUmp'] == 1){
    $filtru_TermUmp = 'AND SUBSTRING(Stadiu, 6, 1) = "1"';
  }else if($_SESSION['fiTermUmp'] == 0){
    $filtru_TermUmp = 'AND SUBSTRING(Stadiu, 6, 1) = "0"';
  }else{
    $filtru_TermUmp = "";
  }
  
    //filtru TermAcc/neterminate/toate
  if((!isset($_SESSION['fiTermAcc'])) or ($_SESSION['fiTermAcc'] == '?')){
    $filtru_TermAcc = "";
    $_SESSION['fiTermAcc'] = '?';
  }else if($_SESSION['fiTermAcc'] == 1){
    $filtru_TermAcc = 'AND SUBSTRING(Stadiu, 7, 1) = "1"';
  }else if($_SESSION['fiTermAcc'] == 0){
    $filtru_TermAcc = 'AND SUBSTRING(Stadiu, 7, 1) = "0"';
  }else{
    $filtru_TermAcc = "";
  }
  
      //filtru Livrate/nelivrate/toate
  if((!isset($_SESSION['fiLivr'])) or ($_SESSION['fiLivr'] == '?')){
    $filtru_Livr = "";
    $_SESSION['fiLivr'] = '?';
  }else if($_SESSION['fiLivr'] == 1){
    $filtru_Livr = 'AND SUBSTRING(Stadiu, 10, 1) = "1"';
  }else if($_SESSION['fiLivr'] == 0){
    $filtru_Livr = 'AND SUBSTRING(Stadiu, 10, 1) = "0"';
  }else{
    $filtru_Livr = "";
  }
  
      //filtru LivratePartial/nelivratePartial/toate
  if((!isset($_SESSION['fiLivrPart'])) or ($_SESSION['fiLivrPart'] == '?')){
    $filtru_LivrPart = "";
    $_SESSION['fiLivrPart'] = '?';
  }else if($_SESSION['fiLivrPart'] == 1){
    $filtru_LivrPart = 'AND SUBSTRING(Stadiu, 11, 1) = "1"';
  }else if($_SESSION['fiLivrPart'] == 0){
    $filtru_LivrPart = 'AND SUBSTRING(Stadiu, 11, 1) = "0"';
  }else{
    $filtru_LivrPart = "";
  }  
  
  // filtru pe dealer (cand se logheaza un dealer)
  if(EsteDealer()){
    if($_SESSION['pag'] == 'comenzi' or $_SESSION['pag'] == 'comenziAnulate' || $_SESSION['pag'] == 'productie'){ //daca e ptr. lista comenzi sau productie
      $filtru_dealer = "AND IDClient='".$_SESSION['firma'][1]."'";
    }else if($_SESSION['pag'] == 'asteptare' || $_SESSION['pag'] == 'asteptareAnulate'){ //daca e ptr. lista comenzi sau productie
      $filtru_dealer = "AND IDDealer='".$_SESSION['firma'][1]."'";
    }else{
      $filtru_dealer = "";
    }
  }else{
    $filtru_dealer = "";
  }
  
  // filtru pe utilizator care vede doar comenzi proprii
  if(VedeDoarComenzileProprii()){
    if($_SESSION['pag'] == 'comenzi' or $_SESSION['pag'] == 'comenziAnulate' || $_SESSION['pag'] == 'productie'){ //daca e ptr. lista comenzi sau productie
      $filtru_vedeDoarComenzileProprii = "AND co.IDResponsabil='".$_SESSION['idUtilizator']."'";
    }else if($_SESSION['pag'] == 'asteptare' || $_SESSION['pag'] == 'asteptareAnulate'){ //daca e ptr. lista comenzi sau productie
     $filtru_vedeDoarComenzileProprii = "AND co.IDResponsabil='".$_SESSION['idUtilizator']."'";
   }else{
      $filtru_vedeDoarComenzileProprii = "";
    }
  }else{
   $filtru_vedeDoarComenzileProprii = "";
  }
  $fc = $filtru_traseu_livrare.' '.$filtru_pe_dealer.' '.$filtru_pe_responsabil;
  $fc = $fc.' '.$filtru_de_la_data_creare.' '.$filtru_pana_la_data_creare;
  $fc = $fc.' '.$filtru_montaj.' '.$filtru_dealer.' '.$filtru_factura.' ';
  $fc = $fc.' '.$filtru_DatProdTamp.' '.$filtru_DatProdUmp.' '.$filtru_DatProdAcc.' ';
  $fc = $fc.' '.$filtru_TermTamp.' '.$filtru_TermUmp.' '.$filtru_TermAcc.' ';
  $fc = $fc.' '.$filtru_Livr.' '.$filtru_LivrPart.' '.$filtru_vedeDoarComenzileProprii.' ';
    if(isset($_SESSION['cautaNumeComanda']) && $_SESSION['cautaNumeComanda'] != '' && $_SESSION['pag'] == 'comenzi'){
    $fc = 'AND co.nume LIKE "%'.$_SESSION['cautaNumeComanda'].'%"'.' '.$filtru_dealer.' '.$filtru_vedeDoarComenzileProprii.' ';
  }
   return $fc;
}

function SeteazaTextFiltre($cbd){
  $tf = '';
  if($_SESSION['fiDeal'] != '?'){
    $sqlStr = 'SELECT Nume FROM dealeri WHERE ID='.$_SESSION['fiDeal'].';';
    $result = $cbd->query($sqlStr);
    if($result->num_rows == 1){
      $row = $result->fetch_assoc();
      $tf .= $row['Nume'].'<br>';
    }
  }
  
  if($_SESSION['fiResp'] != '?'){
    $sqlStr = 'SELECT Nume FROM utilizatori WHERE ID='.$_SESSION['fiResp'].';';
    $result = $cbd->query($sqlStr);
    if($result->num_rows == 1){
      $row = $result->fetch_assoc();
      $tf .= $row['Nume'].'<br>';
    }
  }
  
  if($_SESSION['pag'] == 'comenzi' or $_SESSION['pag'] == 'comenziAnulate' || $_SESSION['pag'] == 'productie'){
    if($_SESSION['fiTrLi'] != '?'){
      $sqlStr = 'SELECT Nume FROM livrare WHERE ID='.$_SESSION['fiTrLi'].';';
      $result = $cbd->query($sqlStr);
      if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $tf .= $row['Nume'].'<br>';
      }
    }
  }
 
  if(isset($_SESSION['fiDeLa'])){
    $tf = $tf.$_SESSION['fiDeLa'].' ';
  }
  $tf = $tf.'- '.$_SESSION['tipFiltruData'].' -';
  if(isset($_SESSION['fiPaLa'])){
    $tf = $tf.$_SESSION['fiPaLa'].'<br>';
 }    

  if($_SESSION['pag'] == 'comenzi' || $_SESSION['pag'] == 'productie'){
    if($_SESSION['fiCuMo'] == '0'){
      $tf = $tf.'fara montaj<br>';
    }else if($_SESSION['fiCuMo'] == '1'){
        $tf = $tf.'cu montaj<br>';
    } 
  }
  
  if($_SESSION['fiCuFa'] == '0'){
    $tf = $tf.'nefacturate<br>';
  }else if($_SESSION['fiCuFa'] == '1'){
    $tf = $tf.'facturate<br>';
  }
  
  if($_SESSION['fiDatProdTamp'] == '0'){
    $tf = $tf.'NU e data in productie tamplaria<br>';
  }else if($_SESSION['fiDatProdTamp'] == '1'){
    $tf = $tf.'e data in productie tamplaria<br>';
  }
  
  if($_SESSION['fiDatProdUmp'] == '0'){
    $tf = $tf.'NU e data in productie umplutura<br>';
  }else if($_SESSION['fiDatProdUmp'] == '1'){
    $tf = $tf.'e data in productie umplutura<br>';
  }
  
  if($_SESSION['fiDatProdAcc'] == '0'){
    $tf = $tf.'NU sunt date in productie accesoriile<br>';
  }else if($_SESSION['fiDatProdAcc'] == '1'){
    $tf = $tf.'sunt date in productie accesoriile<br>';
  }
  
  if($_SESSION['fiTermTamp'] == '0'){
    $tf = $tf.'NU e terminata tamplaria<br>';
  }else if($_SESSION['fiTermTamp'] == '1'){
    $tf = $tf.'e terminata tamplaria<br>';
  }
  
  if($_SESSION['fiTermUmp'] == '0'){
    $tf = $tf.'NU e terminata umplutura<br>';
  }else if($_SESSION['fiTermUmp'] == '1'){
    $tf = $tf.'e terminata umplutura<br>';
  }
  
  if($_SESSION['fiTermAcc'] == '0'){
    $tf = $tf.'NU sunt terminate accesoriile<br>';
 }else if($_SESSION['fiTermAcc'] == '1'){
    $tf = $tf.'sunt terminate accesoriile<br>';
  }
  
  if($_SESSION['fiLivr'] == '0'){
    $tf = $tf.'NU e livrata<br>';
  }else if($_SESSION['fiLivr'] == '1'){
    $tf = $tf.'e livrata<br>';
  }
  
  if($_SESSION['fiLivrPart'] == '0'){
    $tf = $tf.'NU e livrata partial<br>';
  }else if($_SESSION['fiLivrPart'] == '1'){
   $tf = $tf.'e livrata partial<br>';
  }
  
  if(isset($_SESSION['cautaNumeComanda']) && $_SESSION['cautaNumeComanda'] != '' && ($_SESSION['pag'] == 'comenzi' or $_SESSION['pag'] == 'comenziAnulate')){
    $tf = 'nume comanda LIKE '.$_SESSION['cautaNumeComanda'].'';
  }
  
  if($_SESSION['pag'] == 'raportDeclaratii'){
    $tf = 'livrate de la: '.$_SESSION['fiDeLa'].' pana la: '.$_SESSION['fiPaLa'];
  }
  
  return $tf;
}

function FormatCell($Stadiu){
  $str = 'background: linear-gradient('.CuloareStadiu($Stadiu[7]).', '.CuloareStadiu($Stadiu[8]).') no-repeat,
                      linear-gradient('.CuloareStadiu($Stadiu[1]).', '.CuloareStadiu($Stadiu[4]).') no-repeat,
                      linear-gradient('.CuloareStadiu($Stadiu[2]).', '.CuloareStadiu($Stadiu[5]).') no-repeat,
                      linear-gradient('.CuloareStadiu($Stadiu[3]).', '.CuloareStadiu($Stadiu[6]).') no-repeat,
                      linear-gradient('.CuloareStadiu($Stadiu[10]).', '.CuloareStadiu($Stadiu[9]).') no-repeat;
          background-size: 20% 100%, 40% 100%, 60% 100%, 80% 100%, 100% 100%;'; 
  return $str;
}

function CuloareStadiu($St){
  if($St == 1){return '#d6e9c6';}else{return '#ebccd1';};
}

function AccesComanda(){
  $str = '';
  
  if($_SESSION['pag'] == 'asteptare'){
    if(!VedeComenziAsteptare()){
      $str = 'hidden';
    }else if(!ModificaComenziAsteptare()){
      $str = 'disabled';    
    }    
  }else if($_SESSION['pag'] == 'comenzi' or $_SESSION['pag'] == 'comenziAnulate'){
    if(!VedeComenzi()){
      $str = 'hidden';
    }else if(!ModificaComanda()){
      $str = 'disabled';    
    }    
  }else if($_SESSION['pag'] == 'productie'){
    if(!VedeComenzi()){
      $str = 'hidden';
    }else if(!ModificaComanda()){
      $str = 'disabled';    
    } 
  }
  return $str;
}


// meniuri
function NuAdministreaza(){
  if(!VedeUtilizatori() && !VedeDealeri() && !VedePF() && !VedeZoneLivrare()){return TRUE;}else{return FALSE;}
}
function VedeComenzi(){
  if($_SESSION['Meniuri'][1] == '1'){return TRUE;} else {return FALSE;}
}
function ComandaNoua(){
  if($_SESSION['Meniuri'][2] == '1'){return TRUE;} else {return FALSE;}
}
function ModificaComanda(){
  if($_SESSION['Meniuri'][3] == '1'){return TRUE;} else {return FALSE;}
}
function TiparesteContract(){
  if($_SESSION['Meniuri'][4] == '1'){return TRUE;} else {return FALSE;}
}
function ComandaNouaPentruDealeri(){
  if($_SESSION['Meniuri'][5] == '1'){return TRUE;} else {return FALSE;}
}
function VedeUtilizatori(){
  if($_SESSION['Meniuri'][6] == '1'){return TRUE;} else {return FALSE;}
}
function AdaugaUtilizatori(){
  if($_SESSION['Meniuri'][7] == '1'){return TRUE;} else {return FALSE;}
}
function VedeReclamatii(){
  if($_SESSION['Meniuri'][6] == '1'){return TRUE;} else {return FALSE;}
}
function AdaugaReclamatii(){
  if($_SESSION['Meniuri'][7] == '1'){return TRUE;} else {return FALSE;}
}
function ModificaUtilizatori(){
 if($_SESSION['Meniuri'][8] == '1'){return TRUE;} else {return FALSE;}
}
function VedeDealeri(){
  if($_SESSION['Meniuri'][6] == '1'){return TRUE;} else {return FALSE;}
}
function VedePF(){
  if($_SESSION['Meniuri'][6] == '1'){return TRUE;} else {return FALSE;}
}
function AdaugaPF(){
  if($_SESSION['Meniuri'][10] == '1'){return TRUE;} else {return FALSE;}
}
function ModificaPF(){
  if($_SESSION['Meniuri'][11] == '1'){return TRUE;} else {return FALSE;}
}
function AdaugaDealeri(){
  if($_SESSION['Meniuri'][10] == '1'){return TRUE;} else {return FALSE;}
}
function ModificaDealeri(){

 if($_SESSION['Meniuri'][11] == '1'){return TRUE;} else {return FALSE;}
}
function VedeZoneLivrare(){
  if($_SESSION['Meniuri'][12] == '1'){return TRUE;} else {return FALSE;}
}
function AdaugaZoneLivrare(){
  if($_SESSION['Meniuri'][13] == '1'){return TRUE;} else {return FALSE;}
}
function ModificaZoneLivrare(){
if($_SESSION['Meniuri'][14] == '1'){return TRUE;} else {return FALSE;}
}
function VedeProductie(){
  if($_SESSION['Meniuri'][15] == '1'){return TRUE;} else {return FALSE;}
}
function VedeComenziAsteptare(){
  if($_SESSION['Meniuri'][16] == '1'){return TRUE;} else {return FALSE;}
}
function AdaugaComenziAsteptare(){
  if($_SESSION['Meniuri'][17] == '1'){return TRUE;} else {return FALSE;}
}
function ModificaComenziAsteptare(){
  if($_SESSION['Meniuri'][18] == '1'){return TRUE;} else {return FALSE;}
}
function TiparesteDeclaratii(){
  if($_SESSION['Meniuri'][19] == '1'){return TRUE;} else {return FALSE;}
}
function IncarcaCFU(){
  if($_SESSION['Meniuri'][20] == '1'){return TRUE;} else {return FALSE;}
}
function DescarcaCFU(){
  if($_SESSION['Meniuri'][21] == '1'){return TRUE;} else {return FALSE;}
}
function IncarcaFactura(){
  if($_SESSION['Meniuri'][22] == '1'){return TRUE;} else {return FALSE;}
}
function DescarcaFactura(){
  if($_SESSION['Meniuri'][23] == '1'){return TRUE;} else {return FALSE;}
}
function IncarcaDovadaPlata(){
  if($_SESSION['Meniuri'][24] == '1'){return TRUE;} else {return FALSE;}
}
function DescarcaDovadaPlata(){
  if($_SESSION['Meniuri'][25] == '1'){return TRUE;} else {return FALSE;}
}
function IncarcaFisierDiverse(){
  if($_SESSION['Meniuri'][26] == '1'){return TRUE;} else {return FALSE;}
}
function DescarcaFisierDiverse(){
  if($_SESSION['Meniuri'][27] == '1'){return TRUE;} else {return FALSE;}
}
function TiparesteAvizInsotire(){
  if($_SESSION['Meniuri'][28] == '1'){return TRUE;} else {return FALSE;}
}
function StergeFactura(){
  if($_SESSION['Meniuri'][29] == '1'){return TRUE;} else {return FALSE;}
}
function VedeDoarComenzileProprii(){
  if($_SESSION['Meniuri'][30] == '1'){return TRUE;} else {return FALSE;}
}
//drepturi
function DataLi(){
  if($_SESSION['Drepturi'][1] == '1'){return TRUE;} else {return FALSE;}
}
function DatPTam(){
  if($_SESSION['Drepturi'][2] == '1'){return TRUE;} else {return FALSE;}
}
function DatPUmp(){
  if($_SESSION['Drepturi'][3] == '1'){return TRUE;} else {return FALSE;}
}
function DatPAcc(){
  if($_SESSION['Drepturi'][4] == '1'){return TRUE;} else {return FALSE;}
}
function TerTam(){
  if($_SESSION['Drepturi'][5] == '1'){return TRUE;} else {return FALSE;}
}
function TerUmp(){
  if($_SESSION['Drepturi'][6] == '1'){return TRUE;} else {return FALSE;}
}
function TerAcc(){
  if($_SESSION['Drepturi'][7] == '1'){return TRUE;} else {return FALSE;}
}
function OkFin(){
  if($_SESSION['Drepturi'][8] == '1'){return TRUE;} else {return FALSE;}
}
function Fact(){
  if($_SESSION['Drepturi'][9] == '1'){return TRUE;} else {return FALSE;}
}
function Livr(){
  if($_SESSION['Drepturi'][10] == '1'){return TRUE;} else {return FALSE;}
}
function AprobaCA(){
  if($_SESSION['Drepturi'][11] == '1'){return TRUE;} else {return FALSE;}
}
function AnuleazaCA(){
  if($_SESSION['Drepturi'][12] == '1'){return TRUE;} else {return FALSE;}
}
function AnuleazaC(){
  if($_SESSION['Drepturi'][13] == '1'){return TRUE;} else {return FALSE;}
}
function AreFisier($ID, $nrFisier, $cbd){
  if(($_SESSION['pag'] == 'comenzi') or ($_SESSION['pag'] == 'comenziAnulate')){
    $sqlStr = 'SELECT DataUpload1, DataUpload2, DataUpload3, DataUpload4 FROM fisiere WHERE IDComanda='.$ID.' AND EsteComanda = 1';    
  }else if($_SESSION['pag'] == 'asteptare'){
    $sqlStr = 'SELECT DataUpload1, DataUpload2, DataUpload3, DataUpload4 FROM fisiere WHERE IDComanda='.$ID.' AND EsteComanda = 0';
  }else{
    $sqlStr = '';
  }
  $result = $cbd->query($sqlStr);
  if($result->num_rows == 0){
    $are = FALSE;
  }else{
    $row = $result->fetch_assoc();
    switch($nrFisier){
      case 1:
        if($row['DataUpload1'] == NULL){$are = FALSE;}else{$are = TRUE;}
        break;
      case 2:
        if($row['DataUpload2'] == NULL){$are = FALSE;}else{$are = TRUE;}
        break;
      case 3:
        if($row['DataUpload3'] == NULL){$are = FALSE;}else{$are = TRUE;}
        break;
      case 4:
        if($row['DataUpload4'] == NULL){$are = FALSE;}else{$are = TRUE;}
        break;
    }
  }
  return $are;
}
function VerificareOcolireLogin(){
    if (!isset($_SESSION['nume'])){
    die('Nu sunteti autentificat!');}
}
function FDate($str){
  return (implode('.', array_reverse(explode('-', $str))));  
}
function UFDate($str){
  return (implode('-', array_reverse(explode('.', $str))));  
}
function GetRightColor($right){
  if($right  == 0)	{return('bg-danger');}   else{return('bg-success');}
}
function GetRightGlyph($right){
  if($right  == 0)	{return('glyphicon-ban-circle');}   else{return('glyphicon-ok-circle');}
}
function GetInstallationGlyph($right){
  if($right  == 0)	{return('glyphicon-remove');}   else{return('glyphicon-ok');}
}
function EsteDealer(){
  if($_SESSION['firma'][1] != 0){
    return true;
  }
}
function GetResponsabilByID($ID, $cbd){
  $sqlStr = 'SELECT Nume FROM utilizatori WHERE ID="'.$ID.'"';
  $result = $cbd->query($sqlStr);
  if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    $Nume = $row['Nume'];
  }else{
    $Nume = 'undefined';
  }
  return $Nume;
}
function AreObservatii($IDComanda, $cbd, $EsteComanda){
  $sqlStr = 'SELECT ID FROM observatii WHERE IDComanda='.$IDComanda.' AND EsteComanda = '.$EsteComanda.';';
  $result = $cbd->query($sqlStr);
  if($result->num_rows >= 1){
    $areObs = TRUE;
  }else{
    $areObs = FALSE;
  }
  return $areObs;
}