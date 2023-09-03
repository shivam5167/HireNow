<?php

include "../components/connect.php";

session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

   $name = filter_var($_POST['name'],FILTER_UNSAFE_RAW);
   $pws = filter_var(sha1($_POST['pass']),FILTER_UNSAFE_RAW);
   $cpws = filter_var(sha1($_POST['cpass']),FILTER_UNSAFE_RAW);

   $check_name = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
   $check_name->execute([$name]);
   // $row = $check_name->rowCount();
   if($check_name->rowCount() > 0){
      $message[] = 'username already exist!';
   }else{
      if($pws != $cpws){
         $message[] = 'confirm password not matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admins` (name,password) VALUES (?,?)");
         $insert_admin->execute([$name,$pws]);
         $message[] = 'new admin registered successfully!';
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register admin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" class="btn" name="submit">
   </form>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>