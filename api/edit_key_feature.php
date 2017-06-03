<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$kid=intval($_REQUEST['kid']);
    @$feature=$_REQUEST['feature'];
    // compare the feature with former one
    $sql="SELECT * FROM KeyInfo WHERE kid = $kid AND feature = '$feature';"; 
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) == 1){
      $data['msg'] = "the same as former";
      $data['state'] = 0;
    }else{
      $sql="UPDATE KeyInfo SET feature = '$feature' WHERE kid = $kid;";
      $result=mysqli_query($conn,$sql);
      if(mysqli_affected_rows($conn) == 1){
        $data['msg'] = "set feature success";
        $data['state'] = 1; 
        $data['feature'] = $feature;
      }else{
        $data['msg'] = "set feature fail";
        $data['state'] = 0;
      }
    }
    echo json_encode($data);    
?>