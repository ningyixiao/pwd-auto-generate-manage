<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$kid=intval($_REQUEST['kid']);
    @$shareState = 2; //share key to user is 2
    @$targetUser=$_REQUEST['targetUser'];
    @$uKey=$_REQUEST['uKey'];
    // judge the key has shared with others
    $sql="SELECT targetUser FROM KeyInfo WHERE kid = $kid;";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) == 1){
      $row=mysqli_fetch_assoc($result);
      if($row['targetUser'] == null){
          $sql="UPDATE KeyInfo SET shareState=$shareState,targetUser='$targetUser',uKey='$uKey' WHERE kid = $kid;";
          $result=mysqli_query($conn,$sql);
          if(mysqli_affected_rows($conn) == 1){
            $data['msg'] = "share key success";
            $data['state'] = 1; 
          }else{
            $data['msg'] = "share key fail";
            $data['state'] = 0;
          }
      }else{
          $data['msg'] = "key shares with others";
          $data['state'] = 0;
      }
    }else{
      $data['msg'] = "share key not exists";
      $data['state'] = 0;
    }
    
    echo json_encode($data);    
?>