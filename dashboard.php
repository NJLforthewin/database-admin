<?php
// Page-specific settings
$pageTitle = "Dashboard";
$useChartJs = true; // We need Chart.js on this page

// Define some variables for statistics (these could later be replaced with database queries)
$statistics = [
    'checkin_today' => 23,
    'checkout_today' => 13,
    'in_hotel' => 60,
    'available_rooms' => 10,
    'occupied_rooms' => 90
];

$rooms = [
    [
        'type' => 'Single Room',
        'occupancy_rate' => 85,
        'available' => 5,
        'occupied' => 25
    ],
    [
        'type' => 'Double Room',
        'occupancy_rate' => 78,
        'available' => 10,
        'occupied' => 20
    ],
    [
        'type' => 'Deluxe Room',
        'occupancy_rate' => 60,
        'available' => 8,
        'occupied' => 12
    ],
    [
        'type' => 'VIP Suite',
        'occupancy_rate' => 90,
        'available' => 2,
        'occupied' => 18
    ]
];

$weeklyOccupancy = [
    'Monday' => 85,
    'Tuesday' => 78,
    'Wednesday' => 60,
    'Thursday' => 90,
    'Friday' => 75,
    'Saturday' => 88,
    'Sunday' => 65
];

// Include header
include 'includes/header.php';

// Include sidebar
include 'includes/sidebar.php';
?>

<div class="main-content">
    <div class="header">
        <div class="notification">
            <a href="notification.php"><img src="<?php echo $imagesPath; ?>notification.png" alt="Notification Icon"></a>
        </div>
        <div class="profile">
            <a href="profile.php"><img src="<?php echo $imagesPath; ?>Avatar.png" alt="Profile"></a>
        </div>
    </div>
    
    <div class="overview">
        <h2>Overview</h2>
        <div class="overview-container">
            <div class="overview-item">
                <span>Today's</span>
                <strong>Check-in: <span class="count"><?php echo $statistics['checkin_today']; ?></span></strong>
            </div>
            <div class="overview-item">
                <span>Today's</span>
                <strong>Check-out: <span class="count"><?php echo $statistics['checkout_today']; ?></span></strong>
            </div>
            <div class="overview-item">
                <span>Total</span>
                <strong>In hotel: <span class="count"><?php echo $statistics['in_hotel']; ?></span></strong>
            </div>
            <div class="overview-item">
                <span>Total</span>
                <strong>Available room: <span class="count"><?php echo $statistics['available_rooms']; ?></span></strong>
            </div>
            <div class="overview-item">
                <span>Total</span>
                <strong>Occupied room: <span class="count"><?php echo $statistics['occupied_rooms']; ?></span></strong>
            </div>
        </div>
    </div>
    
    <div class="hotel-performance">
        <h2>Rooms</h2>
        <div class="performance-container">
            <?php foreach ($rooms as $room): ?>
            <div class="single">
                <h3><?php echo $room['type']; ?></h3>
                <p>Occupancy Rate: <?php echo $room['occupancy_rate']; ?>%</p>
                <p>Available: <?php echo $room['available']; ?></p>
                <p>Occupied: <?php echo $room['occupied']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
<!-- Occupancy Statistics -->
<div class="hotel-performance half-width" style="max-width: 50%;">
    <h2 style="font-size: 1rem;">Occupancy Statistics</h2>
    <canvas id="occupancyChart" style="max-width: 100%; height: 150px;"></canvas>
</div>
</div>

<?php
// Prepare data for the chart - convert arrays to JSON strings
$weeklyOccupancyLabels = json_encode(array_keys($weeklyOccupancy));
$weeklyOccupancyData = json_encode(array_values($weeklyOccupancy));

// Add page-specific scripts
$pageScripts = <<<SCRIPT
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('occupancyChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {$weeklyOccupancyLabels},
                datasets: [{
                    label: 'Occupancy Rate (%)',
                    data: {$weeklyOccupancyData},
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2', '#fd7e14']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {beginAtZero: true, max: 100}
                }
            }
        });
    });
</script>
SCRIPT;

// Include footer
include 'includes/footer.php';
?>