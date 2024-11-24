<?php
if(isset($_POST['update'])) {
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
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $amount = (int)$_POST['amount'];

    $sql = "UPDATE $file SET name = '$name', description = '$desc', amount = $amount
            WHERE id = '$id'";
    $conn->query($sql);
    if($conn->affected_rows > 0) {
        $redirectUrl = $_SERVER['HTTP_REFERER'] ?? 'default_page.php';
        header("Location: $redirectUrl?message=updated");
        exit();
    } else {
        $redirectUrl = $_SERVER['HTTP_REFERER'] ?? 'default_page.php';
        header("Location: $redirectUrl?message=noMatch");
        exit();
    }
    $conn->close();
}
echo "  <form action='update.php' method='post' id='add'>
            <h2>Update</h2>
            <input type='text' name='id' placeholder='Enter Id of the Data you want to Update' required class='input'><br>
            <label for='name'>Name:</label><br>
            <input type='text' name='name' placeholder='Enter Name' required class='input'><br>
            <label for='description'>Description:</label><br>
            <input type='text' name='description' placeholder='Enter Description' required class='input'><br>
            <label for='amount'>Amount:</label><br>
            <input type='text' name='amount' placeholder='Enter Amount' required class='input'><br>
            <div>
                <input type='submit' name='update' value='Update' class='submit'>
                <input type='button' value='Cancel' class='submit' onclick='window.location.href=window.location.href;'>
            </div>
        </form>";
?>