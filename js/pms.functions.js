var maxFSize = 1024000;

function ArataFormaMC(ID){
  $('#mcIDComanda').val(ID);
  $.ajax({
    type: 'POST',
    url: 'operatiiBD.php?pg='+'getDateComanda',
    data:   'ID='+ID,
    success: function(data){
      //alert(data);
      dc = JSON.parse(data);
      $('#mcTitlu1').text('Editare comanda ' + dc.Nume + ' din data de ' + dc.DataCreare);
      if (dca.NumeClient) {
        $('#mcaTitlu2').text('Beneficiar ' + dca.NumeClient);
    } else if (dca.NumeDealer) {
        $('#mcaTitlu2').text('Beneficiar ' + dca.NumeDealer);
    }
      $('#mcNume').val(dc.Nume);
      $('#mcIDResponsabil').val(dc.IDResponsabil);
      $('#mcValoare').val(dc.Valoare);
      $('#mcIncasat').val(dc.Incasat);
      $('#mcDataLivrare').val(dc.DataLivrare);
      $('#mcAdresaLivrare').val(dc.AdresaLivrare);
      $('#mcIDLivrare').val(dc.IDLivrare);
      $('#mcSuprafata').val(dc.Suprafata);
      $('#mcGreutate').val(dc.Greutate);
      $('#mcFerestre').val(dc.Ferestre);
      $('#mcUsi').val(dc.Usi);
      $('#mcDescriere').val(dc.Descriere);
      $('#mcMontaj').val(dc.CuMontaj);
      //alert(dc.IDClient);
      if(dc.IDClient > 10000){
        $('#mcNume').attr('disabled', true);
      }else{
        $('#mcNume').attr('disabled', false);        
      };
      $("input[name=mcMontaj][value=" + dc.CuMontaj + "]").prop("checked",true);
      if(dc.Anulata == 1){$('#mcAnulata').prop('checked', true);}else{$('#mcAnulata').prop('checked', false);};      
      var i;
      for (i = 1; i <= 10; i++) { 
        FormatCheckBox('#mcLa'+i, '#mcIn'+i, dc.Stadiu.charAt(i));
      };
      if(dc.NrObservatii > 0){
        $('#listaObservatii').html(dc.Observatii);
        $('#listaObservatii').removeClass('hidden');
      }else{
        $('#listaObservatii').addClass('hidden');
      };
    }
  }); 
  $('#mcSubmit').attr('onclick', "updateData('updateComanda', '" + ID + "')");
  $('#mc').modal('show');
};

function ArataFormaMCA(ID) {
  $.ajax({
      type: 'POST',
      url: 'operatiiBD.php?pg=' + 'getDateComandaAsteptare',
      data: 'ID=' + ID,
      success: function(data) {
          dca = JSON.parse(data);
          $('#mcaTitlu1').text('Editare comanda asteptare ' + dca.NumeComanda + ' din data de ' + dca.DataCreare);
          if (dca.NumeClient) {
              $('#mcaTitlu2').text('Beneficiar ' + dca.NumeClient);
          } else if (dca.NumeDealer) {
              $('#mcaTitlu2').text('Beneficiar ' + dca.NumeDealer);
          }
          $('#mcaNume').val(dca.NumeComanda);
          $('#mcaIDLivrare').val(dca.IDLivrare);      
          if (dca.Anulata == 1) {
              $('#mcaAnulata').prop('checked', true);
          } else {
              $('#mcaAnulata').prop('checked', false);
          }
          if (dca.NrObservatii > 0) {
              $('#listaObservatiiCoAs').html(dca.Observatii);
              $('#listaObservatiiCoAs').removeClass('hidden');
          } else {
              $('#listaObservatiiCoAs').addClass('hidden');
          }
      }
  }); 
  $('#mcaSubmit').attr('onclick', "updateData('updateComandaAsteptare', '" + ID + "')");
  $('#mca').modal('show');
}

function IncarcaFisier(ID, NrFisier){
  //alert(ID);
  $.ajax({//cere datele comenzii
    type: 'POST',
    url: 'operatiiBD.php?pg='+'getDateOperatiiFisiere',
    data:   'ID='+ID,
    success: function(data){
      //alert(data);
      //seteaza datele comenzii
      var dof = JSON.parse(data);
      var TipFisier;
      switch(NrFisier){
        case 1: 
          TipFisier = 'fisier CFU'; 
          $('#divNrFactura').addClass('hidden');
          $('#divValoareFactura').addClass('hidden');
          $('#lblCuDeclaratii').addClass('hidden');
          //$('#ufNrFactura').val('');
          break;
        case 2: 
          TipFisier = 'factura'; 
          $('#divNrFactura').removeClass('hidden');
          $('#divValoareFactura').removeClass('hidden');
          $('#ufValoareFactura').val(dof.Valoare);
          $('#lblCuDeclaratii').removeClass('hidden');
          break;
        case 3: 
          TipFisier = 'dovada plata'; 
          $('#divNrFactura').addClass('hidden');
          $('#divValoareFactura').addClass('hidden');
          $('#lblCuDeclaratii').addClass('hidden');
          break;
        case 4: 
          TipFisier = 'fisier diverse'; 
          $('#divNrFactura').addClass('hidden');
          $('#divValoareFactura').addClass('hidden');
          $('#lblCuDeclaratii').addClass('hidden');
          break;
      };
      $('#uploadTitlu1').text('Incarca ' + TipFisier + ' pentru comanda ' + dof.NumeComanda + ' din data de ' + dof.DataCreare);
      $('#uploadTitlu2').text('Beneficiar ' + dof.NumeDealer);
    }
  }); 
  $('#uploadSubmit').attr('onclick', 'UploadFisier('+ID+', '+NrFisier+')');
  $('#upload').modal('show');
};

function AprobaCA(ID){
  $.ajax({//cere datele comenzii
    type: 'POST',
    url: 'operatiiBD.php?pg='+'getDateComandaAsteptare',
    data:   'ID='+ID,
    success: function(data){
      //seteaza datele comenzii
      dca = JSON.parse(data);
      $('#clientCA').val(dca.IDClient);
      $('#dealerCA').val(dca.IDDealer);
      var NumeLucrare = dca.CodPartener + ' ' +dca.NumeComanda;      
      $('#acaNume').val(NumeLucrare);
      $('#acaIDTraseuLivrare').val(dca.IDLivrare);
      $('#idCA').val(ID);
      if (dca.NumeDealer) {
        $('#acaTitlu').text('Aproba comanda ' + dca.NumeComanda + ' partenerului ' + dca.NumeDealer);
    } else if (dca.NumeClient) {
        $('#acaTitlu').text('Aproba comanda ' + dca.NumeComanda + ' partenerului ' + dca.NumeClient);
    }
      if(dca.NrObservatii > 0){        
        $('#acaListaObservatii').html(dca.Observatii);
        $('#acaListaObservatii').removeClass('hidden');
      }else{
        $('#acaListaObservatii').addClass('hidden');
      };      
    }
  });
  $('#aprobaComanda').modal('show');
};

function UploadFisier(ID, NrFisier){
  var Fisier = document.getElementById('uploadFile');
  var NrFactura = jQuery.trim($('#ufNrFactura').val());
  var ValoareFactura = jQuery.trim($('#ufValoareFactura').val());
  var CuDeclaratii;
  if (document.getElementById('ufCuDeclaratii').checked){ CuDeclaratii = 1;
  }else{CuDeclaratii = 0;};  
  //validare corectitudine campuri
  if(Fisier.files.length == 0){
    ShowInfo('Alert!', 'Alegeti un fisier sau renuntati!');
  }else if(Fisier.files[0].size >= maxFSize){
    ShowInfo('Alert!', 'Fisierul poate avea maxim ' + maxFSize/1024 + 'Kb!');
  }else if(NrFisier == 2 && NrFactura == ''){
    ShowInfo('Alert!', 'Introduceti numar factura!');
  }else{
    //alert(ID);
    var data = new FormData();
    jQuery.each(jQuery('#uploadFile')[0].files, function(i, file) {
        data.append('file-'+i, file);
    });  
    data.append('ID', ID);
    data.append('NrFisier', NrFisier);
    data.append('NrFactura', NrFactura);
    data.append('ValoareFactura', ValoareFactura);
    data.append('CuDeclaratii', CuDeclaratii);
    if(location.pathname.indexOf('comenzi.php') >= 0){
      data.append('EsteComanda', 1);
      //alert(location.pathname.indexOf('comenzi.php'));
    }else if(location.pathname.indexOf('asteptare.php') >= 0){
      data.append('EsteComanda', 0);      
    };
    $.ajax({//trimite fisier
      type: 'POST',
      url: 'operatiiBD.php?pg='+'salveazaFisier',
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data){
        if (String(data).length > 4){
          alert(data);
        }
        var str = location.pathname;
        if(str.indexOf('comenzi.php') >= 0){
          window.top.location.href = 'comenzi.php';  
        }else if(str.indexOf('asteptare.php') >= 0){
          window.top.location.href = 'asteptare.php';              
        };
      }
    });
  }
};


function ChangeWeek(tip){
  $.ajax({
    type: 'POST',
    url: 'seteazaFiltre.php',
    data: 'DeLaDaLi=' + tip,
    success: function(data){
      window.top.location.href = 'productie.php';
    }
  }); 
};

function FormatCheckBox(labelID, inputID, stadiu){
  if(stadiu == '1'){
    $(labelID).addClass('text-success').removeClass('text-danger');
    $(inputID).prop('checked', true);
  }else{
    $(labelID).addClass('text-danger').removeClass('text-success');
    $(inputID).prop('checked',false);
  };
};

function CautaNumeComanda(){
      $.ajax({
        type: 'POST',
        url: 'seteazaFiltre.php',
        data:   'cautaNumeComanda=' + $('#cautaNumeComanda').val(),
        success: function(data){
          window.top.location.href = 'comenzi.php';            
        }
      });  
};

function updateData(updateType, ID){  
  switch(updateType){
    
    case 'seteazaFiltre': 
      //alert(location.pathname);
      var fiTrLi  = $('#fiTrLi').val();
      var fiDeal  = $('#fiDeal').val();
      var fiResp  = $('#fiResp').val();
      var fiDeLa  = $('#fiDeLa').val();
      var fiPaLa  = $('#fiPaLa').val();
      var fiCuMo  = $('input[name=fiCuMo]:checked').val();    
      var fiCuFa  = $('input[name=fiCuFa]:checked').val();    
      var fiDatProdTamp  = $('input[name=fiDatProdTamp]:checked').val();    
      var fiDatProdUmp  = $('input[name=fiDatProdUmp]:checked').val();    
      var fiDatProdAcc  = $('input[name=fiDatProdAcc]:checked').val();    
      var fiTermTamp  = $('input[name=fiTermTamp]:checked').val();    
      var fiTermUmp  = $('input[name=fiTermUmp]:checked').val();    
      var fiTermAcc  = $('input[name=fiTermAcc]:checked').val();    
      var fiLivr  = $('input[name=fiLivr]:checked').val();      
      var fiLivrPart  = $('input[name=fiLivrPart]:checked').val();      
      var tipFiltruData = $('input[name=tipFiltruData]:checked').val();    
      $.ajax({
        type: 'POST',
        url: 'seteazaFiltre.php',
        data:   'fiTrLi=' + fiTrLi + 
                '&fiDeal=' + fiDeal +
                '&fiDeLa=' + fiDeLa +
                '&fiPaLa=' + fiPaLa +
                '&fiCuMo=' + fiCuMo +
                '&fiCuFa=' + fiCuFa +
                '&fiDatProdTamp=' + fiDatProdTamp +
                '&fiDatProdUmp=' + fiDatProdUmp +
                '&fiDatProdAcc=' + fiDatProdAcc +
                '&fiTermTamp=' + fiTermTamp +
                '&fiTermUmp=' + fiTermUmp +
                '&fiTermAcc=' + fiTermAcc +
                '&fiLivr=' + fiLivr +
                '&fiLivrPart=' + fiLivrPart +
                '&tipFiltruData=' + tipFiltruData +
                '&fiResp=' + fiResp,
        success: function(data){
          var str = location.pathname;
          //alert(str);
          if(str.indexOf('comenzi.php') >= 0){
            window.top.location.href = 'comenzi.php';  
          }else if(str.indexOf('productie.php') >= 0){
            window.top.location.href = 'productie.php';              
          }else if(str.indexOf('raportDeclaratii.php') >= 0){
            window.top.location.href = 'raportDeclaratii.php';              
          }else if(str.indexOf('asteptare.php') >= 0){
            window.top.location.href = 'asteptare.php';              
          }else if(str.indexOf('asteptareAnulate.php') >= 0){
            window.top.location.href = 'asteptareAnulate.php';              
          };           
        }
      });
      break;
      
    case 'anuleazaFiltre':    
      $.ajax({
        type: 'POST',
        url: 'seteazaFiltre.php',
        success: function(data){
          var str = location.pathname;
          if(str.indexOf('comenzi.php') >= 0){
            window.top.location.href = 'comenzi.php';  
          }else if(str.indexOf('productie.php') >= 0){
            window.top.location.href = 'productie.php';              
          }else if(str.indexOf('asteptare.php') >= 0){
            window.top.location.href = 'asteptare.php';              
          }else if(str.indexOf('asteptareAnulate.php') >= 0){
            window.top.location.href = 'asteptareAnulate.php';              
          };
        }
      });
      break; 
    
   
    case 'updateComanda':
      var Nume          = $('#mcNume').val();
      var Descriere     = $('#mcDescriere').val();
      var Observatie    = $('#mcObservatie').val();
      var IDResponsabil = $('#mcIDResponsabil').val();
      var Valoare       = $('#mcValoare').val();
      var Incasat       = $('#mcIncasat').val();
      var DataLivrare   = $('#mcDataLivrare').val();
      var AdresaLivrare = $('#mcAdresaLivrare').val();
      var IDLivrare =     $('#mcIDLivrare').val();
      var Suprafata     = $('#mcSuprafata').val();
      var Greutate      = $('#mcGreutate').val();
      var Ferestre      = $('#mcFerestre').val();
      var Usi           = $('#mcUsi').val();
      var CuMontaj      = $('input[name=mcMontaj]:checked').val();
      var Anulata;
      if (document.getElementById('mcAnulata').checked){ Anulata = 1;
      }else{Anulata = 0;};
      var StergeFactura;
      if (document.getElementById('mcStergeFactura').checked){ StergeFactura = 1;
      }else{StergeFactura = 0;};
      
      var Stadiu = '8';
      for (i = 1; i <= 10; i++) { 
        Stadiu = Stadiu + GetStadiuComanda(i);
      };       
      //alert(Stadiu);
      $.ajax({
        type: 'POST',
        url: 'operatiiBD.php?pg='+updateType,
        data:   'ID='+ID+ 
                '&Nume='+Nume+
                '&Descriere='+Descriere+
                '&Observatie='+Observatie+
                '&IDResponsabil='+IDResponsabil+
                '&Valoare='+Valoare+
                '&Incasat='+Incasat+
                '&DataLivrare='+DataLivrare+
                '&AdresaLivrare='+AdresaLivrare+
                '&IDLivrare='+IDLivrare+
                '&Suprafata='+Suprafata+ 
                '&Greutate='+Greutate+ 
                '&CuMontaj='+CuMontaj+ 
                '&Ferestre='+Ferestre+ 
                '&Usi='+Usi+
                '&Anulata='+Anulata+
                '&StergeFactura='+StergeFactura+
                '&Stadiu='+Stadiu,
        success: function(data){
          if (String(data).length > 4){
            alert(data);
          }
          var str = location.pathname;
          if(str.indexOf('comenzi.php') >= 0){
            window.top.location.href = 'comenzi.php';  
          }else if(str.indexOf('comenziAnulate.php') >= 0){
            window.top.location.href = 'comenziAnulate.php';              
          }else if(str.indexOf('productie.php') >= 0){
            window.top.location.href = 'productie.php';              
          };
        }
      });
      break;

    case 'updateComandaAsteptare': 
      var NumeComanda   = $('#mcaNume').val();
      var Anulata;
      var IDLivrare =     $('#mcaIDLivrare').val();      
      var Observatie    = $('#mcaObservatie').val();
      if (document.getElementById('mcaAnulata').checked){ Anulata = 1;
      }else{Anulata = 0;};
      var StergeFactura;
      if (document.getElementById('mcaStergeFactura').checked){ StergeFactura = 1;
      }else{StergeFactura = 0;};      
      
      $.ajax({
        type: 'POST',
        url: 'operatiiBD.php?pg='+updateType,
        data:   'ID='+ID+ 
                '&NumeComanda='+NumeComanda+
                '&IDLivrare='+IDLivrare+
                '&Observatie='+Observatie+
                '&StergeFactura='+StergeFactura+
                '&Anulata='+Anulata,
        success: function(data){ 
          if (String(data).length > 4){
            alert(data);
          }
          window.top.location.href = 'asteptare.php';            
        }
      });
      break;

      case 'updateDealer': 
      var Reprezentant  = $('#Reprezentant' + ID).val();
      var CodPartener       = $('#CodPartener'      + ID).val();
      var Activ;
      if (document.getElementById('mdActiv' + ID).checked){ Activ = 1;
      }else{Activ = 0;};      
      var TelFix        = $('#TelFix'           + ID).val();
      var TelMobil      = $('#TelMobil'         + ID).val();
      var email         = $('#email'            + ID).val();     
      var CUI           = $('#CUI'              + ID).val();     
      var Banca         = $('#Banca'            + ID).val();     
      var Cont          = $('#Cont'             + ID).val();     
      var CNP           = $('#CNP'              + ID).val();     
      var CI            = $('#CI'               + ID).val();     
      var Adresa        = $('#Adresa'           + ID).val();  
      var IDLivrare     = $('#IDLivrare'      + ID).val();  
      var IDResponsabil = $('#IDResponsabil'  + ID).val();  
      //alert(IDLivrare);
      var RC            = $('#RC'           + ID).val();     

      $.ajax({
        type: 'POST',
        url: 'operatiiBD.php?pg='+updateType,
        data:   'ID='+ID+ 
                '&Reprezentant='+Reprezentant+
                '&CodPartener='+CodPartener+
                '&Activ='+Activ+
                '&TelFix='+TelFix+
                '&TelMobil='+TelMobil+
                '&email='+email+ 
                '&CUI='+CUI+ 
                '&Banca='+Banca+ 
                '&Cont='+Cont+ 
                '&CNP='+CNP+ 
                '&CI='+CI+
                '&Adresa='+Adresa+
                '&IDLivrare='+IDLivrare+
                '&IDResponsabil='+IDResponsabil+
                '&RC='+RC,
        success: function(data){
          if (String(data).length > 4){
            alert(data);
          }
          window.top.location.href = 'dealeri.php';            
        }
      });
      break;

      case 'updatePF': 
      var Activ;
      if (document.getElementById('mdActiv' + ID).checked){ Activ = 1;
      }else{Activ = 0;};      
      var TelMobil      = $('#TelMobil'         + ID).val();
      var email         = $('#email'            + ID).val();     
      var CUI           = $('#CUI'              + ID).val();     
      var Banca         = $('#Banca'            + ID).val();     
      var Cont          = $('#Cont'             + ID).val();     
      var CNP           = $('#CNP'              + ID).val();     
      var CI            = $('#CI'               + ID).val();     
      var Adresa        = $('#Adresa'           + ID).val();  
      var IDLivrare     = $('#IDLivrare'      + ID).val();  
      var IDResponsabil = $('#IDResponsabil'  + ID).val();  
      //alert(IDLivrare);
      var RC            = $('#RC'           + ID).val();     

      $.ajax({
        type: 'POST',
        url: 'operatiiBD.php?pg='+updateType,
        data:   'ID='+ID+ 
                '&Activ='+Activ+
                '&TelMobil='+TelMobil+
                '&email='+email+ 
                '&CUI='+CUI+ 
                '&Banca='+Banca+ 
                '&Cont='+Cont+ 
                '&CNP='+CNP+ 
                '&CI='+CI+
                '&Adresa='+Adresa+
                '&IDLivrare='+IDLivrare+
                '&IDResponsabil='+IDResponsabil+
                '&RC='+RC,
        success: function(data){
          if (String(data).length > 4){
            alert(data);
          }
          window.top.location.href = 'persoanefizice.php';            
        }
      });
      break;

    case 'updateUser': 
      var Parola      = $('#Parola'      + ID).val();
      var Email      = $('#Email'      + ID).val();
      var Telefon      = $('#Telefon'      + ID).val();
      var Activ;
      if (document.getElementById('Activ' + ID).checked){ Activ = 1;
      }else{Activ = 0;};
      
      // stadiu lucrari
      //  1 DataLivrare     
      //  2 DatPTam
      //  3 DatPUmp
      //  4 DatPAcc
      //  5 TermTam
      //  6 TermUmp
      //  7 TermAcc
      //  8 OKFin
      //  9 Facturat
      // 10 Livrat
      // 11 Aproba comenzi asteptare
      // 12 Anuleaza comenzi asteptare
      // 13 Anuleaza comenzi
      var DataLivrare, DatPTam, DatPUmp, DatPAcc, DatPAcc, TermTam, TermUmp, TermAcc, OkFin, Facturat, Livrat;

      if (document.getElementById('DataLivrare' + ID).checked){ DataLivrare = 1;
      }else{DataLivrare = 0;};      
      if (document.getElementById('DatPTam' + ID).checked){ DatPTam = 1;
      }else{DatPTam = 0;};      
      if (document.getElementById('DatPUmp' + ID).checked){ DatPUmp = 1;
      }else{DatPUmp = 0;};      
      if (document.getElementById('DatPAcc' + ID).checked){ DatPAcc = 1;
      }else{DatPAcc = 0;};      
      if (document.getElementById('TermTam' + ID).checked){ TermTam = 1;
      }else{TermTam = 0;};      
      if (document.getElementById('TermUmp' + ID).checked){ TermUmp = 1;
      }else{TermUmp = 0;};      
      if (document.getElementById('TermAcc' + ID).checked){ TermAcc = 1;
      }else{TermAcc = 0;};      
      if (document.getElementById('OkFin' + ID).checked){ OkFin = 1;
      }else{OkFin = 0;};      
      if (document.getElementById('Facturat' + ID).checked){ Facturat = 1;
      }else{Facturat = 0;};      
      if (document.getElementById('Livrat' + ID).checked){ Livrat = 1;
      }else{Livrat = 0;}; 
      if (document.getElementById('AprobaComenziAsteptare' + ID).checked){ AprobaComenziAsteptare = 1;
      }else{AprobaComenziAsteptare = 0;}; 
      if (document.getElementById('AnuleazaComenziAsteptare' + ID).checked){ AnuleazaComenziAsteptare = 1;
      }else{AnuleazaComenziAsteptare = 0;}; 
      if (document.getElementById('AnuleazaComenzi' + ID).checked){ AnuleazaComenzi = 1;
      }else{AnuleazaComenzi = 0;}; 
      
      var Drepturi = '8' + DataLivrare + DatPTam + DatPUmp + DatPAcc;
          Drepturi = Drepturi + TermTam + TermUmp + TermAcc + OkFin + Facturat + Livrat;
          Drepturi = Drepturi + AprobaComenziAsteptare + AnuleazaComenziAsteptare + AnuleazaComenzi;
      // meniuri      
      //  1 VedeComenzi  
      //  2 ComandaNoua  
      //  3 ModificaComanda  
      //  4 TiparesteContract  
      //  5 ComandaNouaPentruDealeri  
      //  6 VedeUtilizatori  
      //  7 AdaugaUtilizatori  
      //  8 ModificaUtilizatori  
      //  9 VedeDealeri  
      // 10 AdaugaDealeri  
      // 11 ModificaDealeri  
      // 12 VedeZoneLivrare  
      // 13 AdaugaZoneLivrare  
      // 14 ModificaZoneLivrare  
      // 15 VedeProductie 
      // 16 Vede comenzi asteptare
      // 17 Adauga comenzi asteptare
      // 18 Modifica comenzi asteptare
      // 19 TiparesteDeclaratii
      // 20 IncarcaCFU
      // 21 DescarcaCFU
      // 22 IncarcaFactura
      // 23 DescarcaFactura
      // 24 IncarcaDovadaPlata
      // 25 DescarcaDovadaPlata
      // 26 IncarcaFisierDiverse
      // 27 DescarcaFisierDiverse
      // 28 TiparesteAvizInsotire
      // 29 StergeFactura
      // 30 VedeDoarComenzileProprii
      // 31 VedePF
      // 32 AdaugaPF
      // 33 ModificaPF

      var VedeComenzi, ComandaNoua, ModificaComanda, TiparesteContract, TiparesteDeclaratii, TiparesteAvizInsotire;
      var ComandaNouaPentruDealeri, VedeUtilizatori, AdaugaUtilizatori, ModificaUtilizatori;
      var VedeDealeri, AdaugaDealeri, ModificaDealeri, VedeZoneLivrare;
      var VedePF, AdaugaPF, ModificaPF;
      var AdaugaZoneLivrare, ModificaZoneLivrare, VedeProductie;
      var VedeComenziAsteptare, AdaugaComenziAsteptare, ModificaComenziAsteptare;
      var AprobaComenziAsteptare, IncarcaCFU, DescarcaCFU, IncarcaFactura, DescarcaFactura, StergeFactura;
      var VedeDoarComenzileProprii;
      var IncarcaDovadaPlata, DescarcaDovadaPlata, IncarcaFisierDiverse, DescarcaFisierDiverse;

      if (document.getElementById('VedeComenzi' + ID).checked){ VedeComenzi = 1;
      }else{VedeComenzi = 0;}; 
      if (document.getElementById('ComandaNoua' + ID).checked){ ComandaNoua = 1;
      }else{ComandaNoua = 0;}; 
      if (document.getElementById('ModificaComanda' + ID).checked){ ModificaComanda = 1;
      }else{ModificaComanda = 0;}; 
      if (document.getElementById('TiparesteContract' + ID).checked){ TiparesteContract = 1;
      }else{TiparesteContract = 0;}; 
      if (document.getElementById('ComandaNouaPentruDealeri' + ID).checked){ ComandaNouaPentruDealeri = 1;
      }else{ComandaNouaPentruDealeri = 0;}; 
      if (document.getElementById('VedeUtilizatori' + ID).checked){ VedeUtilizatori = 1;
      }else{VedeUtilizatori = 0;}; 
      if (document.getElementById('AdaugaUtilizatori' + ID).checked){ AdaugaUtilizatori = 1;
      }else{AdaugaUtilizatori = 0;}; 
      if (document.getElementById('ModificaUtilizatori' + ID).checked){ ModificaUtilizatori = 1;
      }else{ModificaUtilizatori = 0;}; 
      if (document.getElementById('VedeDealeri' + ID).checked){ VedeDealeri = 1;
      }else{VedeDealeri = 0;}; 
      if (document.getElementById('AdaugaDealeri' + ID).checked){ AdaugaDealeri = 1;
      }else{AdaugaDealeri = 0;}; 
      if (document.getElementById('ModificaDealeri' + ID).checked){ ModificaDealeri = 1;
      }else{ModificaDealeri = 0;}; 
      if (document.getElementById('VedePF' + ID).checked){ VedePF = 1;
      }else{VedePF = 0;}; 
      if (document.getElementById('AdaugaPF' + ID).checked){ AdaugaPF = 1;
      }else{AdaugaPF = 0;}; 
      if (document.getElementById('ModificaPF' + ID).checked){ ModificaPF = 1;
      }else{ModificaPF = 0;}; 
      if (document.getElementById('VedeZoneLivrare' + ID).checked){ VedeZoneLivrare = 1;
      }else{VedeZoneLivrare = 0;}; 
      if (document.getElementById('AdaugaZoneLivrare' + ID).checked){ AdaugaZoneLivrare = 1;
      }else{AdaugaZoneLivrare = 0;}; 
      if (document.getElementById('ModificaZoneLivrare' + ID).checked){ ModificaZoneLivrare = 1;
      }else{ModificaZoneLivrare = 0;}; 
      if (document.getElementById('VedeProductie' + ID).checked){ VedeProductie = 1;
      }else{VedeProductie = 0;}; 
      if (document.getElementById('VedeComenziAsteptare' + ID).checked){ VedeComenziAsteptare = 1;
      }else{VedeComenziAsteptare = 0;}; 
      if (document.getElementById('AdaugaComenziAsteptare' + ID).checked){ AdaugaComenziAsteptare = 1;
      }else{AdaugaComenziAsteptare = 0;}; 
      if (document.getElementById('ModificaComenziAsteptare' + ID).checked){ ModificaComenziAsteptare = 1;
      }else{ModificaComenziAsteptare = 0;}; 
      if (document.getElementById('TiparesteDeclaratii' + ID).checked){ TiparesteDeclaratii = 1;
      }else{TiparesteDeclaratii = 0;}; 
      if (document.getElementById('IncarcaCFU' + ID).checked){ IncarcaCFU = 1;
      }else{IncarcaCFU = 0;}; 
      if (document.getElementById('DescarcaCFU' + ID).checked){ DescarcaCFU = 1;
      }else{DescarcaCFU = 0;}; 
      if (document.getElementById('IncarcaFactura' + ID).checked){ IncarcaFactura = 1;
      }else{IncarcaFactura = 0;}; 
      if (document.getElementById('DescarcaFactura' + ID).checked){ DescarcaFactura = 1;
      }else{DescarcaFactura = 0;}; 
      if (document.getElementById('IncarcaDovadaPlata' + ID).checked){ IncarcaDovadaPlata = 1;
      }else{IncarcaDovadaPlata = 0;}; 
      if (document.getElementById('DescarcaDovadaPlata' + ID).checked){ DescarcaDovadaPlata = 1;
      }else{DescarcaDovadaPlata = 0;}; 
      if (document.getElementById('IncarcaFisierDiverse' + ID).checked){ IncarcaFisierDiverse = 1;
      }else{IncarcaFisierDiverse = 0;}; 
      if (document.getElementById('DescarcaFisierDiverse' + ID).checked){ DescarcaFisierDiverse = 1;
      }else{DescarcaFisierDiverse = 0;}; 
      if (document.getElementById('TiparesteAvizInsotire' + ID).checked){ TiparesteAvizInsotire = 1;
      }else{TiparesteAvizInsotire = 0;}; 
      if (document.getElementById('StergeFactura' + ID).checked){ StergeFactura = 1;
      }else{StergeFactura = 0;}; 
      if (document.getElementById('VedeDoarComenzileProprii' + ID).checked){ VedeDoarComenzileProprii = 1;
      }else{VedeDoarComenzileProprii = 0;}; 

      
      var Meniuri = '8' + VedeComenzi + ComandaNoua + ModificaComanda;
          Meniuri = Meniuri + TiparesteContract + ComandaNouaPentruDealeri + VedeUtilizatori;
          Meniuri = Meniuri + AdaugaUtilizatori + ModificaUtilizatori;
          Meniuri = Meniuri + VedeDealeri + AdaugaDealeri + ModificaDealeri;
          Meniuri = Meniuri + VedePF + AdaugaPF + ModificaPF;
          Meniuri = Meniuri + VedeZoneLivrare + AdaugaZoneLivrare + ModificaZoneLivrare;
          Meniuri = Meniuri + VedeProductie + VedeComenziAsteptare + AdaugaComenziAsteptare;
          Meniuri = Meniuri + ModificaComenziAsteptare + TiparesteDeclaratii;
          Meniuri = Meniuri + IncarcaCFU + DescarcaCFU + IncarcaFactura + DescarcaFactura;
          Meniuri = Meniuri + IncarcaDovadaPlata + DescarcaDovadaPlata + IncarcaFisierDiverse + DescarcaFisierDiverse;
          Meniuri = Meniuri + TiparesteAvizInsotire + StergeFactura + VedeDoarComenzileProprii;

      $.ajax({
        type: 'POST',
        url: 'operatiiBD.php?pg='+updateType,
        data:   'ID='           +ID+ 
                '&Parola='      + Parola +
                '&Email='      + Email +
                '&Telefon='      + Telefon +
                '&Activ='       + Activ +
                '&Drepturi='    + Drepturi + 
                '&Meniuri='     + Meniuri,
        success: function(data){
          if (String(data).length > 6){
            alert(data);
          }
          window.top.location.href = 'useri.php';
        }
      });
      break;
      
    case 'adaugaComanda': 
      var ID = $('#Client').val();
      var NumeCl = jQuery.trim($('#NumeCl').val());
      var AdresaCl = jQuery.trim($('#AdresaCl').val());
      var TelFixCl = jQuery.trim($('#TelFixCl').val());
      var TelMobilCl = $('#TelMobilCl').val();
      var CnpCl = $('#CnpCl').val();
      var CiCl = $('#CiCl').val();
      var ReprezCl = $('#ReprezCl').val();
      var CuiCl = $('#CuiCl').val();
      var RcCl = $('#RcCl').val();
      var emailCl = $('#e-mailCl').val();
      var idCA = $('#idCA').val();
      var Nume = jQuery.trim($('#Nume').val()); 
      var NrContract = jQuery.trim($('#NrContract').val());
      var Valoare = $('#Valoare').val();
      var Incasat = $('#Incasat').val();
      var DataLivrare = $('#DataLivrare').val();
      var AdresaLivrare = $('#AdresaLivrare').val();
      var IDTraseuLivrare = $('#IDTraseuLivrare').val();
      var Suprafata = $('#Suprafata').val();
      var Greutate = $('#Greutate').val(); 
      var Ferestre = $('#Ferestre').val();
      var Usi = $('#Usi').val();
      var Descriere = $('#Descriere').val();
      var Observatii = $('#Observatii').val();
      var CuMontaj = $('input[name=Montaj]:checked').val();     
      var Fisier = document.getElementById('uploadFileCo');
      var FaraCFU;
      if(document.getElementById('FaraCFUCo').checked){
        FaraCFU = 1;
      }else{
        FaraCFU = 0;
      };
      //validare corectitudine campuri
      if (NumeCl == '' || NumeCl == null){
        ShowInfo('Alert!', 'Introduceti numele clientului!');      
      }else if (AdresaCl == '' || AdresaCl == null){
        ShowInfo('Alert!', 'Introduceti adresa client!');
      }else if (TelFixCl == '' || TelFixCl == null){
        ShowInfo('Alert!', 'Introduceti telefon client!');
      }else if (Nume == '' || Nume == null){
        ShowInfo('Alert!', 'Introduceti numele lucrarii!');
      }else if (NrContract == '' || NrContract == null){
        ShowInfo('Alert!', 'Introduceti numar contract!');
      }else if (Valoare == '' || Valoare == null){
        ShowInfo('Alert!', 'Introduceti valoarea lucrarii!');
      }else if (Incasat == '' || Incasat == null){
        ShowInfo('Alert!', 'Introduceti avansul sau 0!');
      }else if (DataLivrare == '' || DataLivrare == null){
        ShowInfo('Alert!', 'Alegeti data livrare!');
//      }else if (Suprafata == '' || Suprafata == null){
//        ShowInfo('Alert!', 'Introduceti suprafata lucrarii sau 0 daca nu are!');
//      }else if (Greutate == '' || Greutate == null){
//        ShowInfo('Alert!', 'Introduceti greutatea lucrarii sau 0 daca nu are!');
      }else if (Ferestre == '' || Ferestre == null){
        ShowInfo('Alert!', 'Introduceti numarul de ferestre sau 0 daca nu are!');
      }else if (Usi == '' || Usi == null){
        ShowInfo('Alert!', 'Introduceti numarul de usi sau 0 daca nu are!');
//      }else if((!isNumber(Valoare) || !isNumber(Suprafata) || !isNumber(Greutate) || !isNumber(Ferestre) || !isNumber(Usi))){
//        ShowInfo('Alert!', 'Introduceti numere in campurile numerice!');
      }else if (FaraCFU == 0 && Fisier.files.length == 0){
        ShowInfo('Alert!', 'Alegeti un fisier sau confirmati ca e fara CFU!');
      }else if(FaraCFU == 0 && Fisier.files.length > 0 && Fisier.files[0].size >= maxFSize){
        ShowInfo('Alert!', 'Fisierul poate avea maxim ' + maxFSize/1024 + 'Kb!');
      }else{ 
        var dateCo = new FormData();
        dateCo.append('ID', ID);
        dateCo.append('NumeCl', NumeCl);
        dateCo.append('AdresaCl', AdresaCl);
        dateCo.append('TelFixCl', TelFixCl);
        dateCo.append('TelMobilCl', TelMobilCl);
        dateCo.append('CnpCl', CnpCl);
        dateCo.append('CiCl', CiCl);
        dateCo.append('ReprezCl', ReprezCl);
        dateCo.append('CuiCl', CuiCl);
        dateCo.append('RcCl', RcCl);
        dateCo.append('emailCl', emailCl);
        dateCo.append('idCA', idCA);
        dateCo.append('Nume', Nume);
        dateCo.append('NrContract', NrContract);
        dateCo.append('Valoare', Valoare);
        dateCo.append('Incasat', Incasat);
        dateCo.append('DataLivrare', DataLivrare);
        dateCo.append('AdresaLivrare', AdresaLivrare);
        dateCo.append('IDTraseuLivrare', IDTraseuLivrare);
        dateCo.append('Suprafata', Suprafata);
        dateCo.append('Greutate', Greutate);
        dateCo.append('Ferestre', Ferestre);
        dateCo.append('Usi', Usi);
        dateCo.append('Descriere', Descriere);
        dateCo.append('Observatii', Observatii);
        dateCo.append('CuMontaj', CuMontaj);
        dateCo.append('FaraCFU', FaraCFU);
        jQuery.each(jQuery('#uploadFileCo')[0].files, function(i, file) {
          dateCo.append('file-'+i, file);
        });   
//alert(dateCo);        
        $.ajax({
          type: 'POST',
          url: 'operatiiBD.php?pg=' + updateType,
          data:   dateCo,
          cache: false,
          contentType: false,
          processData: false,          
          success: function(data){
            AfterPost(data);
            document.getElementById('js-form-cn1').reset();
            document.getElementById('js-form-cn2').reset();
          }
        });
      };
      break;      

    case 'aprobaComanda': 
      var ID = $('#clientCA').val();
      var idCA = $('#idCA').val();
      var Nume = $('#acaNume').val();
      var Valoare = $('#acaValoare').val();
      var Incasat = $('#acaIncasat').val();
      var DataLivrare = $('#acaDataLivrare').val();
      var AdresaLivrare = $('#acaAdresaLivrare').val();
      var IDTraseuLivrare = $('#acaIDTraseuLivrare').val();
      //var Suprafata = $('#acaSuprafata').val();
      var Suprafata = 0;
      //var Greutate = $('#acaGreutate').val();
      var Greutate = 0;
      var Ferestre = $('#acaFerestre').val();
      var Usi = $('#acaUsi').val();
      var Descriere = $('#acaDescriere').val();
      var Observatii = $('#acaObservatii').val();
      var CuMontaj = $('input[name=acaMontaj]:checked').val();     
//alert(Suprafata);
      //validare corectitudine campuri
      if (Nume == '' || Nume == null){
        ShowInfo('Alert!', 'Introduceti numele lucrarii!');      
      }else if (Valoare == '' || Valoare == null){
        ShowInfo('Alert!', 'Introduceti valoarea lucrarii!');
      }else if (Incasat == '' || Incasat == null){
        ShowInfo('Alert!', 'Introduceti avansul incasat sau 0!');
      }else if (DataLivrare == '' || DataLivrare == null){
        ShowInfo('Alert!', 'Alegeti data livrare!');
//      }else if (Suprafata == '' || Suprafata == null){
//        ShowInfo('Alert!', 'Introduceti suprafata lucrarii sau 0 daca nu are!');
//      }else if (Greutate == '' || Greutate == null){
//        ShowInfo('Alert!', 'Introduceti greutatea lucrarii sau 0 daca nu are!');
      }else if (Ferestre == '' || Ferestre == null){
        ShowInfo('Alert!', 'Introduceti numarul de ferestre sau 0 daca nu are!');
      }else if (Usi == '' || Usi == null){
        ShowInfo('Alert!', 'Introduceti numarul de usi sau 0 daca nu are!');        
      }else{ //alert(idCA);
        $.ajax({
          type: 'POST',
          url: 'operatiiBD.php?pg=' + updateType,
          data:   'ID='             + ID +
                  '&idCA='          + idCA +
                  '&Nume='          + Nume +
                  '&Valoare='       + Valoare +
                  '&Incasat='       + Incasat +
                  '&DataLivrare='   + DataLivrare +
                  '&AdresaLivrare=' + AdresaLivrare +
                  '&IDTraseuLivrare=' + IDTraseuLivrare +
                  '&Suprafata='     + Suprafata +
                  '&Greutate='      + Greutate +
                  '&Ferestre='      + Ferestre +
                  '&Usi='           + Usi +
                  '&Descriere='     + Descriere +
                  '&Observatii='    + Observatii +
                  '&CuMontaj='      + CuMontaj,
          success: function(data){
            if (String(data).length > 4){
              alert(data);
            }
            window.top.location.href = 'asteptare.php';            
          }
        });
      };
      break;      

      case 'adaugaComandaAsteptare':      
      var NumeCoAs = jQuery.trim($('#NumeCoAs').val());
      var IDClient = $('#Client').val();
      var IDDealer = $('#Dealer').val();
      var IDLivrare = $('#IDTraseuLivrareCoAs').val();
      var ObservatiiCoAs = $('#ObservatiiCoAs').val();
      var Fisier = document.getElementById('uploadFileCoAs');
      var FaraCFU = document.getElementById('FaraCFUCoAs').checked ? 1 : 0;
  
      // Validare corectitudine campuri
      if (NumeCoAs == '' || NumeCoAs == null){
          ShowInfo('Alert!', 'Introduceti numele comenzii!');      
      } else if (IDLivrare == '0' || IDLivrare == null){
          ShowInfo('Alert!', 'Alegeti orasul de livrare!');
      } else if (FaraCFU == 0 && Fisier.files.length == 0){
          ShowInfo('Alert!', 'Alegeti un fisier sau confirmati ca e fara CFU!');
      } else if(FaraCFU == 0 && Fisier.files.length > 0 && Fisier.files[0].size >= maxFSize){
          ShowInfo('Alert!', 'Fisierul poate avea maxim ' + maxFSize/1024 + 'Kb!');
      } else {
          var dateCoAs = new FormData();
          dateCoAs.append('NumeCoAs', NumeCoAs);
          dateCoAs.append('IDClient', IDClient);
          dateCoAs.append('IDDealer', IDDealer);
          dateCoAs.append('IDLivrare', IDLivrare);
          dateCoAs.append('ObservatiiCoAs', ObservatiiCoAs);
          dateCoAs.append('FaraCFU', FaraCFU);
          
          // Adaugarea fisierului in formular (daca exista)
          jQuery.each(jQuery('#uploadFileCoAs')[0].files, function(i, file) {
              dateCoAs.append('file-'+i, file);
          });
  
          // Trimiterea datelor catre server prin AJAX
          $.ajax({
              type: 'POST',
              url: 'operatiiBD.php?pg=' + updateType,
              data: dateCoAs,
              cache: false,
              contentType: false,
              processData: false,          
              success: function(data){
                  AfterPost(data);
                  document.getElementById('js-form-can1').reset();
              }
          });
      }
      break;
  
      case 'adaugaDealer': 
      var NumePartener          = $('#NumePartener'       ).val();
      var Reprezentant  = $('#Reprezentant'     ).val();
      var CodPartener       = $('#CodPartener'          ).val();
      var TelMobil      = $('#TelMobil'         ).val();
      var email         = $('#email'            ).val();     
      var CUI           = $('#CUI'              ).val();     
      var Banca         = $('#Banca'            ).val();     
      var Cont          = $('#Cont'             ).val();     
      var CNP           = $('#CNP'              ).val();      
      var Adresa        = $('#Adresa'           ).val();     
      var IDLivrare     = $('#IDLivrare' ).val();     
      var IDResponsabil = $('#IDResponsabil'   ).val();   
      var RC            = $('#RC'               ).val();  
      //validare campuri obligatorii
      if (NumePartener == '' || NumePartener == null){
          ShowInfo('Alert!', 'Completati nume partener!');
      }else if (IDResponsabil == 0){
          ShowInfo('Alert!', 'Alegeti responsabil!');
      }else{
        $.ajax({
          type: 'POST',
          url: 'operatiiBD.php?pg=' + updateType,
          data:   'NumePartener='           + NumePartener +
                  '&Reprezentant='  + Reprezentant +
                  '&CodPartener='       + CodPartener +
                  '&TelMobil='      + TelMobil +
                  '&email='         + email + 
                  '&CUI='           + CUI + 
                  '&Banca='         + Banca + 
                  '&Cont='          + Cont + 
                  '&CNP='           + CNP + 
                  '&Adresa='        + Adresa +
                  '&IDLivrare='     + IDLivrare +
                  '&IDResponsabil=' + IDResponsabil +
                  '&RC='            + RC,
          success: function(data){
            AfterPost(data);
            document.getElementById('js-form-d').reset();
          }
        });
      };
      break;

      case 'adaugaPF': 
      var NumeClient        = $('#NumeClient'       ).val();
      var TelMobilPF      = $('#TelMobilPF'         ).val();
      var emailPF        = $('#emailPF'            ).val();     
      var CUIPF         = $('#CUIPF'              ).val();     
      var BancaPF         = $('#BancaPF'            ).val();     
      var ContPF          = $('#ContPF'             ).val();     
      var CNPPF           = $('#CNPPF'              ).val();      
      var AdresaPF        = $('#AdresaPF'           ).val();     
      var IDLivrarePF     = $('#IDLivrarePF' ).val();     
      var IDResponsabilPF = $('#IDResponsabilPF'   ).val();   
      var RCPF            = $('#RCPF'               ).val();  
      //validare campuri obligatorii
      if (NumeClient == '' || NumeClient == null){
          ShowInfo('Alert!', 'Completati nume partener!');
      }else{
        $.ajax({
          type: 'POST',
          url: 'operatiiBD.php?pg=' + updateType,
          data:   'NumeClient='           + NumeClient +
                  '&TelMobilPF='      + TelMobilPF +
                  '&emailPF='         + emailPF + 
                  '&CUIPF='           + CUIPF + 
                  '&BancaPF='         + BancaPF + 
                  '&ContPF='          + ContPF + 
                  '&CNPPF='           + CNPPF + 
                  '&AdresaPF='        + AdresaPF +
                  '&IDLivrarePF='     + IDLivrarePF +
                  '&IDResponsabilPF=' + IDResponsabilPF +
                  '&RCPF='            + RCPF,
          success: function(data){
            AfterPost(data);
            document.getElementById('js-form-d').reset();
          }
        });
      };
      break;
    
      case 'adaugaZonaLivrare': 
      var NumeTara = $('#NumeTara').val();
      var NumeZonaLivrare = $('#NumeZonaLivrare').val();
      var Descriere = $('#Descriere').val();
      var Distanta = $('#Distanta').val();
  
      // Validare corectitudine campuri
      if (isNaN(Distanta) || Distanta < 0) {
          ShowInfo('Alert!', 'Introduceti o distanta valida!');
      // Validare campuri obligatorii
      } else if (NumeZonaLivrare.trim() === '') {
          ShowInfo('Alert!', 'Completati denumire oraș!');
      } else {
          $.ajax({
              type: 'POST',
              url: 'operatiiBD.php?pg=' + updateType,
              data: {
                  'action': 'adaugaZonaLivrare',
                  'NumeTara': NumeTara,
                  'NumeZonaLivrare': NumeZonaLivrare,
                  'Descriere': Descriere,
                  'Distanta': Distanta
              },
              success: function(data) {
                  AfterPost(data);
                  $('#js-form-zl')[0].reset(); // Utilizăm jQuery pentru a reseta formularul
              }
          });
      }
      break;
    
      case 'adaugaUser':       
      var Nume   = $('#NumeUser').val();
      var Firma  = $('#FirmaUser').val();
      var Parola = $('#Parola').val();
      var Activ;
      if (document.getElementById('Activ').checked){ Activ = 1;}
      else{Activ = 0;};
      var Email = $('#Email').val();
      var Telefon = $('#Telefon').val();
      
      // stadiu lucrari
      //  1 DataLivrare     
      //  2 DatPTam
      //  3 DatPUmp
      //  4 DatPAcc
      //  5 TermTam
      //  6 TermUmp
      //  7 TermAcc
      //  8 OKFin
      //  9 Facturat
      // 10 Livrat
      // 11 Aproba comenzi asteptare
      // 12 Anuleaza comenzi asteptare
      // 13 Anuleaza comenzi
      var DataLivrare, DatPTam, DatPUmp, DatPAcc, DatPAcc, TermTam, TermUmp, TermAcc, OkFin, Facturat, Livrat;
      var AprobaComenziAsteptare, AnuleazaComenziAsteptare; 
      if (document.getElementById('ModDataLivrare').checked){ DataLivrare = 1;}
      else{DataLivrare = 0;};      
      if (document.getElementById('DatPTam').checked){ DatPTam = 1;}
      else{DatPTam = 0;}; 
      if (document.getElementById('DatPUmp').checked){ DatPUmp = 1;}
      else{DatPUmp = 0;};      
      if (document.getElementById('DatPAcc').checked){ DatPAcc = 1;}
      else{DatPAcc = 0;};      
      if (document.getElementById('TermTam').checked){ TermTam = 1;}
      else{TermTam = 0;};      
      if (document.getElementById('TermUmp').checked){ TermUmp = 1;}
      else{TermUmp = 0;};      
      if (document.getElementById('TermAcc').checked){ TermAcc = 1;}
      else{TermAcc = 0;};      
      if (document.getElementById('OkFin').checked){ OkFin = 1;}
      else{OkFin = 0;};      
      if (document.getElementById('Facturat').checked){ Facturat = 1;}
      else{Facturat = 0;};      
      if (document.getElementById('Livrat').checked){ Livrat = 1;}
      else{Livrat = 0;};               
      if (document.getElementById('AprobaComenziAsteptare').checked){ AprobaComenziAsteptare = 1;
      }else{AprobaComenziAsteptare = 0;};              
      if (document.getElementById('AnuleazaComenziAsteptare').checked){ AnuleazaComenziAsteptare = 1;
      }else{AnuleazaComenziAsteptare = 0;};              
      if (document.getElementById('AnuleazaComenzi').checked){ AnuleazaComenzi = 1;
      }else{AnuleazaComenzi = 0;};              
      
      var Drepturi = '8' + DataLivrare + DatPTam + DatPUmp + DatPAcc;
          Drepturi = Drepturi + TermTam + TermUmp + TermAcc + OkFin + Facturat + Livrat;
          Drepturi = Drepturi + AprobaComenziAsteptare + AnuleazaComenziAsteptare;
          Drepturi = Drepturi + AnuleazaComenzi;
      // meniuri      
      //  1 VedeComenzi  
      //  2 ComandaNoua  
      //  3 ModificaComanda  
      //  4 TiparesteContract  
      //  5 ComandaNouaPentruDealeri  
      //  6 VedeUtilizatori  
      //  7 AdaugaUtilizatori  
      //  8 ModificaUtilizatori  
      //  9 VedeDealeri  
      // 10 AdaugaDealeri  
      // 11 ModificaDealeri  
      // 12 VedeZoneLivrare  
      // 13 AdaugaZoneLivrare  
      // 14 ModificaZoneLivrare  
      // 15 VedeProductie  
      // 16 Vede comenzi asteptare
      // 17 Adauga comenzi asteptare
      // 18 Modifica comenzi asteptare
      // 19 TiparesteDeclaratii
      // 20 IncarcaCFU
      // 21 DescarcaCFU
      // 22 IncarcaFactura
      // 23 DescarcaFactura
      // 24 IncarcaDovadaPlata
      // 25 DescarcaDovadaPlata
      // 26 IncarcaFisierDiverse
      // 27 DescarcaFisierDiverse 
      // 28 TiparesteAvizInsotire
      // 29 StergeFactura
      // 29 VedeDoarComenzileProprii
      // 30 VedePF
      // 31 AdaugaPF
      // 32 ModificaPF

      var VedeComenzi, ComandaNoua, ModificaComanda, TiparesteContract, TiparesteDeclaratii;
      var ComandaNouaPentruDealeri, VedeUtilizatori, AdaugaUtilizatori, ModificaUtilizatori;
      var VedeDealeri, AdaugaDealeri, ModificaDealeri, VedeZoneLivrare;
      var VedePF, AdaugaPF, ModificaPF;
      var AdaugaZoneLivrare, ModificaZoneLivrare, VedeProductie;
      var VedeComenziAsteptare, AdaugaComenziAsteptare, ModificaComenziAsteptare;
      var AprobaComenziAsteptare, IncarcaCFU, DescarcaCFU, IncarcaFactura, DescarcaFactura, StergeFactura;
      var VedeDoarComenzileProprii;
      var IncarcaDovadaPlata, DescarcaDovadaPlata, IncarcaFisierDiverse, DescarcaFisierDiverse;
      var TiparesteAvizInsotire;

      if (document.getElementById('VedeComenzi').checked){ VedeComenzi = 1;}
      else{VedeComenzi = 0;}; 
      if (document.getElementById('ComandaNoua').checked){ ComandaNoua = 1;}
      else{ComandaNoua = 0;}; 
      if (document.getElementById('ModificaComanda').checked){ ModificaComanda = 1;}
      else{ModificaComanda = 0;}; 
      if (document.getElementById('TiparesteContract').checked){ TiparesteContract = 1;}
      else{TiparesteContract = 0;}; 
      if (document.getElementById('ComandaNouaPentruDealeri').checked){ ComandaNouaPentruDealeri = 1;}
      else{ComandaNouaPentruDealeri = 0;}; 
      if (document.getElementById('VedeUtilizatori').checked){ VedeUtilizatori = 1;}
      else{VedeUtilizatori = 0;}; 
      if (document.getElementById('AdaugaUtilizatori').checked){ AdaugaUtilizatori = 1;}
      else{AdaugaUtilizatori = 0;}; 
      if (document.getElementById('ModificaUtilizatori').checked){ ModificaUtilizatori = 1;}
      else{ModificaUtilizatori = 0;}; 
      if (document.getElementById('VedeDealeri').checked){ VedeDealeri = 1;}
      else{VedeDealeri = 0;}; 
      if (document.getElementById('AdaugaDealeri').checked){ AdaugaDealeri = 1;}
      else{AdaugaDealeri = 0;}; 
      if (document.getElementById('ModificaDealeri').checked){ ModificaDealeri = 1;}
      else{ModificaDealeri = 0;}; 
      if (document.getElementById('VedePF').checked){ VedePF = 1;}
      else{VedePF = 0;}; 
      if (document.getElementById('AdaugaPF').checked){ AdaugaPF = 1;}
      else{AdaugaPF = 0;}; 
      if (document.getElementById('ModificaPF').checked){ ModificaPF = 1;}
      else{ModificaPF = 0;}; 
      if (document.getElementById('VedeZoneLivrare').checked){ VedeZoneLivrare = 1;}
      else{VedeZoneLivrare = 0;}; 
      if (document.getElementById('AdaugaZoneLivrare').checked){ AdaugaZoneLivrare = 1;}
      else{AdaugaZoneLivrare = 0;}; 
      if (document.getElementById('ModificaZoneLivrare').checked){ ModificaZoneLivrare = 1;}
      else{ModificaZoneLivrare = 0;}; 
      if (document.getElementById('VedeProductie').checked){ VedeProductie = 1;}
      else{VedeProductie = 0;};   
      if (document.getElementById('VedeComenziAsteptare').checked){ VedeComenziAsteptare = 1;
      }else{VedeComenziAsteptare = 0;}; 
      if (document.getElementById('AdaugaComenziAsteptare').checked){ AdaugaComenziAsteptare = 1;
      }else{AdaugaComenziAsteptare = 0;}; 
      if (document.getElementById('ModificaComenziAsteptare').checked){ ModificaComenziAsteptare = 1;
      }else{ModificaComenziAsteptare = 0;}; 
      if (document.getElementById('TiparesteDeclaratii').checked){ TiparesteDeclaratii = 1;
      }else{TiparesteDeclaratii = 0;}; 
      if (document.getElementById('IncarcaCFU').checked){ IncarcaCFU = 1;
      }else{IncarcaCFU = 0;}; 
      if (document.getElementById('DescarcaCFU').checked){ DescarcaCFU = 1;
      }else{DescarcaCFU = 0;}; 
      if (document.getElementById('IncarcaFactura').checked){ IncarcaFactura = 1;
      }else{IncarcaFactura = 0;}; 
      if (document.getElementById('DescarcaFactura').checked){ DescarcaFactura = 1;
      }else{DescarcaFactura = 0;}; 
      if (document.getElementById('IncarcaDovadaPlata').checked){ IncarcaDovadaPlata = 1;
      }else{IncarcaDovadaPlata = 0;}; 
      if (document.getElementById('DescarcaDovadaPlata').checked){ DescarcaDovadaPlata = 1;
      }else{DescarcaDovadaPlata = 0;}; 
      if (document.getElementById('IncarcaFisierDiverse').checked){ IncarcaFisierDiverse = 1;
      }else{IncarcaFisierDiverse = 0;}; 
      if (document.getElementById('DescarcaFisierDiverse').checked){ DescarcaFisierDiverse = 1;
      }else{DescarcaFisierDiverse = 0;};       
      if (document.getElementById('TiparesteAvizInsotire').checked){ TiparesteAvizInsotire = 1;
      }else{TiparesteAvizInsotire = 0;}; 
      if (document.getElementById('StergeFactura').checked){ StergeFactura = 1;
      }else{StergeFactura = 0;}; 
      if (document.getElementById('VedeDoarComenzileProprii').checked){ VedeDoarComenzileProprii = 1;
      }else{VedeDoarComenzileProprii = 0;}; 
      
      var Meniuri = '8' + VedeComenzi + ComandaNoua + ModificaComanda;
          Meniuri = Meniuri + TiparesteContract + ComandaNouaPentruDealeri + VedeUtilizatori;
          Meniuri = Meniuri + AdaugaUtilizatori + ModificaUtilizatori;
          Meniuri = Meniuri + VedeDealeri + AdaugaDealeri + ModificaDealeri;
          Meniuri = Meniuri + VedePF + AdaugaPF + ModificaPF;
          Meniuri = Meniuri + VedeZoneLivrare + AdaugaZoneLivrare + ModificaZoneLivrare;
          Meniuri = Meniuri + VedeProductie + VedeComenziAsteptare + AdaugaComenziAsteptare;
          Meniuri = Meniuri + ModificaComenziAsteptare + TiparesteDeclaratii;
          Meniuri = Meniuri + IncarcaCFU + DescarcaCFU + IncarcaFactura + DescarcaFactura;
          Meniuri = Meniuri + IncarcaDovadaPlata + DescarcaDovadaPlata + IncarcaFisierDiverse + DescarcaFisierDiverse;
          Meniuri = Meniuri + TiparesteAvizInsotire + StergeFactura + VedeDoarComenzileProprii;
          
      //validare campuri obligatorii
      if (Nume == '' || Nume == null || Firma == '' || Firma == null){
          ShowInfo('Alert!', 'Completati nume si alegeti firma!');
      }else{
        $.ajax({
          type: 'POST',
          url: 'operatiiBD.php?pg=' + updateType,
          data: {  'action': 'adaugaUser',
                  'Nume'         : Nume ,
                  'Parola'      : Parola ,
                  'Firma'       : Firma ,
                  'Activ'       : Activ ,
                  'Email'       : Email ,
                  'Telefon'     : Telefon ,
                  'Drepturi'    : Drepturi, 
                  'Meniuri'     : Meniuri
          },
          success: function(data){
            AfterPost(data);
            document.getElementById('js-form-u').reset();            
          }
        });
      };
      break;

      case 'updateZonaLivrare':
        var Descriere  = $('#Descriere' + ID).val();
        var Distanta       = $('#Distanta'      + ID).val();
        //validare corectitudine campuri
        if (!isNumber(Distanta) || Distanta < 0){
          ShowInfo('Alert!', 'Introduceti o distanta valida!');      
        }else{
          $.ajax({
            type: 'POST',
            url: 'operatiiBD.php?pg='+updateType,
            data:   'ID=' + ID + 
                    '&Descriere=' + Descriere +
                    '&Distanta='      + Distanta,
            success: function(data){AfterPost(data);}
          });
        };
        break;         
    }
  }

function AfterPost(data){
  if (String(data).length > 4){//daca e o eroare din php
    ShowInfo('Alert!', data);
  }else{//daca e success in php
    $('#js-form-zl, #js-form-d, #js-form-u')[0].reset();
    ShowInfo('Succes!', 'Date salvate. Continuati...');
  }
}

function ShowInfo(Tip, Text1){
  $('.js-info1').html(Tip);
  $('.js-info2').html(Text1);
  var s1, s2;
  switch(Tip){
    case 'Alert!': 
      s1 = 'alert-success';
      s2 = 'alert-danger';
    break;
    case 'Succes!': 
      s1 = 'alert-danger';
      s2 = 'alert-success';
    break;
  };
  $('.js-div-info').removeClass(s1).addClass(s2);
  $('.js-div-info').show('fade');
  setTimeout(function(){
    $('.js-div-info').hide('fade');
  }, 5000);    
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function GetStadiuComanda(ID){
  var Std;
  if ($('#mcIn'+ID).is(':checked')){ Std = '1';
  }else{Std = '0';};   
  return Std;
};

//la document ready
$(function(){ 
  //initializare tooltip
  $('[data-toggle="tooltip"]').tooltip({html: true});
  
  //initializare datepicker
  $('#dp input').datepicker({
    format: "dd.mm.yyyy",
    weekStart: 1,
    daysOfWeekHighlighted: "0,6",
    autoclose: true,
    language: "ro"
  });

  //reicarcare pagina la iesire din modale
//  $('#adaugaComanda').on('hidden.bs.modal', function(){
//    var str = location.pathname;
//    if(str.indexOf('comenzi.php') >= 0){
//      window.top.location.href = 'comenzi.php';
//    }else if(str.indexOf('asteptare.php') >= 0){
//      window.top.location.href = 'asteptare.php';
//    }else{
//      window.top.location.href = 'comenzi.php';
//    };
//  });
  $('#adaugaComanda').on('hidden.bs.modal', function(){window.top.location.href = 'comenzi.php';});
  $('#adaugaComandaAsteptare').on('hidden.bs.modal', function(){window.top.location.href = 'asteptare.php';});
  $('#adaugaUser').on('hidden.bs.modal', function(){window.top.location.href = 'useri.php';});
  //$('#modificaUser').on('hidden.bs.modal', function(){window.top.location.href = 'useri.php';});
  $('#adaugaDealer').on('hidden.bs.modal', function(){window.top.location.href = 'dealeri.php';});
  //$('#modificaDealer').on('hidden.bs.modal', function(){window.top.location.href = 'dealeri.php';});
  $('#adaugaZonaLivrare').on('hidden.bs.modal', function(){window.top.location.href = 'zoneLivrare.php';});
  $('.js-modificareZonaLivrare').on('hidden.bs.modal', function(){//ptr. ca aici validam date
    location.reload();
  });
  
  //link-ul de inchidere info din modale
  $('.js-a-close').click(function(){
    $('.js-div-info').hide('fade');
  });  
    
  //header fix la tabele
  $('table').fixMe();
  
  //dezactivare check-box-uri daca se selecteaza dealer la adaugare client
  $('#FirmaUser').change(function(){
    //daca e producator
    if($('#FirmaUser').children('option:first-child, option:last-child').is(':selected')){
      $('input:checkbox').prop('checked', false);
      $('input:checkbox').prop('disabled', false);
    }else{//daca e dealer
      $('input:checkbox:not("#Activ, #VedeComenzi")').prop('checked', false);
      $('#VedeComenzi').prop('checked', true);
      $('#VedeComenziAsteptare').prop('checked', true);
      $('#AdaugaComenziAsteptare').prop('checked', true);
      $('#ModificaComenziAsteptare').prop('checked', true);
      $('input:checkbox:not("#Activ")').prop('disabled', true);
    };
    $('#Activ').prop('checked', true);    
  });

  //ascundere NumarContract la comanda noua daca este ptr. delaer
  $('#Client').change(function(){
    //daca e comanda pentru client direct
    if($('#Client').children('option:first-child').is(':selected')){
      $('#NrContract').attr('disabled', false);
      $('#NrContract').val('');
    }else{//daca e comanda pentru dealer
      $('#NrContract').attr('disabled', true);
      $('#NrContract').val('-');
    };
  });  
  
  //scrierea numelui clientului la nume lucrare
  $("#NumeCl").blur(function(){
    $("#Nume").val($("#NumeCl").val());
  });
  
  //formatare campuri client daca se alege dealer la comanda noua
  $('#Client').change(function(){
    //daca e client direct empty and enable fields
    if($('#Client').children('option:first-child').is(':selected')){
      $('.dateCl').attr('disabled', false);
      $('.dateCl').find('input').val('');
      $('#Nume').val('');
      $('#Nume').attr('disabled', true);      
      $('#cuMontaj').prop('checked', 'checked');
    }else{//daca e dealer disable and complete fields
      $('.dateCl').attr('disabled', true);
      $('#faraMontaj').prop('checked', 'checked');
      $('#Nume').attr('disabled', false);      
      //extrage date dealer de pe server
      ID = $('#Client').val();
      $.ajax({
        type: 'POST',
        url: 'operatiiBD.php?pg=getDateDealer',
        data:   'ID=' + ID,
        success: function(data){
          dd = JSON.parse(data);
          $('#NumeCl').val(dd.Nume);
          $('#AdresaCl').val(dd.Adresa);
          $('#TelFixCl').val(dd.TelFix);
          $('#TelMobilCl').val(dd.TelMobil);
          $('#CnpCl').val(dd.CNP);
          $('#CiCl').val(dd.CI);
          $('#ReprezCl').val(dd.Reprezentant);
          $('#CuiCl').val(dd.CUI);
          $('#RcCl').val(dd.RC);
          $('#mailCl').val(dd.email);
          $('#Nume').val(dd.CodPartener);
          $('#IDTraseuLivrare').val(dd.IDLivrare);
        }
      });      
    };     
  });
  
  //setare oras livrare la comanda asteptare noua
  $('#Dealer').change(function(){   
    //extrage date dealer de pe server
    var ID = $('#Dealer').val();
    $.ajax({
      type: 'POST',
      url: 'operatiiBD.php?pg=getDateDealer',
      data:   'ID=' + ID,
      success: function(data){
        dd = JSON.parse(data);
        $('#IDTraseuLivrareCoAs').val(dd.IDLivrare);
      }
    });          
  });    
}); 



;(function($){
  $.fn.fixMe = function(){
    return this.each(function(){
      var $this = $(this),
        $t_fixed;
      function init(){
        $t_fixed = $this.clone();
        $t_fixed.find("tbody").remove().end().addClass("fixed").insertBefore($this);
        resizeFixed();
      }
      function resizeFixed(){
        $t_fixed.find("th").each(function(index){
          $(this).css("width",$this.find("th").eq(index).outerWidth()+"px");
        });
      }
      function scrollFixed(){
        var offset = $(this).scrollTop(),
        tableOffsetTop = $this.offset().top,
        tableOffsetBottom = tableOffsetTop + $this.height() - $this.find("thead").height();
        if(offset < tableOffsetTop || offset > tableOffsetBottom)
          $t_fixed.hide();
        else if(offset >= tableOffsetTop && offset <= tableOffsetBottom && $t_fixed.is(":hidden"))
          $t_fixed.show();
      }
      $(window).resize(resizeFixed);
      $(window).scroll(scrollFixed);
      init();
    });
  };
})(jQuery);