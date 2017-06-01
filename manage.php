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
    <div class="left-menu">
        <div class="accordion">
            <div class="section">
                <input type="radio" name="accordion-1" id="section-1" checked="checked" />
                <label for="section-1"><span>Messages</span></label>
                <div class="content">
                    <ul>
                        <li><i class="fa fa-inbox"></i><span>Inbox</span></li>
                        <li><i class="fa fa-share"></i><span>Sent    </span></li>
                        <li><i class="fa fa-archive"></i><span>Archive</span></li>
                    </ul>
                </div>
            </div>
            <div class="section">
                <input type="radio" name="accordion-1" id="section-2" value="toggle" />
                <label for="section-2"><span>Usage</span></label>
                <div class="content">
                    <ul>
                        <li><i class="fa fa-cog"></i><span>System</span></li>
                        <li><i class="fa fa-group"></i><span>Users    </span></li>
                        <li><i class="fa fa-sitemap"></i><span>Visitation</span></li>
                    </ul>
                </div>
            </div>
            <div class="section">
                <input type="radio" name="accordion-1" id="section-3" value="toggle" />
                <label for="section-3"><span>Scroller</span></label>
                <div class="content">
                    <ul>
                        <li><i class="fa fa-coffee"></i><span>Need Coffee</span></li>
                        <li><i class="fa fa-coffee"></i><span>Need Coffee    </span></li>
                        <li><i class="fa fa-coffee"></i><span>Need Coffee</span></li>
                        <li><i class="fa fa-coffee"></i><span>Need Coffee</span></li>
                        <li><i class="fa fa-coffee"></i><span>Need Coffee    </span></li>
                        <li><i class="fa fa-coffee"></i><span>Need Coffee</span></li>
                        <li><i class="fa fa-coffee"></i><span>Need Coffee</span></li>
                        <li><i class="fa fa-coffee"></i><span>Need Coffee    </span></li>
                        <li><i class="fa fa-coffee"></i><span>Need Coffee</span></li>
                    </ul>
                </div>
            </div>
            <div class="section">
                <input type="radio" name="accordion-1" id="section-4" value="toggle" />
                <label for="section-4"><span>Section 4</span></label>
                <div class="content"></div>
            </div>
        </div>
    </div>
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
