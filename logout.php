<?php 
    setcookie("token","",time()-1,"/");
    setcookie("nickname","",time()-1,"/");
    $url="index.php"; 
    echo "<script>"; 
    echo "location.href='$url'"; 
    echo "</script>"; 
 ?>