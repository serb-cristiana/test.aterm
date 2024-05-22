<?php
session_start();
include 'functii.php';
VerificareOcolireLogin();
VerificareOcolireAdminSauCoordTehnicSauAgentSauCoordFin();
ConectareBd();
?>

<html>
<head>
    <title>Production Management System - Administrator</title>
    <link href="CSS/layout.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="main"><?php 
    include 'meniu.php';
    //extragere date lucrare de impartit
    $Parinte = $_GET['Parinte'];
    $query = $conbd->query("SELECT * FROM comenzi WHERE Parinte=".$Parinte." ORDER BY CodIntern2;");?>
    <div class="div_sigla">
        <br>
        <!--img src="images/sigla.png"-->
        Production Management System <br>
        <?php echo $_SESSION['producator'];?>
    </div>	
</div>

<div style="width:20000px;"><?php
    //afisarea tuturor subcomenzilor
    while ($row = $query->fetch_assoc()){?>
    <div class='imparte_lucrare'>
        <table>
            <tr><td>                                                    </td></tr>
            <tr><td>Cod intern:     <?php echo $row['CodIntern'];?>	</td></tr>
            <tr><td>Cod intern 2:   <?php echo $row['CodIntern2'];?>	</td></tr>
            <tr><td>Nume lucrare:   <?php echo $row['Nume'];?>		</td></tr>
            <tr><td>Descriere:      <?php echo $row['Descriere'];?>	</td></tr>
            <tr><td>Valoare:        <?php echo $row['Valoare'];?> euro	</td></tr>
            <tr><td>Suprafata:      <?php echo $row['Suprafata'];?> mp	</td></tr>
            <tr><td>Greutate:       <?php echo $row['Greutate'];?> kg	</td></tr>
            <tr><td>Ferestre:       <?php echo $row['Ferestre'];?>bucati</td></tr>
            <tr><td>Usi:            <?php echo $row['Usi'];?> bucati	</td></tr>
        </table>
    </div><?php
    //valorile ultimei subcomenzi:
    $CodIntern = $row['CodIntern'];
    if ($row['CodIntern2'] > 0){
        $CodIntern2_1 = $row['CodIntern2'];
    }else{
        $CodIntern2_1 = 1;
    }
    $CodIntern2_2   = $CodIntern2_1 + 1;
    $Nume_1         = $row['Nume'];
    $Nume_2         = $row['Nume'];
    $Descriere_1    = $row['Descriere'];
    $Descriere_2    = $row['Descriere'];
    $Valoare_1      = $row['Valoare'];
    $Valoare_2      = $row['Valoare'];
    $Suprafata_1    = $row['Suprafata'];
    $Suprafata_2    = $row['Suprafata'];
    $Greutate_1     = $row['Greutate'];
    $Greutate_2     = $row['Greutate'];
    $Ferestre_1     = $row['Ferestre'];
    $Ferestre_2     = $row['Ferestre'];
    $Usi_1          = $row['Usi'];
    $Usi_2          = $row['Usi'];
    $Parinte        = $row['Parinte'];
    $IDClient      = $row['IDClient'];
    $Responsabil    = $row['Responsabil'];
    $DataCreare     = $row['DataCreare'];
    $DataLivrare    = $row['DataLivrare'];
    $TraseuLivrare  = $row['TraseuLivrare'];
    $AdresaLivrare  = $row['AdresaLivrare'];
    $CuMontaj       = $row['CuMontaj'];
    }
    //form-ul ptr impartirea ultimei subcomenzi
    ?>
    <form action='validare_impartire.php' method='POST'>
        <input type='hidden' name='ID'              value='<?php echo $CodIntern;?>'>
        <input type='hidden' name='CodIntern'       value='<?php echo $CodIntern;?>'>
        <input type='hidden' name='CodIntern2_1'    value='<?php echo $CodIntern2_1;?>'>
        <input type='hidden' name='CodIntern2_2'    value='<?php echo $CodIntern2_2;?>'>
        <input type='hidden' name='Parinte'         value='<?php echo $Parinte;?>'>
        <input type='hidden' name='IDClient'       value='<?php echo $IDClient;?>'>
        <input type='hidden' name='Responsabil'     value='<?php echo $Responsabil;?>'>
        <input type='hidden' name='DataCreare'      value='<?php echo $DataCreare;?>'>
        <input type='hidden' name='DataLivrare'     value='<?php echo $DataLivrare;?>'>
        <input type='hidden' name='TraseuLivrare'   value='<?php echo $TraseuLivrare;?>'>
        <input type='hidden' name='AdresaLivrare'   value='<?php echo $AdresaLivrare;?>'>
        <input type='hidden' name='CuMontaj'        value='<?php echo $CuMontaj;?>'>
        <div class='imparte_lucrare'>
            <div>
                <table>
                    <tr><td>Prima</tr></td>
                    <tr><td>Cod intern: <?php echo $CodIntern;?></tr></td>
                    <tr><td>Cod intern 2: <?php echo $CodIntern2_1;?> </tr></td>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Nume_1;?>'   	name='Nume_1'/>         </td></tr>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Descriere_1;?>'  name='Descriere_1'/>    </td></tr>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Valoare_1;?>'   	name='Valoare_1'/>      </td></tr>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Suprafata_1;?>'  name='Suprafata_1'/>    </td></tr>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Greutate_1;?>'   name='Greutate_1'/>     </td></tr>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Ferestre_1;?>'   name='Ferestre_1'/>     </td></tr>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Usi_1;?>'   	name='Usi_1'/>          </td></tr>
                </table>
            </div>
            <div>
                <table>
                    <tr><td>A doua</tr></td>
                    <tr><td>Cod intern: <?php echo $CodIntern;?></tr></td>
                    <tr><td>Cod intern 2: <?php echo $CodIntern2_2;?> </tr></td>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Nume_2;?>'   	name='Nume_2'/> </td></tr>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Descriere_2;?>'  name='Descriere_2'/> </td></tr>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Valoare_2;?>'   	name='Valoare_2'/> </td></tr>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Suprafata_2;?>'  name='Suprafata_2'/> </td></tr>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Greutate_2;?>'   name='Greutate_2'/> </td></tr>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Ferestre_2;?>'   name='Ferestre_2'/> </td></tr>
                    <tr><td><input type='text' style='text-align:center;' size='25' value='<?php echo $Usi_2;?>'   	name='Usi_2'/> </td></tr>
                </table>
            </div>
            <input type='submit' value='Imparte' name='bmu'>
        </div>
    </form>
</div>
</body>
<?php $conbd->close();?>
</html>