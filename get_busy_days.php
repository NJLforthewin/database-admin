<?php
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
$servername = "";
$username = "";
$password = "";
$dbname = "";
$busyDays = [];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $startDate = "$year-$month-01";
    $endDate = date('Y-m-t', strtotime($startDate));
    $stmt = $conn->prepare("SELECT 
        DAY(check_in_date) as day,
        COUNT(*) as count
        FROM reservations
        WHERE check_in_date BETWEEN :start_date AND :end_date
        GROUP BY DAY(check_in_date)
        HAVING count > 3");
    
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $busyDays[] = (int)$row['day'];
    }
} catch(PDOException $e) {
    error_log("Database error in get_busy_days.php: " . $e->getMessage());
    if ($month % 2 == 0) {
        $busyDays = [1, 2, 3, 4, 5];
    } else {
        $firstDay = new DateTime("$year-$month-01");
        $lastDay = new DateTime(date('Y-m-t', strtotime("$year-$month-01")));
        
        $interval = new DateInterval('P1D');
        $currentDay = clone $firstDay;
        
        while ($currentDay <= $lastDay) {
            if ($currentDay->format('w') == 0) { 
                $busyDays[] = (int)$currentDay->format('j'); 
            }
            $currentDay->add($interval);
        }
    }
}

header('Content-Type: application/json');
echo json_encode($busyDays);
?>