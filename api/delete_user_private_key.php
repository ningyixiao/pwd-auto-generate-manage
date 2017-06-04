<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$kid=intval($_REQUEST['kid']);
    $sql="DELETE FROM KeyInfo WHERE kid = $kid;";
    $result=mysqli_query($conn,$sql);
    if(mysqli_affected_rows($conn) == 1){
        $data['msg']='delete key success';
        $data['state']=1;
    }else{
        $data['msg']='delete key fail';
        $data['state']=0;
    }
    echo json_encode($data);    
?>