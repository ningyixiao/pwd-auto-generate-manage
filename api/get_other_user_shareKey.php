<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$targetUser=$_REQUEST['targetUser'];
    $sql="SELECT kid,creator,feature,uKey FROM KeyInfo WHERE targetUser = '$targetUser';";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
        while($row=mysqli_fetch_assoc($result)){
            $keyList[] = $row;
        }
        $data["keyList"] = $keyList;
        $data['msg']="get other user shared key success";
        $data['state']=1;
    }else{
        $data['msg']="No key.";
        $data['state']=0;
    }
    echo json_encode($data);    
?>