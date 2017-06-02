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
                <label id="label_openKey" for="section-1"><span>openKey</span></label>
                <div class="content">
                    <ul>
                        <li><i class="fa fa-cog"></i><a class="func_link" id="set">set</a></li>
                    </ul>
                </div>
            </div>
            <div class="section">
                <input type="radio" name="accordion-1" id="section-2" value="toggle" />
                <label id="key_repo" for="section-2"><span>Key Repository</span></label>
                <div class="content">
                    <ul>
                        <li><i class="fa fa-user"></i><a class="func_link key" id="p_key" data-share="1">private key</a></li>
                        <li><i class="fa fa-chain"></i><a class="func_link key" id="s_key_u" data-share="2">share with user</a></li>
                        <!-- <li><i class="fa fa-chain"></i><a class="func_link key" id="s_key_g" data-share="3">share with group</a></li> -->
                    </ul>
                </div>
            </div>
            <!-- <div class="section">
                <input type="radio" name="accordion-1" id="section-3" value="toggle" />
                <label for="section-3"><span>Group</span></label>
                <div class="content">
                    <ul id="group_list">
                        <li><i class="fa fa-group"></i><a class="func_link group" id="group_groupname">g1</a></li>
                    </ul>
                </div>
            </div> -->
        </div>
    </div>
    <!--/. Sidebar -->
    <!-- main area -->
    <div id="main" class="main">
        <div class="m_section" data-origin="set">
            <div class="card">
                    <div class="card-block">
                        <div class="set_info_box"></div>
                        <!--Header-->
                        <div class="text-center">
                            <h3><i class="fa fa-pencil"></i> Set your openKey</h3>
                            <hr class="mt-2 mb-2">
                        </div>
                        <!--Body-->
                        <p>You must set the openKey before you save the key.</p>
                        <br>
                        <!--Body-->
                        <div class="md-form">
                            <i class="fa fa-lock prefix"></i>
                            <input type="password" id="set_pwd" class="form-control">
                            <label for="set_pwd">Your account password</label>
                            <div class="set_info0 info">wrong password</div>
                        </div>
                        <div class="md-form">
                            <i class="fa fa-key prefix"></i>
                            <input type="password" id="set_openKey" class="form-control">
                            <label for="set_openKey">Your openKey</label>
                            <div class="set_info1 info">not allowd null</div>
                        </div>
                        <div class="md-form">
                            <i class="fa fa-key prefix"></i>
                            <input type="password" id="set_openKey_confirm" class="form-control">
                            <label for="set_openKey_confirm">Reenter your openKey</label>
                            <div class="set_info2 info">not allowd null</div>
                        </div>
                        <div class="text-center">
                            <button id="set_btn" class="btn btn-deep-orange waves-effect waves-light">Confirm</button>
                        </div>
                    </div>
            </div>
        </div>
        <div class="m_section" data-origin="p_key"></div>
        <div class="m_section" data-origin="s_key_u"></div>
        <div class="m_section" data-origin="s_key_g"></div>
        <div class="m_section" data-origin="group"></div>
    </div>
    <!-- /.main area -->
    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="res/mdb/js/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="res/mdb/js/tether.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="res/mdb/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="res/mdb/js/mdb.min.js"></script>
    <!-- md5 -->
    <script type="text/javascript" src="res/md5.min.js"></script>
    <!-- AES -->
    <script type="text/javascript" src="res/crypto-js.min.js"></script>
    <!-- jquery.cookie.js -->
    <script type="text/javascript" src="res/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/manage.js"></script>
    <?php if(isset($_REQUEST['hasOpenKey'])){ ?> 
    <script>
        // url attr hasOpenKey exist
        $(function(){
           $("#label_openKey").trigger("click");
           $("#set").trigger("click"); 
        }) 
    </script>
    <?php }else{ ?>
    <script>
        $(function(){
           $("#key_repo").trigger("click");
           $("#p_key").trigger("click"); 
        })   
    </script>   
    <?php } ?>
</body>

</html>
