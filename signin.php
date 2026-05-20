<?php
     // Data base connection
     require('config/database.php');

     // Get data from login form
     $e_mail = $_POST['email'];
     $p_asswd = $_POST['pswd'];
     $enc_pass = md5($p_asswd);

     // Query 
     $sql_login = "
         select
             u.*
         from
             users u
         where
             u.email = '$e_mail' and
             u.password = '$enc_pass'
     ";

     // Execute query
     $res = pg_query($sql_login);

     if($res){
         $num = pg_num_rows($res);
         if($num > 0){
            header('refresh:0;url=index.html');
         }else{
            echo "<script>alert('Email or password nor found')</script>";
            header('refresh:0;url=login.html');
         }
     }else{
        echo "Query error !!!";
     }
?>