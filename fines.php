<?php
include "dbcon.php";

$sql = "SELECT * FROM fines";
$result = $conn->query($sql);

$add = "SELECT SUM(amount) AS total_amount FROM fines";
$sum = $conn->query($add);
if($sum->num_rows > 0) {
    $row = $sum->fetch_assoc();
    $totalAmount = $row['total_amount'];
} else {
    $totalAmount = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fines</title>
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
        <h1>Fines</h1>
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
                                </tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "  <tr>
                                    <td class='num'>" . htmlspecialchars($row['id']) . "</td> 
                                    <td class='date'>" . htmlspecialchars($row['updated_on']) . "</td>
                                    <td class='name'>" . htmlspecialchars($row['name']) . "</td>
                                    <td class='desc'>" . htmlspecialchars($row['description']) . "</td>
                                    <td class='amount'>&#8369; " . htmlspecialchars($row['amount']) . "</td>
                                </tr>";
                    }
                    echo "      <tr>
                                    <td colspan='4'>Total Fines: </td>
                                    <td class='amount'>&#8369; " . htmlspecialchars($totalAmount) . "</td>
                                </tr>
                            </table>";
                } else {
                    echo "<p>No Result Found.</p>";
                }
                $conn->close();
            ?>
        </div>

        <div class="nav_operations">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <button type="submit" name="choice" value="1">Add</button>
                <button type="submit" name="choice" value="2">Update</button>
                <button type="submit" name="choice" value="3">Delete</button>
                <button type="submit" name="choice" value="4">Filter</button>
            </form>

            <?php
                $choice = $_POST['choice'] ?? null;
                if($choice) {
                    switch($choice) {
                        case '1': 
                            include "add.php";
                            break;

                        case '2':
                            include "update.php";
                            break;

                        case '3':
                            include "delete.php";
                            break;

                        case '4':
                            echo "  <form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='post' id='add'>
                                        <h2>Filter</h2>
                                        <input type='text' name='data' placeholder='Enter Data to Filter' required class='input'><br>
                                        <div>
                                            <input type='submit' name='filter' value='Filter' class='submit'>
                                            <input type='button' value='Cancel' class='submit' onclick='window.location.href=window.location.href;'>
                                        </div>
                                        </form>";
                            break;
                    }
                    
                }
                include "filter.php";
            ?>
        </div>
    </main>

    <footer class="footer">
        Class Fund Management System
    </footer>
</body>
</html>
