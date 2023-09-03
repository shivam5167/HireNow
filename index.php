<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>home</title>

  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <?php include 'components/user_header.php'; ?>

  <div class="home-bg">

    <section class="home">

      <div class="swiper home-slider">

        <div class="swiper-wrapper">

          <div class="swiper-slide slide">
            <div class="image">
              <img src="images/p10.png" alt="">
            </div>
            <div class="content">
              <span>upto 50% off</span>
              <h3>Available in your area</h3>
              <a href="shop.php" class="btn">Book now</a>
            </div>
          </div>

          <div class="swiper-slide slide">
            <div class="image">
              <img src="images/m2.png" alt="">
            </div>
            <div class="content">
              <span>upto 50% off</span>
              <h3>Available in your area</h3>
              <a href="shop.php" class="btn">Book now</a>
            </div>
          </div>

          <div class="swiper-slide slide">
            <div class="image">
              <img src="images/m1.jpg" alt="">
            </div>
            <div class="content">
              <span>upto 50% off</span>
              <h3>Available in your area</h3>
              <a href="shop.php" class="btn">Book now</a>
            </div>
          </div>

        </div>

        <div class="swiper-pagination"></div>

      </div>

    </section>

  </div>

  <section class="category">
    <h1 class="heading">Book by category</h1>
    <div class="swiper category-slider">
      <div class="swiper-wrapper">
        <a href="category.php?category=laptop" class="swiper-slide slide">
          <img src="images/p1.png" alt="">
          <h3>Plumber</h3>
        </a>
        <a href="category.php?category=tv" class="swiper-slide slide">
          <img src="images/p2.png" alt="">
          <h3>Mechanic</h3>
        </a>
        <a href="category.php?category=camera" class="swiper-slide slide">
          <img src="images/p4.png" alt="">
          <h3>Electrician</h3>
        </a>
        <a href="category.php?category=mouse" class="swiper-slide slide">
          <img src="images/p5.png" alt="">
          <h3>Carpenter</h3>
        </a>
        <a href="category.php?category=fridge" class="swiper-slide slide">
          <img src="images/p6.png" alt="">
          <h3>Electrician</h3>
        </a>
        <a href="category.php?category=washing" class="swiper-slide slide">
          <img src="images/p7.png" alt="">
          <h3>Painter</h3>
        </a>
        <a href="category.php?category=smartphone" class="swiper-slide slide">
          <img src="images/p8.png" alt="">
          <h3>Designer</h3>
        </a>
        <a href="category.php?category=watch" class="swiper-slide slide">
          <img src="images/p9.png" alt="">
          <h3>cleaner</h3>
        </a>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </section>

  <section class="home-products">
    <h1 class="heading">latest service</h1>
    <div class="wrapper">
      <?php
      $limit = 9;
      if (isset($_GET['page'])) {
        $page = $_GET['page'];
      } else {
        $page = 1;
      }
      $offset = ($page - 1) * $limit;
      $query = $conn->prepare("SELECT * FROM `products` ORDER BY id DESC LIMIT {$offset},{$limit}");
      $query->execute();
      if ($query->rowCount() > 0) {
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <form action="" method="post" class="slide">
            <input type="hidden" name="pid" value="<?= $row['id']; ?>">
            <input type="hidden" name="name" value="<?= $row['name']; ?>">
            <input type="hidden" name="price" value="<?= $row['price']; ?>">
            <input type="hidden" name="image" value="<?= $row['image_01']; ?>">
            <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
            <a href="quick_view.php?pid=<?= $row['id']; ?>" class="fas fa-eye"></a>
            <img src="uploaded_img/<?= $row['image_01']; ?>" alt="">
            <div class="name"><?= $row['name']; ?></div>
            <div class="flex">
              <div class="price"><span>₹</span><?= $row['price']; ?><span>/-</span></div>
              <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
            </div>
            <input type="submit" value="add to cart" class="btn" name="add_to_cart">
          </form>
      <?php
        }
      } else {
        echo '<p class="empty">no products added yet!</p>';
      }
      ?>
    </div>
    <div class="page-num">
      <?php
      $sql = $conn->prepare("SELECT * FROM `products`");
      $sql->execute();
      if ($sql->rowCount() > 0) {
        $total_row = $sql->rowCount();
        $total_page = ceil($total_row / $limit);
        if ($page > 1) echo '<a href="index.php?page=' . ($page - 1) . '"><button class="fa-solid fa-backward"></button></a>';
        echo '<ul>';
        for ($i = 1; $i <= $total_page; $i++) {
          if ($page == $i) $active = "active";
          else $active = '';
          echo '<li><a class="' . $active . '" href="index.php?page=' . $i . '">' . $i . '</a></li>';
        }
        echo '</ul>';
        if ($page < $total_page) echo '<a href="index.php?page=' . ($page + 1) . '"><button class="fa-solid fa-forward"></button></a>';
      }
      ?>
    </div>
  </section>


  <?php include 'components/footer.php'; ?>

  <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

  <script src="js/script.js"></script>

  <script>
    var swiper = new Swiper(".home-slider", {
      loop: true,
      spaceBetween: 20,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });

    var swiper = new Swiper(".category-slider", {
      loop: true,
      spaceBetween: 20,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        0: {
          slidesPerView: 2,
        },
        650: {
          slidesPerView: 3,
        },
        768: {
          slidesPerView: 4,
        },
        1024: {
          slidesPerView: 5,
        },
      },
    });

    var swiper = new Swiper(".products-slider", {
      loop: true,
      spaceBetween: 20,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        550: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
      },
    });
  </script>

</body>

</html>