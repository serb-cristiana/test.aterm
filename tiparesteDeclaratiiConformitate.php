<?php
session_start();
include 'functii.php';
VerificareOcolireLogin();
if (TiparesteDeclaratii() == FALSE) {die('Forbiden acces!');};
ConectareBd();
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
    <link href="css/layout.css" rel="stylesheet" type="text/css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script language="JavaScript" type="text/javascript" src="js/pms.functions.js"></script>
    <script language="JavaScript" type="text/javascript" src="js/datepicker.js"></script>

    <script>
    function printDiv(divName) {
      var printContents = document.getElementById(divName).outerHTML;
      var originalContents = document.body.outerHTML;
      document.body.outerHTML = printContents;
      window.print();
      document.body.outerHTML = originalContents;
    }
    </script>
</head>
<body>
 <div class="container">   
  <input type="button" class="button" onclick="printDiv('pag1')" value="Tipareste pagina 1" />
  <button class="button" onclick="window.location.href='comenzi.php'">Inapoi la lista comenzi</button>
  <br><br>
  <?php
$ID = $_GET['ID'];
$sqlStr = 'SELECT 
  co.ID AS ID,
  co.Parinte AS Parinte,
  co.IDClient AS IDClient,
  co.CuMontaj AS CuMontaj,  
  co.CodIntern AS CodIntern,
  co.NrContract AS NrContract,
  co.NrDeclCert AS NrDeclCert,
  co.CodIntern2 AS CodIntern2,
  COALESCE(de.Nume, cl.Nume) AS NumeClient,
  cl.Adresa AS Adresa,
  cl.TelFix AS TelFix,
  cl.CNP AS CNP,
  cl.CI AS CI,
  cl.CUI AS CUI,
  cl.RC AS RC,
  co.Nume AS Nume,
  co.NrFactura AS NrFactura,
  co.Valoare AS Valoare,
  (SELECT Nume FROM utilizatori AS ut WHERE ut.ID=co.IDResponsabil) AS Responsabil,
  co.Descriere AS Descriere, 
  co.Suprafata AS Suprafata,
  co.Greutate AS Greutate,
  co.Ferestre AS Ferestre,
  co.Usi AS Usi,  
  co.DataCreare AS DataCreare, 
  co.DataLivrare AS DataLivrare, 
  co.AdresaLivrare AS AdresaLivrare,
  (SELECT Nume FROM livrare AS li WHERE li.ID = co.IDLivrare) AS TraseuLivrare,
  co.Stadiu AS Stadiu
  FROM comenzi AS co 
  LEFT JOIN dealeri AS de ON co.IDClient = de.ID
  LEFT JOIN clienti AS cl ON co.IDClient = cl.ID
  WHERE co.ID='.$ID.';';
$query = $conbd->query($sqlStr);
$date = $query->fetch_assoc();
?>
<!----------------------------------pag 1-------------------------------------------->
  <div id="pag1" class="pag_contract">
    <img src="images/headerContract.png" class="sigle"/>
    <h4>DECLARAŢIE DE CONFORMITATE</h4>
    <h4>Nr. <?php echo $date['NrDeclCert'];?>-FPVC / <?php echo FDate($date['DataLivrare']);?></h4>
    <div class="par_contract">
    <p>1. Cod unic de identificare al produsului-tip: <strong>FERESTRE EXTERIOARE  - FPVC</strong></p>
    <p>2. Tipul, lotul sau numărul de serie sau orice alt element care permite identificarea produsului pentru construcţii:<br>
      <div class="centrat">Livrat la data de: <?php echo FDate($date['DataLivrare']);?> cu factura nr.: <?php echo $date['NrFactura'];?><br>
        Beneficiar: <?php echo $date['NumeClient'];?>, lucrare: <?php echo $date['Nume'];?>
      </div>
    </p>
    <p>3. Utilizarea sau utilizările preconizate ale produsului pentru construcţii, 
      în conformitate cu specificaţia tehnică armonizată aplicabilă: <strong>SR EN 14351-1+A1/2010 (EN 14351 -1+A1:2010)</strong><br>
      CONSTRUCŢII CIVILE, INDUSTRIALE ŞI AGRICOLE; LUCRĂRI TEHNICO – EDILITARE – 
      - Oricare, in afara de compartimentare la foc/fum si pe cai de evacuare, si ferestre de acoperis
    </p>
    <p>4. Numele, denumirea socială sau marca înregistrată şi adresa de contact a fabricantului:<br>
      <div class="centrat"><strong>S.C. ATERM S.R.L. MEDIAS</strong> <br>
      <strong>Soseaua Sibiului Nr. 48  Loc. Medias jud. Sibiu</strong> <br>
      <strong>Tel.: 0269 – 833118; Fax: 0269 – 833118</strong> <br>
      <strong>Baza de productie: Medias Str. Garii Fara nr. jud. Sibiu</strong></div>
    </p>
    <p>
      5. Numele şi adresa de contact a reprezentantului autorizat: <strong>Nu este cazul</strong>
    </p>
    <p>
      6. Sistemul sau sistemele de evaluare şi verificare a constanţei performanţei produsului pentru construcţii:<br>
    <div class="centrat"><strong>Sistemul 1</strong></div>
    </p>
    <p>
      7. Organismul S.C. QUALITY CERT S.A. BUCURESTI  - Sos. Panduri Nr. 94 sector 5 Bucuresti 
      a efectuat inspectarea initiala a fabricii si a controlului productiei in fabrica precum 
      si supravegherea si evaluarea continua a controlului productiei in fabrica, 
      in cadrul sistemului 1 şi a emis:  
      <strong>Certificatul de conformitate rezultat în urma controlului din fabrică al producţiei  nr. 1870-CPR-1152/4/2016</strong><br>    
    </p>
    <p>
      8. Performanţa declarată:
    </p>
    <table >
      <tr>
        <td>Caracteristici</td>
        <td>Standardul de incercari</td>
        <td>Prevederile din<br>standard</td>
        <td>Valori declarate</td>
      </tr>
      <tr>
        <td>Etanseitate la apa (Clasa)</td>
        <td rowspan="11"></td>
        <td>1A; 2A; 3A; 4A; 5A; 6A; 7A; 8A; 9A</td>
        <td>Clasa 5A......E900</td>
      </tr>
      <tr>
        <td>Reactia la foc</td>
        <td>F; E; D; C; B; A2; A1</td>
        <td>npd</td>
      </tr>
      <tr>
        <td>Rezistenta la incarcarea data de vant <br>
          - presiunea de incercare<br>
          - deformatia ramei
        </td>
        <td>A (≤ 1/150); B (≤ 1/200); C (≤ 1/300)</td>
        <td>Clasa C2/B2......C5/B5</td>
      </tr>
      <tr>
        <td>Forta de actionare (Clasa)</td>
        <td>-</td>
        <td>1.....2</td>
      </tr>
      <tr>
        <td>Rezistenta la soc</td>
        <td>npd</td>
        <td>1....3</td>
      </tr>
      <tr>
        <td>Permeabilitate la aer (Clasa)</td>
        <td>1 (150); 2 (300); 3 (600); 4 (600)</td>
        <td>Clasa 4</td>
      </tr>
      <tr>
        <td>Performanta acustica Rw (C;Ctr) (dB)</td>
        <td>Valoare declarata</td>
        <td>33(-2; -6) dB.....46(-2; -5) dB</td>
      </tr>
      <tr>
        <td>Transmitanta termica Uw(W/(m 2-K))</td>
        <td>Valoare declarata</td>
        <td>0,84....1,6</td>
      </tr>
      <tr>
        <td>Capacitatea portanta a dispozitivelor de securitate</td>
        <td>Valoare prag</td>
        <td>npd</td>
      </tr>
      <tr>
        <td>Rezistenta mecanica (Clasa)</td>
        <td>-</td>
        <td>4</td>
      </tr>
      <tr>
        <td>Rezistenta la deschidere si inchidere repetata</td>
        <td>Numar de cicluri</td>
        <td>3</td>
      </tr>
    </table>
    <p>9. Performanţa produsului identificat la pct. 1 şi 2 este în conformitate cu performanţa declarată de la pct. 8.
     Această declaraţie de performanţă este emisă pe răspunderea exclusivă a fabricantului identificat la pct 4.
   </p>
    </div>
    <!--<img src="images/footerContract.png" class="sigle"/>-->
    <div style="text-align: center; width:100%; position: absolute; bottom:15px;">
      Responsabil Control Productie	<img src="images/semnatura_cert_decl.png"/>
    </div>    
  </div>
<!----------------------------------sfarsit pag 1-------------------------------------------->

<!----------------------------------pag 2-------------------------------------------->
  <br>
  <input type="button" onclick="printDiv('pag2')" value="Tipareste pagina 2" />
  <button onclick="window.location.href='comenzi.php'">Inapoi la lista comenzi</button>
  <br><br>
  <div id="pag2" class="pag_contract">
    <img src="images/headerContract.png" class="sigle"/>
   <h4>DECLARAŢIE DE PERFORMANTA</h4>
    <h4>Nr. <?php echo $date['NrDeclCert'];?>-UPVC / <?php echo FDate($date['DataLivrare']);?></h4>
    <div class="par_contract">
    <p>1. Cod unic de identificare al produsului-tip: <strong>USI EXTERIOARE PENTRU PIETONI - UPVC</strong></p>
    <p>2. Tipul, lotul sau numărul de serie sau orice alt element care permite identificarea produsului pentru construcţii:<br>
      <div class="centrat">Livrat la data de: <?php echo FDate($date['DataLivrare']);?> cu factura nr.: <?php echo $date['NrFactura'];?><br>
        Beneficiar: <?php echo $date['NumeClient'];?>, lucrare: <?php echo $date['Nume'];?>
      </div>
    </p>
    <p>3. Utilizarea sau utilizările preconizate ale produsului pentru construcţii, 
      în conformitate cu specificaţia tehnică armonizată aplicabilă: <strong>SR EN 14351-1+A1/2010 (EN 14351 -1+A1:2010)<br>
      CONSTRUCŢII CIVILE, INDUSTRIALE ŞI AGRICOLE; LUCRĂRI TEHNICO – EDILITARE – <br>
      COMUNICARE IN ZONE DE LOCUINTE SI COMERCIALE -	Pe cai de evacuare</strong>
    </p>
    <p>4. Numele, denumirea socială sau marca înregistrată şi adresa de contact a fabricantului:<br>
      <div class="centrat"><strong>S.C. ATERM S.R.L. MEDIAS <br>
      Soseaua Sibiului Nr. 48  Loc. Medias jud. Sibiu <br>
      Tel.: 0269 – 833118; Fax: 0269 – 833118, 
      Baza de productie: Medias Str. Garii Fara nr. jud. Sibiu</strong></div>
    </p>
    <p>
      5. Numele şi adresa de contact a reprezentantului autorizat: <strong>Nu este cazul</strong>
    </p>
    <p>
      6. Sistemul sau sistemele de evaluare şi verificare a constanţei performanţei produsului pentru construcţii:<br>
    <div class="centrat"><strong>Sistemul 1</strong></div>
    </p>
    <p>
      7. Organismul S.C. QUALITY CERT S.A. BUCURESTI  - Sos. Panduri Nr. 94 sector 5 Bucuresti 
      a efectuat inspectarea initiala a fabricii si a controlului productiei in fabrica precum 
      si supravegherea si evaluarea continua a controlului productiei in fabrica, 
      in cadrul sistemului 1 şi a emis:  
      <strong>Certificatul de conformitate rezultat în urma controlului din fabrică al producţiei  nr. 1870-CPR-1152/4/2016</strong><br>    
    </p>
    <p>
      8. Performanţa declarată:
    </p>
    <table >
      <tr>
        <td>Caracteristici</td>
        <td>Standardul de incercari</td>
        <td>Prevederile din<br>standard</td>
        <td>Valori declarate</td>
      </tr>
      <tr>
        <td>Latime si inaltime (mm)</td>
        <td rowspan="13">SR EN 14351-1+A1:2010</td>
        <td>-</td>
        <td>variabil</td>
      </tr>
      <tr>
        <td>Etanseitate la apa (Clasa)</td>
        <td>1A; 2A; 3A; 4A; 5A; 6A; 7A; 8A; 9A</td>
        <td>Clasa 5A......E900</td>
      </tr>
      <tr>
        <td>Reactia la foc</td>
        <td>F; E; D; C; B; A2; A1</td>
        <td>npd</td>
      </tr>
      <tr>
        <td>Rezistenta la incarcarea data de vant <br>
          - presiunea de incercare<br>
          - deformatia ramei
        </td>
        <td>A (≤ 1/150); B (≤ 1/200); C (≤ 1/300)</td>
        <td>Clasa C2/B2......C5/B5</td>
      </tr>
      <tr>
        <td>Forta de actionare (Clasa)</td>
        <td>-</td>
        <td>1.....2</td>
      </tr>
      <tr>
        <td>Rezistenta la soc</td>
        <td>npd</td>
        <td>1....3</td>
      </tr>
      <tr>
        <td>Permeabilitate la aer (Clasa)</td>
        <td>1 (150); 2 (300); 3 (600); 4 (600)</td>
        <td>Clasa 4</td>
      </tr>
      <tr>
        <td>Performanta acustica Rw (C;Ctr) (dB)</td>
        <td>Valoare declarata</td>
        <td>33(-2; -6) dB.....46(-2; -5) dB</td>
      </tr>
      <tr>
        <td>Transmitanta termica Uw(W/(m 2-K))</td>
        <td>Valoare declarata</td>
        <td>0,84....1,6</td>
      </tr>
      <tr>
        <td>Capacitatea de rezistenta a dispozitivelor de siguranta</td>
        <td>Valoare prag</td>
        <td>npd</td>
      </tr>
      <tr>
        <td>Rezistenta mecanica (Clasa)</td>
        <td>-</td>
        <td>4</td>
      </tr>
      <tr>
        <td>Rezistenta la efractie</td>
        <td>Valoare declarata</td>
        <td>≤ WK 3</td>
      </tr>
      <tr>
        <td>Rezistenta la deschidere si inchidere repetata</td>
        <td>Numar de cicluri</td>
        <td>3</td>
      </tr>
    </table>
    <p>9. Performanţa produsului identificat la pct. 1 şi 2 este în conformitate cu performanţa declarată de la pct. 8.
     Această declaraţie de performanţă este emisă pe răspunderea exclusivă a fabricantului identificat la pct 4.
    </p>
    </div>
    <!--<img src="images/footerContract.png" class="sigle"/>-->
    <div style="text-align: center; width:100%; position: absolute; bottom:15px;">
      Responsabil Control Productie	<img src="images/semnatura_cert_decl.png"/>
    </div> 
  </div>
  <!----------------------------------sfarsit pag 2-------------------------------------------->
  
  <!----------------------------------pag 3-------------------------------------------->
  <br>
  <input type="button" onclick="printDiv('pag3')" value="Tipareste pagina 3" />
  <button onclick="window.location.href='comenzi.php'">Inapoi la lista comenzi</button>
  <br><br>
  <div id="pag3" class="pag_contract">
    <img src="images/headerContract.png" class="sigle"/>
    <h4>DECLARAŢIE DE PERFORMANTA</h4>
    <h4>Nr. <?php echo $date['NrDeclCert'];?>-FAL / <?php echo FDate($date['DataLivrare']);?></h4>
    <div class="par_contract">
    <p>1. Cod unic de identificare al produsului-tip: <strong>FERESTRE EXTERIOARE  - FAL</strong></p>
    <p>2. Tipul, lotul sau numărul de serie sau orice alt element care permite identificarea produsului pentru construcţii:<br>
      <div class="centrat">Livrat la data de: <?php echo FDate($date['DataLivrare']);?> cu factura nr.: <?php echo $date['NrFactura'];?><br>
        Beneficiar: <?php echo $date['NumeClient'];?>, lucrare: <?php echo $date['Nume'];?>
      </div>
    </p>
    <p>3. Utilizarea sau utilizările preconizate ale produsului pentru construcţii, 
      în conformitate cu specificaţia tehnică armonizată aplicabilă: <strong>SR EN 14351-1+A1/2010 (EN 14351 -1+A1:2010)</strong><br>
      CONSTRUCŢII CIVILE, INDUSTRIALE ŞI AGRICOLE; LUCRĂRI TEHNICO – EDILITARE – 
      - Oricare, in afara de compartimentare la foc/fum si pe cai de evacuare, si ferestre de acoperis
    </p>
    <p>4. Numele, denumirea socială sau marca înregistrată şi adresa de contact a fabricantului:<br>
      <div class="centrat"><strong>S.C. ATERM S.R.L. MEDIAS</strong> <br>
      <strong>Soseaua Sibiului Nr. 48  Loc. Medias jud. Sibiu</strong> <br>
      <strong>Tel.: 0269 – 833118; Fax: 0269 – 833118</strong> <br>
      <strong>Baza de productie: Medias Str. Garii Fara nr. jud. Sibiu</strong></div>
    </p>
    <p>
      5. Numele şi adresa de contact a reprezentantului autorizat: <strong>Nu este cazul</strong>
   </p>
    <p>
      6. Sistemul sau sistemele de evaluare şi verificare a constanţei performanţei produsului pentru construcţii:<br>
    <div class="centrat"><strong>Sistemul 1</strong></div>
    </p>
    <p>
      7. Organismul S.C. QUALITY CERT S.A. BUCURESTI  - Sos. Panduri Nr. 94 sector 5 Bucuresti 
      a efectuat inspectarea initiala a fabricii si a controlului productiei in fabrica precum 
      si supravegherea si evaluarea continua a controlului productiei in fabrica, 
      in cadrul sistemului 1 şi a emis:  
      <strong>Certificatul de conformitate rezultat în urma controlului din fabrică al producţiei  nr. 1870-CPR-1152/4/2016</strong><br>    
    </p>
    <p>
      8. Performanţa declarată:
    </p>
    <table >
      <tr>
        <td>Caracteristici</td>
        <td>Standardul de incercari</td>
        <td>Prevederile din<br>standard</td>
        <td>Valori declarate</td>
      </tr>
      <tr>
        <td>Etanseitate la apa (Clasa)</td>
        <td rowspan="11"></td>
        <td>1A; 2A; 3A; 4A; 5A; 6A; 7A; 8A; 9A</td>
        <td>Clasa 3A......E1300</td>
      </tr>
      <tr>
        <td>Reactia la foc</td>
        <td>F; E; D; C; B; A2; A1</td>
        <td>A1</td>
      </tr>
      <tr>
        <td>Rezistenta la incarcarea data de vant <br>
          - presiunea de incercare<br>
          - deformatia ramei
        </td>
        <td>A (≤ 1/150); B (≤ 1/200); C (≤ 1/300)</td>
        <td>Clasa C3/B3......C5/B5± 1200 Pa</td>
      </tr>
      <tr>
        <td>Forta de actionare (Clasa)</td>
        <td>-</td>
        <td>1.....2</td>
      </tr>
      <tr>
        <td>Rezistenta la soc</td>
        <td>npd</td>
        <td>npd</td>
      </tr>
      <tr>
        <td>Permeabilitate la aer (Clasa)</td>
        <td>1 (150); 2 (300); 3 (600); 4 (600)</td>
        <td>Clasa 3</td>
      </tr>
      <tr>
        <td>Performanta acustica Rw (C;Ctr) (dB)</td>
        <td>Valoare declarata</td>
        <td>10 dB.....20 dB</td>
      </tr>
      <tr>
        <td>Transmitanta termica Uw(W/(m 2-K))</td>
        <td>Valoare declarata</td>
        <td>1,0....2,0</td>
      </tr>
      <tr>
        <td>Capacitatea portanta a dispozitivelor de securitate</td>
        <td>Valoare prag</td>
        <td>npd</td>
      </tr>
      <tr>
        <td>Rezistenta mecanica (Clasa)</td>
        <td>-</td>
        <td>4</td>
      </tr>
      <tr>
        <td>Rezistenta la deschidere si inchidere repetata</td>
        <td>Numar de cicluri</td>
        <td>3</td>
      </tr>
    </table>
    <p>9. Performanţa produsului identificat la pct. 1 şi 2 este în conformitate cu performanţa declarată de la pct. 8.
      Această declaraţie de performanţă este emisă pe răspunderea exclusivă a fabricantului identificat la pct 4.
    </p>
    </div>
    <div style="text-align: center; width:100%; position: absolute; bottom:15px;">
      Responsabil Control Productie	<img src="images/semnatura_cert_decl.png"/>
    </div> 
  </div>
  <!----------------------------------sfarsit pag 3-------------------------------------------->
  
  <!----------------------------------pag 4-------------------------------------------->
  <br>
  <input type="button" onclick="printDiv('pag4')" value="Tipareste pagina 4" />
  <button onclick="window.location.href='comenzi.php'">Inapoi la lista comenzi</button>
  <br><br>
  <div id="pag4" class="pag_contract">
    <img src="images/headerContract.png" class="sigle"/>
    <h4>DECLARAŢIE DE PERFORMANTA</h4>
    <h4>Nr. <?php echo $date['NrDeclCert'];?>-UAL / <?php echo FDate($date['DataLivrare']);?></h4>
    <div class="par_contract">
    <p>1. Cod unic de identificare al produsului-tip: <strong>USI EXTERIOARE PENTRU PIETONI - UAL</strong></p>
    <p>2. Tipul, lotul sau numărul de serie sau orice alt element care permite identificarea produsului pentru construcţii:<br>
      <div class="centrat">Livrat la data de: <?php echo FDate($date['DataLivrare']);?> cu factura nr.: <?php echo $date['NrFactura'];?><br>
        Beneficiar: <?php echo $date['NumeClient'];?>, lucrare: <?php echo $date['Nume'];?>
      </div>
    </p>
    <p>3. Utilizarea sau utilizările preconizate ale produsului pentru construcţii, 
      în conformitate cu specificaţia tehnică armonizată aplicabilă: <strong>SR EN 14351-1+A1/2010 (EN 14351 -1+A1:2010)<br>
      CONSTRUCŢII CIVILE, INDUSTRIALE ŞI AGRICOLE; LUCRĂRI TEHNICO – EDILITARE – <br>
      COMUNICARE IN ZONE DE LOCUINTE SI COMERCIALE -	Pe cai de evacuare</strong>
    </p>
    <p>4. Numele, denumirea socială sau marca înregistrată şi adresa de contact a fabricantului:<br>
      <div class="centrat"><strong>S.C. ATERM S.R.L. MEDIAS <br>
      Soseaua Sibiului Nr. 48  Loc. Medias jud. Sibiu <br>
      Tel.: 0269 – 833118; Fax: 0269 – 833118, 
      Baza de productie: Medias Str. Garii Fara nr. jud. Sibiu</strong></div>
    </p>
    <p>
      5. Numele şi adresa de contact a reprezentantului autorizat: <strong>Nu este cazul</strong>
    </p>
    <p>
      6. Sistemul sau sistemele de evaluare şi verificare a constanţei performanţei produsului pentru construcţii:<br>
    <div class="centrat"><strong>Sistemul 1</strong></div>
    </p>
    <p>
      7. Organismul S.C. QUALITY CERT S.A. BUCURESTI  - Sos. Panduri Nr. 94 sector 5 Bucuresti 
      a efectuat inspectarea initiala a fabricii si a controlului productiei in fabrica precum 
      si supravegherea si evaluarea continua a controlului productiei in fabrica, 
      in cadrul sistemului 1 şi a emis:  
      <strong>Certificatul de conformitate rezultat în urma controlului din fabrică al producţiei  nr. 1870-CPR-1152/4/2016</strong><br>    
    </p>
    <p>
      8. Performanţa declarată:
    </p>
    <table >
      <tr>
        <td>Caracteristici</td>
        <td>Standardul de incercari</td>
        <td>Prevederile din<br>standard</td>
        <td>Valori declarate</td>
      </tr>
      <tr>
        <td>Latime si inaltime (mm)</td>
        <td rowspan="13">SR EN 14351-1+A1:2010</td>
        <td>-</td>
        <td>variabil</td>
      </tr>
      <tr>
        <td>Etanseitate la apa (Clasa)</td>
        <td>1A; 2A; 3A; 4A; 5A; 6A; 7A; 8A; 9A</td>
        <td>Clasa 4A......E1300</td>
      </tr>
      <tr>
        <td>Reactia la foc</td>
        <td>F; E; D; C; B; A2; A1</td>
        <td>A1</td>
      </tr>
      <tr>
        <td>Rezistenta la incarcarea data de vant <br>
          - presiunea de incercare<br>
          - deformatia ramei
        </td>
        <td>A (≤ 1/150); B (≤ 1/200); C (≤ 1/300)</td>
        <td>Clasa C2/B2......C5/B5± 2400 Pa</td>
      </tr>
      <tr>
        <td>Forta de actionare (Clasa)</td>
        <td>-</td>
        <td>1.....2</td>
      </tr>
      <tr>
        <td>Rezistenta la soc</td>
      <td>npd</td>
        <td>npd</td>
      </tr>
      <tr>
        <td>Permeabilitate la aer (Clasa)</td>
        <td>1 (150); 2 (300); 3 (600); 4 (600)</td>
        <td>Clasa 3....4</td>
      </tr>
      <tr>
        <td>Performanta acustica Rw (C;Ctr) (dB)</td>
        <td>Valoare declarata</td>
        <td>10 dB.....20 dB</td>
      </tr>
      <tr>
        <td>Transmitanta termica Uw(W/(m 2-K))</td>
        <td>Valoare declarata</td>
        <td>0,84....1,6</td>
      </tr>
      <tr>
        <td>Capacitatea de rezistenta a dispozitivelor de siguranta</td>
        <td>Valoare prag</td>
        <td>npd</td>
      </tr>
      <tr>
        <td>Rezistenta mecanica (Clasa)</td>
        <td>-</td>
        <td>4</td>
      </tr>
      <tr>
        <td>Rezistenta la efractie</td>
        <td>npd</td>
        <td>npd</td>
      </tr>
      <tr>
        <td>Rezistenta la deschidere si inchidere repetata</td>
        <td>Numar de cicluri</td>
        <td>3</td>
      </tr>
    </table>
    <p>9. Performanţa produsului identificat la pct. 1 şi 2 este în conformitate cu performanţa declarată de la pct. 8.
      Această declaraţie de performanţă este emisă pe răspunderea exclusivă a fabricantului identificat la pct 4.
    </p>
    </div>
    <div style="text-align: center; width:100%; position: absolute; bottom:15px;">
      Responsabil Control Productie	<img src="images/semnatura_cert_decl.png"/>
    </div> 
  </div>
  <!----------------------------------sfarsit pag 4-------------------------------------------->  

  <!----------------------------------pag 5-------------------------------------------->
  <br>
  <input type="button" onclick="printDiv('pag5')" value="Tipareste pagina 5" />
  <button onclick="window.location.href='comenzi.php'">Inapoi la lista comenzi</button>
  <br><br>
  <div id="pag5" class="pag_contract">
    <img src="images/headerContract.png" class="sigle"/>
    <h4>DECLARAŢIE DE PERFORMANTA</h4>
    <h4>Nr. <?php echo $date['NrDeclCert'];?>-UIPVC / <?php echo FDate($date['DataLivrare']);?></h4>
    <div class="par_contract">
    <p>1. Cod unic de identificare al produsului-tip: <strong>USI EXTERIOARE PENTRU PIETONI - UIPVC</strong></p>
    <p>2. Tipul, lotul sau numărul de serie sau orice alt element care permite identificarea produsului pentru construcţii:<br>
      <div class="centrat">Livrat la data de: <?php echo FDate($date['DataLivrare']);?> cu factura nr.: <?php echo $date['NrFactura'];?><br>
        Beneficiar: <?php echo $date['NumeClient'];?>, lucrare: <?php echo $date['Nume'];?>
      </div>
    </p>
    <p>3. Utilizarea sau utilizările preconizate ale produsului pentru construcţii, 
      în conformitate cu specificaţia tehnică armonizată aplicabilă: <strong>SR EN 14351-1+A1/2010 (EN 14351 -1+A1:2010)<br>
      CONSTRUCŢII CIVILE, INDUSTRIALE ŞI AGRICOLE; LUCRĂRI TEHNICO – EDILITARE – <br>
      COMUNICARE IN ZONE DE LOCUINTE SI COMERCIALE -	Pe cai de evacuare</strong>
    </p>
    <p>4. Numele, denumirea socială sau marca înregistrată şi adresa de contact a fabricantului:<br>
      <div class="centrat"><strong>S.C. ATERM S.R.L. MEDIAS <br>
      Soseaua Sibiului Nr. 48  Loc. Medias jud. Sibiu <br>
      Tel.: 0269 – 833118; Fax: 0269 – 833118, 
      Baza de productie: Medias Str. Garii Fara nr. jud. Sibiu</strong></div>
    </p>
    <p>
      5. Numele şi adresa de contact a reprezentantului autorizat: <strong>Nu este cazul</strong>
    </p>
    <p>
      6. Sistemul sau sistemele de evaluare şi verificare a constanţei performanţei produsului pentru construcţii:<br>
    <div class="centrat"><strong>Sistemul 1</strong></div>
    </p>
    <p>
      7. Organismul S.C. QUALITY CERT S.A. BUCURESTI  - Sos. Panduri Nr. 94 sector 5 Bucuresti 
      a efectuat inspectarea initiala a fabricii si a controlului productiei in fabrica precum 
      si supravegherea si evaluarea continua a controlului productiei in fabrica, 
      in cadrul sistemului 1 şi a emis:  
      <strong>Certificatul de conformitate rezultat în urma controlului din fabrică al producţiei  nr. 1870-CPR-1152/4/2016</strong><br>    
    </p>
    <p>
      8. Performanţa declarată:
    </p>
    <table >
      <tr>
        <td>Caracteristici</td>
        <td>Standardul de incercari</td>
        <td>Prevederile din<br>standard</td>
        <td>Valori declarate</td>
      </tr>
      <tr>
        <td>Latime si inaltime (mm)</td>
        <td rowspan="13">SR EN 14351-1+A1:2010</td>
        <td>-</td>
        <td>variabil</td>
      </tr>
      <tr>
        <td>Etanseitate la apa (Clasa)</td>
        <td>1A; 2A; 3A; 4A; 5A; 6A; 7A; 8A; 9A</td>
        <td>Clasa 5A......E900</td>
      </tr>
      <tr>
        <td>Reactia la foc</td>
        <td>F; E; D; C; B; A2; A1</td>
        <td>npd</td>
      </tr>
      <tr>
        <td>Rezistenta la incarcarea data de vant <br>
          - presiunea de incercare<br>
          - deformatia ramei
        </td>
        <td>A (≤ 1/150); B (≤ 1/200); C (≤ 1/300)</td>
        <td>Clasa C2/B2......C5/B5</td>
      </tr>
      <tr>
        <td>Forta de actionare (Clasa)</td>
        <td>-</td>
        <td>1.....2</td>
      </tr>
      <tr>
        <td>Rezistenta la soc</td>
        <td>npd</td>
        <td>npd</td>
      </tr>
      <tr>
        <td>Permeabilitate la aer (Clasa)</td>
        <td>1 (150); 2 (300); 3 (600); 4 (600)</td>
        <td>Clasa 4</td>
      </tr>
      <tr>
        <td>Performanta acustica Rw (C;Ctr) (dB)</td>
        <td>Valoare declarata</td>
        <td>33(-2; -6) dB.....46(-2; -5) dB</td>
      </tr>
      <tr>
        <td>Transmitanta termica Uw(W/(m 2-K))</td>
        <td>Valoare declarata</td>
        <td>0,84....1,6</td>
      </tr>
      <tr>
        <td>Capacitatea de rezistenta a dispozitivelor de siguranta</td>
        <td>Valoare prag</td>
        <td>npd</td>
      </tr>
      <tr>
        <td>Rezistenta mecanica (Clasa)</td>
        <td>-</td>
        <td>4</td>
      </tr>
      <tr>
        <td>Rezistenta la efractie</td>
        <td>Valoare declarata</td>
        <td>≤ WK 3</td>
      </tr>
      <tr>
        <td>Rezistenta la deschidere si inchidere repetata</td>
        <td>Numar de cicluri</td>
        <td>3</td>
      </tr>
    </table>
    <p>9. Performanţa produsului identificat la pct. 1 şi 2 este în conformitate cu performanţa declarată de la pct. 8.
      Această declaraţie de performanţă este emisă pe răspunderea exclusivă a fabricantului identificat la pct 4.
    </p>
    </div>
    <div style="text-align: center; width:100%; position: absolute; bottom:15px;">
      Responsabil Control Productie	<img src="images/semnatura_cert_decl.png"/>
    </div> 
  </div>
  <!----------------------------------sfarsit pag 4-------------------------------------------->  
</div>
</body>
<?php $conbd->close();?>
</html>