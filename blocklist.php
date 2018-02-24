<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        
        <link href="startbootstrap/bower_components/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="startbootstrap/dist/css/sb-admin-2.css" rel="stylesheet" type="text/css"/>
        <link href="startbootstrap/bower_components/bootstrap-social/bootstrap-social.css" rel="stylesheet" type="text/css"/>
        <link href="startbootstrap/DataTables/datatables.css" rel="stylesheet" type="text/css"/>
        
        <link href="css/custom.css" rel="stylesheet" type="text/css"/>
        <link href="startbootstrap/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="dropzone_upload/dropzone.css" rel="stylesheet" type="text/css"/>
        
        <script src="startbootstrap/bower_components/jquery/dist/jquery-1.12.3.min.js" type="text/javascript"></script>
        <script src="startbootstrap/bower_components/bootstrap/dist/js/bootstrap.js" type="text/javascript"></script>
        <script src="startbootstrap/Dropzone/dropzone.js" type="text/javascript"></script>
        <script src="startbootstrap/DataTables/datatables.js" type="text/javascript"></script>
        
        
    </head>
    <body>
        <?php include 'Dropdown_menu/navbar.php'; ?>

    <div id="wrapper">
        <div class="panel-body">
        <div class="x_panel">
            <div class=x_title>
                Lista dei blocchi
            </div>        
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-hover" id="dt-filestable">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Data inserimento</th>
                            <th>Nome file</th>
                            <th>Dimensione</th>
                            <th>Hash File</th>
                            <th>Hash Blocco</th>
                        </tr>
                    </thead>
                    
                    </table>
                </div>
            <!-- /.table-responsive -->
            </div>
            </div>
        </div>
    </div>     
    </body>
    <?php include "include/footer.php";?>
    
</html>
        
<script>
    $(document).ready(function() {
       
       var tableparams =  {
            "destroy" :true,
            "processing": true,
                    "bProcessing" : true,
                    "order": [[ 0, "desc" ]],
                    "ajax": {   "url": 'ajax/listafile.php',
                                "type": 'GET',
                                "data": ''
                    },
                    "fnInitComplete": function(oSettings, json) {  //fnInitComplete
                      // console.log( 'DataTables has finished its initialisation.' );
                       
                    },    
                    "fnfooterCallback": function( row, data, start, end, display  ) { //footerCallback
                       
                    },
                    "fnDrawCallback": function( oSettings ) {
                       
                    },
                    responsive: true,
                    stateSave: false
        };

        table = $('#dt-filestable').DataTable(tableparams);
       
        setInterval( function () {
            table.ajax.reload( null, false ); // user paging is not reset on reload
        }, 15000 );    
    });
    
       
</script>