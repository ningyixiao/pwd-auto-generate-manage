$(function() {
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
                    if(data.state == 1){
                        $("#modalLoginForm").modal('hide');
                        $("#userdropdownMenu").html(data.nickname);
                        window.location.href="index.php";
                    }
                },
                error: function() {}
            });
        }
    });
})
