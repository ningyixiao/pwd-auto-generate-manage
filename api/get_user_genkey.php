<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$creator=$_REQUEST['creator'];
    @$shareState=intval($_REQUEST['shareState']);
    $sql="SELECT * FROM KeyInfo WHERE creator = '$creator' AND shareState = $shareState;";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
        while($row=mysqli_fetch_assoc($result)){
            $keyList[] = $row;
        }
        $data["keyList"] = $keyList;
        $data['msg']="get user key success";
        $data['state']=1;
    }else{
        $data['msg']="No private key, please save one.";
        $data['state']=0;
    }
    echo json_encode($data);    
?>