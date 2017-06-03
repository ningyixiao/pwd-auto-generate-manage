// AES algorithm
function encryptAES(rowKey, openKey) {
    return CryptoJS.AES.encrypt(rowKey, openKey).toString();
}

function decryptAES(encKey, openKey) {
    return CryptoJS.AES.decrypt(encKey, openKey).toString(CryptoJS.enc.Utf8);
}

function randomArray(times, array) {
    var length = array.length;
    var r_array = [];
    for (var i = 0; i < times; i++) {
        var idx = Math.floor(Math.random() * length);
        r_array.push(array[idx]);
    }
    return r_array;
}

function judgeArrayItemDistance(array, min, max) {
    var length = array.length;
    var state = true;
    ((max - array[0]) <= 0) && (state = false);
    for (var i = 0; i < length; i++) {
        if (i == length - 1) {
            ((array[i] - min) <= 0) && (state = false);
        } else {
            ((array[i] - array[i + 1]) <= 0) && (state = false);
        }
    }
    return state;
}

function numDivideArray(times, num) {
    while (true) {
        var node_arr = [];
        var re_arr = [];
        for (var i = 0; i < times - 1; i++) {
            node_arr[i] = Math.floor(Math.random() * num + 1);
        }
        // arr sort by descending order
        node_arr.sort(function(a, b) {
            return b - a
        });
        if (judgeArrayItemDistance(node_arr, 0, num)) {
            var count = node_arr.length + 1;
            var temp_arr = [];
            node_arr.unshift(num);
            node_arr.push(0);
            for (var j = 0; j < count; j++) {
                temp_arr[j] = node_arr[j] - node_arr[j + 1];
            }
            re_arr = temp_arr;
            break;
        }
    }
    return re_arr.sort(function(a, b) {
        return b - a
    });
}

function confusion_arr(array) {
    var length = array.length;
    var re_arr = [];
    for (var i = 0; i < length; i++) {
        var idx = Math.floor(Math.random() * array.length);
        // console.log(idx, array[idx]);
        re_arr = re_arr.concat(array.splice(idx, 1));
    }
    return re_arr;
}

function pwdGenerate() {
    // genetate random pwd string
    var PWD_LENGTH = 13;
    var lowChar_array = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    var upChar_array = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    var num_array = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    var spclChar_array = ['!', '@', '#', '$'];
    // cal random char array
    var namespace = [lowChar_array, upChar_array, num_array, spclChar_array];
    var times_array = numDivideArray(namespace.length, PWD_LENGTH);
    var randomPwdArray = [];
    for (var n = 0; n < namespace.length; n++) {
        randomPwdArray = randomPwdArray.concat(randomArray(times_array[n], namespace[n]));
    }
    randomPwdArray = confusion_arr(randomPwdArray);
    return randomPwdArray.join("");
}
$(function() {
    // When access this page, firstly judge has cookie 
    // If not, then show the login modal
    // If exist, not hide the login modal
    if ($.cookie("nickname") == null) {
        $("#modalLoginForm").modal('show');
    }
    // listen mode button click event
    $("#change_mode").click(function() {
        $("body").toggleClass("mode-bg");
        $("#random_key_area").toggleClass("mode-border mode-color");
        $(".generate_btn").toggleClass("mode-border");
    });
    // listen Generate button click event
    $("#generate_btn").click(function() {
        var randomPwdStr = pwdGenerate();
        $("#random_key_area").html(randomPwdStr);
    });
    //listen mouse enter&leave the random_key_area event
    $(".wrap").mouseenter(function() {
        if ($("#random_key_area").html().length > 0) {
            $(".mask").css("display", "unset");
            $(".random_key_area").css("color", "#fff");
        }
    }).mouseleave(function() {
        $(".mask").css("display", "none");
        $(".random_key_area").css("color", "unset");
    });
    //listen Save click event
    $("#saveKey").click(function(e) {
        e.preventDefault();
        // judge user state log in/sign out
        if ($.cookie("token") == null) {
            $("#modalLoginForm").modal("show");
        } else {
            // if openKey is set, then show save key modal
            $.ajax({
                type: "post",
                url: "api/check_openKey_set.php",
                data: { "nickname": $.cookie("nickname") },
                dataType: "json",
                success: function(data) {
                    // console.log(data);
                    // data.checkState = true, indicate that openKey is set
                    if (data.checkState) {
                        // show save key modal
                        $("#modalSaveKeyForm").modal("show");
                    } else {
                        // link to openKey set page
                        window.location.href = "manage.php?hasOpenKey=false";
                    }
                },
                error: function() {}
            });
        }
    });
    //listen Save Key button click event
    $("#saveKeyBtn").click(function() {
        var feature = $("#key_feature").val();
        if (feature.length == 0) {
            $("#key_feature_info").html("not allowd null");
            $("#key_feature_info").css("display", "block");
        } else if ($.cookie("nickname") == null) {
            $("#modalLoginForm").modal("show");
        } else {
            // encrypt key with openKey by AES
            var creator = $.cookie("nickname");
            // get user's openKey
            $.ajax({
                type: "post",
                url: "api/get_user_openKey.php",
                data: { "nickname": creator },
                dataType: "json",
                success: function(data) {
                    if (data.state == 1) {
                        // post a http request for save this key 
                        var rowKey = $("#random_key_area").html();
                        var openKey = data.openKey;
                        var genKey = encryptAES(rowKey, openKey);
                        var shareState = 1;
                        var data = {
                            "creator": creator,
                            "feature": feature,
                            "genKey": genKey,
                            "shareState": shareState
                        };
                        $.ajax({
                            type: "post",
                            url: "api/save_key.php",
                            data: data,
                            dataType: "json",
                            success: function(data) {
                                if(data.state == 1){
                                    window.location.href = "manage.php";
                                }else{
                                    alert(data.msg);
                                }
                            },
                            error:function(){}
                        });
                    } else {
                        // get openKey fail

                    }
                },
                error: function() {}
            });
        }
    });
    // listen key_feature input box focus event
    $("#key_feature").focus(function() {
        $("#key_feature_info").css("display", "none");
    });
    // Register Controll
    // validate input of nickname and pwd
    var checkstate = {
        "nickname_state": 0,
        "pwd_state": 0
    };
    $('#reg_nickname').blur(function(e) {
        var that = this;
        if ($(that).val().length == 0) {
            $("#reg_nickname_info").html("not allowed null");
            $("#reg_nickname_info").css("display", "unset");
        } else {
            var nickname = {
                "nickname": $(that).val()
            };
            $.ajax({
                type: "post",
                url: "api/check_nickname_unique.php",
                data: nickname,
                dataType: "json",
                success: function(data) {
                    // console.log(data.msg);
                    if (data.checkState) {
                        checkstate.nickname_state = 1;
                    } else {
                        checkstate.nickname_state = 0;
                        $("#reg_nickname_info").html("already exists");
                        $("#reg_nickname_info").css("display", "unset");
                    }
                },
                error: function() {}
            });
        }
    });
    $('#reg_nickname').focus(function(e) {
        $("#reg_nickname_info").css("display", "none");
    });
    $('#reg_pwd').focus(function(e) {
        $("#reg_pwd_info").css("display", "none");
    });
    $('#reg_rePwd').focus(function(e) {
        $("#reg_pwd_info").css("display", "none");
    });
    $('#reg_rePwd').blur(function(e) {
        var pwd = $('#reg_pwd').val();
        var rePwd = $('#reg_rePwd').val();
        if (pwd.length == 0 || rePwd.length == 0) {
            return;
        } else {
            if (pwd == rePwd) {
                checkstate.pwd_state = 1;
            } else {
                checkstate.pwd_state = 0;
                $("#reg_pwd_info").html("twice not the same");
                $("#reg_pwd_info").css("display", "unset");
            }
        }
    });
    $("#reg_btn").click(function(e) {
        var nickname = $('#reg_nickname').val();
        var pwd = $('#reg_pwd').val();
        var data = {
            "nickname": nickname,
            "pwd": pwd
        };
        if (checkstate.nickname_state == 1 && checkstate.pwd_state == 1) {
            // pwd encrypt with md5 
            data.pwd = md5(data.pwd);
            $.ajax({
                type: "post",
                url: "api/add_user.php",
                data: data,
                dataType: "json",
                success: function(data) {
                    checkstate.nickname_state = 0;
                    checkstate.pwd_state = 0;
                    if (data.state == 1) {
                        $(".reg_info").html("Registration success, please log in.");
                        $(".reg_info").addClass("success");
                    } else {
                        $(".reg_info").html("Registration fail, please redo.");
                        $(".reg_info").addClass("fail");
                    }
                },
                error: function() {}
            });
        }
    });

    // login controll
    $("#log_btn").click(function(e) {
        var nickname = $("#log_nickname").val();
        var pwd = $("#log_pwd").val();
        if (nickname.length == 0 || pwd.length == 0) {
            return;
        } else {
            var data = {
                "nickname": nickname,
                "pwd": md5(pwd)
            };
            $.ajax({
                type: "post",
                url: "api/login.php",
                data: data,
                dataType: "json",
                success: function(data) {
                    if (data.state == 1) {
                        $("#modalLoginForm").modal('hide');
                        $("#userdropdownMenu").html(data.nickname);
                        window.location.href = "index.php";
                    }
                },
                error: function() {}
            });
        }
    });
})
