<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$kid=intval($_REQUEST['kid']);
    @$shareState = 1; //cancel share, then the value is 1
    @$targetUser = NULL; 
    @$uKey = NULL; 
    $sql="SELECT * FROM KeyInfo WHERE kid = $kid;";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) == 1){
      $row=mysqli_fetch_assoc($result);
      if($row['targetUser'] !== null){
          $sql="UPDATE KeyInfo SET shareState=$shareState,targetUser='$targetUser',uKey='$uKey' WHERE kid = $kid;";
          $result=mysqli_query($conn,$sql);
          if(mysqli_affected_rows($conn) == 1){
            $data['msg'] = "cancel share success";
            $data['state'] = 1; 
          }else{
            $data['msg'] = "cancel share fail";
            $data['state'] = 0;
          }
      }else{
          $data['msg'] = "key is not shared";
          $data['state'] = 0;
      }
    }else{
      $data['msg'] = "share key not exists";
      $data['state'] = 0;
    }
    
    echo json_encode($data);    
?>