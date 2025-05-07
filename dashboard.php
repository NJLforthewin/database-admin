<?php
$pageTitle = "Dashboard";
$pageCss = "css/dashboard.css";
$useChartJs = true; 
$headerExtras = '<script src="js/dashboard.js"></script>';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";
$statistics = [
    'checkin_today' => 0,
    'checkout_today' => 0,
    'in_hotel' => 0,
    'available_rooms' => 0,
    'occupied_rooms' => 0
];

$rooms = [];
$monthlyOccupancy = [];
$roomStatus = [
    'occupied' => [
        'total' => 0,
        'clean' => 0,
        'dirty' => 0,
        'inspected' => 0
    ],
    'available' => [
        'total' => 0,
        'clean' => 0,
        'dirty' => 0,
        'inspected' => 0
    ]
];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $today = date('Y-m-d');
    $stmt = $conn->prepare("SELECT 
        (SELECT COUNT(*) FROM reservations WHERE check_in_date = :today) as checkin_today,
        (SELECT COUNT(*) FROM reservations WHERE check_out_date = :today) as checkout_today,
        (SELECT COUNT(*) FROM reservations WHERE :today BETWEEN check_in_date AND check_out_date) as in_hotel");
    $stmt->bindParam(':today', $today);
    $stmt->execute();
    $statsResult = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($statsResult) {
        $statistics['checkin_today'] = $statsResult['checkin_today'];
        $statistics['checkout_today'] = $statsResult['checkout_today'];
        $statistics['in_hotel'] = $statsResult['in_hotel'];
    }
    $stmt = $conn->prepare("SELECT 
        room_type, 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) as available,
        price,
        (SELECT COUNT(*) FROM room_deals WHERE room_type_id = room_types.id) as deals
        FROM rooms 
        JOIN room_types ON rooms.room_type_id = room_types.id
        GROUP BY room_type, price");
    $stmt->execute();
    $roomResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($roomResults) > 0) {
        $rooms = $roomResults;
    } else {
        $rooms = [
            [
                'room_type' => 'Single Room',
                'available' => 0,
                'total' => 0,
                'price' => 0,
                'deals' => 0
            ],
            [
                'room_type' => 'Double Room',
                'available' => 0,
                'total' => 0,
                'price' => 0,
                'deals' => 0
            ],
            [
                'room_type' => 'Deluxe Room',
                'available' => 0,
                'total' => 0,
                'price' => 0,
                'deals' => 0
            ],
            [
                'room_type' => 'VIP Suite',
                'available' => 0,
                'total' => 0, 
                'price' => 0,
                'deals' => 0
            ]
        ];
    }
    $stmt = $conn->prepare("SELECT 
        status, 
        cleanliness,
        COUNT(*) as count
        FROM rooms
        GROUP BY status, cleanliness");
    $stmt->execute();
    $roomStatusResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($roomStatusResults as $row) {
        if ($row['status'] == 'occupied') {
            if ($row['cleanliness'] == 'clean') {
                $roomStatus['occupied']['clean'] = $row['count'];
            } else if ($row['cleanliness'] == 'dirty') {
                $roomStatus['occupied']['dirty'] = $row['count'];
            } else if ($row['cleanliness'] == 'inspected') {
                $roomStatus['occupied']['inspected'] = $row['count'];
            }
            $roomStatus['occupied']['total'] += $row['count'];
        } else if ($row['status'] == 'available') {
            if ($row['cleanliness'] == 'clean') {
                $roomStatus['available']['clean'] = $row['count'];
            } else if ($row['cleanliness'] == 'dirty') {
                $roomStatus['available']['dirty'] = $row['count'];
            } else if ($row['cleanliness'] == 'inspected') {
                $roomStatus['available']['inspected'] = $row['count'];
            }
            $roomStatus['available']['total'] += $row['count'];
        }
    }
        $statistics['available_rooms'] = $roomStatus['available']['total'];
    $statistics['occupied_rooms'] = $roomStatus['occupied']['total'];
    
    $stmt = $conn->prepare("SELECT 
        DATE_FORMAT(date, '%b') as month,
        AVG(occupancy_rate) as rate
        FROM daily_occupancy
        WHERE date >= DATE_SUB(CURRENT_DATE, INTERVAL 10 MONTH)
        GROUP BY DATE_FORMAT(date, '%Y-%m')
        ORDER BY date ASC");
    $stmt->execute();
    $occupancyResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($occupancyResults) > 0) {
        foreach ($occupancyResults as $row) {
            $monthlyOccupancy[$row['month']] = (float)$row['rate'];
        }
    } else {
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'];
        foreach ($monthNames as $month) {
            $monthlyOccupancy[$month] = 0;
        }
    }
    $currentMonth = date('n');
    $currentYear = date('Y');
    $startDate = "$currentYear-$currentMonth-01";
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
    $busyDaysResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $busyDays = [];
    foreach ($busyDaysResults as $row) {
        $busyDays[] = (int)$row['day'];
    }
    
} catch(PDOException $e) {
    error_log("Database error in Dashboard.php: " . $e->getMessage());
    $statistics = [
        'checkin_today' => 23,
        'checkout_today' => 13,
        'in_hotel' => 60,
        'available_rooms' => 10,
        'occupied_rooms' => 90
    ];
    
    $rooms = [
        [
            'room_type' => 'Single room',
            'available' => 2,
            'total' => 30,
            'price' => 568,
            'deals' => 2
        ],
        [
            'room_type' => 'Double room',
            'available' => 2, 
            'total' => 35,
            'price' => 1068,
            'deals' => 6
        ],
        [
            'room_type' => 'Deluxe room',
            'available' => 2,
            'total' => 25,
            'price' => 1568,
            'deals' => 1
        ],
        [
            'room_type' => 'VIP Suite',
            'available' => 4,
            'total' => 10,
            'price' => 2568,
            'deals' => 20
        ]
    ];
    
    $monthlyOccupancy = [
        'May' => 85,
        'Jun' => 65,
        'Jul' => 78,
        'Aug' => 45,
        'Sep' => 90,
        'Oct' => 75,
        'Nov' => 78,
        'Dec' => 88,
        'Jan' => 92,
        'Feb' => 85
    ];
    
    $roomStatus = [
        'occupied' => [
            'total' => 104,
            'clean' => 90,
            'dirty' => 4,
            'inspected' => 60
        ],
        'available' => [
            'total' => 20,
            'clean' => 30,
            'dirty' => 19,
            'inspected' => 30
        ]
    ];
    
    $busyDays = [5, 12, 19, 26];
}

$currentMonth = date('n');
$currentYear = date('Y');
$currentDay = date('j');
$daysInMonth = date('t', strtotime("$currentYear-$currentMonth-01"));
$firstDayOfMonth = date('w', strtotime("$currentYear-$currentMonth-01"));
$monthName = date('F Y', strtotime("$currentYear-$currentMonth-01"));

$monthlyLabels = json_encode(array_keys($monthlyOccupancy));
$monthlyData = json_encode(array_values($monthlyOccupancy));
$busyDaysJSON = json_encode($busyDays);

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="main-content">
    <div class="header">
        <div class="notification">
            <img src="<?php echo $imagesPath; ?>notification.png" alt="Notification Icon">
        </div>
        <div class="profile">
            <img src="<?php echo $imagesPath; ?>Avatar.png" alt="Profile">
        </div>
    </div>
    
    <div class="dashboard-section">
        <h2>Overview</h2>
        <div class="overview-container">
            <div class="overview-item">
                <div class="overview-label">Today's</div>
                <div class="overview-value">
                    <span>Check-in</span>
                    <span class="highlight"><?php echo $statistics['checkin_today']; ?></span>
                </div>
            </div>
            <div class="overview-item">
                <div class="overview-label">Today's</div>
                <div class="overview-value">
                    <span>Check-out</span>
                    <span class="highlight"><?php echo $statistics['checkout_today']; ?></span>
                </div>
            </div>
            <div class="overview-item">
                <div class="overview-label">Total</div>
                <div class="overview-value">
                    <span>In hotel</span>
                    <span class="highlight"><?php echo $statistics['in_hotel']; ?></span>
                </div>
            </div>
            <div class="overview-item">
                <div class="overview-label">Total</div>
                <div class="overview-value">
                    <span>Available room</span>
                    <span class="highlight"><?php echo $statistics['available_rooms']; ?></span>
                </div>
            </div>
            <div class="overview-item">
                <div class="overview-label">Total</div>
                <div class="overview-value">
                    <span>Occupied room</span>
                    <span class="highlight"><?php echo $statistics['occupied_rooms']; ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="dashboard-section">
        <h2>Rooms</h2>
        <div class="rooms-container">
            <?php foreach ($rooms as $room): ?>
            <div class="room-card">
                <?php if (isset($room['deals']) && $room['deals'] > 0): ?>
                <div class="deal-badge"><?php echo $room['deals']; ?> Deals</div>
                <?php endif; ?>
                <div class="card-menu">
                    <i class="dots-menu">⋮</i>
                </div>
                <div class="room-type"><?php echo $room['room_type']; ?></div>
                <div class="room-availability">
                    <span class="available"><?php echo $room['available']; ?></span>/<span class="total"><?php echo $room['total']; ?></span>
                </div>
                <div class="room-price">
                    <span class="currency">$</span>
                    <span class="amount"><?php echo number_format($room['price']); ?></span>
                    <span class="period">/ day</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="dashboard-section">
        <h2>Occupancy Statistics</h2>
        <div class="chart-controls">
            <div class="chart-toggle">
                <label class="toggle-label">
                    <input type="checkbox" id="viewToggle" checked>
                    <span class="toggle-text">Monthly</span>
                </label>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="occupancyChart"></canvas>
        </div>
        
        <div class="calendar-section">
            <div class="calendar-header">
                <button class="calendar-nav prev" id="prevMonth">&#10094;</button>
                <div class="current-month" id="currentMonthDisplay"><?php echo $monthName; ?></div>
                <button class="calendar-nav next" id="nextMonth">&#10095;</button>
            </div>
            <div class="calendar-grid">
                <div class="calendar-days">
                    <div class="day-name">SUN</div>
                    <div class="day-name">MON</div>
                    <div class="day-name">TUE</div>
                    <div class="day-name">WED</div>
                    <div class="day-name">THU</div>
                    <div class="day-name">FRI</div>
                    <div class="day-name">SAT</div>
                </div>
                <div class="calendar-dates" id="calendarDates">
                    <?php
                    for ($i = 0; $i < $firstDayOfMonth; $i++) {
                        echo '<div class="calendar-date empty"></div>';
                    }
                    
                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        $class = 'calendar-date';
                        
                        if ($day == $currentDay) {
                            $class .= ' today';
                        }
                        
                        if (in_array($day, $busyDays)) {
                            $class .= ' highlighted';
                        }
                        
                        echo "<div class=\"$class\">$day</div>";
                    }
                    
                    $remainingCells = 7 - (($firstDayOfMonth + $daysInMonth) % 7);
                    if ($remainingCells < 7) {
                        for ($i = 0; $i < $remainingCells; $i++) {
                            echo '<div class="calendar-date empty"></div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Room Status Section -->
    <div class="dashboard-section">
        <h2>Room status</h2>
        <div class="status-container">
            <div class="status-column">
                <div class="status-item">
                    <div class="status-label">Occupied rooms</div>
                    <div class="status-value"><?php echo $roomStatus['occupied']['total']; ?></div>
                </div>
                <div class="status-item">
                    <div class="status-label">Clean</div>
                    <div class="status-value"><?php echo $roomStatus['occupied']['clean']; ?></div>
                </div>
                <div class="status-item">
                    <div class="status-label">Dirty</div>
                    <div class="status-value"><?php echo $roomStatus['occupied']['dirty']; ?></div>
                </div>
                <div class="status-item">
                    <div class="status-label">Inspected</div>
                    <div class="status-value"><?php echo $roomStatus['occupied']['inspected']; ?></div>
                </div>
            </div>
            <div class="status-column">
                <div class="status-item">
                    <div class="status-label">Available rooms</div>
                    <div class="status-value"><?php echo $roomStatus['available']['total']; ?></div>
                </div>
                <div class="status-item">
                    <div class="status-label">Clean</div>
                    <div class="status-value"><?php echo $roomStatus['available']['clean']; ?></div>
                </div>
                <div class="status-item">
                    <div class="status-label">Dirty</div>
                    <div class="status-value"><?php echo $roomStatus['available']['dirty']; ?></div>
                </div>
                <div class="status-item">
                    <div class="status-label">Inspected</div>
                    <div class="status-value"><?php echo $roomStatus['available']['inspected']; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$pageScripts = <<<SCRIPT
<script>
    // Pass PHP variables to JavaScript
    const monthlyLabels = {$monthlyLabels};
    const monthlyData = {$monthlyData};
    const currentMonth = {$currentMonth};
    const currentYear = {$currentYear};
    const currentDay = {$currentDay};
    const busyDays = {$busyDaysJSON};
    
    // These variables will be used in dashboard.js
    let currentDisplayMonth = currentMonth;
    let currentDisplayYear = currentYear;
</script>
SCRIPT;

include 'includes/footer.php';
?>