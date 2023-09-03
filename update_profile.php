<?php

include "../components/connect.php";

session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

   $name = filter_var($_POST['name'],FILTER_UNSAFE_RAW);
   $empty_pws = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pws = $_POST['prev_pass'];
   $old_pws = filter_var(sha1($_POST['old_pass']),FILTER_UNSAFE_RAW);
   $new_pws = filter_var(sha1($_POST['new_pass']),FILTER_UNSAFE_RAW);
   $confirm_pws = filter_var(sha1($_POST['confirm_pass']),FILTER_UNSAFE_RAW);

   if($prev_pws != $old_pws){
      $message[] = 'please enter old password!';
   }else if($new_pws != $confirm_pws){
      $message[] = 'confirm password not matched!';
   }else{
      if($new_pws != $empty_pws){
         $insert = $conn->prepare("UPDATE `admins` SET name = ? , password = ? WHERE id = ?");
         $insert->execute([$name,$new_pws,$admin_id]);
         $message[] = 'Profile updated successfully!';
      }else{
         $message[] = 'Please enter a new password!';
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
   <title>update profile</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>update profile</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
      <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="old_pass" placeholder="enter old password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="enter new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="confirm new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="update now" class="btn" name="submit">
   </form>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>