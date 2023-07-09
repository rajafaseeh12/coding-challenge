<!DOCTYPE html>
<html>
<head>
    <title>Coding Challenge</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>This is a coding challenge</h1>
    <h1>Filtered Results</h1>

    <div class="form-container">
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="GET">
            <label for="employee_name">Employee Name:</label>
            <input type="text" name="employee_name" id="employee_name" value="<?php echo isset($_GET['employee_name']) ? $_GET['employee_name'] : ''; ?>">
            <br>
            <label for="event_name">Event Name:</label>
            <input type="text" name="event_name" id="event_name" value="<?php echo isset($_GET['event_name']) ? $_GET['event_name'] : ''; ?>">
            <br>
            <label for="date">Date:</label>
            <input type="date" name="event_date" id="date" value="<?php echo isset($_GET['event_date']) ? $_GET['event_date'] : ''; ?>">
            <br>
            <input type="submit" name="submit" value="Filter">
        </form>
    </div>

    <?php
    require_once 'database.php';

    if (!isset($_GET["submit"]) || empty($_GET["submit"])) {
        require_once 'insert.php';
    }

    if (isset($_GET["submit"]) && !empty($_GET["submit"])) {
        $employeeName = $_GET["employee_name"];
        $eventName = $_GET["event_name"];
        $eventDate = $_GET["event_date"];

        $sql = "SELECT * FROM bookings WHERE 1=1";

        if (!empty($employeeName)) {
            $sql .= " AND employee_name LIKE '%$employeeName%'";
        }

        if (!empty($eventName)) {
            $sql .= " AND event_name LIKE '%$eventName%'";
        }

        if (!empty($eventDate)) {
            $sql .= " AND event_date = '$eventDate'";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>
                    <th>Employee Name</th>
                    <th>Email</th>
                    <th>Event Name</th>
                    <th>Date</th>
                </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["employee_name"]."</td>";
                echo "<td>".$row["employee_mail"]."</td>";
                echo "<td>".$row["event_name"]."</td>";
                echo "<td>".$row["event_date"]."</td>";
                echo "</tr>";
            }
            echo "<tr><td colspan='3'><b>Total Price</b></td><td><b>".calculatePrice($conn, $sql)."</b></td></tr>";

            echo "</table>";
        } else {
            echo "No results found.";
        }
    }

    function calculatePrice($conn, $query) {
        $totalPrice = 0;

        $result = $conn->query("SELECT SUM(participation_fee) AS total FROM ($query) AS subquery");

        if ($result && $row = $result->fetch_assoc()) {
            $totalPrice = $row["total"];
        }

        return $totalPrice;
    }

    ?>
</body>
</html>