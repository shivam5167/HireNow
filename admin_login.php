<?php

include("../components/connect.php");
session_start();

if(isset($admin_id)){
   header('location:dashboard.php');
}

if (isset($_POST["submit"])) {

   $name = filter_var($_POST['name'], FILTER_UNSAFE_RAW);
   $pws = filter_var(sha1($_POST['pass']), FILTER_UNSAFE_RAW);

   $sql = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $sql->execute([$name, $pws]);
   $row = $sql->fetch(PDO::FETCH_ASSOC);
   if ($sql->rowCount() > 0) {
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard.php');
   } else {
      $message[] = 'Incorrect username or password!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   ?>

   <section class="form-container">

      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
         <h3>login now</h3>
         <p>default username = <span>admin</span> & password = <span>111</span></p>
         <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="login now" class="btn" name="submit">
      </form>

   </section>

</body>

</html>