<?php
include "dbcon.php";

$sql = "SELECT * FROM contribution";
$result = $conn->query($sql);

$add = "SELECT SUM(amount) AS total_amount FROM contribution";
$sum = $conn->query($add);
if($sum->num_rows > 0) {
    $row = $sum->fetch_assoc();
    $totalAmount = $row['total_amount'];
} else {
    $totalAmount = 0;
}

$update_row = null;
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

    $update_id = $_POST['update_id'];

    $update_sql = "SELECT * FROM $file WHERE id = '$update_id'";
    $update_result = $conn->query($update_sql);
    if($update_result->num_rows > 0) {
        $update_row = $update_result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contributions</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="operations.css">
</head>
<body>
    <?php
    if (isset($_GET['message']) && $_GET['message'] === 'success') {
        echo "<p class='message'>New record added successfully!</p>";
    } elseif(isset($_GET['message']) && $_GET['message'] === 'updated') {
        echo "<p class='message'>Data updated successfully!</p>";
    } elseif(isset($_GET['message']) && $_GET['message'] === 'deleted') {
        echo "<p class='message'>Data deleted successfully!</p>";
    } elseif(isset($_GET['message']) && $_GET['message'] === 'noMatch') {
        echo "<p class='message'>No match Id!</p>";
    }
    ?>
    <script>
    setTimeout(function() {
        const messageElements = document.getElementsByClassName('message');
        if (messageElements.length > 0) {
            messageElements[0].style.display = 'none';
        }
        const url = new URL(window.location.href);
        url.searchParams.delete('message');
        window.history.replaceState({}, document.title, url.toString());
    }, 3000); 
    </script>

    <header>
        <h1>BSIT 2 - 1 Class Fund Management System</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="contributions.php">Contribution</a></li>
            <li><a href="fines.php">Fines</a></li>
            <li><a href="class_funds.php">Class Fund</a></li>
            <li><a href="expenses.php">Expenses</a></li>
        </ul>
        <div id="logout"><a href="login.php">Logout</a></div>
    </nav>

    <main>
        <h1>Contributions</h1>
        <div class="updates">
            <h2>Latest Updates</h2>
            <?php
                if($result->num_rows > 0) {
                    echo "  <table>
                                <tr>
                                    <th class='num'>ID</th>
                                    <th class='date'>Date</th>
                                    <th class='name'>Name</th>
                                    <th class='desc'>Description</th>
                                    <th class='amount'>Amount</th>
                                    <th class='add_button_container'>
                                        <div>
                                            <button class='add_button' onclick='addForm()'>
                                                <i class='fas fa-plus'></i>
                                            </button>
                                        </div>
                                    </th>
                                </tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "  <tr>
                                    <td class='num'>" . htmlspecialchars($row['id']) . "</td> 
                                    <td class='date'>" . htmlspecialchars($row['updated_on']) . "</td>
                                    <td class='name'>" . htmlspecialchars($row['name']) . "</td>
                                    <td class='desc'>" . htmlspecialchars($row['description']) . "</td>
                                    <td class='amount'>&#8369; " . htmlspecialchars($row['amount']) . "</td>
                                    <td class='icon_container'>
                                        <form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='post' style='display:inline;'>
                                            <input type='hidden' name='update_id' value='" . htmlspecialchars($row['id']) . "'>
                                            <button type='submit' name='update' class='delete-btn' title='Update'>&#9998;</button>
                                        </form>
                                        <form action='delete.php' method='post' style='display:inline;'>
                                            <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['id']) . "'>
                                            <button type='submit' name='delete' class='delete-btn' title='Delete'>&#10060;</button>
                                        </form>
                                    </td>
                                </tr>";
                    }
                    echo "      <tr>
                                    <td colspan='5'>Total Contribution: </td>
                                    <td class='amount'>&#8369; " . htmlspecialchars($totalAmount) . "</td>
                                </tr>
                            </table>";
                            if(isset($update_row)) {
                                include "update.php";
                            }
                            
                } else {
                    echo "<p>No Result Found.</p>";
                }
                $conn->close();
            ?>
            <div id='add_form_container'>
                <?php include "add.php" ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        Class Fund Management System
    </footer>
</body>
<script>
    function setOverlayHeight(varname) {
        const overlay = document.getElementById(varname);
        overlay.style.height = `${document.documentElement.scrollHeight}px`;
    }
    setOverlayHeight("update_back");
    setOverlayHeight("add_back");
    window.addEventListener("resize", setOverlayHeight);

    function addForm() {
        document.getElementById('add_form_container').style.display = 'block';
    }
</script>
</html>
