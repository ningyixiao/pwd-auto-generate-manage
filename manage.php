<?php  
    if(!isset($_COOKIE["token"])){
        $url="index.php"; 
        echo "<script>"; 
        echo "location.href='$url'"; 
        echo "</script>"; 
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pwd-Auto-Generator</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="res/font-awesome/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="res/mdb/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="res/mdb/css/mdb.min.css" rel="stylesheet">
    <link href="res/mdb/css/compiled.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/manage.css" rel="stylesheet">
</head>

<body>
    <!--Navbar-->
    <nav class="navbar navbar-toggleable-md navbar-dark special-color-dark bg-primary">
        <div class="container">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav1" aria-controls="navbarNav1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="index.php">
                <strong>PAG</strong>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown btn-group">
                        <a class="nav-link dropdown-toggle" id="userdropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_COOKIE["nickname"] ?>
                        </a>
                        <div class="dropdown-menu dropdown" aria-labelledby="userdropdownMenu">
                            <a href="#" class="dropdown-item">
                                <i class="fa fa-windows" aria-hidden="true"></i>
                                The Console
                            </a>
                            <a href="logout.php" class="dropdown-item">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                Log Out
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">mode</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--/.Navbar-->
    
    <!-- Sidebar -->
    <ul class="cus_sidebar">
        <li>
            <a class="waves-effect waves-light" href="#">Repository</a>
        </li>
        <li>
            <a class="waves-effect waves-light" href="#">Share Info</a>
        </li>
        <li>
            <a class="waves-effect waves-light" href="#">Group</a>
        </li>
    </ul>
    <!--/. Sidebar -->
    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="res/mdb/js/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="res/mdb/js/tether.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="res/mdb/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="res/mdb/js/mdb.min.js"></script>
    <script type="text/javascript" src="js/manage.js"></script>
</body>

</html>
