<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        
        <link href="startbootstrap/bower_components/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="startbootstrap/dist/css/sb-admin-2.css" rel="stylesheet" type="text/css"/>
        <link href="startbootstrap/bower_components/bootstrap-social/bootstrap-social.css" rel="stylesheet" type="text/css"/>
        <link href="startbootstrap/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="dropzone_upload/dropzone.css" rel="stylesheet" type="text/css"/>
        
        
        <script src="startbootstrap/bower_components/jquery/dist/jquery-1.12.3.min.js" type="text/javascript"></script>
        <script src="startbootstrap/bower_components/bootstrap/dist/js/bootstrap.js" type="text/javascript"></script>
        <script src="startbootstrap/Dropzone/dropzone.js" type="text/javascript"></script>
        

        
    </head>
    <body>
        <?php include 'Dropdown_menu/navbar.php'; ?>
        
        <hr>
        <div class="panel-header" >
            <form id="MyDropzone" method="post" action="dropzone_upload/upload.php" class="dropzone" style="display: none;">
            </form>
        </div>
        <div class="panel-body no-print">
            <div id="carica">
                <button class="btn btn-primary start" id="Bt_Carica">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Carica file...</span>
                </button>
                <button type="button" class="btn btn-warning" id="Bt_CancTable"  style="display: none;">
                     <i class="fa fa-trash-o fa-fw"></i>
                     <span>Cancella selezionati</span>
                </button>
            </div>
            <br><hr><br>
            SHA256: 
            <div class="form-group input-group">
                <input type="text" class="form-control" id="sha256"  placeholder="">
                <span class="input-group-addon">@</span>
            </div>
            File: 
            <div class="form-group input-group">
                <input type="text" class="form-control" id="file"  placeholder="">
                <span class="input-group-addon">@</span>
            </div>
            Size: 
            <div class="form-group input-group">
                <input type="text" class="form-control" id="size"  placeholder="">
                <span class="input-group-addon">@</span>
            </div>
            <hr>
            Titolo: 
            <div class="form-group input-group">
                <input type="text" class="form-control" id="titolo"  placeholder="">

            </div>
            Note: 
            <div class="form-group input-group">
                  <textarea class="form-control" rows="3" Columns="50" id="txtComments"></textarea>
                  <span id="spnCharLeft"></span>
            </div>
            <hr>
            <form action="?" method="post" style="display: none;" id="verifica">
                    <!-- other form fields -->

                    <script src="https://authedmine.com/lib/captcha.min.js" async></script>
                    <script>
                            function myCaptchaCallback(token) {
                                    $('#bt_save').show("slow"); 
                                    console.log('Hashes reached. Token is: ' + token);
                            }
                    </script>
                    <div class="coinhive-captcha" 
                            data-hashes="256" 
                            data-key="QnKlvIW4yYMFyyfRWY3pDLhdfJ2qO4Tv"
                            data-whitelabel="false"
                            data-disable-elements="input[type=submit]"
                            data-callback="myCaptchaCallback"
                    >
                            <em>Loading Captcha...<br>
                            If it doesn't load, please disable Adblock!</em>
                    </div>
                    
                    
                    <!-- submit button will be automatically disabled and later enabled
                            again when the captcha is solved -->
                    
            </form>
            <button class="btn btn-success" style="display: none;" type="submit" value="Submit" id="bt_save">
                        Salva i dati
            </button>
        </div>
    </body>
    <?php include "include/footer.php";?>
<script>
    $(document).ready(function() {
        
        $('#bt_save').click(function(){
            console.log('save:'+$('#sha256').val()
                               +'|'
                               +$('#file').val()
                               +'|'
                               +$('#size').val()
                               +'|'
                               +$('#titolo').val()
                               +'|'
                               +$('#txtComments').val()
                );
            $.ajax({url: "ajax/savedata.php",
                    type: "post",
                    data: {
                                sha256 : $('#sha256').val(),
                                file   : $('#file').val(), 
                                size   : $('#size').val(),
                                titolo : $('#titolo').val(),
                                note   : $('#txtComments').val()
                            },
                    success: function(result){
                        var ress = $.parseJSON(result);
                        console.log(ress['NewBlock'] );
                        if (ress['NewBlock'] !== -1){
                           //registrato 
                           console.log("registrato");
                        }else{
                           //già presente aprire la pagina del dettaglio del blocco
                           console.log("doppione");  
                        }
                        $('#bt_save').hide('slow');
                        window.location.href = "blockinfo.php?newblock="+ress['NewBlock']+"&sha256="+sha256.value;
                    }
            });
            
        }); 
        
        
        $('#Bt_Carica').click(function(){
            $('#MyDropzone').show("slow"); 
            $('#Bt_CancTable').show("slow");
        });  
        $('#spnCharLeft').css('display', 'none');
        var maxLimit = 1024;
        $('#txtComments').keyup(function () {
            var lengthCount = this.value.length;              
            if (lengthCount > maxLimit) {
                this.value = this.value.substring(0, maxLimit);
                var charactersLeft = maxLimit - lengthCount + 1;                   
            }
            else {                   
                var charactersLeft = maxLimit - lengthCount;                   
            }
            $('#spnCharLeft').css('display', 'block');
            $('#spnCharLeft').text(charactersLeft + ' caratteri disponibili.');
        });
        
        $('#Bt_CancTable').click( function() {
           $('#MyDropzone').hide("slow");  
           $('#bt_save').hide('slow');
           $('#verifica').hide('slow');
           $('#Bt_CancTable').hide('slow');
           $('#file').val('');
           $('#size').val('');
           $('#sha256').val('');
           $('#titolo').val('');
           $('#txtComments').val('');
           
           $('#Bt_Carica').show("slow");
        });
    });
    
    Dropzone.autoDiscover = false;
    
var uploader = new Dropzone('#MyDropzone', {
    //acceptedFiles: "*.*",
    dictDefaultMessage :'<span class="bigger-150 bolder"><i class="ace-icon fa fa-caret-right red"></i> Trascina qui i file</span> da caricare \
			 <span class="smaller-80 grey">(o clicca)</span> <br /> \
			 <i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i>',
    dictResponseError: 'Errore caricando i file!',
    previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"progress progress-small progress-striped active\"><div class=\"progress-bar progress-bar-success\" data-dz-uploadprogress></div></div>\n  <div class=\"dz-success-mark\"><span></span></div>\n  <div class=\"dz-error-mark\"><span></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>",
    init: function() {
      //  $('#MyDropzone').hide();
        thisDropzone = this;


    },
    success: function(file, responseText){
        var size= responseText[0].size;
        var sha256=responseText[0].sha256;
        var file= responseText[0].name;
        
        //console.log('size:'+responseText[0].size);
        console.log(responseText);
        $('#sha256').val(sha256);
        $('#file').val(file);
        $('#size').val(size);
        $('#verifica').show("slow");
        $('#bt_save').show("slow"); //solo per test
        $('#Bt_CancTable').show("slow");
        
        this.on("complete", function(file) { 
            this.removeAllFiles(true); 
        });
    },
    accept: function(file, done){
       
      done();
      $('#Bt_Carica').hide("slow");
     
      $('#MyDropzone').hide("slow");  
      
    }
});    
</script>    
</html>