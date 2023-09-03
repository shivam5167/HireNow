<?php
  //checking user pressed add to cart button
  if(isset($_POST['add_to_cart'])){
    //checking user has login to it.
    if($user_id == ''){
      header("location:user_login.php");
    }else{
      $pid = filter_var($_POST['pid'], FILTER_UNSAFE_RAW);
      $name = filter_var($_POST['name'], FILTER_UNSAFE_RAW);
      $price= filter_var($_POST['price'], FILTER_UNSAFE_RAW);
      $image = filter_var($_POST['image'], FILTER_UNSAFE_RAW);
      $qty = filter_var($_POST['qty'], FILTER_UNSAFE_RAW);

      //checking product exist in User cart
      $check_product_cart = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_product_cart->execute([$name,$user_id]);
      if($check_product_cart->rowCount() > 0){
        $message[] = 'Already added to cart!';
      }else{
        //now checking that product is in wishlist and from there the user has added to cart
        $check_product_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
        $check_product_wishlist->execute([$name,$user_id]);

        //if it exist in wishlist then we will delete that product form wishlist and add to cart
        if($check_product_wishlist->rowCount() > 0){
          $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
          $delete_wishlist->execute([$name,$user_id]);
        }

        $insert_into_cart = $conn->prepare("INSERT INTO `cart` (user_id, pid, name, price, quantity, image) VALUES (?,?,?,?,?,?)");
        $insert_into_cart->execute([$user_id,$pid,$name,$price,$qty,$image]);
        $message[] = 'added to cart!';
      }
    }

  }

  if(isset($_POST['add_to_wishlist'])){

    if($user_id == ''){
      header("location:user_login.php");
    }else{

      $pid = filter_var($_POST['pid'], FILTER_UNSAFE_RAW);
      $name = filter_var($_POST['name'], FILTER_UNSAFE_RAW);
      $price= filter_var($_POST['price'], FILTER_UNSAFE_RAW);
      $image = filter_var($_POST['image'], FILTER_UNSAFE_RAW);

      //checking if it exist in wishlist or not if so then a message will displayed in wishlist
      $check_product_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_product_wishlist->execute([$name,$user_id]);
      if($check_product_wishlist->rowCount() > 0){
        $message[] = 'Already added to wishlist!';
      }else{
        $insert_into_wishlist = $conn->prepare("INSERT INTO `wishlist` (user_id,pid,name,price,image) VALUES (?,?,?,?,?)");
        $insert_into_wishlist->execute([$user_id,$pid,$name,$price,$image]);
        $message[] = "Added to wishlist";
      }

    }


  }
