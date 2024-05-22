<?php
session_start();
$_SESSION['pag'] = 'reclamatii';
include 'functii.php';
VerificareOcolireLogin();
if (VedeReclamatii() == FALSE) {
    die('Acces interzis!');
};
ConectareBd();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Production Management System Administrator - Reclamații</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <style>
        /* Stiluri pentru câmpurile de filtrare */
        input[type="text"] {
            width: 100%;
            padding: 6px 12px;
            margin-bottom: 10px;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <?php include 'meniu.php'; ?>
    <div class="container-fluid underFirstNavbar"> 
        <h2>.</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nume Comandă <input type="text" id="filterNumeComanda"></th>
                    <th>Nume Dealer <input type="text" id="filterNumeDealer"></th>
                    <th>Descriere</th>
                    <th>Data Reclamației <input type="date" id="filterDataReclamatie"></th>
                    <th>Material Video</th>
                    <th>Material Foto</th>
                </tr>
            </thead>
            <tbody id="tabelReclamatii">
                <?php
                $date = $conbd->query("SELECT ID, NumeComanda, NumeDealer, Descriere, DataReclamatie, MaterialVideo, MaterialFoto FROM reclamatii");
                while ($row = $date->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $row['NumeComanda']; ?></td>
                        <td><?php echo $row['NumeDealer']; ?></td>
                        <td><?php echo $row['Descriere']; ?></td>
                        <td><?php echo $row['DataReclamatie']; ?></td>
                        <td>
                            <!-- Afișarea linkului către materialul video -->
                            <?php if (!empty($row['MaterialVideo'])) { ?>
                                <a href="afiseaza_material.php?id=<?php echo $row['ID']; ?>&tip=video">Video</a>
                            <?php } else {
                                echo 'N/A';
                            } ?>
                        </td>
                        <td>
                            <!-- Afișarea linkului către materialul Foto -->
                            <?php if (!empty($row['MaterialFoto'])) { ?>
                                <a href="afiseaza_material.php?id=<?php echo $row['ID']; ?>&tip=Foto">Poză</a>
                            <?php } else {
                                echo 'N/A';
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
    $(document).ready(function(){
        // Functia de filtrare pentru fiecare coloana
        $("#filterNumeComanda").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tabelReclamatii tr").filter(function() {
                $(this).toggle($(this).children("td:first").text().toLowerCase().indexOf(value) > -1)
            });
        });

        $("#filterNumeDealer").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tabelReclamatii tr").filter(function() {
                $(this).toggle($(this).children("td:nth-child(2)").text().toLowerCase().indexOf(value) > -1)
            });
        });

        $("#filterDataReclamatie").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tabelReclamatii tr").filter(function() {
                $(this).toggle($(this).children("td:nth-child(3)").text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    </script>
</body>
</html>
