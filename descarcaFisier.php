<?php
session_start();
include 'functii.php';
VerificareOcolireLogin();
ConectareBd();
$ID = $_GET['ID'];
$NrFisier = $_GET['NrFisier'];
if(($_SESSION['pag'] == 'comenzi') or ($_SESSION['pag'] == 'comenziAnulate')){
  $esteComanda = ' AND EsteComanda=1 ';
}else if($_SESSION['pag'] == 'asteptare'){
  $esteComanda = ' AND EsteComanda=0 ';
}else{
  $esteComanda = ' ';
};
$sqlStr = "SELECT Fisier".$NrFisier.", NumeFisier".$NrFisier.", TipFisier".$NrFisier.", SizeFisier".$NrFisier." "
  . "FROM fisiere WHERE IDComanda=".$ID." ".$esteComanda.";";
$query = $conbd->query($sqlStr);
$row = $query->fetch_assoc();
$fileName = $row['NumeFisier'.$NrFisier];
$size = $row['SizeFisier'.$NrFisier];
$type = $row['TipFisier'.$NrFisier];
//$file = $row['Fisier'.$NrFisier];
//header("Cache-Control: public");
header("Content-length: $size");
header("Content-type: $type");
//header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="'.$fileName.'"');
//header("Content-Transfer-Encoding: binary");
//header("Content-Type: binary/octet-stream");
//readfile($file);
//ob_end_clean();    
ob_clean();    
flush();
echo $row['Fisier'.$NrFisier];
$conbd->close();
exit;
?>