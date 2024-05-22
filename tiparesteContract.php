<?php
session_start();
include 'functii.php';
VerificareOcolireLogin();
if (TiparesteContract() == FALSE) {die('Forbiden acces!');};
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

    <!--JSPDF CDN-->
    <script src= "https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"> </script>

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
    <button class="button" onclick="window.location.href='comenzi.php'">Back</button> 
    <button onClick="window.print()"> Tipareste Contract </button> <br><br>
    <input type="button" class="button" onclick="printDiv('pag1')" value="Tipareste pagina 1" />
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
    co.CodIntern2 AS CodIntern2,
    COALESCE(de.Nume, cl.Nume) AS NumeClient,
    cl.Adresa AS Adresa,
    cl.TelFix AS TelFix,
    cl.CNP AS CNP,
    cl.CI AS CI,
    cl.CUI AS CUI,
    cl.RC AS RC,
    co.Nume AS Nume,
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
  
    <div id="pag1" class="pag_contract">
      <img src="images/log.png" align="left" width="210" height="90"/><br>
      <h3>CONTRACT FURNIZARE</h3>
      <h3>PRODUSE ŞI PRESTĂRI SERVICII</h3>
      <h3>Nr. <?php echo $date['NrContract'];?> din <?php echo FDate($date['DataCreare']);?></h3><br>
      <div class="par_contract">
        <p><strong>1. PĂRŢILE CONTRACTANTE</strong></p>
        <p>S.C ATERM S.R.L. cu sediul în Mediaş, Sos. Sibiului, Nr. 48, Bloc 9, Etaj P, Apartament 7, jud. Sibiu, cod fiscal RO 18734344, 
          ING BANK MEDIAŞ RO81INGB0000999904894558, înregistrată la Registrul Comerţului Sibiu sub nr. J32/797/2006, tel/fax: 0269-833233, 
          reprezentată prin Bănceu Răzvan Ioan în calitate de <b>FURNIZOR</b>,<br></p>
          <p>și</p>
          <p> Dl./D-na <?php echo $date['NumeClient'];?>, domiciliat/ă în <?php echo $date['Adresa'];?>,
          Cod unic de înregistrare <?php if($date['CUI'] == ''){echo '_____________';}else{ echo $date['CUI'];};?>, 
          înregistrată la O.R.C. sub nr.  <?php if($date['RC'] == ''){echo '_____________';}else{ echo $date['RC'];};?>, 
          reprezentată prin <?php echo $date['NumeClient'];?>, 
          identificat cu C.I. <?php if($date['CI'] == ''){echo '_____________';}else{ echo $date['CI'];};?>, 
          C.N.P. <?php if($date['CNP'] == ''){echo '_____________';}else{ echo $date['CNP'];};?>,
          telefon <?php if($date['TelFix'] == ''){echo '_____________';}else{ echo $date['TelFix'];};?>, 
          în calitate de <b>BENEFICIAR</b>,</p><br>
          <p><strong>2. OBIECTUL CONTRACTULUI</strong></p>
          <p>Obiectul contractului îl reprezintă produsele şi serviciile <b>FURNIZORULUI</b> ofertei de preţ acceptată de către <b>BENEFICIAR</b>. 
          Oferta semnată de Beneficiar şi Fişa de Măsurători sunt părţi integrante ale prezentului Contract.</p><br>
          <p><strong>3. VALOAREA CONTRACTULUI ŞI MODALITĂŢI DE PLATĂ</strong></p>
          <p> 3.1. Valoarea contractului este în sumă de <?php echo $date['Valoare'];?>  lei, inclusiv TVA, 
          conform Ofertei de Preţ întocmită de Furnizor şi acceptată de Beneficiar. 
          Orice produs şi/său serviciu solicitat Furnizorului de către Beneficiar în plus faţă de cele stabilite iniţial, necesită o nouă ofertă de preţ. 
          Drept urmare, se va constitui un Act Adiţional la prezentul Contract sau se va întocmi un contract nou.</p>
          <p> 3.2. Valoarea contractului se achita prin virament bancar sau în numerar la casieria societăţii, în baza facturii fiscale emise de către Furnizor.</p>
          <p> 3.3. Beneficiarul se obliga să achite următoarele valori din preţul cuvenit la data semnării prezentului contract:<br>
          <ol type="1">
            <li> _____________lei până la data de _____________;  </li> 
            <li> _____________lei până la data de _____________;  </li> 
            <li> _____________lei până la data de _____________;  </li> 
            <li> _____________lei până la data de _____________;  </li> 
            <li> _____________lei până la data de _____________;  </li>
          </ol></p>
          <p> 3.4. Beneficiarul se obliga să achite, cu titlu de avans, un procent de 50 % din preţul convenit la data semnării prezentului contract, 
            urmând că diferenţa de 50% să se achite cu 48 de ore înaintea executării lucrărilor de montaj.</p>
          <p> 3.5. Neachitarea contravalorii obligaţiilor de plată sau a facturilor întocmite de către Furnizor la termenul stabilit, 
            atrage după sine plata unor penalităţi de întârziere în cuantum de 0,1 % din valoarea sume de plata scadente pentru fiecare zi de întârziere, de către Beneficiar. 
            Penalităţile se aplica începând cu ziua următoare scadentei, valoarea penalităţilor putând depăşii valoarea debitului restant.</p>
          <p> 3.6. In situaţia in care Beneficiarul nu achita avansul stabilit in termen de maxim 3 zile de la semnarea contractului, prezentul contract încetează, 
            fara somaţie sau trecerea vreunui termen si fara intervenţia instanţelor judecătoreşti.</p>
            <br>
          <p><strong>4. TERMENUL DE PREDARE SI EXECUTAREA LUCRĂRII</strong></p>
          <p>4.1. Părţile contractante stabilesc ca termen de execuţie a lucrării in ....... maxim zile lucrătoare de la data încasării avansului. Locaţia la care se executa lucrarea este:<br>
          Localitate: ………………………………………..<br>
          Strada: ………………..., Nr. ………………………………..<br>
          Judeţ: ……………………………..<br>
          Persoana desemnata pentru recepţie: ……………………..……………………………………..<br>
          Telefon: ………………………………….<br></p> 
        </div>
        <div style="text-align: left; color: #D3D3D3; width:100%; position: absolute; bottom:2px; font-size:10px">
        <p>
          Aterm SRL <br>
          NRC: J32/797/2006, CUI: RO 18734344 <br>
          Str. Gării FN, municipiul Mediaş, județul Sibiu, România <br>
          Banca: ING BANK; IBAN: RO 81 INGB 0000 9999 0489 4558 <br>
          Mobil: +4 0754 042 042, Tel./Fax: +4 0269 833 118 <br>
          office@aterm.ro; www.aterm.ro <br>
        </p>
      </div>
      <div style="text-align: center; width:100%; position: absolute; bottom:10px;"> Pagina 1	</div>
    </div> <br>
    <input type="button" onclick="printDiv('pag2')" value="Tipareste pagina 2" /> <br><br>
    <div id="pag2" class="pag_contract">
      <img src="images/log.png" align="left" width="210" height="80"/> <br><br><br><br>
      <div class="par_contract">
        <p> 4.2. Termenul de predare si execuţie a lucrării poate fi schimbat in următoarele cazuri:<br>
        <ol type="a">
          <li>Beneficiarul solicita modificări la oferta agreata de Părţile Contractante, după data încheierii prezentului contract, acesta are obligaţia de a notifica Furnizorul in scris, urmând ca Furnizorul sa ii comunica in scris daca modificările cerute pot fi acceptate. In situaţia in care modificările sunt acceptate, Beneficiarul va comunica Beneficiarului noul termen de execuţie a lucrării;<br></li>
          <li>Beneficiarul nu asigura condiţiile necesare de livrare sau de lucru (curent electric, accesul si frontal de lucru la locaţia specificata);<br></li>
          <li>Condiţiile meteo nu sunt favorabile începerii sau continuării lucrării;<br></li>
          <li>Documentaţiile de execuţie sau avize lipsesc; <br></li>
          <li>Sistarea sau restricţionarea lucrărilor de organele competente. <br></li>
          <li>Orice alta situaţie/eveniment neprevăzut apărută si independenta de voinţa Furnizorului si/sau a Beneficiarului si care împiedică începerea, continuarea si/sau încheierea lucrării. <br></li> 
        </ol></p> 
        <p><strong>5. RECEPŢIA LUCRĂRII</strong></p>
        <p>5.1. La finalizarea lucrării, părţile au obligaţia de a încheia Procesul verbal la terminarea lucrării. In situaţia in care Beneficiarul sau un reprezentant al acestuia nu poate fi prezent la recepţia lucrării acesta are obligaţia de a notifica in scris Furnizorul cu 1 (una) zi înainte de data începerii lucrării.<br></p>
        <p>5.2. După finalizarea lucrării, Beneficiarul are obligaţia de a semna Procesul Verbal de recepţie, refuzul nejustificat de a semna procesul verbal la terminarea lucrării nu da dreptul Beneficiarului de a refuza plata lucrărilor executate.<br></p>
        <p>5.3. Furnizorul are obligaţia de a-i preda Beneficiarului lucrarea executata si de a ii prezenta funcţionalitatea produselor si modul de utilizare a acesteia. Beneficiarul are dreptul de a solicita Furnizorului orice lămuriri cu privire la produse si de a sesiza orice neconformităţi, care se vor consemna in cuprinsul procesului verbal.<br></p>
        <p>5.4. La recepţia lucrării, produsele se evaluează astfel:<br>
        <ol> 
          <li>Controlul vizual se face privindu-se elementul de tâmplărie de la o distanta de 2 metri in poziţie perpendiculara. Observarea se va face dintr-un unghi de vedere care corespunde unghiului din care va fi privit după utilizare. De regula privirea trebuie sa cada direct pe mijlocul elementului de tâmplărie. Lumina va avea intensitatea corespunzătoare unei lumini naturale difuze. Fiecare examinare nu trebuie sa dureze mai mult de 20 secunde.<br></li>
          <li>Toate defectele mai mici de 1 mm nu vor fi luate in considerare. Defectele care nu pot fi evitate datorita manipulării materiei prime si a procesului tehnic de execuţie, respectiv zgârieturi fine care nu lasă crestături, se considera defecte tolerate si sunt acceptate. Crestături sunt rizuri foarte ascuţite sau fisuri > 3 mm care se găsesc in zona principala si deranjează din punct de vedere vizual sau funcţional nu se accepta. Umflaturi - in mod obişnuit sunt bule de aer care se găsesc sub folia decor si nu se accepta.<br></li>
        </ol>
      </p>
      <p><strong>6. RESPONSABILITĂŢILE GENERALE ALE PĂRŢILOR</strong></p>
      <p> 6.1. FURNIZORUL îşi asuma următoarele obligaţii:<br>
      <ul>
        <li>sa execute produsele si serviciile in termenul prevăzut in prezentul contract. Nerespectarea de către Furnizor a termenului de predare, atrage după sine plata penalităţilor de 0,1% din valoarea contractului pentru fiecare zi de întârziere. <br></li>
        <li>sa execute produsele si serviciile conform Ofertei de preţ semnate de către Beneficiar.<br></li>
        <li>sa garanteze produsele si serviciile conform certificatului de garanţie. <br></li>
        <li>sa remedieze eventualele defecte de fabricaţie sau de instalare, cu titlu gratuit in perioada de garanţie. <br></li>
        <li>sa instaleze produsele fara a fi responsabil de efectuarea reparaţiilor si de finisare a zidăriei. In cazul in care, montarea produselor Furnizorului necesita demontarea produselor existenta, aceste produse existente se demontează prin taiere. Daca beneficiarul doreşte sa recupereze aceste produse, atunci demontarea acestor produse revine integral Beneficiarului. Furnizorului nu i se poate imputa deteriorarea produselor existente de tâmplărie.<br></li>
      </ul></p>
    </div>
    <div style="text-align: left; color: #D3D3D3; width:100%; position: absolute; bottom:2px; font-size:10px">
    <p>
      Aterm SRL <br>
      NRC: J32/797/2006, CUI: RO 18734344 <br>
      Str. Gării FN, municipiul Mediaş, județul Sibiu, România <br>
      Banca: ING BANK; IBAN: RO 81 INGB 0000 9999 0489 4558 <br>
      Mobil: +4 0754 042 042, Tel./Fax: +4 0269 833 118 <br>
      office@aterm.ro; www.aterm.ro <br>
    </p>
  </div>
  <div style="text-align: center; width:100%; position: absolute; bottom:10px;">Pagina 2	</div>
</div> <br>
<input type="button" onclick="printDiv('pag3')" value="Tipareste pagina 3" /> <br><br>
<div id="pag3" class="pag_contract">
  <img src="images/log.png" align="left" width="210" height="90"/> <br><br><br><br><br>
  <div class="par_contract">
    <p> 6.2. BENEFICIARUL îşi asuma următoarele obligaţii:<br>
    <ul>
      <li>sa asigure frontul de lucru, condiţii de montaj, alimentare cu energie electrica 220V si condiţii de protecţie a muncii specifice lucrării; In cazul in care Beneficiarul nu îşi îndeplineşte obligaţiile privind asigurarea condiţiilor de montaj asumate prin fisa de măsurători, Furnizorul are dreptul de a nu monta produsele si a solicita contravaloarea prejudiciului cauzat. In cazul in care Beneficiarul solicita montarea tâmplăriei in alte condiţii decât cele stabilite prin fisa de măsurători si prezentul contract, Prestatorul nu va monta tâmplăria, ci o va preda beneficiarului cu proces verbal de predare primire.<br></li>
      <li>sa plătească întreaga valoare a lucrării conform contractului, conform prevederilor Art. 3 - VALOAREA CONTRACTULUI SI MODALITĂŢI DE PLATA din prezentul contract.<br></li>
      <li>sa răspundă direct in fata organelor in drept pentru autorizaţia necesara conform legii pentru efectuarea construcţiilor amenajate.<br></li>
      <li>sa semneze procesul verbal la terminarea lucrării. <br></li>
      <li>sa evacueze prin mijloace si cheltuieli proprii deşeurile rezultate in urma demontării produselor vechi de tâmplărie, având obligaţia de la preda centrelor specializate de colectare si reciclare conform normelor in vigoare. <br></li>
      <li>in caz de executare, de către Beneficiar, a unor lucrări de zugrăveli sau construcţii, produsele montate de Furnizor trebuie acoperite integral cu o folie protectoare împotriva deteriorării.<br></li>
      <li>sa achite integral contravaloarea produselor din Oferta de Preţ in cazul in care renunţă la comanda.<br></li>
    </ul></p>
    <p><strong>7. GARANŢII</strong></p>
    <p>Prestatorul acorda pentru lucrarea beneficiarului:<br>
      <ul>
        <li>5 ani garanţie pentru sistemul de profile;<br></li>
        <li>2 ani garanţie pentru feronerie;<br></li>
        <li>2 ani garanţie pentru geam termoizolant (nu condensează in interiorul pachetului termoizolator);<br></li>
        <li>1 an garanţie pentru rulourile manuale; <br></li>
        <li>2 ani garanţie pentru rulourile cu motor;<br></li>
        <li>2 ani pentru reglaje.<br></li>
      </ul>
    </p>
    <p><strong>8. TRANSFERUL DE PROPRIETATE</strong></p>
      <p>Prestatorul este proprietar de drept pe structura tâmplăriei si a geamurilor aferente conform prezentului contract pana la plata integrala a lucrării, in caz contrar prezentul contract constituie titlu executoriu de ridicare a structurii executate de către prestator, iar avansul acordat de beneficiar nu va mai fi restituit. </p> <br>
    <p><strong>9. PROTECŢIA DATELOR CU CARACTER PERSONAL</strong></p>
      <p> 9.1. Datele cu caracter personal ale persoanelor de contact/reprezentanţi ai ambelor părţi precum şi salariaţii acestora vor avea acces în derularea prezentului contract, se vor prelucra în condiţiile Regulamentului (UE) 2016/679 - privind protecţia persoanelor fizice în ceea ce priveşte prelucrarea datelor cu caracter personal şi privind libera circulaţie a acestor date.</p>
      <p> 9.2. Fiecare parte va divulga celeilalte părţi date cu caracter personal privind angajaţii sau reprezentanţii săi responsabili cu executarea prezentului contract. Aceste date vor consta în: datele de identificare, poziţie, număr de telefon, adresa de e-mail a angajaţilor/reprezentanţilor relevanţi.</p>
      <p> 9.3. Părţile, în calitate de operator de date vor prelucra datele cu caracter personal în scopul executării acestui contract precum şi pentru a-şi îndeplini obligaţiile care îi sunt impuse de legislaţia aplicabilă, precum şi în scopuri legitime, cum ar fi, prevenirea fraudei, realizarea raportărilor interne, aplicarea măsurilor de analiză a clientelei conform legislaţiei aplicabile etc în condiţiile Regulamentului General privind protecţia datelor.</p> <br>
    </div>
    <div style="text-align: left; color: #D3D3D3; width:100%; position: absolute; bottom:2px; font-size:10px">
    <p>
      Aterm SRL <br>
      NRC: J32/797/2006, CUI: RO 18734344 <br>
      Str. Gării FN, municipiul Mediaş, județul Sibiu, România <br>
      Banca: ING BANK; IBAN: RO 81 INGB 0000 9999 0489 4558 <br>
      Mobil: +4 0754 042 042, Tel./Fax: +4 0269 833 118 <br>
      office@aterm.ro; www.aterm.ro <br>
    </p>
  </div>
  <div style="text-align: center; width:100%; position: absolute; bottom:10px;">Pagina 3	</div>
</div> <br>
<input type="button" onclick="printDiv('pag4')" value="Tipareste pagina 4" /> <br><br>
<div id="pag4" class="pag_contract">
  <img src="images/log.png" align="left" width="210" height="80"/> <br><br><br><br>
  <div class="par_contract">
    <p> 9.4. Acolo unde legea prevede astfel, fiecare parte care divulga informaţii în legătura cu angajaţii/reprezentanţii săi trebuie să furnizeze o notă de informare persoanelor vizate, informându-le în mod corespunzător cu privire la prelucrarea datelor cu caracter personal ale acestora, efectuată de către cealaltă parte în legătura cu prezentul contract.</p>
    <p> 9.5. Pentru evitarea oricărui dubiu, părţile iau cunoştinţa şi convin ca fiecare parte să determine, în mod independent, scopul/scopurile şi mijloacele de prelucrare a datelor cu caracter personal în legătura cu acest contract. Mai precis, părţile convin prin prezenta şi confirmă că nu o să acţioneze că operatori asociaţi sau să fie într-o relaţie de tip operator-persoană împuternicită de operator, fiecare parte acţionând ca un operator de date independent pentru propria prelucrare a datelor în legătura cu prezentul contract şi niciuna dintre părţi nu acceptă vreo răspundere pentru o încălcare de către cealaltă parte a legislaţiei aplicabile.</p> <br>
    <p><strong>10. FORŢA MAJORA</strong></p>
    <p> Niciuna din părţile contractante nu răspund de neexecutarea la termen sau/si executarea in mod necorespunzător, total sau parţial a oricărei obligaţii care-i revin in baza prezentului contract daca neexecutarea sau executarea necorespunzătoare a obligaţiilor respective a fost cauzata de forţa majora, aşa cum este definit de către lege. Partea care invoca forţa majora este obligata sa notifice in scris celelalte parti in termen de 7 (şapte) zile producerea evenimentului si sa ia toate masurile necesare posibile in vederea limitării consecinţelor.</p><br>
    <p><strong>11. LITIGII</strong></p>
    <p> Părţile au convenit ca toate neînţelegerile privind validarea prezentului contract s-au rezultat din interpretarea, executarea sau încetarea acestuia sa fie rezolvate pe cale amiabila de către reprezentanţii lor.</p>
    <p> In cazul in care nu este posibila rezolvarea litigiilor pe cale amiabila, ele vor fi supuse spre soluţionarea instanţelor judecătoreşti competente de la sediul Prestatorului.</p> <br>
    <p><strong>12. CLAUZE SI EFECTE</strong></p>
    <p> Formarea condensului pe suprafaţa interioara a geamului termoizolator respectiv a ramelor. In principiu poate apărea condensul pe suprafaţa interioara a geamurilor termoizolatoare respective ramelor.Se vorbeşte in acest caz si de formarea apei exsudate sau a apei de condens. Acest fenomen nu are voie insa sa fie confundat cu condensarea din spaţiul intermediar al geamurilor termoizolatoare. Condensul este un fenomen fizic ce nu poate fi evitat, iar in cauzele formarii apei de condens pe suprafaţa interioara a elementelor de construcţie se aplica după cum urmează:</p>
    <ol type="1">
      <li> In locuinţa se produc permanent vapori de apa, iar prin măsurători s-au stabilit următoarele cantităţi:</li>
      <ul>
        <li> aerul respirat de om: cantitatea produsa zilnic > 1-2 litri vapori</li>
        <li> gătit: zilnic pana la 2 litri vapori într-o gospodărie de 4 persoane</li>
        <li> baie, spălatul rufelor, udatul florilor: zilnic pana la 3 litri vapori la 4 persoane. Vechiile ferestre erau de regula atât de neetanşe încât permiteau un schimb permanent de aer.</li>
      </ul>
      <li>In cazul apariţiei condensului pe suprafaţa interioara a geamului termoizolator, respectiv a ramelor, Prestatorul este exenorat de răspundere si nu poate fi obligat la plata de daune-interese fata de Beneficiar. </li><br>
    </ol>
    <p><strong>13. CLAUZE FINALE</strong></p>
    <p> Prezentul contract, împreună cu anexele sale care fac parte integrata din cuprinsul sau, reprezintă voinţa părţilor si înlătura orice alta înţelegere verbala dintre acestea, anterioare sau posterioare semnării lui. Prezentul contract a fost întocmit in doua exemplare, azi cate unul pentru fiecare parte.  
    </p>
  </div>
  <div class="cuTab"> 
    <div class="tab" style="width: 500px;">
    PRESTATOR<br>
    S.C. ATERM S.R.L
  </div>
  <div class="tab">    
    BENEFICIAR<br>
    <?php echo $date['NumeClient'];?>
  </div>    
</div> <br><br>
<div style="text-align: left; color: #D3D3D3; width:100%; position: absolute; bottom:2px; font-size:10px">
<p>
  Aterm SRL <br>
  NRC: J32/797/2006, CUI: RO 18734344 <br>
  Str. Gării FN, municipiul Mediaş, județul Sibiu, România <br>
  Banca: ING BANK; IBAN: RO 81 INGB 0000 9999 0489 4558 <br>
  Mobil: +4 0754 042 042, Tel./Fax: +4 0269 833 118 <br>
  office@aterm.ro; www.aterm.ro <br>
</p>
</div>
<div style="text-align: center; width:100%; position: absolute; bottom:10px;">Pagina 4	</div>
</div>
</div>
</body>
<?php $conbd->close();?>
</html>