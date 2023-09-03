<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){
   $name = filter_var($_POST['name'],FILTER_UNSAFE_RAW);
   $email = filter_var($_POST['email'],FILTER_UNSAFE_RAW);
   $empty_pws = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pws = $_POST['prev_pass'];
   $old_pws = filter_var(sha1($_POST['old_pass']),FILTER_UNSAFE_RAW);
   $new_pws = filter_var(sha1($_POST['new_pass']),FILTER_UNSAFE_RAW);
   $confirm_pws = filter_var(sha1($_POST['cpass']),FILTER_UNSAFE_RAW);

   if($prev_pws != $old_pws){
      $message[] = 'Old password may be incorrect.';
   }else if($new_pws != $confirm_pws){
      $message[] = 'confirm password not matched!';
   }else{
      if($new_pws != $empty_pws){
         $insert = $conn->prepare("UPDATE `users` SET name = ? , email = ?, password = ? WHERE id = ?");
         $insert->execute([$name,$email,$new_pws,$user_id]);
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
   <title>register</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>update now</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
      <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" value="<?= $fetch_profile["name"]; ?>">
      <input type="email" name="email" required placeholder="enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>">
      <input type="password" name="old_pass" placeholder="enter your old password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="enter your new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" placeholder="confirm your new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="update now" class="btn" name="submit">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>