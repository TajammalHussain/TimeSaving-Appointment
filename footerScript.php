<script src="../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
<!-- Bootstrap popper Core JavaScript -->
<script src="../assets/node_modules/popper/popper.min.js"></script>
<script src="../assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="dist/js/perfect-scrollbar.jquery.min.js"></script>
<!--Menu sidebar -->
<script src="dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="dist/js/custom.min.js"></script>
<script src="../assets/node_modules/toast-master/js/jquery.toast.js"></script>
<script src="dist/js/pages/toastr.js"></script>


<?php
    switch($_SESSION['page_id'])
    {
        case 1:
            ?>
            
            <?php
            break;
        case 3:
            ?>
            <script src="../assets/node_modules/dropify/dist/js/dropify.min.js"></script>
            <script>
            $(document).ready(function() {
                // Basic
                $('.dropify').dropify();
        
                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove: 'Supprimer',
                        error: 'Désolé, le fichier trop volumineux'
                    }
                });
        
                // Used events
                var drEvent = $('#input-file-events').dropify();
        
                drEvent.on('dropify.beforeClear', function(event, element) {
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });
        
                drEvent.on('dropify.afterClear', function(event, element) {
                    alert('File deleted');
                });
        
                drEvent.on('dropify.errors', function(event, element) {
                    console.log('Has Errors');
                });
        
                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e) {
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
            </script>
            <?php
            break;
        case 4:
            ?>
            <script>
                $(document).ready(function() {
                    $('#example').DataTable();
                } );
            </script>
            <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
            <?php
            break;
        case 5:
            ?>
            <script>
                $(document).ready(function() {
                    $('#example12').DataTable();
                } );
            </script>
            <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
            <?php
            break;
        
    }
    ?>
    <script>
    
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
    
        var pusher = new Pusher('b20bc17a9833899f99aa', {
          cluster: 'ap2'
        });
    
        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            var flag=0;
            var uid = document.getElementById('uid').value;
            var utype = document.getElementById('utype').value;
            if(utype!=1)
            {
                var dt = JSON.parse(JSON.stringify(data));
                var dt1 = dt.message.split("@#@");
                var i=0;
                for(i=1;i<dt1.length;i++)
                {
                    if(dt1[i]==uid)
                    {
                        flag=1;
                    }
                }
                if(flag==1)
                {
                    alert(dt1[0]);
                }
            }
        });
      </script>
