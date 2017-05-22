<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$nickname=$_REQUEST['nickname'];
    @$pwd=$_REQUEST['pwd'];
    $sql="INSERT INTO User (uid,nickname,pwd,masterKey) VALUES (NULL,'$nickname','$pwd','');";
    $result=mysqli_query($conn,$sql);
    if($result){
        $data['msg']='add user success';
        $data['state']=1;
    }else{
        $data['msg']='add user fail';
        $data['state']=0;
    }
    echo json_encode($data);    
?>