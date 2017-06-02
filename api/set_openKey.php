<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$nickname=$_REQUEST['nickname'];
    @$openKey=$_REQUEST['openKey'];
    $sql="UPDATE UserInfo SET openKey = '$openKey' WHERE nickname = '$nickname';";
    $result=mysqli_query($conn,$sql);
    if(mysqli_affected_rows($conn) == 1){
       $data['msg'] = "set openKey success";
       $data['state'] = 1; 
    }else{
       $data['msg'] = "set openKey fail";
       $data['state'] = 0;
    }
    echo json_encode($data);    
?>