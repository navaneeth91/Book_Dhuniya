<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View PDF</title>
</head>
<body>
   <div style="width: 100%; height: 100vh;">
      <?php
         include 'config.php';

         // Check if ID parameter is set and numeric
         if(isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];

            // Fetch PDF details from the database
            $fetch_pdf_query = mysqli_prepare($conn, "SELECT name, pdf_content FROM `ebooks` WHERE id = ?");
            mysqli_stmt_bind_param($fetch_pdf_query, 'i', $id);
            mysqli_stmt_execute($fetch_pdf_query);
            mysqli_stmt_store_result($fetch_pdf_query);

            // Check if PDF with the given ID exists
            if(mysqli_stmt_num_rows($fetch_pdf_query) > 0) {
               // Bind result variables
               mysqli_stmt_bind_result($fetch_pdf_query, $pdf_name, $pdf_content);
               mysqli_stmt_fetch($fetch_pdf_query);

               // Display PDF using an iframe
               echo "<iframe src='data:application/pdf;base64,".base64_encode($pdf_content)."' width='100%' height='100%'></iframe>";
            } else {
               // PDF not found, display an error message
               echo "PDF not found.";
            }
         } else {
            // Invalid ID parameter, display an error message
            echo "Invalid ID parameter.";
         }
      ?>
   </div>
</body>
</html>
