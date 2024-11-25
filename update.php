<?php
if(isset($_POST['update_form'])) {
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

    $update_id = $_POST['update_id'];
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $amount = (int)$_POST['amount'];

    $sql = "UPDATE $file SET name = '$name', description = '$desc', amount = $amount
            WHERE id = '$update_id'";
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
echo "  <div class='update_back' id='update_back'>
        <form action='update.php' method='post' class='update_form'>
            <h2>Update</h2>
            <label for='name'>Name:</label><br>
            <input type='hidden' name='update_id' value='" . htmlspecialchars($update_row['id']) . "'>
            <input type='text' name='name' placeholder='Enter Name' value='" . htmlspecialchars($update_row['name']) . "' required class='input'><br>
            <label for='description'>Description:</label><br>
            <input type='text' name='description' placeholder='Enter Description' value='" . htmlspecialchars($update_row['description']) . "' required class='input'><br>
            <label for='amount'>Amount:</label><br>
            <input type='text' name='amount' placeholder='Enter Amount' value='" . htmlspecialchars($update_row['amount']) . "' required class='input'><br>
            <div>
                <input type='submit' name='update_form' value='Update' class='submit'>
                <input type='button' value='Cancel' class='submit' onclick='window.location.href=window.location.href;'>
            </div>
        </form>
        </div>";
?>