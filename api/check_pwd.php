<?php
    header("Content-type:application/json;charset=utf-8");
    require('init_0.php');
    @$nickname=$_REQUEST['nickname'];
    @$pwd=$_REQUEST['pwd'];
    $sql="SELECT * FROM UserInfo WHERE nickname = '$nickname';";
    $result=mysqli_query($conn,$sql);
    if($result->num_rows > 0){
        while($row = mysqli_fetch_assoc($result)){
            if(strcmp($pwd,$row['pwd']) == 0){
                $data['msg']='password correct';
                $data['state']=1;
            }else{
                $data['msg']='password incorrect';
                $data['state']=2;
            }
        }
    }else{
        $data['msg']='nickname not exist';
        $data['state']=0;
    }
    echo json_encode($data);    
?>