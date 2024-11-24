<?php
if(isset($_POST['filter'])) {
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

    $data = $_POST['data'];

    $sql = "SELECT * FROM $file WHERE id = '$data' OR name = '$data' OR description = '$data' OR amount = '$data' OR updated_on = '$data'";
    $result = $conn->query($sql);

    $add = "SELECT SUM(amount) AS total_amount FROM $file WHERE id = '$data' OR name = '$data' OR description = '$data' OR amount = '$data' OR updated_on ='$data'";
    $sum = $conn->query($add);
    if($sum->num_rows > 0) {
        $row = $sum->fetch_assoc();
        $totalAmount = $row['total_amount'];
    } else {
        $totalAmount = 0;
    }

    if($result->num_rows > 0) {
        echo "  <div class='updates'>
                <table>
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
                        <td class='date'>" . htmlspecialchars($row['name']) . "</td>
                        <td class='desc'>" . htmlspecialchars($row['description']) . "</td>
                        <td class='amount'>&#8369; " . htmlspecialchars($row['amount']) . "</td>
                    </tr>";
        }
        echo "      <tr>
                        <td colspan='4'>Total Contribution: </td>
                        <td class='amount'>&#8369; " . htmlspecialchars($totalAmount) . "</td>
                    </tr>
                </table>
                </div>";
    }
    $result = null;
    $conn->close();
}
?>