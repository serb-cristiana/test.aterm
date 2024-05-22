<?php
session_start();
include 'functii.php';
VerificareOcolireLogin();
$pgApelanta = isset($_GET['pg'])?$_GET['pg']:'';
switch ($pgApelanta){

  case 'getDateComanda':
    if (isset($_POST['ID'])){
      ConectareBd();
      $ID = $_POST['ID'];
      $dc = new stdClass();
      $query = $conbd->query('SELECT * FROM comenzi WHERE ID='.$ID.';');
      $row = $query->fetch_assoc();
      if ($row['IDClient'] >= 10000){
        $query2 = $conbd->query('SELECT Nume FROM clienti WHERE ID='.$row['IDClient'].';');
      }else{
        $query2 = $conbd->query('SELECT Nume FROM dealeri WHERE ID='.$row['IDClient'].';');
      };
      $row2 = $query2->fetch_assoc();
      $dc->NumeClient = $row2['Nume'];    
      $dc->Nume = $row['Nume'];
      $dc->IDClient = $row['IDClient'];
      $dc->Descriere = $row['Descriere'];
      $dc->Valoare = $row['Valoare'];
      $dc->Incasat = $row['Incasat'];
      $dc->IDResponsabil = $row['IDResponsabil'];
      if($row['IDLivrare'] > 0){
        $dc->IDLivrare = $row['IDLivrare'];
      }else{
        $dc->IDLivrare = 0;
      };
      $dc->DataLivrare = FDate($row['DataLivrare']);
      $dc->DataCreare = FDate($row['DataCreare']);
      $dc->AdresaLivrare = $row['AdresaLivrare'];
      $dc->Suprafata = $row['Suprafata'];
      $dc->Greutate = $row['Greutate'];
      $dc->Ferestre = $row['Ferestre'];
      $dc->Usi = $row['Usi'];
      $dc->CuMontaj = $row['CuMontaj'];
      $dc->Stadiu = $row['Stadiu'];
      $dc->Anulata = $row['Anulata'];
      //observatiile comenzii
      $dc->Observatii = '';
      $dc->NrObservatii = 0;
      $query = $conbd->query('SELECT * FROM observatii WHERE IDComanda='.$ID.' AND EsteComanda=1 ORDER BY ID DESC;');
      while($row2 = $query->fetch_assoc()){
        $dc->Observatii .= 'In '.FDate($row2['Data']).', '.GetResponsabilByID($row2['IDResponsabil'], $conbd).' a scris: '.$row2['Text'].'.<br>';
        $dc->NrObservatii++;
      };    
      $dcJSON = json_encode($dc);
      echo $dcJSON;
    };  
    break;  

    case 'getDateComandaAsteptare':
      if (isset($_POST['ID'])) {
          ConectareBd();
          $ID = $_POST['ID'];
          $dca = new stdClass();
          $sqlStr = 'SELECT a.Nume AS NumeComanda, a.DataCreare AS DataCreare, '
              . 'a.IDDealer AS IDDealer, a.IDClient AS IDClient, a.IDLivrare AS IDLivrare, a.Anulata AS Anulata, d.Nume AS NumeDealer, c.Nume AS NumeClient, d.CodPartener AS CodPartener '
              . 'FROM asteptare AS a '
              . 'LEFT JOIN dealeri AS d ON a.IDDealer = d.ID '
              . 'LEFT JOIN clienti AS c ON a.IDClient = c.ID '
              . 'WHERE a.ID='.$ID.' AND a.DataAcceptare IS NULL;';
          $query = $conbd->query($sqlStr);
          $row = $query->fetch_assoc();
          if ($row) {
              $dca->NumeComanda = $row['NumeComanda'];
              $dca->IDClient = $row['IDClient'];
              $dca->IDDealer = $row['IDDealer'];
              $dca->IDLivrare = $row['IDLivrare'];
              $dca->NumeDealer = $row['NumeDealer'];
              $dca->NumeClient = $row['NumeClient']; // Adaugă numele clientului în obiectul JSON
              $dca->CodPartener = $row['CodPartener'];
              $dca->Anulata = $row['Anulata'];
              $dca->DataCreare = FDate($row['DataCreare']);
              // Observațiile comenzii
              $dca->Observatii = '';
              $dca->NrObservatii = 0;
              $queryObs = $conbd->query('SELECT * FROM observatii WHERE IDComanda='.$ID.' AND EsteComanda=0 ORDER BY ID DESC;');
              while ($rowObs = $queryObs->fetch_assoc()) {
                  $dca->Observatii .= 'In '.FDate($rowObs['Data']).', '.GetResponsabilByID($rowObs['IDResponsabil'], $conbd).' a scris: '.$rowObs['Text'].'.<br>';
                  $dca->NrObservatii++;
              }
              $dcaJSON = json_encode($dca);
              echo $dcaJSON;
          } else {
              echo json_encode(array('error' => 'Comanda nu a fost găsită.'));
          }
      }
      break;
  
  
  case 'getDateOperatiiFisiere':
    if (isset($_POST['ID'])){
      ConectareBd();
      $ID = $_POST['ID'];
      $dof = new stdClass();
      if($_SESSION['pag'] == 'asteptare'){//daca e comanda in asteptare
        $sqlStr = 'SELECT a.Nume AS NumeComanda, a.DataCreare AS DataCreare, '
         . 'd.Nume AS NumeDealer '
         . 'c.Nume AS NumeClient '
          . 'FROM asteptare AS a LEFT JOIN dealeri AS d ON a.IDDealer = d.ID ' 
          . 'FROM asteptare AS a LEFT JOIN clienti AS c ON a.IDClient = c.ID ' 
          . 'WHERE a.ID='.$ID.' AND a.DataAcceptare IS NULL;';        
      }else if($_SESSION['pag'] == 'comenzi' or $_SESSION['pag'] == 'comenziAnulate'){//daca e comanda acceptata
        $sqlStr = 'SELECT c.Nume AS NumeComanda, c.DataCreare AS DataCreare, c.IDClient AS IDClient, d.IDDealer AS IDDealer, c.Valoare AS Valoare, '
          . 'd.Nume AS NumeDealer, '
          . 'c.Nume AS NumeClient '
          . 'FROM comenzi AS c '
          . 'LEFT JOIN dealeri AS d ON c.IDDealer = d.ID ' 
          . 'LEFT JOIN clienti AS c ON c.IDClient = c.ID ' 
          . 'WHERE c.ID='.$ID.';';  
      }else{
        $sqlStr = '';
      };
      $query = $conbd->query($sqlStr);
      $row = $query->fetch_assoc();      
      $dof->NumeComanda = $row['NumeComanda'];
      $dof->Valoare = $row['Valoare'] ?? null;
      if($_SESSION['pag'] == 'asteptare'){//daca e comanda in asteptare
        $dof->NumeDealer = $row['NumeDealer'];        
      }else if($_SESSION['pag'] == 'comenzi' or $_SESSION['pag'] == 'comenziAnulate'){//daca e comanda acceptata
        if($row['IDClient'] > 10000){
          $dof->NumeDealer = $row['NumeClient'];        
       }else{
          $dof->NumeDealer = $row['NumeDealer'];        
        };
      };
      $dof->DataCreare = FDate($row['DataCreare']);   
      $dofJSON = json_encode($dof);
      echo $dofJSON;      
    };  
    break;     
    
  case 'getDateDealer':
    if (isset($_POST['ID'])){
      ConectareBd();
      $ID = $_POST['ID'];
      $dd = new stdClass();
      $query = $conbd->query('SELECT * FROM dealeri WHERE ID='.$ID.';');
      $row = $query->fetch_assoc();    
      $dd->Nume = $row['Nume'];
      $dd->Reprezentant = $row['Reprezentant'];
      $dd->Adresa = $row['Adresa'];
      $dd->IDLivrare = $row['IDLivrare'];
      $dd->TelFix = $row['TelFix'];
      $dd->TelMobil = $row['TelMobil'];
      $dd->CNP = $row['CNP'];
      $dd->CI = $row['CI'];
      $dd->CUI = $row['CUI'];
      $dd->RC = $row['RC'];
      $dd->email = $row['email'];
      $dd->CodPartener = $row['CodPartener'];
      $ddJSON = json_encode($dd);
      echo $ddJSON;    
    };  
    break;    
    
  case 'updateComanda':
    if (ModificaComanda() == FALSE) {die('Forbiden acces!');};
    ConectareBd();
    if (isset($_POST['ID'])){
      $ID = $_POST['ID'];
      $Nume = $_POST['Nume'];
      $Valoare = $_POST['Valoare'];
      $Incasat = $_POST['Incasat'];
      $Descriere = $_POST['Descriere'];
      $Observatie = trim($_POST['Observatie']);
      $IDResponsabil = $_SESSION['idUtilizator'];
      $DataLivrare = $_POST['DataLivrare'];
      $DataLivrare = UFDate($DataLivrare);
      $AdresaLivrare = $_POST['AdresaLivrare'];
      $IDLivrare = $_POST['IDLivrare'];
      $Suprafata = $_POST['Suprafata'];
      $Greutate = $_POST['Greutate'];
      $Ferestre = $_POST['Ferestre'];
      $Usi = $_POST['Usi'];
      $Stadiu = $_POST['Stadiu'];
      $CuMontaj = $_POST['CuMontaj'];
      $Anulata = $_POST['Anulata'];      
      $StergeFactura = $_POST['StergeFactura'];      
      $query = $conbd->prepare('UPDATE comenzi SET Nume=?, Descriere=?, Valoare=?, Incasat=?, '
        . 'DataLivrare=?, AdresaLivrare=?, IDLivrare=?, Suprafata=?, Greutate=?, '
        . 'Ferestre=?, Usi=?, CuMontaj=?, Stadiu=?, Anulata=? WHERE ID=?;');
      $query->bind_param('sssssssssssisii', $Nume, $Descriere, $Valoare, $Incasat, $DataLivrare, 
        $AdresaLivrare, $IDLivrare, $Suprafata, $Greutate, $Ferestre, $Usi, $CuMontaj, 
        $Stadiu, $Anulata, $ID);
      if ($query->execute()){
        echo 'O';
      }else{
        echo 'Eroare SQL: '.$conbd->error;
      };
      if($Observatie != ''){
        $esteComanda = 1;
        $data = Date('Y-m-d');
        $query = $conbd->prepare('INSERT INTO observatii (IDComanda, Text, IDResponsabil, Data, EsteComanda) VALUES(?, ?, ?, ?, ?)');
        $query->bind_param('isisi', $ID, $Observatie, $IDResponsabil, $data, $esteComanda);
        if ($query->execute()){
          echo 'K';
        }else{
          echo 'Eroare SQL: '.$conbd->error;
        };
      };
      if($StergeFactura == 1){
        //stergere din fisiere
        $query = $conbd->prepare('UPDATE fisiere SET Fisier2="", '
          . 'NumeFisier2 = "", TipFisier2 = "", SizeFisier2 = 0, '
          . 'DataUpload2 = NULL, IDUtilizator2 = 0 '
          . 'WHERE IDComanda = ? AND EsteComanda=1;');
        $query->bind_param('i', $ID);
        if($query->execute()){
          echo '';
        }else{
          echo 'Eroare SQL: '.$conbd->error;
        };
        //stergere nr factura si setare ca nefacturat
        $sqlStr2 = 'SELECT Stadiu FROM comenzi WHERE ID='.$ID.';';
        $query2 = $conbd->query($sqlStr2);
        $row2 = $query2->fetch_assoc();
        $Stadiu = $row2['Stadiu'];  
        $Stadiu[8] = '0';
        $query = $conbd->prepare('UPDATE comenzi SET NrFactura="", Stadiu = ? WHERE ID = ?');
        $query->bind_param('si', $Stadiu, $ID);
        if($query->execute()){
          echo '';
        }else{
          echo 'Eroare SQL: '.$conbd->error;
        };
      };

   };    
  break;  
  
  case 'updateComandaAsteptare':
    if (ModificaComenziAsteptare() == FALSE) {die('Forbiden acces!');};
    ConectareBd();
    if (isset($_POST['ID'])){
      $ID = $_POST['ID'];
      $NumeComanda = $_POST['NumeComanda'];
      $IDLivrare = $_POST['IDLivrare'];
      $Observatie = trim($_POST['Observatie']);
      $NumeComanda = $_POST['NumeComanda'];
      $Anulata = $_POST['Anulata'];
      $StergeFactura = $_POST['StergeFactura'];
      $query = $conbd->prepare('UPDATE asteptare SET Nume=?, IDLivrare=?, Anulata=? WHERE ID=?;');
      $query->bind_param('siii', $NumeComanda, $IDLivrare, $Anulata, $ID);
      if ($query->execute()){
        echo 'O';
      }else{
        echo 'Eroare SQL: '.$conbd->error;
      };
      if($Observatie != ''){
        $IDResponsabil = $_SESSION['idUtilizator'];
        $esteComanda = 0;
        $data = Date('Y-m-d');
        $query = $conbd->prepare('INSERT INTO observatii (IDComanda, Text, IDResponsabil, Data, EsteComanda) VALUES(?, ?, ?, ?, ?)');
        $query->bind_param('isisi', $ID, $Observatie, $IDResponsabil, $data, $esteComanda);
        if ($query->execute()){
          echo 'K';
        }else{
          echo 'Eroare SQL: '.$conbd->error;
        };
      }; 
      if($StergeFactura == 1){
        //stergere din fisiere
        $query = $conbd->prepare('UPDATE fisiere SET Fisier2="", '
          . 'NumeFisier2 = "", TipFisier2 = "", SizeFisier2 = 0, '
          . 'DataUpload2 = NULL, IDUtilizator2 = 0 '
          . 'WHERE IDComanda = ? AND EsteComanda=0;');
        $query->bind_param('i', $ID);
        if($query->execute()){
          echo '';
        }else{
          echo 'Eroare SQL: '.$conbd->error;
        };
        //stergere nr factura
        $query = $conbd->prepare('UPDATE asteptare SET NrFactura="" WHERE ID = ?');
        $query->bind_param('i', $ID);
        if($query->execute()){
          echo '';
        }else{
          echo 'Eroare SQL: '.$conbd->error;
        };
      };      
    };    
  break;   
  
  case 'updateDealer':
   if (ModificaDealeri() == FALSE) {die('Forbiden acces!');};
   ConectareBd();
   $errStr = '';
   if (isset($_POST['ID'])){
     $ID = $_POST['ID'];
     $Reprezentant = $_POST['Reprezentant'];
     $CodPartener = $_POST['CodPartener'];
     $Activ = $_POST['Activ'];
     $TelMobil = $_POST['TelMobil'];
     $email = $_POST['email'];
     $CUI = $_POST['CUI'];
     $Banca = $_POST['Banca'];
     $Cont = $_POST['Cont'];
     $CNP = $_POST['CNP'];
     $Adresa = $_POST['Adresa'];
     $IDLivrare = $_POST['IDLivrare'];
     $IDResponsabil = $_POST['IDResponsabil'];
     $RC = $_POST['RC'];   
     //extragem ID Responsabil vechi
     $query = $conbd->query('SELECT * FROM dealeri WHERE ID='.$ID.';');
     $row = $query->fetch_assoc();
     $IDVechiResponsabil = $row['IDResponsabil'];
     //daca dealerului i se schimba responsabilul, se modifica toate comenzile vechi pe noul responsabil
     if($IDVechiResponsabil != $IDResponsabil){
       //comenzi
       $query = $conbd->prepare('UPDATE comenzi SET IDResponsabil=? WHERE IDClient=?;');
       $query->bind_param('ii', $IDResponsabil, $ID);
       if ($query->execute()){
       }else{
         $errStr = $errStr.'Eroare SQL: '.$conbd->error;
       }
       //comenzi asteptare
       $query = $conbd->prepare('UPDATE asteptare SET IDResponsabil=? WHERE IDDealer=?;');
       $query->bind_param('ii', $IDResponsabil, $ID);
       if ($query->execute()){         
       }else{
         $errStr = $errStr.'Eroare SQL: '.$conbd->error;
       }
     }  
    //si update dealer
     $query = $conbd->prepare('UPDATE dealeri SET Reprezentant=?, CodPartener=?, Activ=?, TelMobil=?, email=?, CUI=?, Banca=?, Cont=?, CNP=?, Adresa=?, IDLivrare=?, IDResponsabil=?, RC=? WHERE ID=?;');
     $query->bind_param('ssisssssssiisi', $Reprezentant, $CodPartener, $Activ, $TelMobil, $email, $CUI, $Banca, $Cont, $CNP, $Adresa, $IDLivrare, $IDResponsabil, $RC, $ID);
     if ($query->execute()){
     }else{
       $errStr = $errStr.'Eroare SQL: '.$conbd->error;
     }
   };    
   if ($errStr == ''){$errStr = 'OK';}
   echo $errStr;
 break;

 case 'updatePF':
  if (ModificaPF() == FALSE) {die('Forbiden acces!');};
  ConectareBd();
  $errStr = '';
  if (isset($_POST['ID'])){
    $ID = $_POST['ID'];
    $Activ = $_POST['Activ'];
    $TelMobil = $_POST['TelMobil'];
    $email = $_POST['email'];
    $CUI = $_POST['CUI'];
    $Banca = $_POST['Banca'];
    $Cont = $_POST['Cont'];
    $CNP = $_POST['CNP'];
    $Adresa = $_POST['Adresa'];
    $IDLivrare = $_POST['IDLivrare'];
    $IDResponsabil = $_POST['IDResponsabil'];
    $RC = $_POST['RC'];   
    //extragem ID Responsabil vechi
    $query = $conbd->query('SELECT * FROM clienti WHERE ID='.$ID.';');
    $row = $query->fetch_assoc();
    $IDVechiResponsabil = $row['IDResponsabil'];
    //daca clientului i se schimba responsabilul, se modifica toate comenzile vechi pe noul responsabil
    if($IDVechiResponsabil != $IDResponsabil){
      //comenzi
      $query = $conbd->prepare('UPDATE comenzi SET IDResponsabil=? WHERE IDClient=?;');
      $query->bind_param('ii', $IDResponsabil, $ID);
      if ($query->execute()){
      }else{
        $errStr = $errStr.'Eroare SQL: '.$conbd->error;
      }
      //comenzi asteptare
      $query = $conbd->prepare('UPDATE asteptare SET IDResponsabil=? WHERE IDDealer=?;');
      $query->bind_param('ii', $IDResponsabil, $ID);
      if ($query->execute()){         
      }else{
        $errStr = $errStr.'Eroare SQL: '.$conbd->error;
      }
    }  
   //si update client
    $query = $conbd->prepare('UPDATE clienti SET Activ=?, TelMobil=?, email=?, CUI=?, Banca=?, Cont=?, CNP=?, Adresa=?, IDLivrare=?, IDResponsabil=?, RC=? WHERE ID=?;');
    $query->bind_param('isssssssiisi', $Activ, $TelMobil, $email, $CUI, $Banca, $Cont, $CNP, $Adresa, $IDLivrare, $IDResponsabil, $RC, $ID);
    if ($query->execute()){
    }else{
      $errStr = $errStr.'Eroare SQL: '.$conbd->error;
    }
  };    
  if ($errStr == ''){$errStr = 'OK';}
  echo $errStr;
break;

  case 'updateUser':
    if (ModificaUtilizatori() == FALSE) {die('Forbiden acces!');};
   ConectareBd();
   if (isset($_POST['ID'])){
     $ID = $_POST['ID'];    
     $Parola       = $_POST['Parola'];
     $Activ        = $_POST['Activ'];
     $Email        = $_POST['Email'];
     $Telefon        = $_POST['Telefon'];
     $Drepturi     = $_POST['Drepturi'];
     $Meniuri      = $_POST['Meniuri']; 
     $query = $conbd->prepare('UPDATE utilizatori SET Parola=?, Activ=?, Email=?, Telefon=?, Drepturi=?, Meniuri=? WHERE ID=?;');
     $query->bind_param('sissssi', $Parola, $Activ, $Email, $Telefon, $Drepturi, $Meniuri, $ID);
     if ($query->execute()){
       echo 'OK';
     }else{
       echo 'Eroare SQL: '.$conbd->error;
     }
   };    
 break;  

 case 'updateZonaLivrare':
  if (ModificaZoneLivrare() == FALSE) {die('Forbiden acces!');};
  ConectareBd();
  if (isset($_POST['ID'])){
    $ID = $_POST['ID'];    
    $Descriere  = $_POST['Descriere'];
    $Distanta       = $_POST['Distanta']; 
    $query = $conbd->prepare('UPDATE livrare SET Descriere=?, Distanta=? WHERE ID=?;');
    $query->bind_param('ssi', $Descriere, $Distanta, $ID);
    if ($query->execute()){
      echo 'OK';
    }else{
      echo 'Eroare SQL: '.$conbd->error;
    }
  };    
break;    

  case 'adaugaDealer':
    if (AdaugaDealeri() == FALSE) {die('Forbiden acces!');};
    ConectareBd();  
    $NumePartener = $_POST['NumePartener'];
    $Reprezentant = $_POST['Reprezentant'];
    $CodPartener = $_POST['CodPartener'];
    $TelMobil = $_POST['TelMobil'];
    $email = $_POST['email'];
    $CUI = $_POST['CUI'];
    $Banca = $_POST['Banca'];
    $Cont = $_POST['Cont'];
    $CNP = $_POST['CNP'];
    $Adresa = $_POST['Adresa'];
    $IDLivrare = $_POST['IDLivrare'];
    $IDResponsabil = $_POST['IDResponsabil'];
    $RC = $_POST['RC'];
    $query = $conbd->prepare('INSERT INTO dealeri '
      . '(Nume, Reprezentant, CodPartener, TelMobil, email, CUI, Banca, Cont, CNP, Adresa, RC, IDLivrare, IDResponsabil)'
      . 'Values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $query->bind_param('sssssssssssii', $NumePartener, $Reprezentant, $CodPartener, $TelMobil, $email, $CUI, $Banca, $Cont, $CNP, $Adresa, $RC, $IDLivrare, $IDResponsabil);
    if ($query->execute()){
      echo 'OK';
    }else{
      echo 'Eroare SQL: '.$conbd->error;
    };       
  break;

  case 'adaugaPF':
    if (AdaugaPF() == FALSE) {die('Forbiden acces!');};
    ConectareBd();  
    $NumeClient = $_POST['NumeClient'];
    $AdresaPF = $_POST['AdresaPF'];
    $TelMobilPF = $_POST['TelMobilPF'];
    $CNPPF = $_POST['CNPPF'];
    $CUIPF = $_POST['CUIPF'];
    $RCPF = $_POST['RCPF'];
    $emailPF = $_POST['emailPF'];
    $IDResponsabilPF = $_POST['IDResponsabilPF'];
    $IDLivrarePF = $_POST['IDLivrarePF'];
    $BancaPF = $_POST['BancaPF'];
    $ContPF = $_POST['ContPF'];
    $query = $conbd->prepare('INSERT INTO clienti '
      . '(Nume, Adresa, TelMobil, CNP, CUI, RC, email, IDResponsabil, IDLivrare, Cont, Banca)'
      . 'Values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $query->bind_param('sssssssiiss', $NumeClient, $AdresaPF, $TelMobilPF, $CNPPF, $CUIPF, $RCPF, $emailPF, $IDResponsabilPF, $IDLivrarePF, $BancaPF, $ContPF);
    if ($query->execute()){
      echo 'OK';
    }else{
      echo 'Eroare SQL: '.$conbd->error;
    };       
  break;

  case 'adaugaUser':
    if (AdaugaUtilizatori() == FALSE) {die('Forbiden acces!');};
    ConectareBd();   
    $Nume     = $_POST['Nume'];
    $Parola   = $_POST['Parola'];
    $Firma    = $_POST['Firma'];
    $Activ    = $_POST['Activ'];
    $Email    = $_POST['Email'];
    $Telefon   = $_POST['Telefon'];
    $Drepturi = $_POST['Drepturi'];
    $Meniuri  = $_POST['Meniuri'];

    $query = $conbd->prepare('INSERT INTO utilizatori (Nume, Parola, Firma, Activ, Email, Telefon, Drepturi, Meniuri) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $query->bind_param('sssissss', $Nume, $Parola, $Firma, $Activ, $Email, $Telefon, $Drepturi, $Meniuri);
    if ($query->execute()){
      echo 'OK';
    }else{
      echo 'Eroare SQL: '.$conbd->error;
    };   
  break;  

  case 'adaugaZonaLivrare':
    if (AdaugaZoneLivrare() == FALSE) {die('Forbiden acces!');};
    ConectareBd();
    $NumeTara = $_POST['NumeTara'];
    $NumeZonaLivrare = $_POST['NumeZonaLivrare'];
    $Descriere = $_POST['Descriere'];
    $Distanta = $_POST['Distanta'];

    $query = $conbd->prepare('INSERT INTO livrare (Tara, Nume, Descriere, Distanta) VALUES (?, ?, ?, ?)');
    $query->bind_param('ssss', $NumeTara, $NumeZonaLivrare, $Descriere, $Distanta);

    if ($query->execute()){
      echo 'OK';
    }else{
      echo 'Eroare SQL: '.$conbd->error;
    };       
  break; 

  

  case 'adaugaComanda':
    if (ComandaNoua() == FALSE) {die('Forbiden acces!');};
    ConectareBd();
    $errStr = '';

    $ID = $_POST['ID'];
    if($ID == 0){//daca e client direct
      $NumeCl = $_POST['NumeCl'];
      $AdresaCl = $_POST['AdresaCl'];
      $TelFixCl = $_POST['TelFixCl'];
      $TelMobilCl = $_POST['TelMobilCl'];
      $CnpCl = $_POST['CnpCl'];
      $CiCl = $_POST['CiCl'];
      $ReprezCl = $_POST['ReprezCl'];
      $CuiCl = $_POST['CuiCl'];
      $RcCl = $_POST['RcCl'];
      $emailCl = $_POST['emailCl'];      
      //salvare date client direct
      $query = $conbd->prepare('INSERT INTO clienti '
      . '(Nume, Reprezentant, Adresa, TelFix, TelMobil, CNP, CI, CUI, RC, email)'
      . 'Values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
      $query->bind_param('ssssssssss', $NumeCl, $ReprezCl, $AdresaCl, $TelFixCl, $TelMobilCl, $CnpCl, $CiCl, $CuiCl, $RcCl, $emailCl);
      if ($query->execute()){
        $IDClient = $conbd->insert_id; 
        $errStr = 'O';
      }else{
        $errStr = $conbd->error;
      };      
    }else{//daca e dealer
      $IDClient = $ID;              
    };

    //cautarea ultimului ID si incrementarea cu 1
    $sql="SELECT CodIntern, ID FROM comenzi WHERE ID = (SELECT MAX(ID) FROM comenzi);";
    $query=$conbd->query($sql);
    $row = $query->fetch_assoc();
    $Parinte = $row['ID']+1;

    //cautarea celui mai mare CodIntern (CodIntern al celui mai mare Parinte si incrementarea cu 1)
    $sql="SELECT CodIntern, ID FROM comenzi WHERE ID = (SELECT MAX(Parinte) FROM comenzi);";
    $query=$conbd->query($sql);
    $row = $query->fetch_assoc();
    $CodIntern = $row['CodIntern']+1;
    
    //extragere ID Responsabil    
    if($ID == 0){//daca e client direct
      $sql="SELECT ID FROM utilizatori WHERE Nume = '".$_SESSION['nume']."';";
      $query=$conbd->query($sql);
      $row = $query->fetch_assoc();
      $IDResponsabil = $row['ID'];    
    }else{//daca e dealer
      $sql="SELECT IDResponsabil FROM dealeri WHERE ID = '".$IDClient."';";
      $query=$conbd->query($sql);
      $row = $query->fetch_assoc();
      $IDResponsabil = $row['IDResponsabil'];              
    };
    
    $DataCreare = date('Y-m-d');
    $Nume = $_POST['Nume'];
    $NrContract = $_POST['NrContract'];
    $idCA = $_POST['idCA'];    
    $Valoare = $_POST['Valoare'];
    $Incasat = $_POST['Incasat'];
    $DataLivrare = UFDate($_POST['DataLivrare']);
    $AdresaLivrare = $_POST['AdresaLivrare'];
    $IDTraseuLivrare = $_POST['IDTraseuLivrare'];
    $Suprafata = $_POST['Suprafata'];
    $Greutate = $_POST['Greutate'];
    $Ferestre = $_POST['Ferestre'];
    $Usi = $_POST['Usi'];
    $Descriere = $_POST['Descriere'];
    $CuMontaj = $_POST['CuMontaj'];
    $Stadiu = '800000010000000000000000';
    $Observatii = trim($_POST['Observatii']);
    $FaraCFU = $_POST['FaraCFU'];
    
    $query = $conbd->prepare('INSERT INTO comenzi '
      . '(Parinte, Nume, Descriere, Valoare, Incasat, IDClient, IDResponsabil, CodIntern, '
      . 'DataCreare, DataLivrare, AdresaLivrare, IDLivrare, Suprafata, Greutate, '
      . 'Ferestre, Usi, CuMontaj, Stadiu, NrContract, FaraCFU)'
      . 'Values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $query->bind_param('issddiiisssiddiiissi', $Parinte, $Nume, $Descriere, 
      $Valoare, $Incasat, $IDClient, $IDResponsabil, $CodIntern, $DataCreare, $DataLivrare, 
      $AdresaLivrare, $IDTraseuLivrare, $Suprafata, $Greutate, $Ferestre, $Usi, 
      $CuMontaj, $Stadiu, $NrContract, $FaraCFU);
    if ($query->execute()){
      $errStr = $errStr.'';
    }else{
      $errStr = $errStr.$conbd->error;
    };
    
    $esteComanda = 1;
    if($Observatii != ''){
      $query = $conbd->prepare('INSERT INTO observatii '
        . '(IDComanda, Text, IDResponsabil, Data, EsteComanda)'
        . 'Values(?, ?, ?, ?, ?)');
      $query->bind_param('isisi', $Parinte, $Observatii, $IDResponsabil, $DataCreare, $esteComanda);
      if ($query->execute()){
        $errStr = $errStr.'';
      }else{
        $errStr = $errStr.$conbd->error;
      };      
    };
    
    //creare pozitie fisier  
    $sqlStr = 'INSERT INTO fisiere (IDComanda, EsteComanda) Values(?, ?); ';
    $query = $conbd->prepare($sqlStr);
    $query->bind_param('ii', $Parinte, $esteComanda);   
    $query->execute();
    if($FaraCFU == 0){//daca este cu CFU
      //salvare upload
      if ($_FILES['file-0']['size'] > 0){
        $Fisier = $_FILES['file-0'];
        $fileName = preg_replace('/\s+/', '', addslashes($_FILES['file-0']['name']));
        $tmpName  = $_FILES['file-0']['tmp_name'];
        $fileSize = $_FILES['file-0']['size'];
        //$fileType = addslashes($Fisier['type']);
        $fileType = $Fisier['type'];
        $fp      = fopen($tmpName, 'r');
        $content = fread($fp, filesize($tmpName));
        $content = addslashes($content);
        fclose($fp);         
        $Data = Date('Y-m-d h:m:s');
        $NrFisier = 1;
        $sqlStr = '';
        $sqlStr = $sqlStr.'UPDATE fisiere SET Fisier'.$NrFisier.'="'.$content.'",';
        $sqlStr = $sqlStr.' NumeFisier'.$NrFisier.'="'.$fileName.'", ';
        $sqlStr = $sqlStr.' TipFisier'.$NrFisier.'="'.$fileType.'", ';
        $sqlStr = $sqlStr.' SizeFisier'.$NrFisier.'="'.$fileSize.'", ';
        $sqlStr = $sqlStr.' DataUpload'.$NrFisier.'="'.$Data.'", ';
        $sqlStr = $sqlStr.' IDUtilizator'.$NrFisier.'='.$IDResponsabil.' ';
        $sqlStr = $sqlStr.'WHERE IDComanda='.$Parinte.' AND EsteComanda='.$esteComanda.';';
        $query = $conbd->query($sqlStr);
        if($query){
          $errStr = $errStr.'K';
        }else{
          $errStr = $errStr.' eroare salvare fisier: '.$conbd->error;
        };
      };     
    };
    echo $errStr;   
  break;  

  case 'aprobaComanda':
    if (AprobaCA() == FALSE) {die('Forbiden acces!');};
    ConectareBd();
    $errStr = '';
    $idCA = $_POST['idCA'];
    $sql = "SELECT DataAcceptare, FaraCFU, NrFactura FROM asteptare WHERE ID=".$idCA.";";
    $query=$conbd->query($sql);
    $row = $query->fetch_assoc();
    if($row['DataAcceptare'] == NULL){
      $IDClient = $_POST['ID'];            
      $FaraCFU = $row['FaraCFU'];
      $NrFactura = $row['NrFactura'];

      //cautarea ultimului ID si incrementarea cu 1
      $sql="SELECT CodIntern, ID FROM comenzi WHERE ID = (SELECT MAX(ID) FROM comenzi);";
      $query=$conbd->query($sql);
      $row = $query->fetch_assoc();
      $Parinte = $row['ID']+1;

      //cautarea celui mai mare CodIntern (CodIntern al celui mai mare Parinte si incrementarea cu 1)
      $sql="SELECT CodIntern, ID FROM comenzi WHERE ID = (SELECT MAX(Parinte) FROM comenzi);";
      $query=$conbd->query($sql);
      $row = $query->fetch_assoc();
      $CodIntern = $row['CodIntern']+1;

      //extragere ID Responsabil
//      $sql="SELECT ID FROM utilizatori WHERE Nume = '".$_SESSION['nume']."';";
//      $query=$conbd->query($sql);
//      $row = $query->fetch_assoc();
//      $IDResponsabil = $row['ID'];    
      $sql="SELECT IDResponsabil FROM dealeri WHERE ID = '".$IDClient."';";
      $query=$conbd->query($sql);
      $row = $query->fetch_assoc();
      $IDResponsabil = $row['IDResponsabil'];     
      $DataCreare = date('Y-m-d');
      $Nume = $_POST['Nume'];
      $Valoare = $_POST['Valoare'];
      $Incasat = $_POST['Incasat'];
      $DataLivrare = UFDate($_POST['DataLivrare']);
      $AdresaLivrare = $_POST['AdresaLivrare'];
      $IDTraseuLivrare = $_POST['IDTraseuLivrare'];
      $Suprafata = $_POST['Suprafata'];
      $Greutate = $_POST['Greutate'];
      $Ferestre = $_POST['Ferestre'];
      $Usi = $_POST['Usi'];
      $Descriere = $_POST['Descriere'];
      $CuMontaj = $_POST['CuMontaj'];
      if($NrFactura != ''){
        $Stadiu = '800000001000000000000000';        
      }else{        
        $Stadiu = '800000000000000000000000';        
      };
      $Observatii = trim($_POST['Observatii']);
      $query = $conbd->prepare('INSERT INTO comenzi '
        . '(Parinte, Nume, Descriere, Valoare, Incasat, IDClient, IDResponsabil, CodIntern, '
        . 'DataCreare, DataLivrare, AdresaLivrare, IDLivrare, Suprafata, Greutate, '
        . 'Ferestre, Usi, CuMontaj, Stadiu, FaraCFU, NrFactura)'
        . 'Values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
      $query->bind_param('issddiiisssiddiiisis', $Parinte, $Nume, $Descriere, $Valoare, $Incasat, 
        $IDClient, $IDResponsabil, $CodIntern, $DataCreare, $DataLivrare, $AdresaLivrare, 
        $IDTraseuLivrare, $Suprafata, $Greutate, $Ferestre, $Usi, $CuMontaj, $Stadiu, $FaraCFU, $NrFactura);
      if ($query->execute()){
        $errStr = $errStr.'K';
      }else{
        $errStr = $errStr.$conbd->error;
      };

      if($Observatii != ''){
        $EsteComanda = 1;
        $query = $conbd->prepare('INSERT INTO observatii '
          . '(IDComanda, Text, IDResponsabil, Data, EsteComanda)'
          . 'Values(?, ?, ?, ?, ?)');
        $query->bind_param('isisi', $Parinte, $Observatii, $IDResponsabil, $DataCreare, $EsteComanda);
        if ($query->execute()){
          $errStr = $errStr;
        }else{
          $errStr = $errStr.$conbd->error;
        }; 
      };
        
      $query3 = $conbd->prepare('UPDATE asteptare SET IDUtilizatorAcceptare=?, DataAcceptare=? WHERE ID=?');
      $query3->bind_param('isi', $IDResponsabil, $DataCreare, $idCA);
      if ($query3->execute()){
        $errStr = $errStr;
      }else{
        $errStr = $errStr.$conbd->error;
      };

      $query4 = $conbd->prepare('UPDATE fisiere SET IDComanda=?, EsteComanda=1 WHERE IDComanda=? AND EsteComanda=0;');
      $query4->bind_param('ii', $Parinte, $idCA);
      if ($query4->execute()){
        $errStr = $errStr.'K';
      }else{
        $errStr = $errStr.$conbd->error;
      }; 
      
      $query5 = $conbd->prepare('UPDATE observatii SET IDComanda=?, EsteComanda=1 WHERE IDComanda=? AND EsteComanda=0;');
      $query5->bind_param('ii', $Parinte, $idCA);
      if ($query5->execute()){
        $errStr = $errStr.'';
      }else{
        $errStr = $errStr.$conbd->error;
      };      
    }else{
      $errStr = 'Comanda a fost acceptata de alt utiliazator!';
    };
    echo $errStr;
  break;
  
  case 'adaugaComandaAsteptare':
    if (AdaugaComenziAsteptare() == FALSE) {
        die('Acces interzis!');
    } 
    ConectareBd();  
    $NumeCoAs = $_POST['NumeCoAs'];
    $IDClient = $_POST['IDClient'];
    $IDDealer = $_POST['IDDealer'];
    $IDLivrare = $_POST['IDLivrare'];
    $ObservatiiCoAs = $_POST['ObservatiiCoAs'];
    $FaraCFU = $_POST['FaraCFU'];
    $DataCreare = date('Y-m-d');
    $NrFisier = 1;
    
    // Extrage ID-ul responsabilului
    $sql = "SELECT ID FROM utilizatori WHERE Nume = '".$_SESSION['nume']."';";
    $query = $conbd->query($sql);
    $row = $query->fetch_assoc();
    $IDResponsabil = $row['ID'];
    
    // Inserează în tabela asteptare
    $sqlStr = 'INSERT INTO asteptare (Nume, IDClient, IDDealer, IDLivrare, IDResponsabil, DataCreare, FaraCFU) VALUES (?, ?, ?, ?, ?, ?, ?)';
    $query = $conbd->prepare($sqlStr);
    $query->bind_param('siiiisi', $NumeCoAs, $IDClient, $IDDealer, $IDLivrare, $IDResponsabil, $DataCreare, $FaraCFU);
  
    if ($query->execute()) {
        $IDca = $conbd->insert_id; 
        $errStr = 'O';
    } else {
        $errStr = $errStr . ' eroare salvare in asteptare: ' . $sqlStr . ' ' . $NumeCoAs . ' ' . $IDClient . ' ' . $IDDealer . ' ' . $IDLivrare . ' ' . $IDResponsabil . ' ' . $DataCreare . ' ' . $FaraCFU . ' ' . $conbd->error;
    }
    
    // Observațiile
    $EsteComanda = 0; 
    if ($ObservatiiCoAs != '') {
        $sqlObservatii = 'INSERT INTO observatii (IDComanda, Text, IDResponsabil, Data, EsteComanda) VALUES (?, ?, ?, ?, ?)';
        $queryObservatii = $conbd->prepare($sqlObservatii);
        $queryObservatii->bind_param('isisi', $IDca, $ObservatiiCoAs, $IDResponsabil, $DataCreare, $EsteComanda);
        if ($queryObservatii->execute()) {
            $errStr = $errStr;
        } else {
            $errStr = $errStr . $conbd->error;
        }
    }
      
    // Creare poziție fișier
    $sqlFisiere = 'INSERT INTO fisiere (IDComanda, EsteComanda) VALUES (?, ?)';
    $queryFisiere = $conbd->prepare($sqlFisiere);
    $queryFisiere->bind_param('ii', $IDca, $EsteComanda);   
    $queryFisiere->execute();
    
    if($FaraCFU == 0){
        //salvare upload
        if ($_FILES['file-0']['size'] > 0){
            // Codul pentru salvarea fisierului
            $Fisier = $_FILES['file-0'];
            $fileName = preg_replace('/\s+/', '', addslashes($_FILES['file-0']['name']));
            $tmpName  = $_FILES['file-0']['tmp_name'];
            $fileSize = $_FILES['file-0']['size'];
            //$fileType = addslashes($Fisier['type']);
            $fileType = $Fisier['type'];
            $fp      = fopen($tmpName, 'r');
            $content = fread($fp, filesize($tmpName));
            $content = addslashes($content);
            fclose($fp);    
            $Data = Date('Y-m-d h:m:s');
            $sqlStr = '';
            $sqlStr = $sqlStr.'UPDATE fisiere SET Fisier'.$NrFisier.'="'.$content.'",';
            $sqlStr = $sqlStr.' NumeFisier'.$NrFisier.'="'.$fileName.'", ';
            $sqlStr = $sqlStr.' TipFisier'.$NrFisier.'="'.$fileType.'", ';
            $sqlStr = $sqlStr.' SizeFisier'.$NrFisier.'="'.$fileSize.'", ';
            $sqlStr = $sqlStr.' DataUpload'.$NrFisier.'="'.$Data.'", ';
            $sqlStr = $sqlStr.' IDUtilizator'.$NrFisier.'='.$IDResponsabil.' ';
            $sqlStr = $sqlStr.'WHERE IDComanda='.$IDca.' AND EsteComanda='.$EsteComanda.';';
            $query = $conbd->query($sqlStr);
            if($query){
                $errStr = $errStr.'K';
            } else {
                $errStr = $errStr.' eroare salvare fisier: '.$sqlStr.' '.$fileName.' '.$fileType.' '.$fileSize.' '.$Data.' '.$IDResponsabil.' '.$IDca.' '.$EsteComanda.' '.$conbd->error;
            }
        }
    }
    
    echo $errStr;
    break;

  
  case 'salveazaFisier':
    $errStr = '';
    ConectareBd();
    $ID = $_POST['ID'];
    $NrFisier = $_POST['NrFisier'];  
    $NrFactura = $_POST['NrFactura'];  
    $Valoare = $_POST['ValoareFactura'];  
    $EsteComanda = $_POST['EsteComanda'];
    $CuDeclaratii = $_POST['CuDeclaratii'];
    if($NrFisier == 2){
      if($EsteComanda == 1){
        //scriere facturat in stadiu
        $sqlStr2 = 'SELECT Stadiu FROM comenzi WHERE ID='.$ID.';';
        $query2 = $conbd->query($sqlStr2);
        $row2 = $query2->fetch_assoc();
        $Stadiu = $row2['Stadiu'];  
        $Stadiu[8] = '1';          
        $sqlStr = 'UPDATE comenzi SET NrFactura ="'.$NrFactura.'", Stadiu="'.$Stadiu.'" WHERE ID = '.$ID.';';
      }else{
        $sqlStr = 'UPDATE asteptare SET NrFactura ="'.$NrFactura.'" WHERE ID = '.$ID.';';
      };
      $query = $conbd->query($sqlStr);
      if($query){
        $errStr = $errStr.'O';
      }else{
        $errStr = $errStr.' eroare set NrFactura: '.$conbd->error;
      }; 
      //generare nr declaratii certificate
      if($EsteComanda == 1 && $CuDeclaratii == 1){
        $query = $conbd->query('SELECT (MAX(NrDeclCert) + 1) AS NrDeclCert FROM comenzi;');
        $row = $query->fetch_assoc();
        $NrDeclCert = $row['NrDeclCert'];
        $sqlStr = 'UPDATE comenzi SET NrDeclCert = '.$NrDeclCert.' WHERE ID = '.$ID.';';
        $query = $conbd->query($sqlStr);
      };
      $sqlStr = 'UPDATE comenzi SET Valoare = '.$Valoare.' WHERE ID = '.$ID.';';
      $query = $conbd->query($sqlStr);      
    };
    //salvare upload
    if ($_FILES['file-0']['size'] > 0){
    //$string = preg_replace('/\s+/', '', $string);
      $Fisier = $_FILES['file-0'];
      $fileName = preg_replace('/\s+/', '', addslashes($_FILES['file-0']['name']));
      $tmpName  = $_FILES['file-0']['tmp_name'];
      $fileSize = $_FILES['file-0']['size'];
      //$fileType = addslashes($Fisier['type']);
      $fileType = $Fisier['type'];
      $fp      = fopen($tmpName, 'r');
      $content = fread($fp, filesize($tmpName));
      $content = addslashes($content);
      fclose($fp);

      //extragere ID Responsabil
      $sql="SELECT ID FROM utilizatori WHERE Nume = '".$_SESSION['nume']."';";
      $query=$conbd->query($sql);
      $row = $query->fetch_assoc();
      $IDUtilizator = $row['ID'];            
      $Data = Date('Y-m-d h:m:s');
      $sqlStr = '';
      $sqlStr = $sqlStr.'UPDATE fisiere SET Fisier'.$NrFisier.'="'.$content.'",';
      $sqlStr = $sqlStr.' NumeFisier'.$NrFisier.'="'.$fileName.'", ';
      $sqlStr = $sqlStr.' TipFisier'.$NrFisier.'="'.$fileType.'", ';
      $sqlStr = $sqlStr.' SizeFisier'.$NrFisier.'="'.$fileSize.'", ';
      $sqlStr = $sqlStr.' DataUpload'.$NrFisier.'="'.$Data.'", ';
      $sqlStr = $sqlStr.' IDUtilizator'.$NrFisier.'='.$IDUtilizator.' ';
      $sqlStr = $sqlStr.'WHERE IDComanda='.$ID.' AND EsteComanda='.$EsteComanda.';';
      $query = $conbd->query($sqlStr);
      if($query){
        $errStr = $errStr.'K';
      }else{
        $errStr = $errStr.' eroare set NrFactura: '.$conbd->error;
      }; 
  };
  break;   
  default :   
}
?>