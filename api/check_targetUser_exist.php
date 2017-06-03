<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$nickname=$_REQUEST['targetUser'];
    $sql="SELECT * FROM UserInfo WHERE nickname = '$nickname';";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $data['openKey'] = $row['openKey'];
        $data['msg']='targetUser exists';
        $data['state']=1;
    }else{
        $data['msg']='targetUser not exists';
        $data['state']=0;
    }
    echo json_encode($data);    
?>