<?php  ?>
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
    <link href="css/index.css" rel="stylesheet">
</head>

<body class="mode">
    <!--Navbar-->
    <nav class="navbar navbar-toggleable-md navbar-dark special-color-dark bg-primary">
        <div class="container">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav1" aria-controls="navbarNav1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">
                <strong>PAG</strong>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav1">
                <ul class="navbar-nav ml-auto">
                    <?php if(isset($_COOKIE["token"])){ ?>
                    <li id="nav_item1" class="nav-item dropdown btn-group">
                        <a class="nav-link dropdown-toggle" id="userdropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_COOKIE["nickname"] ?>
                        </a>
                        <div class="dropdown-menu dropdown" aria-labelledby="userdropdownMenu">
                            <a href="manage.php" class="dropdown-item">
                                <i class="fa fa-windows" aria-hidden="true"></i>
                                The Console
                            </a>
                            <a href="logout.php" class="dropdown-item">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                Log Out
                            </a>
                        </div>
                    </li>
                    <?php }else{ ?>
                    <li id="nav_item2" class="nav-item">
                        <a data-toggle="modal" data-target="#modalLoginForm" class="nav-link">
                            <i class="fa fa-sign-in" aria-hidden="true"></i>
                            Log In
                        </a>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a id="change_mode" class="nav-link">mode</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--/.Navbar-->
    <!--Modal: Login / Register Form-->
    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!--Content-->
            <div class="modal-content">

                <!--Modal cascading tabs-->
                <div class="modal-c-tabs">
                    <div class="reg_info"></div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tabs-2 light-blue darken-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#log_panel" role="tab"><i class="fa fa-user mr-1"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#reg_panel" role="tab"><i class="fa fa-user-plus mr-1"></i> Register</a>
                        </li>
                    </ul>

                    <!-- Tab panels -->
                    <div class="tab-content">
                        <!--login Panel-->
                        <div class="tab-pane fade in show active" id="log_panel" role="tabpanel">

                            <!--Body-->
                            <div class="modal-body mb-1">
                                <div class="md-form form-sm">
                                    <i class="fa fa-user-circle-o prefix"></i>
                                    <input type="text" id="log_nickname" class="form-control">
                                    <label for="log_nickname">Your Nickname</label>
                                </div>

                                <div class="md-form form-sm">
                                    <i class="fa fa-lock prefix"></i>
                                    <input type="password" id="log_pwd" class="form-control">
                                    <label for="log_pwd">Your Password</label>
                                    <span id="log_pwd_info">password is incorrect</span>
                                </div>
                                <div class="text-center mt-2">
                                    <button id="log_btn" class="btn btn-info">Log in <i class="fa fa-sign-in ml-1"></i></button>
                                    <button type="button" class="btn btn-outline-info waves-effect ml-auto" data-dismiss="modal">Close <i class="fa fa-times-circle ml-1"></i></button>
                                </div>
                            </div>
                            <!--Footer-->
                            <div class="modal-footer display-footer">
                                <div class="options text-center text-md-right mt-1">
                                    <p>Forgot <a href="#" class="blue-text">Password?</a></p>
                                </div>
                            </div>
                        </div>
                        <!--/.login Panel-->
                        <!--register Panel-->
                        <div class="tab-pane fade" id="reg_panel" role="tabpanel">

                            <!--Body-->
                            <div class="modal-body">
                                <div class="md-form form-sm">
                                    <i class="fa fa-envelope prefix"></i>
                                    <input type="text" id="reg_nickname" class="form-control">
                                    <label for="reg_nickname">Your Nickname</label>
                                    <span id="reg_nickname_info">already exists</span>
                                </div>

                                <div class="md-form form-sm">
                                    <i class="fa fa-lock prefix"></i>
                                    <input type="password" id="reg_pwd" class="form-control">
                                    <label for="reg_pwd">Your Password</label>
                                    <span id="reg_pwd_info">twice not the same</span>
                                </div>

                                <div class="md-form form-sm">
                                    <i class="fa fa-lock prefix"></i>
                                    <input type="password" id="reg_rePwd" class="form-control">
                                    <label for="reg_rePwd">Repeat password</label>
                                </div>

                                <div class="text-center form-sm mt-2">
                                    <button id="reg_btn" class="btn btn-info">Sign up <i class="fa fa-sign-in ml-1"></i></button>
                                    <button type="button" class="btn btn-outline-info waves-effect ml-auto" data-dismiss="modal">Close <i class="fa fa-times-circle ml-1"></i></button>
                                </div>
                            </div>
                        </div>
                        <!--/.register Panel-->
                    </div>

                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!--/.Modal: Login / Register Form-->
    <!-- main function -->
    <div class="main_section">
        <div class="wrap">
            <div id="random_key_area" class="random_key_area"></div>
            <div class="mask">
                <a id="saveKey" href="#">Save it into your repository</a>
            </div> 
        </div>
        <a id="generate_btn" class="generate_btn">Generate</a>
    </div>
    <!-- /.main function -->
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
    <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
