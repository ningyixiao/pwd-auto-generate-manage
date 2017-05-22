<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$nickname=$_REQUEST['nickname'];
    $sql="SELECT * FROM UserInfo WHERE nickname = '$nickname';";
    $result=mysqli_query($conn,$sql);
    if($result){
        $userInfo=mysqli_fetch_assoc($result);
        if($userInfo!==null){
            if(strcmp($userInfo["openKey"],"") == 0){
                $data['msg']='openKey not set yet';
                $data['checkState']=false;
            }else{
                $data['msg']='ok';
                $data['checkState']=true;
            }
        }else{
            $data['msg']='user not exist';
            $data['checkState']=false;
        }
    }else{
        $data['msg']='UserInfo table is empty';
        $data['checkState']=false;
    }
    echo json_encode($data);    
?>