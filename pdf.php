<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View PDFs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- custom css file link  -->


    <style>
    .header{
        background-color: purple;
        text-decoration: none;
    }

.header .header-2.active{
   position: fixed;
   top:0; left:0; right:0;
   z-index: 1000;
}

.header .header-2 .flex{
    color: white;
   padding:2rem;
   display: flex;
   align-items: center;
   justify-content: space-between;
   max-width: 1200px;
   margin:0 auto;
   position: relative;
}
.header .header-2 .flex .logo{
   font-size: 2.5rem;
   color:var(--purple);
   text-decoration: none;
}

.header .header-2 .flex .navbar a{
   margin:0 1rem;
   font-size: 1rem;
   color:var(--light-white);
   text-transform: uppercase;
   text-decoration: none;
}

.header .header-2 .flex .navbar a:hover{
   color:var(--purple);
   text-decoration: underline;
}

.header .header-2 .flex .icons > *{
   font-size: 2.5rem;
   color:var(--white);
   cursor: pointer;
   margin-left: 1.5rem;
}

.header .header-2 .flex .icons > *:hover{
   color:var(--purple);
}
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-gap: 30px;
            width: 100px;align-self: center;
        }
        .pdf-item {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .pdfsection{
            text-align: center;
        }
    </style>
</head>
<body>
<header class="header">
   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">Book Dhuniya</a>

         <nav class="navbar">
            <a href="home.php">home</a>
            <a href="about.php">about</a>
            <a href="shop.php">shop</a>
            <a href="contact.php">contact</a>
            <a href="orders.php">orders</a>
            <a href="pdf.php">ebooks</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
          
         </div>

         
      </div>
   </div>

</header>
<section class="pdfsection">
    <h1>View PDFs</h1>
    <div class="grid-container">
        <?php
        include 'config.php';
        // Fetch PDFs from the database
        $fetch_pdfs_query = mysqli_query($conn, "SELECT id, name, price FROM `ebooks`") or die('query failed');
        if(mysqli_num_rows($fetch_pdfs_query) > 0) {
            while($row = mysqli_fetch_assoc($fetch_pdfs_query)) {
                echo "<div class='pdf-item'>";
                echo "<h3>{$row['name']}</h3>";
                echo "<p>Price: ₹{$row['price']}</p>";
                echo "<p><a href='view_pdf.php?id={$row['id']}'>View</a> | <a href='download_pdf.php?id={$row['id']}'>Download</a></p>";
                echo "</div>";
            }
        } else {
            echo "<p>No PDFs available.</p>";
        }
        ?>
    </div>
</section>
</body>
</html>

