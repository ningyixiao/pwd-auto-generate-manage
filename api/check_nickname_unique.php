<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$nickname=$_REQUEST['nickname'];
    $sql="SELECT * FROM User WHERE nickname = '$nickname';";
    $result=mysqli_query($conn,$sql);
    if($result){
        $name=mysqli_fetch_assoc($result);
        if($name!==null){
            $data['msg']='ok';
            $data['checkState']=false;
        }else{
            $data['msg']='ok';
            $data['checkState']=true;
        }
    }else{
        $data['msg']='user is empty';
        $data['checkState']=true;
    }
    echo json_encode($data);    
?>