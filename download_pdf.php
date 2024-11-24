<?php
// Include database configuration
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

        // Set headers for PDF download
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename='$pdf_name'");

        // Output PDF content
        echo $pdf_content;
    } else {
        // PDF not found, redirect or display an error message
        echo "PDF not found.";
    }
} else {
    // Invalid ID parameter, redirect or display an error message
    echo "Invalid ID parameter.";
}
?>
