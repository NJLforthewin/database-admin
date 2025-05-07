<?php
$pageTitle = "Reservation Management";
$pageCss = "css/reservation.css";

// Sample data - you can replace this with your actual data source
$reservations = [
    [
        'id' => '#5644',
        'name' => 'Alexander',
        'room_number' => 'A647',
        'total_amount' => 467,
        'amount_paid' => 200,
        'room_type' => 'Deluxe Room',
        'status' => 'Check In',
        'payment_status' => 'Partially'
    ],
    [
        'id' => '#6112',
        'name' => 'Pegasus',
        'room_number' => 'A456',
        'total_amount' => 645,
        'amount_paid' => 250,
        'room_type' => 'Single Room',
        'status' => 'Pending',
        'payment_status' => 'Partially'
    ],
    [
        'id' => '#6141',
        'name' => 'Martin',
        'room_number' => 'A645',
        'total_amount' => 686,
        'amount_paid' => 686,
        'room_type' => 'Double Room',
        'status' => 'Pending',
        'payment_status' => 'Paid'
    ],
    [
        'id' => '#8535',
        'name' => 'Cecil',
        'room_number' => 'A684',
        'total_amount' => 8413,
        'amount_paid' => 8413,
        'room_type' => 'VIP Suites',
        'status' => 'Check Out',
        'payment_status' => 'Paid'
    ],
    [
        'id' => '#6541',
        'name' => 'Luke',
        'room_number' => 'B464',
        'total_amount' => 841,
        'amount_paid' => 0,
        'room_type' => 'VIP Suites',
        'status' => 'Booked',
        'payment_status' => 'Unpaid'
    ],
    [
        'id' => '#9846',
        'name' => 'Yadrin',
        'room_number' => 'C648',
        'total_amount' => 684,
        'amount_paid' => 300,
        'room_type' => 'Double Room',
        'status' => 'Check In',
        'payment_status' => 'Partially'
    ],
    [
        'id' => '#4921',
        'name' => 'Kiand',
        'room_number' => 'D644',
        'total_amount' => 984,
        'amount_paid' => 0,
        'room_type' => 'Deluxe Room',
        'status' => 'Check In',
        'payment_status' => 'Unpaid'
    ],
    [
        'id' => '#4921',
        'name' => 'Kiand',
        'room_number' => 'D644',
        'total_amount' => 984,
        'amount_paid' => 984,
        'room_type' => 'Deluxe Room',
        'status' => 'Check Out',
        'payment_status' => 'Paid'
    ],
    [
        'id' => '#9841',
        'name' => 'Turen',
        'room_number' => 'B641',
        'total_amount' => 984,
        'amount_paid' => 984,
        'room_type' => 'Deluxe Room',
        'status' => 'Pending',
        'payment_status' => 'Paid'
    ],
    [
        'id' => '#9841',
        'name' => 'Turen',
        'room_number' => 'B641',
        'total_amount' => 984,
        'amount_paid' => 0,
        'room_type' => 'Deluxe Room',
        'status' => 'Pending',
        'payment_status' => 'Unpaid'
    ],
    [
        'id' => '#3350',
        'name' => 'Michael',
        'room_number' => 'C301',
        'total_amount' => 750,
        'amount_paid' => 250,
        'room_type' => 'Double Room',
        'status' => 'Booked',
        'payment_status' => 'Partially'
    ],
    [
        'id' => '#4433',
        'name' => 'Emma',
        'room_number' => 'A201',
        'total_amount' => 520,
        'amount_paid' => 520,
        'room_type' => 'Single Room',
        'status' => 'Check Out',
        'payment_status' => 'Paid'
    ]
];

$headerExtras = '<script src="js/reservation.js"></script>';

include 'includes/header.php';
include 'includes/sidebar.php';

?>

<div class="main-content">
    <div class="header">
        <div class="notification">
            <img src="<?php echo $imagesPath; ?>Notification.png" alt="Notification Icon">
            <div class="notification-container">
                <h3>Notifications</h3>
                <ul>
                    <li class="new">New reservation: RES-005</li>
                    <li class="new">Check-in reminder: Room 210</li>
                    <li>Check-out completed: Room 105</li>
                    <li>Payment received: RES-002</li>
                </ul>
            </div>
        </div>
        <div class="profile">
            <a href="profile.php"><img src="<?php echo $imagesPath; ?>Avatar.png" alt="Profile"></a>
        </div>
    </div>
    
    <div class="reservation-section">
        <div class="action-buttons">
            <div class="left-actions">
                <button class="action-btn check-in">Check In</button>
                <button class="action-btn check-out">Check out</button>
                <button class="action-btn edit-res">Edit Reservation</button>
            </div>
            
            <div class="search-controls">
                <button class="filter-btn"><i class="filter-icon"></i> Filter</button>
                <div class="search-box">
                    <input type="text" placeholder="Search by room number" id="reservation-search">
                    <i class="search-icon"></i>
                </div>
            </div>
        </div>
        
        <div class="reservation-table-container">
            <table class="reservation-table">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Name</th>
                        <th>Room Number</th>
                        <th>Total amount</th>
                        <th>Amount paid</th>
                        <th>Room Type</th>
                        <th>Status</th>
                        <th>Payment Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="reservation-table-body">
                    <?php foreach (array_slice($reservations, 0, 10) as $reservation): ?>
                    <tr class="reservation-row">
                        <td><?php echo $reservation['id']; ?></td>
                        <td><?php echo $reservation['name']; ?></td>
                        <td><?php echo $reservation['room_number']; ?></td>
                        <td>$ <?php echo $reservation['total_amount']; ?></td>
                        <td>$ <?php echo $reservation['amount_paid']; ?></td>
                        <td><?php echo $reservation['room_type']; ?></td>
                        <td>
                            <span class="status-indicator <?php echo strtolower(str_replace(' ', '-', $reservation['status'])); ?>">
                                <?php echo $reservation['status']; ?>
                            </span>
                        </td>
                        <td><?php echo $reservation['payment_status']; ?></td>
                        <td>
                            <div class="action-menu">
                                <span class="action-dots">⋮</span>
                                <div class="action-dropdown">
                                    <a href="javascript:void(0);" class="view-details">View Details</a>
                                    <a href="javascript:void(0);" class="edit-reservation">Edit</a>
                                    <a href="javascript:void(0);" class="cancel-reservation">Cancel</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="pagination">
            <button class="pagination-btn prev" id="prev-page">Previous</button>
            <div class="page-numbers" id="page-numbers">
                <a href="javascript:void(0);" class="active">1</a>
                <?php if (count($reservations) > 10): ?>
                <a href="javascript:void(0);">2</a>
                <?php endif; ?>
            </div>
            <button class="pagination-btn next" id="next-page">Next</button>
        </div>
    </div>
</div>

<?php
$pageScripts = '<script>document.addEventListener("DOMContentLoaded", function() { initializeReservationData(' . json_encode($reservations) . '); });</script>';


include 'includes/footer.php';
?>