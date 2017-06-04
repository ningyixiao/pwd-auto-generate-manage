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
            <div class="section">
                <input type="radio" name="accordion-1" id="section-3" value="toggle" />
                <label for="section-3"><span>Key From Others</span></label>
                <div class="content">
                    <ul>
                        <li><i class="fa fa-group"></i><a class="func_link u_s_key" id="key_f_u">receive from user</a></li>
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
    <!-- Modal: Look Key -->
    <div class="modal fade" id="modalLookKeyForm" tabindex="-1" role="dialog" aria-labelledby="modalLookKeyFormLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header light-blue darken-3 white-text">
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="title"><i class="fa fa-key"></i> Enter openKey</h4>
                </div>
                <!--Body-->
                <div class="modal-body mb-0">
                    <div class="md-form form-sm">
                        <i class="fa fa-pencil-square-o prefix"></i>
                        <input type="password" id="enter_openKey" class="form-control">
                        <label for="form8">your openKey</label>
                        <div id="enter_openKey_info"></div>
                    </div>
                    <div class="text-center mt-1-half">
                        <button id="confirm_openKey_btn" class="btn btn-info mb-2 waves-effect waves-light">Confirm</button>
                    </div>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!-- /.Modal: Look Key -->
    <!-- Modal: Edit Key -->
    <div class="modal fade" id="modalEditKeyForm" tabindex="-1" role="dialog" aria-labelledby="modalEditKeyFormLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header light-blue darken-3 white-text">
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="title"><i class="fa fa-pencil"></i> Modify Description</h4>
                </div>
                <!--Body-->
                <div class="modal-body mb-0">
                    <div class="md-form form-sm">
                        <i class="fa fa-pencil-square-o prefix"></i>
                        <input type="text" id="edit_feature" class="form-control">
                        <label for="form8">key description</label>
                        <div id="edit_feature_info"></div>
                    </div>
                    <div class="text-center mt-1-half">
                        <button id="confirm_feature_btn" class="btn btn-info mb-2 waves-effect waves-light">Confirm</button>
                    </div>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!-- /.Modal: Edit Key -->
    <!-- Modal: Share Key -->
    <div class="modal fade" id="modalShareKeyForm" tabindex="-1" role="dialog" aria-labelledby="modalShareKeyFormLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header light-blue darken-3 white-text">
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="title"><i class="fa fa-share-alt"></i> Share Key</h4>
                </div>
                <!--Body-->
                <div class="modal-body mb-0">
                    <div class="md-form form-sm">
                        <i class="fa fa-pencil-square-o prefix"></i>
                        <input type="password" id="share_target_user" class="form-control">
                        <label for="form8">target nickname</label>
                        <div id="share_target_user_info"></div>
                    </div>
                    <div class="md-form form-sm">
                        <i class="fa fa-pencil-square-o prefix"></i>
                        <input type="password" id="share_openKey" class="form-control">
                        <label for="form8">your openKey</label>
                        <div id="share_openKey_info"></div>
                    </div>
                    <div class="text-center mt-1-half">
                        <button id="confirm_share_btn" class="btn btn-info mb-2 waves-effect waves-light">Confirm</button>
                    </div>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!-- /.Modal: Share Key -->
    <!-- Modal: Cancel Share Key-->
    <div class="modal fade" id="modalCancelShareForm" tabindex="-1" role="dialog" aria-labelledby="modalCancelShareFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-notify modal-info" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Cancel Share</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">×</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <p>Do you really want to cancel the shared key?</p>
                    </div>
                </div>
                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a id="cancel_share_btn" type="button" class="btn btn-primary-modal waves-effect waves-light">Confirm</a>
                    <a type="button" class="btn btn-outline-secondary-modal waves-effect" data-dismiss="modal">No</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    
    <!-- /.Modal: Cancel Share Key -->
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
        <div id="private_key_section" class="m_section key_list" data-origin="p_key">
            <div style="text-align: center;font-size: 1.8rem;padding-bottom:1rem;">Privete Key List</div>
            <table class="table">
                <thead class="thead-inverse">
                    <tr>
                        <th>Description</th>
                        <th>Key</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="p_key_list">
                    <!-- <tr>
                        <td>Abby</td>
                        <td>Barrett</td>
                        <td>
                            <a class="blue-text"><i class="fa fa-eye"></i></a>
                            <a class="teal-text"><i class="fa fa-pencil"></i></a>
                            <a class="blue-grey-text"><i class="fa fa-share-alt"></i></a>
                            <a class="red-text"><i class="fa fa-times"></i></a>
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
        <div id="share_key_user_section" class="m_section key_list" data-origin="s_key_u">
            <div style="text-align: center;font-size: 1.8rem;padding-bottom:1rem;">Shared Key List</div>
            <table class="table">
                <thead class="thead-inverse">
                    <tr>
                        <th>Description</th>
                        <th>Key</th>
                        <th>targetUser</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="s_key_u_list">
                    <!-- <tr>
                        <td>Abby</td>
                        <td>Barrett</td>
                        <td>Barrett</td>
                        <td>
                            <a class="blue-text"><i class="fa fa-eye"></i></a>
                            <a class="blue-grey-text"><i class="fa fa-chain-broken"></i></a>
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
        <div id="share_key_user_section" class="m_section key_list" data-origin="key_f_u">
            <div style="text-align: center;font-size: 1.8rem;padding-bottom:1rem;">Key From Others List</div>
            <table class="table">
                <thead class="thead-inverse">
                    <tr>
                        <th>Description</th>
                        <th>Key</th>
                        <th>Owner</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="key_f_u_list">
                    <!-- <tr>
                        <td>Abby</td>
                        <td>Barrett</td>
                        <td>Barrett</td>
                        <td>
                            <a class="blue-text"><i class="fa fa-eye"></i></a>
                            <a class="blue-grey-text"><i class="fa fa-chain-broken"></i></a>
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
        <!-- <div class="m_section" data-origin="s_key_g"></div>
        <div class="m_section" data-origin="group"></div> -->
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
