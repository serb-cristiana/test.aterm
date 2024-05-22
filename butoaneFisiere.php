<div class="btn-group btn-group-xs" role="group" aria-label="...">
  <?php $areFis = AreFisier($row['ID'], 1, $conbd); ?>
  <button type="button" class="btn btn-default <?php echo ($areFis && DescarcaCFU()) || (!$areFis && IncarcaCFU()) ? '' : 'disabled'; ?>" title="Fisier comanda" onclick="<?php 
    if ($areFis && DescarcaCFU()) {
      echo "location.href='descarcaFisier.php?ID=".$row['ID']."&NrFisier=1'";
    } elseif (!$areFis && IncarcaCFU()) {
      echo 'IncarcaFisier('.$row['ID'].', 1);';
    } else {
      echo '';
    }
  ?>">
    <span class="<?php echo $areFis ? 'text-success' : 'text-danger'; ?>">C</span>
  </button>
  
  <?php $areFis = AreFisier($row['ID'], 2, $conbd); ?>
  <button type="button" class="btn btn-default <?php 
    if (($areFis && DescarcaFactura()) || (!$areFis && IncarcaFactura())) {
      echo ($_SESSION['pag'] == 'asteptare') ? 'disabled' : '';
    } else {
      echo 'disabled';
    }
  ?>" title="Factura" onclick="<?php 
    if ($_SESSION['pag'] == 'asteptare') {
      echo '';
    } else {    
      if ($areFis && DescarcaFactura()) {
        echo "location.href='descarcaFisier.php?ID=".$row['ID']."&NrFisier=2'";
      } elseif (!$areFis && IncarcaFactura()) {
        echo 'IncarcaFisier('.$row['ID'].', 2);';
      } else {
        echo '';
      }
    }
  ?>">
    <span class="<?php echo $areFis ? 'text-success' : 'text-danger'; ?>">F</span>
  </button>
  
  <?php $areFis = AreFisier($row['ID'], 3, $conbd); ?>
  <button type="button" class="btn btn-default <?php echo ($areFis && DescarcaDovadaPlata()) || (!$areFis && IncarcaDovadaPlata()) ? '' : 'disabled'; ?>" title="Dovada plata" onclick="<?php 
    if ($areFis && DescarcaDovadaPlata()) {
      echo "location.href='descarcaFisier.php?ID=".$row['ID']."&NrFisier=3'";
    } elseif (!$areFis && IncarcaDovadaPlata()) {
      echo 'IncarcaFisier('.$row['ID'].', 3);';
    } else {
      echo '';
    }
  ?>">
    <span class="<?php echo $areFis ? 'text-success' : 'text-danger'; ?>">P</span>
  </button>
  
  <?php $areFis = AreFisier($row['ID'], 4, $conbd); ?>
  <button type="button" class="btn btn-default <?php echo ($areFis && DescarcaFisierDiverse()) || (!$areFis && IncarcaFisierDiverse()) ? '' : 'disabled'; ?>" title="Fisier diverse" onclick="<?php 
    if ($areFis && DescarcaFisierDiverse()) {
      echo "location.href='descarcaFisier.php?ID=".$row['ID']."&NrFisier=4'";
    } elseif (!$areFis && IncarcaFisierDiverse()) {
      echo 'IncarcaFisier('.$row['ID'].', 4);';
    } else {
      echo '';
    }
  ?>">
    <span class="<?php echo $areFis ? 'text-success' : 'text-danger'; ?>">D</span>
  </button>
</div>