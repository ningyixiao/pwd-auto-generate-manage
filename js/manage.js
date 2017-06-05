// AES algorithm
function encryptAES(rowKey, openKey) {
    return CryptoJS.AES.encrypt(rowKey, openKey).toString();
}

function decryptAES(encKey, openKey) {
    return CryptoJS.AES.decrypt(encKey, openKey).toString(CryptoJS.enc.Utf8);
}

$(function() {
    var globalData = {
        "userKeyList": [],
        "keyFromOthersList": [],
        "targetUser": {},
        "shareState": 0
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
        // judge which panel will be show, and list the key
        if (target.hasClass("key")) {
            // post a http request for key
            var shareState = target.data("share");
            // set globalData.shareState
            globalData.shareState = parseInt(shareState);
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
                        if (parseInt(shareState) == 1) {
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
                            for (var j = 0; j < keyList.length; j++) {
                                html += `
                                    <tr data-index=${j}>
                                        <td>${keyList[j].feature}</td>
                                        <td>******</td>
                                        <td>${keyList[j].targetUser}</td>
                                        <td>
                                            <a id="${keyList[j].kid}_key_look" data-index=${j} class="blue-text key_look"><i class="fa fa-eye"></i></a>
                                            <a id="${keyList[j].kid}_key_share" data-index=${j} class="blue-grey-text key_cancel_share"><i class="fa fa-chain-broken"></i></a>
                                        </td>
                                    </tr>`;
                            }
                            $("#s_key_u_list").html(html);
                        }

                    } else {
                        // tell user get keyList null
                        var html = `
                            <th class="blue-grey-text" style="text-align:center;width:100%;">
                                ${data.msg}
                            </th>`;
                        if (parseInt(shareState) == 1) {
                            $("#p_key_list").html(html);
                        } else {
                            $("#s_key_u_list").html(html);
                        }
                    }
                },
                error: function() {
                    console.log("ajax error");
                }
            });
        } else if (target.hasClass("u_s_key")) {
            // set globalData.shareState
            // 1-p,2-share_to_u,3-share_to_g
            //4-receive_from_user,5-receive_from_group
            globalData.shareState = 4;
            var targetUser = $.cookie("nickname");
            $.ajax({
                type: "post",
                url: "api/get_other_user_shareKey.php",
                data: { "targetUser": targetUser },
                dataType: "json",
                success: function(data) {
                    if (data.state == 1) {
                        // set globalData.keyFromOthersList
                        globalData.keyFromOthersList = data.keyList;
                        var keyList = data.keyList;
                        var html = "";
                        for (var k = 0; k < keyList.length; k++) {
                            html += `
                            <tr data-index=${k}>
                                <td>${keyList[k].feature}</td>
                                <td>******</td>
                                <td>${keyList[k].creator}</td>
                                <td>
                                    <a id="${keyList[k].kid}_key_look" data-index=${k} class="blue-text key_look"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            `;
                        }
                        $("#key_f_u_list").html(html);
                    } else {
                        // tell user get keyList null
                        var html = `
                            <th class="blue-grey-text" style="text-align:center;width:100%;">
                                ${data.msg}
                            </th>`;
                        $("#key_f_u_list").html(html);
                    }
                },
                error: function() {}
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

    //=== For Key Repository->private key Module ===
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
        } else if (that.hasClass("key_share")) {
            // share operation
            var index = that.data("index");
            var kid = parseInt(that.attr("id"));
            $("#modalShareKeyForm").data("index", index);
            $("#modalShareKeyForm").data("kid", kid);
            $("#modalShareKeyForm").modal("show");
        } else if (that.hasClass("key_delete")) {
            // delete operation
            var index = that.data("index");
            var kid = parseInt(that.attr("id"));
            $("#modalDeleteKeyForm").data("index", index);
            $("#modalDeleteKeyForm").data("kid", kid);
            $("#modalDeleteKeyForm").modal("show");
        } else {

        }
    });

    // listen focus event of modal input box
    $("#enter_openKey").focus(function() {
        $("#enter_openKey_info").css("display", "none");
    });
    $("#edit_feature").focus(function() {
        $("#enter_openKey_info").css("display", "none");
    });
    $("#share_target_user").focus(function() {
        $("#share_target_user_info").css("display", "none");
    });
    $("#share_openKey").focus(function() {
        $("#share_openKey_info").css("display", "none");
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
                        var encryptKey = "";
                        var decryptKey = "";
                        if (globalData.shareState == 1) {
                            encryptKey = globalData.userKeyList[idx].genKey;
                            decryptKey = decryptAES(encryptKey, data.openKey);
                            // find the key position, and replace the '******'
                            $("#p_key_list tr[data-index=" + idx + "] td:nth-child(2)").html(decryptKey);
                            // after replace, close the modal, and set the eye to eye-slash
                            $("#enter_openKey").val("");
                            $("#modalLookKeyForm").modal("hide");
                            $("#p_key_list a[data-index=" + idx + "] i.fa-eye").removeClass("fa-eye").addClass("fa-eye-slash");
                        } else if (globalData.shareState == 2) {
                            encryptKey = globalData.userKeyList[idx].genKey;
                            decryptKey = decryptAES(encryptKey, data.openKey);
                            // find the key position, and replace the '******'
                            $("#s_key_u_list tr[data-index=" + idx + "] td:nth-child(2)").html(decryptKey);
                            // after replace, close the modal, and set the eye to eye-slash
                            $("#enter_openKey").val("");
                            $("#modalLookKeyForm").modal("hide");
                            $("#s_key_u_list a[data-index=" + idx + "] i.fa-eye").removeClass("fa-eye").addClass("fa-eye-slash");
                        } else if (globalData.shareState == 4) {
                            encryptKey = globalData.keyFromOthersList[idx].uKey;
                            decryptKey = decryptAES(encryptKey, data.openKey);
                            // find the key position, and replace the '******'
                            $("#key_f_u_list tr[data-index=" + idx + "] td:nth-child(2)").html(decryptKey);
                            // after replace, close the modal, and set the eye to eye-slash
                            $("#enter_openKey").val("");
                            $("#modalLookKeyForm").modal("hide");
                            $("#key_f_u_list a[data-index=" + idx + "] i.fa-eye").removeClass("fa-eye").addClass("fa-eye-slash");
                        } else {}

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

    // listen share_target_user blur event
    $("#share_target_user").blur(function() {
        // judge the cookie existence state
        if ($.cookie("nickname") == null) {
            window.location.href = "index.php";
        }
        var targetUser = $("#share_target_user").val();
        if (targetUser !== $.cookie("nickname")) {
            $.ajax({
                type: "post",
                url: "api/check_targetUser_exist.php",
                data: { "targetUser": targetUser },
                dataType: "json",
                success: function(data) {
                    if (data.state == 1) {
                        // assign the openKey to globalData.targetUser
                        globalData.targetUser = {
                            "exist": true,
                            "openKey": data.openKey
                        };
                    } else {
                        $("#share_target_user_info").html(data.msg);
                        $("#share_target_user_info").css("display", "block");
                    }
                },
                error: function() {}
            });
        } else {
            $("#share_target_user_info").html("can't share yourself");
            $("#share_target_user_info").css("display", "block");
        }
    });
    // listen confirm_share_btn click event
    $("#confirm_share_btn").click(function() {
        // judge the cookie existence state
        if ($.cookie("nickname") == null) {
            window.location.href = "index.php";
        }
        var targetUser = $("#share_target_user").val();
        var openKey = $("#share_openKey").val();
        if (targetUser.length == 0) {
            // not allowed null info
            $("#share_target_user_info").html("not allowed null");
            $("#share_target_user_info").css("display", "block");
        } else if (openKey.length == 0) {
            // not allowed null info
            $("#share_openKey_info").html("not allowed null");
            $("#share_openKey_info").css("display", "block");
        } else {
            if (globalData.targetUser.exist) {
                // post a http request for share key
                var kid = $("#modalShareKeyForm").data("kid");
                // decrypt key with user openKey
                var idx = parseInt($("#modalShareKeyForm").data("index"));
                var encKey = globalData.userKeyList[idx].genKey;
                var decKey = decryptAES(encKey, md5(openKey));
                // encrypt key with targetUser openKey
                var encShareKey = encryptAES(decKey, globalData.targetUser.openKey);
                var data = {
                    "kid": kid,
                    "targetUser": targetUser,
                    "uKey": encShareKey
                }
                $.ajax({
                    type: "post",
                    url: "api/share_key_toUser.php",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                        if (data.state == 1) {
                            alert("share success");
                            // find and remove the key from the panel
                            $("#p_key_list tr[data-index=" + idx + "]").remove();
                            // Then close the modal
                            $("#share_target_user").val("");
                            $("#share_openKey").val("");
                            $("#modalShareKeyForm").modal("hide");
                        } else {
                            alert(data.msg);
                        }
                    },
                    error: function() {}
                })
            }
        }
    });
    // listen delete_key_btn click event
    $("#delete_key_btn").click(function() {
        // judge the cookie existence state
        if ($.cookie("nickname") == null) {
            window.location.href = "index.php";
        }
        var openKey = $("#deleteKey_openKey").val();
        if (openKey.length == 0) {
            // not allowed null info
            $("#deleteKey_openKey_info").html("not allowed null");
            $("#deleteKey_openKey_info").css("display", "block");
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
                        // post a http request for cancel share
                        var kid = $("#modalDeleteKeyForm").data("kid");
                        var idx = parseInt($("#modalDeleteKeyForm").data("index"));
                        var data1 = {
                            "kid": kid
                        };
                        $.ajax({
                            type: "post",
                            url: "api/delete_user_private_key.php",
                            data: data1,
                            dataType: "json",
                            success: function(data_1) {
                                console.log("1")
                                if (data_1.state == 1) {
                                    alert("delete key success");
                                    // find and remove the key from the panel
                                    $("#p_key_list tr[data-index=" + idx + "]").remove();
                                    // Then close the modal
                                    $("#modalDeleteKeyForm").modal("hide");
                                } else {
                                    alert(data_1.msg);
                                }
                            },
                            error: function() {}
                        })
                    } else {
                        $("#deleteKey_openKey_info").html(data.msg);
                        $("#deleteKey_openKey_info").css("display", "block")
                    }
                },
                error: function() {}
            });
        }
    });
    //=== For Key Repository->share with user module ===
    // listen key operation[look/cancel share] click event
    $("#s_key_u_list").on("click", "a", function(e) {
        var that = $(this);
        if (that.hasClass("key_look")) {
            // look operation
            var index = that.data("index");
            if (that.children("i").hasClass("fa-eye")) {
                $("#modalLookKeyForm").data("index", index);
                $("#modalLookKeyForm").modal("show");
            } else {
                $("#s_key_u_list tr[data-index=" + index + "] td:nth-child(2)").html("******");
                $("#s_key_u_list a[data-index=" + index + "] i.fa-eye-slash").removeClass("fa-eye-slash").addClass("fa-eye");
            }
        } else if (that.hasClass("key_cancel_share")) {
            // cancel share operation
            var index = that.data("index");
            var kid = parseInt(that.attr("id"));
            $("#modalCancelShareForm").data("index", index);
            $("#modalCancelShareForm").data("kid", kid);
            $("#modalCancelShareForm").modal("show");
        } else {
            console.log("key operation can't be recognized.");
        }
    });

    // listen cancel_share_btn click event
    $("#cancel_share_btn").click(function() {
        // judge the cookie existence state
        if ($.cookie("nickname") == null) {
            window.location.href = "index.php";
        }
        // post a http request for cancel share
        var kid = $("#modalCancelShareForm").data("kid");
        var idx = parseInt($("#modalCancelShareForm").data("index"));
        var data = {
            "kid": kid
        };
        $.ajax({
            type: "post",
            url: "api/cancel_share_key_toUser.php",
            data: data,
            dataType: "json",
            success: function(data) {
                if (data.state == 1) {
                    alert("cancel share success");
                    // find and remove the key from the panel
                    $("#s_key_u_list tr[data-index=" + idx + "]").remove();
                    // Then close the modal
                    $("#modalCancelShareForm").modal("hide");
                } else {
                    alert(data.msg);
                }
            },
            error: function() {}
        })
    });

    //=== For Key From Others->receive from user module ===
    // listen key operation[look/cancel share] click event
    $("#key_f_u_list").on("click", "a", function(e) {
        var that = $(this);
        if (that.hasClass("key_look")) {
            // look operation
            var index = that.data("index");
            if (that.children("i").hasClass("fa-eye")) {
                $("#modalLookKeyForm").data("index", index);
                $("#modalLookKeyForm").modal("show");
            } else {
                $("#key_f_u_list tr[data-index=" + index + "] td:nth-child(2)").html("******");
                $("#key_f_u_list a[data-index=" + index + "] i.fa-eye-slash").removeClass("fa-eye-slash").addClass("fa-eye");
            }
        } else {
            console.log("key operation can't be recognized.");
        }
    });
})
