    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <link href="../assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link href="../assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <style>
        #myOverlay{position:absolute;top:0;left:0;height:100%;width:100%;}
#myOverlay{background:black;backdrop-filter:blur(4px);opacity:.4;z-index:2;display:none;}

#loadingGIF{position:absolute;top:50%;left:50%;z-index:3;display:none;}
    </style>
    <?php
    switch($_SESSION['page_id'])
    {
        case 1:
            ?>
            <link href="dist/css/pages/dashboard1.css" rel="stylesheet">
            <?php
            break;
        case 3:
            ?>
            <link rel="stylesheet" href="../assets/node_modules/dropify/dist/css/dropify.min.css">
            <?php
            break;
        case 4:
            ?>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
            <?php
            break;
        case 5:
            ?>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
            <?php
            break;
    }
    ?>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
      