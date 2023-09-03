<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

if (isset($_POST['submit'])) {

   $name = filter_var($_POST['name'], FILTER_UNSAFE_RAW);
   $pws = filter_var(sha1($_POST['pass']), FILTER_UNSAFE_RAW);
   $cpws = filter_var(sha1($_POST['cpass']), FILTER_UNSAFE_RAW);
   $email = filter_var($_POST['email'], FILTER_UNSAFE_RAW);

   $check_name = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $check_name->execute([$email]);
   if ($check_name->rowCount() > 0) {
      $message[] = 'Email already exist!';
   } else {
      if ($pws != $cpws) {
         $message[] = 'confirm password not matched!';
      } else {
         $insert_admin = $conn->prepare("INSERT INTO `users` (name,email,password) VALUES (?,?,?)");
         $insert_admin->execute([$name,$email,$pws]);
         $message[] = 'registered successfully, login now please!';
         header('location:user_login.php');
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
         <h3>register now</h3>
         <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box">
         <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="register now" class="btn" name="submit">
         <p>already have an account?</p>
         <a href="user_login.php" class="option-btn">login now</a>
      </form>

   </section>













   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>