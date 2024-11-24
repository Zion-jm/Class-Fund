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

    $id = $_POST['id'];

    $sql = "DELETE FROM $file WHERE id = '$id'";
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
echo "  <form action='delete.php' method='post' id='add'>
            <h2>Delete</h2>
            <input type='text' name='id' placeholder='Enter Id of the Data you want to Delete' required class='input'><br>
            <div>
                <input type='submit' name='delete' value='Delete' class='submit'>
                <input type='button' value='Cancel' class='submit' onclick='window.location.href=window.location.href;'>
            </div>
        </form>";
?>

