// AES algorithm
function encryptAES(rowKey, openKey) {
    return CryptoJS.AES.encrypt(rowKey, openKey).toString();
}

function decryptAES(encKey, openKey) {
    return CryptoJS.AES.decrypt(encKey, openKey).toString(CryptoJS.enc.Utf8);
}

$(function() {
    var globalData = {
        "userKeyList": []
    };
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
                    if (data.state == 1) {
                        // set globalData.userKeyList
                        globalData.userKeyList = data.keyList;
                        var keyList = data.keyList;
                        var html = "";
                        for (var i = 0; i < keyList.length; i++) {
                            html += `
                            <tr data-index=${i}>
                                <td>${keyList[i].feature}</td>
                                <td>******</td>
                                <td>
                                    <a id="${keyList[i].kid}_key_look" data-index=${i} class="blue-text key_look"><i class="fa fa-eye"></i></a>
                                    <a id="${keyList[i].kid}_key_edit" data-index=${i} class="teal-text key_edit"><i class="fa fa-pencil"></i></a>
                                    <a id="${keyList[i].kid}_key_share" data-index=${i} class="blue-grey-text key_share"><i class="fa fa-share-alt"></i></a>
                                    <a id="${keyList[i].kid}_key_delete" data-index=${i} class="red-text key_delete"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            `;
                        }
                        $("#p_key_list").html(html);
                    } else {
                        // tell user get keyList fail
                        var html = `
                            <th class="deep-orange-text" style="text-align:center;width:100%;">
                                ${data.msg}
                            </th>`;
                        $("#p_key_list").html(html);
                    }
                },
                error: function() {
                    console.log("ajax error");
                }
            });
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

    // listen key operation[look/edit/share/delete] click event
    $("#p_key_list").on("click", "a", function(e) {
        var that = $(this);
        if (that.hasClass("key_look")) {
            // look operation
            var index = that.data("index");
            if (that.children("i").hasClass("fa-eye")) {
                $("#modalLookKeyForm").data("index", index);
                $("#modalLookKeyForm").modal("show");
            } else {
                $("#p_key_list tr[data-index=" + index + "] td:nth-child(2)").html("******");
                $("#p_key_list a[data-index=" + index + "] i.fa-eye-slash").removeClass("fa-eye-slash").addClass("fa-eye");
            }
        } else if (that.hasClass("key_edit")) {
            // edit operation
            var index = that.data("index");
            var kid = parseInt(that.attr("id"));
            $("#modalEditKeyForm").data("index", index);
            $("#modalEditKeyForm").data("kid", kid);
            $("#modalEditKeyForm").modal("show");
        }
        // share operation
        // delete operation
    });
    // listen focus event of modal input box
    $("#enter_openKey").focus(function() {
        $("#enter_openKey_info").css("display", "none");
    });
    $("#edit_feature").focus(function() {
        $("#enter_openKey_info").css("display", "none");
    });
    
    // listen confirm_openKey_btn click event
    $("#confirm_openKey_btn").click(function() {
        // judge the cookie existence state
        if ($.cookie("nickname") == null) {
            window.location.href = "index.php";
        }
        var openKey = $("#enter_openKey").val();
        if (openKey.length == 0) {
            // not allowed null info
            $("#enter_openKey_info").html("not allowed null");
            $("#enter_openKey_info").css("display", "block");
        } else {
            // post a http request for user openKey
            var nickname = $.cookie("nickname");
            var data = {
                "nickname": nickname,
                "openKey": md5(openKey)
            }
            $.ajax({
                type: "post",
                url: "api/check_openKey.php",
                data: data,
                dataType: "json",
                success: function(data) {
                    if (data.state == 1) {
                        // decrypt the key with md5(openKey)
                        // get the key index of keyList
                        var idx = $("#modalLookKeyForm").data("index");
                        var encryptKey = globalData.userKeyList[idx].genKey;
                        var decryptKey = decryptAES(encryptKey, data.openKey);
                        // find the key position, and replace the '******'
                        $("#p_key_list tr[data-index=" + idx + "] td:nth-child(2)").html(decryptKey);
                        // after replace, close the modal, and set the eye to eye-slash
                        $("#enter_openKey").val("");
                        $("#modalLookKeyForm").modal("hide");
                        $("#p_key_list a[data-index=" + idx + "] i.fa-eye").removeClass("fa-eye").addClass("fa-eye-slash");
                    } else {
                        $("#enter_openKey_info").html(data.msg);
                        $("#enter_openKey_info").css("display", "block");
                    }
                },
                error: function() {}
            });
        }
    });

    // listen confirm_feature_btn click event
    $("#confirm_feature_btn").click(function() {
        // judge the cookie existence state
        if ($.cookie("nickname") == null) {
            window.location.href = "index.php";
        }
        var feature = $("#edit_feature").val();
        if (feature.length == 0) {
            // not allowed null info
            $("#edit_feature_info").html("not allowed null");
            $("#edit_feature_info").css("display", "block");
        } else {
            // post a http request for user openKey
            var kid = $("#modalEditKeyForm").data("kid");
            var data = {
                "kid": kid,
                "feature": feature
            }
            $.ajax({
                type: "post",
                url: "api/edit_key_feature.php",
                data: data,
                dataType: "json",
                success: function(data) {
                    if (data.state == 1) {
                        var feature = data.feature;
                        // get the key index of keyList
                        var idx = $("#modalEditKeyForm").data("index");
                        // find the description position, and replace the original one
                        $("#p_key_list tr[data-index=" + idx + "] td:nth-child(1)").html(feature);
                        // after replace, close the modal
                        $("#edit_feature").val("");
                        $("#modalEditKeyForm").modal("hide");
                    } else {
                        $("#edit_feature_info").html(data.msg);
                        $("#edit_feature_info").css("display", "block");
                    }
                },
                error: function() {}
            });
        }
    });
})
