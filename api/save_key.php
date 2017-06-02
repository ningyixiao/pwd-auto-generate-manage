<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$creator=$_REQUEST['creator'];
    @$feature=$_REQUEST['feature'];
    @$genKey=$_REQUEST['genKey'];
    @$shareState=$_REQUEST['shareState'];
    // find feature exist
    $sql = "SELECT * FROM KeyInfo WHERE creator = '$creator' AND feature = '$feature';";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) == 0){
        $sql="INSERT INTO KeyInfo (kid,creator,feature,genKey,shareState,uKey,gKey,targetUser,targetGroup) VALUES (NULL,'$creator','$feature','$genKey','$shareState',NULL,NULL,NULL,NULL);";
        $result=mysqli_query($conn,$sql);
        if(mysqli_affected_rows($conn) == 1){
            $data["msg"] = "save success"; 
            $data["state"] = 1; 
        }else{
            $data["msg"] = "save fail"; 
            $data["state"] = 0;
        }
    }else{
       $data["msg"] = "The description of key already exists.";
       $data["state"] = 0; 
    }
    echo json_encode($data);    
?>