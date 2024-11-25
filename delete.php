<?php
if(isset($_POST['delete'])) {
    include "dbcon.php";

    $file = '';
    if ($_SERVER['HTTP_REFERER'] === 'http://localhost/Class%20Fund/contributions.php') {
        $file = 'contribution';
    } elseif ($_SERVER['HTTP_REFERER'] === 'http://localhost/Class%20Fund/fines.php') {
        $file = 'fines';
    } elseif ($_SERVER['HTTP_REFERER'] === 'http://localhost/Class%20Fund/class_funds.php') {
        $file = 'fund';
    } elseif ($_SERVER['HTTP_REFERER'] === 'http://localhost/Class%20Fund/expenses.php') {
        $file = 'expenses';
    }

    $delete_id = $_POST['delete_id'];

    $sql = "DELETE FROM $file WHERE id = '$delete_id'";
    $conn->query($sql);
    if($conn->affected_rows > 0) {
        $redirectUrl = $_SERVER['HTTP_REFERER'] ?? 'default_page.php';
        header("Location: $redirectUrl?message=deleted");
        exit();
    } else {
        $redirectUrl = $_SERVER['HTTP_REFERER'] ?? 'default_page.php';
        header("Location: $redirectUrl?message=noMatch");
        exit();
    }

    $conn->close();
}
?>

