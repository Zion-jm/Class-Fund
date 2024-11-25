<?php
if(isset($_POST['add'])) {
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

    $name = $conn->real_escape_string($_POST['name']);
    $desc = empty(trim($_POST['description'])) ? 'contributed' : $conn->real_escape_string($_POST['description']);
    $amount = (int)$_POST['amount'];

    $sql = "INSERT INTO $file(name, description, amount)
            VALUES('$name', '$desc', '$amount')";

if($conn->query($sql)) {
    $redirectUrl = $_SERVER['HTTP_REFERER'] ?? 'default_page.php';
    header("Location: $redirectUrl?message=success");
    exit();
}
    $conn->close();
}
echo "  <div class='add_back' id='add_back'>
        <form action='add.php' method='post' class='add_form'>
            <h2>Add</h2>
            <label for='name'>Name:</label><br>
            <input type='text' name='name' placeholder='Enter Name' required class='input'><br>
            <label for='name'>Description:</label><br>
            <input type='text' name='description' placeholder='Enter Description(Optional)' class='input'><br>
            <label for='amount'>Amount:</label><br>
            <input type='text' name='amount' placeholder='Enter Amount' required class='input'><br>
            <div>
                <input type='submit' name='add' value='Add' class='submit'>
                <input type='button' value='Cancel' class='submit' onclick='window.location.href=window.location.href;'>
            </div>
        </form>";
?>