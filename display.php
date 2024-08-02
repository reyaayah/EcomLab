<?php

/*
CREATE TABLE `cart` (
  `id` int(11) primary key AUTO_INCREMENT NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `image` varchar(2000) DEFAULT NULL,
  `quantity` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `wishlist` (
  `id` int(11) primary key AUTO_INCREMENT NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `image` varchar(2000) DEFAULT NULL,
  `quantity` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
*/ 

@include 'config.php';
if(isset($_POST['add_to_cart'])){
   $product_name=$_POST['product_name'];
   $product_price=$_POST['product_price'];
   $product_image=$_POST['product_image'];
   $product_quantity=1;
   $select_cart=mysqli_query($conn,"SELECT * FROM cart where name='$product_name'");

   if(mysqli_num_rows($select_cart)>0){
      $message[]="Products already added to cart";
   }
   else{
      $insert_product=mysqli_query($conn,"INSERT INTO  cart(name,price,image,quantity) VALUES('$product_name','$product_price','$product_image','$product_quantity')");
      $message[]="Products added succcessfullly to cart";
   }
}
if(isset($_POST['add_to_wishlist'])){
   $product_name=$_POST['product_name'];
   $product_price=$_POST['product_price'];
   $product_image=$_POST['product_image'];
   $product_quantity=1;
   $select_wishlist=mysqli_query($conn,"SELECT * FROM wishlist where name='$product_name'");

   if(mysqli_num_rows($select_wishlist)>0){
      $message[]="Products already added to wishlist";
   }
   else{
      $insert_product=mysqli_query($conn,"INSERT INTO wishlist(name,price,image,quantity) values('$product_name','$product_price','$product_image','$product_quantity')");
      $message[]="Products added succcessfullly to wishlist";
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
</head>

<style>
  header {
   background-color:var(--blue);
   color: white;
   text-align: center;
   padding: 2rem;
   position: relative;
}
   .action-links{
      display: flex;
      justify-content: space-between;
   }
   .bttn{
      background-color: #4CAF50; /* Green background */
      border: none; /* Remove border */
      color: white; /* White text */
      padding: 15px 32px; /* Some padding */
      text-align: center; /* Centered text */
      text-decoration: none; /* Remove underline */
      font-size: 16px; /* Increase font size */
      cursor: pointer; /* Pointer/hand icon */
      border-radius: 8px; /* Rounded corners */
      flex: 1; /* Flex-grow to make all buttons same width */
      margin: 4px;
   }
   .bttn:hover{
      background-color:black;
   }
   .logo {
            display: inline-block;
            width: 100px;
            height: 100px;
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
        }

        .logo img {
            width: 100%;
            height: auto;
        }
</style>

<body>
<header>
    <img class="logo" src="bbliss.png" alt="BagBliss" ALIGN=left>
    <h1 class="heading">BAGBLISS</h1>
    </header>
<div class="action-links">
<a href="http://localhost:8080/riyaawal/ecom/index.php" class="bttn">Add product</a>
<a href="http://localhost:8080/riyaawal/ecom/wishlist.php" class="bttn">Wishlist</a>
<a href="http://localhost:8080/riyaawal/ecom/cart.php" class="bttn">Cart</a>
</div>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.
      '</span> <i class="fas fa-times" 
      onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};
?>
<div class="container">
<section class="products">
   <h1 class="heading">latest products</h1>
   <div class="box-container">
      <?php
        $select_product = mysqli_query($conn,"SELECT * from products");
        if(mysqli_num_rows($select_product)>0){
            while($fetch_product = mysqli_fetch_assoc($select_product)){

      ?>
      <form action="" method="post">
         <div class="box">
            <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
            <h3><?php echo $fetch_product['name']; ?></h3>
            <div class="price">Rs.<?php echo $fetch_product['price']; ?>/-</div>
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <input type="submit" class="btn" value="add to cart" name="add_to_cart">
            <input type="submit" class="btn" value="add to wishlist" name="add_to_wishlist">
         </div>
      </form>
      <?php
            }
        }

      ?>
   </div>
</section>
</div>