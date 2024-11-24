<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
   <p> <a href="home.php">home</a> / about </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="https://i.ibb.co/9gLpJG0/Whats-App-Image-2024-05-02-at-06-54-24-dd5ca9dd.jpg alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p> Book Dhuniya is a  convenient platform for users to
             buy and sell pre-owned books. We offer a wide selection of titles at discounted prices,
            making it easy for book lovers to find affordable reads while also allowing individuals to declutter their 
            bookshelves and earn some extra cash by selling their used books. Users can browse through various genres, authors, and editions, making it easy to find both popular titles and rare finds. Overall, Bookdhuniya facilitate the exchange of books, fostering a
              sustainable and cost-effective way to enjoy reading..</p>
         
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">Users reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="https://i.ibb.co/CBDy0LM/navaneeth-2.jpg" alt="">
         <p>"Bookdhuniya is a reader's paradise! I've found some amazing deals on used books here. It's like a treasure hunt every time I browse through their listings."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Navaneeth</h3>
      </div>

      <div class="box">
         <img src="https://i.ibb.co/5jhM1LM/Whats-App-Image-2024-04-19-at-21-04-17-bf92ee03.jpg">
         <p>"I've been using Bookdhuniya for a few months now, and I'm impressed with the variety of books available. From classics to contemporary bestsellers, there's something for every reader.".</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Nithin</h3>
      </div>

      <div class="box">
         <img src="https://i.ibb.co/88jSn9t/Whats-App-Image-2024-05-02-at-22-32-05-7349f8f1.jpg" alt="">
         <p>"Book Dhuniya is a fantastic platform for book lovers! I've been able to find some amazing used books at incredibly low prices. It's like a treasure trove for book enthusiasts!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Ashwanth</h3>
      </div>

      <div class="box">
         <img src="https://cdn-icons-png.freepik.com/512/3135/3135789.png" alt="">
         <p>"As a student on a budget, Book Dhuniya has been a lifesaver for me. I've been able to buy all the required textbooks for my courses without breaking the bank. Thank you, Book Dhuniya!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Arun kumar</h3>
      </div>

      <div class="box">
         <img src="https://cdn-icons-png.freepik.com/512/3135/3135789.png" alt="">
         <p>"Book Dhuniya offers a seamless buying and selling experience. I've sold some of my old books here and managed to make some extra money. It's a great platform for book enthusiasts!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Sameer reddy</h3>
      </div>

      <div class="box">
         <img src="https://cdn-icons-png.freepik.com/512/11820/11820363.png" alt="">
         <p>"I've been a loyal customer of Book Dhuniya for years now. The quality of the used books is always top-notch, and the prices are unbeatable. Highly recommend giving it a try!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Sachin</h3>
      </div>

   </div>

</section>
<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>