<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$nickname=$_REQUEST['nickname'];
    $sql="SELECT openKey FROM UserInfo WHERE nickname = '$nickname';";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) == 1){
        $userInfo=mysqli_fetch_assoc($result);
        $data["openKey"] = $userInfo["openKey"];
        $data['msg']="get openKey success";
        $data['state']=1;
    }else{
        $data['msg']="get openKey fail";
        $data['detail']="user not exist";
        $data['state']=0;
    }
    echo json_encode($data);    
?>