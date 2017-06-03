<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$nickname=$_REQUEST['nickname'];
    @$openKey=$_REQUEST['openKey'];
    $sql="SELECT * FROM UserInfo WHERE nickname = '$nickname';";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) == 1){
        $row=mysqli_fetch_assoc($result);
        if(strcmp($row["openKey"],$openKey) == 0){
            $data['msg']='openKey correct';
            $data['state']=1;
            $data['openKey'] = $openKey;
        }else{
            $data['msg']='openKey incorrect';
            $data['state']=0;
        }
    }else{
        $data['msg']='user not exist';
        $data['state']=0;
    }
    echo json_encode($data);    
?>