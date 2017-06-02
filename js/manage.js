$(function() {
    // listen a.func_link click event
    $("a.func_link").click(function(e) {
        e.preventDefault();
        var target = $(e.target);
        var origin = target.attr("id");
        // judge the cookie existence state
        if ($.cookie("nickname") == null) {
            window.location.href = "index.php";
        }
        // when the cookie exists, continue
        if (target.hasClass("key")) {
            // post a http request for key
            var shareState = target.data("share");
            var data = {
                "creator": $.cookie("nickname"),
                "shareState": shareState
            };
            $.ajax({
                type: "post",
                url: "api/get_user_genkey.php",
                data: data,
                dataType: "json",
                success: function(data) {
                    // list data.keyList in corresponding area
                    
                },
                error: function() {}
            });
        }
        if (target.hasClass("group")) {
            // post a http request for group
        }
        // display area
        $(".m_section").css("display", "none");
        $("[data-origin=" + origin + "]").css("display", "block");
    });

    // listen set_btn click event
    $("#set_btn").click(function() {
        var pwd = $("#set_pwd").val();
        var openKey = $("#set_openKey").val();
        var openKey_confirm = $("#set_openKey_confirm").val();
        if (pwd.length == 0) {
            $(".set_info0").css("display", "block");
        } else if (openKey.length == 0) {
            $(".set_info1").css("display", "block");
        } else if (openKey_confirm.length == 0) {
            $(".set_info2").css("display", "block");
        } else if (openKey !== openKey_confirm) {
            $(".set_info1").html("twice not the same");
            $(".set_info1").css("display", "block");
        } else {
            if (openKey == openKey_confirm) {
                // judge the cookie existence state
                if ($.cookie("nickname") == null) {
                    window.location.href = "index.php";
                }
                // judge the password correct
                var data1 = {
                    "nickname": $.cookie("nickname"),
                    "pwd": md5(pwd)
                };
                $.ajax({
                    type: "post",
                    url: "api/check_pwd.php",
                    data: data1,
                    dataType: "json",
                    success: function(data) {
                        if (data.state !== 1) {
                            $(".set_info0").css("display", "block");
                        } else {
                            // post a http request for set a openKey
                            var data2 = {
                                "nickname": $.cookie("nickname"),
                                "openKey": md5(openKey)
                            };
                            $.ajax({
                                type: "post",
                                url: "api/set_openKey.php",
                                data: data2,
                                dataType: "json",
                                success: function(data) {
                                    if (data.state == 1) {
                                        $(".set_info_box").html("set openKey success, you can save key now.");
                                        $(".set_info_box").addClass("set_success");
                                        alert("3 seconds after the page will jump to index page.");
                                        var t = setTimeout(function() {
                                            window.location.href = "index.php";
                                        }, 3000);
                                    }
                                    if (data.state == 0) {
                                        $(".set_info_box").html("set openKey fail, please try again.");
                                        $(".set_info_box").addClass("set_fail");
                                    }
                                },
                                error: function() {}
                            });
                        }
                    },
                    error: function() {}
                });
            }
        }
    });

    // listen set_openKey focus event
    $("[data-origin='set'] input").focus(function() {
        $(".set_info0").css("display", "none");
        $(".set_info1").css("display", "none");
        $(".set_info2").css("display", "none");
        $(".set_info_box").removeClass("set_success");
        $(".set_info_box").removeClass("set_fail");
    });
})
