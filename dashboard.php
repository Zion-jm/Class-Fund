<?php
include "dbcon.php";

$sql = "SELECT * FROM contribution";
$result = $conn->query($sql);

$add = "SELECT SUM(amount) AS total_amount FROM contribution";
$sum = $conn->query($add);
if($sum->num_rows > 0) {
    $row = $sum->fetch_assoc();
    $totalContribution = $row['total_amount'];
} else {
    $totalContribution = 0;
}

$add = "SELECT SUM(amount) AS total_amount FROM fines";
$sum = $conn->query($add);
if($sum->num_rows > 0) {
    $row = $sum->fetch_assoc();
    $totalFines = $row['total_amount'];
} else {
    $totalFines = 0;
}

$add = "SELECT SUM(amount) AS total_amount FROM fund";
$sum = $conn->query($add);
if($sum->num_rows > 0) {
    $row = $sum->fetch_assoc();
    $totalFund = $row['total_amount'];
} else {
    $totalFund = 0;
}

$add = "SELECT SUM(amount) AS total_amount FROM expenses";
$sum = $conn->query($add);
if($sum->num_rows > 0) {
    $row = $sum->fetch_assoc();
    $totalExpenses = $row['total_amount'];
} else {
    $totalExpenses = 0;
}

$availableFund = $totalContribution + $totalFines + $totalFund - $totalExpenses;
$totalContribution = number_format($totalContribution);
$totalFines = number_format($totalFines);
$totalFund = number_format($totalFund);
$totalExpenses = number_format($totalExpenses);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Fund Overview</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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
        <h1>Overview</h1>
        <div class="overview">
            <section class="section1">
                <div class="card">
                    <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
                    <h2>Total Contributions</h2>
                    <?php echo "<p>&#8369; $totalContribution</p>" ?>
                </div>
            
                <div class="card">
                    <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
                    <h2>Total Fines</h2>
                    <?php echo "<p>&#8369; $totalFines</p>"?>
                </div>
            </section>

            <section class="section1">
                <div class="card">
                    <div class="icon"><i class="fas fa-wallet"></i></div>
                    <h2>Total Class Fund</h2>
                    <?php echo "<p>&#8369; $totalFund</p>" ?>
                </div>

                <div class="card">
                    <div class="icon"><i class="fas fa-shopping-cart"></i>
                    </div>
                    <h2>Total Expenses</h2>
                    <?php echo "<p>&#8369; $totalExpenses</p>" ?>
                </div>
            </section>

            <section class="section2">
                <div class="card total">
                    <div class="icon"><i class="fas fa-piggy-bank"></i></div>
                    <h2>Available Fund</h2>
                    <?php echo "<p>&#8369; $availableFund</p>" ?>
                    <div class="progress-bar">
                        <span></span>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer class="footer">
        Class Fund Management System
    </footer>
</body>
</html>
