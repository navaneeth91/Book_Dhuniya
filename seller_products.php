<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

function reconnect($conn) {
    // Check and reconnect if necessary
    if (!mysqli_ping($conn)) {
        mysqli_close($conn);
        include 'config.php'; // Reconnect by re-including the config
    }
}

if (isset($_POST['add_product'])) {
    reconnect($conn);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $price = $_POST['price'];
    $condition = $_POST['condition'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $select_product_name = $conn->prepare("SELECT name FROM `products` WHERE name = ?");
    $select_product_name->bind_param("s", $name);
    $select_product_name->execute();
    $select_product_name->store_result();

    if ($select_product_name->num_rows > 0) {
        $message[] = 'Product name already added';
    } else {
        $add_product_query = $conn->prepare("INSERT INTO `products` (name, author, price, `condition`, image) VALUES (?, ?, ?, ?, ?)");
        $add_product_query->bind_param("ssdss", $name, $author, $price, $condition, $image);

        if ($add_product_query->execute()) {
            if ($image_size > 2000000) {
                $message[] = 'Image size is too large';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Product added successfully!';
            }
        } else {
            $message[] = 'Product could not be added!';
            error_log('Product insert error: ' . $add_product_query->error);
        }
    }
}

if (isset($_POST['add_ebook'])) {
    reconnect($conn);
    $ebook_name = mysqli_real_escape_string($conn, $_POST['ebook_name']);
    $ebook_author = mysqli_real_escape_string($conn, $_POST['ebook_author']);
    $ebook_price = $_POST['ebook_price'];
    $pdf = $_FILES['pdf']['name'];
    $pdf_tmp_name = $_FILES['pdf']['tmp_name'];
    $pdf_folder = 'uploaded_img/' . $pdf;

    $select_ebook_name = $conn->prepare("SELECT name FROM `ebooks` WHERE name = ?");
    $select_ebook_name->bind_param("s", $ebook_name);
    $select_ebook_name->execute();
    $select_ebook_name->store_result();

    if ($select_ebook_name->num_rows > 0) {
        $message[] = 'eBook name already added';
    } else {
        if (move_uploaded_file($pdf_tmp_name, $pdf_folder)) {
            $add_ebook_query = $conn->prepare("INSERT INTO `ebooks` (name, author, price, pdf_path) VALUES (?, ?, ?, ?)");
            $add_ebook_query->bind_param("ssds", $ebook_name, $ebook_author, $ebook_price, $pdf);

            if ($add_ebook_query->execute()) {
                $message[] = 'eBook added successfully!';
            } else {
                $message[] = 'Failed to add eBook!';
                error_log('eBook insert error: ' . $add_ebook_query->error);
            }
        } else {
            $message[] = 'Failed to upload eBook!';
        }
    }
}

if (isset($_GET['delete'])) {
    reconnect($conn);
    $delete_id = $_GET['delete'];
    $delete_image_query = $conn->prepare("SELECT image FROM `products` WHERE id = ?");
    $delete_image_query->bind_param("i", $delete_id);
    $delete_image_query->execute();
    $delete_image_query->store_result();
    $delete_image_query->bind_result($image);
    $delete_image_query->fetch();

    if ($delete_image_query->num_rows > 0) {
        unlink('uploaded_img/' . $image);
    }

    $delete_product_query = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product_query->bind_param("i", $delete_id);
    $delete_product_query->execute();
    header('location:seller_products.php');
    exit();
}

if (isset($_POST['update_product'])) {
    reconnect($conn);
    $update_p_id = $_POST['update_p_id'];
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_price = $_POST['update_price'];

    $update_product_query = $conn->prepare("UPDATE `products` SET name = ?, price = ? WHERE id = ?");
    $update_product_query->bind_param("sdi", $update_name, $update_price, $update_p_id);
    $update_product_query->execute();

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/' . $update_image;
    $update_old_image = $_POST['update_old_image'];

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Image file size is too large';
        } else {
            $update_image_query = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
            $update_image_query->bind_param("si", $update_image, $update_p_id);
            $update_image_query->execute();
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('uploaded_img/' . $update_old_image);
        }
    }

    header('location:seller_products.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>

<?php include 'seller_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

    <h1 class="title">SELL BOOKS</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Add Physical Book</h3>
        <input type="text" name="name" class="box" placeholder="Enter book name" required>
        <input type="text" name="author" class="box" placeholder="Enter author name" required>
        <input type="number" min="0" name="price" class="box" placeholder="Enter book price" required>
        <select name="condition" class="box" required>
            <option value="">Select Condition</option>
            <option value="good">Good</option>
            <option value="fair">Normal</option>
            <option value="old">Old</option>
        </select>
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
        <input type="submit" value="Sell Book" name="add_product" class="btn">
    </form>

    <form action="" method="post" enctype="multipart/form-data">
        <h3>Add Ebook</h3>
        <input type="text" name="ebook_name" class="box" placeholder="Enter ebook name" required>
        <input type="text" name="ebook_author" class="box" placeholder="Enter author name" required>
        <input type="number" min="0" name="ebook_price" class="box" placeholder="Enter ebook price" required>
        <input type="file" name="pdf" accept=".pdf" class="box" required>
        <input type="submit" value="Sell Ebook" name="add_ebook" class="btn">
    </form>
</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

    <div class="box-container">

        <?php
        reconnect($conn);
        $select_products = $conn->query("SELECT * FROM `products`");
        if ($select_products->num_rows > 0) {
            while ($fetch_products = $select_products->fetch_assoc()) {
                ?>
                <div class="box">
                    <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                    <div class="name"><?php echo $fetch_products['name']; ?></div>
                    <div class="author">Author: <?php echo $fetch_products['author']; ?></div>
                    <div class="price">₹<?php echo $fetch_products['price']; ?>/-</div>
                    <div class="condition">Condition: <?php echo ucfirst($fetch_products['condition']); ?></div>
                    <a href="seller_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Update</a>
                    <a href="seller_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">No products added yet!</p>';
        }
        ?>
    </div>

</section>

<section class="edit-product-form">

    <?php
    if (isset($_GET['update'])) {
        reconnect($conn);
        $update_id = $_GET['update'];
        $update_query = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $update_query->bind_param("i", $update_id);
        $update_query->execute();
        $result = $update_query->get_result();
        if ($result->num_rows > 0) {
            while ($fetch_update = $result->fetch_assoc()) {
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
                    <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
                    <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
                    <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Enter product name">
                    <input type="text" name="update_author" value="<?php echo $fetch_update['author']; ?>" class="box" required placeholder="Enter author name">
                    <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Enter product price">
                    <select name="update_condition" class="box" required>
                        <option value="">Select Condition</option>
                        <option value="good" <?php if ($fetch_update['condition'] == 'good') echo 'selected'; ?>>Good</option>
                        <option value="fair" <?php if ($fetch_update['condition'] == 'fair') echo 'selected'; ?>>Fair</option>
                        <option value="old" <?php if ($fetch_update['condition'] == 'old') echo 'selected'; ?>>Old</option>
                    </select>
                    <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                    <input type="submit" value="Update" name="update_product" class="btn">
                    <input type="reset" value="Cancel" id="close-update" class="option-btn">
                </form>
                <?php
            }
        }
    } else {
        echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
    }
    ?>

</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
