<?php

session_start();
include "db_conn.php";

if(isset ($_POST['uname']) && isset ($_POST['password'])){
    
    function validate($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

$uname = validate($_POST['uname']);
$pass = validate($_POST['password']);

if(empty($uname)){
    header("Location:sign_in.php?error=User Name is required.");
    exit();
}else if(empty($pass)){
    header("Location:sign_in.php?error=Password is required.");
    exit();
}else{

    $pass = md5($pass);
    
    $sql="SELECT* FROM profil WHERE user_name = '$uname' AND password='$pass'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        if($row['user_name'] === $uname && $row['password'] === $pass){
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
        header("Location:profile.php");
        exit();  
        }else {
            header("Location:sign_in.php?error=Incorrect User Name or Password.");
            exit();
        }  
          
        
    }else {
        header("Location:sign_in.php?error=Incorrect User Name or Password.");
        exit();
    }

}

}else{
    header("Location:sign_in.php");
    exit();
}