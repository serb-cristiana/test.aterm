<?php
session_start();
if(isset($_POST['DeLaDaLi'])){
  if($_POST['DeLaDaLi'] == 'next'){
    $_SESSION['DeLaDaLi'] = date('Y-m-d', strtotime($_SESSION['DeLaDaLi'].'+ 7 days'));
  }else if($_POST['DeLaDaLi'] == 'previous'){
    $_SESSION['DeLaDaLi'] = date('Y-m-d', strtotime($_SESSION['DeLaDaLi'].'- 7 days'));
  }
}else{
  $_SESSION['DeLaDaLi'] = date('Y-m-d', strtotime('-'.(date('w')-1).' days'));
  
  if($_SESSION['pag'] == 'comenzi' or $_SESSION['pag'] == 'comenziAnulate' || $_SESSION['pag'] == 'productie'){
    //traseu livrare
    if(isset($_POST['fiTrLi'])){
      $_SESSION['fiTrLi'] = $_POST['fiTrLi'];
    }else{
      $_SESSION['fiTrLi'] = '?';
    }  
  }else if($_SESSION['pag'] == 'asteptare' || $_SESSION['pag'] == 'asteptareAnulate'){
    $_SESSION['fiTrLi'] = '?';
  } 

  //nume comanda
  if(isset($_POST['cautaNumeComanda'])){
    $_SESSION['cautaNumeComanda'] = $_POST['cautaNumeComanda'];
  }else{
    $_SESSION['cautaNumeComanda'] = '';
  }  

  //dealer
  if(isset($_POST['fiDeal'])){
    $_SESSION['fiDeal'] = $_POST['fiDeal'];
  }else{
    $_SESSION['fiDeal'] = '?';
  }

  //responsabil
  if(isset($_POST['fiResp'])){
    $_SESSION['fiResp'] = $_POST['fiResp'];
  }else{
    $_SESSION['fiResp'] = '?';
  }

  //tip filtru data 
  if(isset($_POST['tipFiltruData'])){
    $_SESSION['tipFiltruData'] = $_POST['tipFiltruData'];
  }else{
    $_SESSION['tipFiltruData'] = 'DataCreare';
  }

  //creat de la
  if(isset($_POST['fiDeLa'])){
    $_SESSION['fiDeLa'] = $_POST['fiDeLa'];
  }else{
    $_SESSION['fiDeLa'] = date('d.m.Y', strtotime(date('d.m.Y').'-30 day'));
  }
  //creat pana la
  if(isset($_POST['fiPaLa'])){
    $_SESSION['fiPaLa'] = $_POST['fiPaLa'];
  }else{
    $_SESSION['fiPaLa'] = date('d.m.Y');
  }

  //toate/cu/fara montaj
  if(isset($_POST['fiCuMo'])){
    $_SESSION['fiCuMo'] = $_POST['fiCuMo'];
  }else{
    $_SESSION['fiCuMo'] = '?';
  }

  //toate/cu/fara fatura
  if(isset($_POST['fiCuFa'])){
    $_SESSION['fiCuFa'] = $_POST['fiCuFa'];
  }else{
    $_SESSION['fiCuFa'] = '?';
  }
  
  //toate/date/nedate in productie tamplaria
  if(isset($_POST['fiDatProdTamp'])){
    $_SESSION['fiDatProdTamp'] = $_POST['fiDatProdTamp'];
  }else{
    $_SESSION['fiDatProdTamp'] = '?';
  }  
  
  //toate/date/nedate in productie umplutura
  if(isset($_POST['fiDatProdUmp'])){
    $_SESSION['fiDatProdUmp'] = $_POST['fiDatProdUmp'];
  }else{
    $_SESSION['fiDatProdUmp'] = '?';
  }  
  
  //toate/date/nedate in productie accesoriile
  if(isset($_POST['fiDatProdAcc'])){
    $_SESSION['fiDatProdAcc'] = $_POST['fiDatProdAcc'];
  }else{
    $_SESSION['fiDatProdAcc'] = '?';
  }
  
  //toate/terminat/neterminat tamplaria
  if(isset($_POST['fiTermTamp'])){
    $_SESSION['fiTermTamp'] = $_POST['fiTermTamp'];
  }else{
    $_SESSION['fiTermTamp'] = '?';
  }

  //toate/terminat/neterminat in productie umplutura
  if(isset($_POST['fiTermUmp'])){
    $_SESSION['fiTermUmp'] = $_POST['fiTermUmp'];
  }else{
    $_SESSION['fiTermUmp'] = '?';
  }

  //toate/terminat/neterminat in productie accesoriile
  if(isset($_POST['fiTermAcc'])){
    $_SESSION['fiTermAcc'] = $_POST['fiTermAcc'];
  }else{
    $_SESSION['fiTermAcc'] = '?';
  }   
  
  //toate/livrate/nelivrate
  if(isset($_POST['fiLivr'])){
    $_SESSION['fiLivr'] = $_POST['fiLivr'];
  }else{
    $_SESSION['fiLivr'] = '?';
  }   

  //toate/livrate partial/nelivrate partial
  if(isset($_POST['fiLivrPart'])){
    $_SESSION['fiLivrPart'] = $_POST['fiLivrPart'];
  }else{
    $_SESSION['fiLivrPart'] = '?';
  }   
}