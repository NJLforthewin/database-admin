<?php
// Page-specific settings
$pageTitle = "Reservation Management";
$pageCss = "css/reservation.css";

// Define reservation data (these could later be replaced with database queries)
$reservations = [
    [
        'id' => 'RES-001',
        'guest_name' => 'John Doe',
        'room_type' => 'Deluxe Room',
        'room_number' => '303',
        'check_in' => '2023-08-15',
        'check_out' => '2023-08-20',
        'guests' => 2,
        'status' => 'Confirmed',
        'payment' => 'Paid',
        'total' => 799.95
    ],
    [
        'id' => 'RES-002',
        'guest_name' => 'Jane Smith',
        'room_type' => 'Single Room',
        'room_number' => '105',
        'check_in' => '2023-08-10',
        'check_out' => '2023-08-12',
        'guests' => 1,
        'status' => 'Checked In',
        'payment' => 'Paid',
        'total' => 179.98
    ],
    [
        'id' => 'RES-003',
        'guest_name' => 'Michael Johnson',
        'room_type' => 'VIP Suite',
        'room_number' => '501',
        'check_in' => '2023-08-18',
        'check_out' => '2023-08-25',
        'guests' => 3,
        'status' => 'Pending',
        'payment' => 'Not Paid',
        'total' => 2099.93
    ],
    [
        'id' => 'RES-004',
        'guest_name' => 'Emily Wilson',
        'room_type' => 'Double Room',
        'room_number' => '210',
        'check_in' => '2023-08-05',
        'check_out' => '2023-08-08',
        'guests' => 2,
        'status' => 'Completed',
        'payment' => 'Paid',
        'total' => 359.97
    ]
];

// Reservation statistics
$reservationStats = [
    'total' => 125,
    'confirmed' => 85,
    'pending' => 25,
    'cancelled' => 15,
    'today_checkin' => 12,
    'today_checkout' => 8
];

// Include header
include 'includes/header.php';

// Include sidebar
include 'includes/sidebar.php';
?>

<div class="main-content">
    <div class="header">
        <div class="notification">
            <img src="<?php echo $imagesPath; ?>notification.png" alt="Notification Icon">
            <!-- Notification Container -->
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
    
    <!-- Reservation Content -->
    <div class="reservation-section">
        <h2>Reservation Management</h2>
        
        <!-- Reservation Statistics -->
        <div class="reservation-stats">
            <div class="stat-box">
                <h3>Total Reservations</h3>
                <p class="stat-value"><?php echo $reservationStats['total']; ?></p>
            </div>
            <div class="stat-box">
                <h3>Confirmed</h3>
                <p class="stat-value"><?php echo $reservationStats['confirmed']; ?></p>
            </div>
            <div class="stat-box">
                <h3>Pending</h3>
                <p class="stat-value"><?php echo $reservationStats['pending']; ?></p>
            </div>
            <div class="stat-box">
                <h3>Cancelled</h3>
                <p class="stat-value"><?php echo $reservationStats['cancelled']; ?></p>
            </div>
            <div class="stat-box">
                <h3>Today's Check-ins</h3>
                <p class="stat-value"><?php echo $reservationStats['today_checkin']; ?></p>
            </div>
            <div class="stat-box">
                <h3>Today's Check-outs</h3>
                <p class="stat-value"><?php echo $reservationStats['today_checkout']; ?></p>
            </div>
        </div>
        
        <!-- Reservation Controls -->
        <div class="reservation-controls">
            <button class="add-res-btn">Add New Reservation</button>
            <div class="search-filter">
                <input type="text" placeholder="Search reservations..." class="search-input">
                <select class="status-filter">
                    <option value="all">All Statuses</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="pending">Pending</option>
                    <option value="checked-in">Checked In</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <input type="date" class="date-filter" placeholder="Filter by date">
            </div>
        </div>
        
        <!-- Reservation Table -->
        <table class="reservation-table">
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Guest Name</th>
                    <th>Room Type</th>
                    <th>Room Number</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo $reservation['id']; ?></td>
                    <td><?php echo $reservation['guest_name']; ?></td>
                    <td><?php echo $reservation['room_type']; ?></td>
                    <td><?php echo $reservation['room_number']; ?></td>
                    <td><?php echo $reservation['check_in']; ?></td>
                    <td><?php echo $reservation['check_out']; ?></td>
                    <td><?php echo $reservation['guests']; ?></td>
                    <td><span class="status-<?php echo strtolower($reservation['status']); ?>"><?php echo $reservation['status']; ?></span></td>
                    <td><?php echo $reservation['payment']; ?></td>
                    <td>$<?php echo number_format($reservation['total'], 2); ?></td>
                    <td class="actions">
                        <button class="view-btn">View</button>
                        <button class="edit-btn">Edit</button>
                        <button class="cancel-btn">Cancel</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="pagination">
            <button class="prev-page">Previous</button>
            <span class="page-numbers">
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
            </span>
            <button class="next-page">Next</button>
        </div>
    </div>
</div>

<?php
// Add page-specific scripts
$pageScripts = <<<SCRIPT
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const notificationIcon = document.querySelector(".notification img");
        const notificationContainer = document.querySelector(".notification-container");

        notificationIcon.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevents click from bubbling up
            notificationContainer.classList.toggle("active");
        });

        document.addEventListener("click", function (event) {
            if (!notificationContainer.contains(event.target) && event.target !== notificationIcon) {
                notificationContainer.classList.remove("active");
            }
        });
        
        // Additional reservation page functionality
        const addResBtn = document.querySelector('.add-res-btn');
        if (addResBtn) {
            addResBtn.addEventListener('click', function() {
                alert('Add new reservation form would appear here');
            });
        }
        
        const viewButtons = document.querySelectorAll('.view-btn');
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const resId = row.cells[0].textContent;
                alert(`View details for reservation \${resId}`);
            });
        });
        
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const resId = row.cells[0].textContent;
                alert(`Edit form for reservation \${resId} would appear here`);
            });
        });
        
        const cancelButtons = document.querySelectorAll('.cancel-btn');
        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const resId = row.cells[0].textContent;
                if (confirm(`Are you sure you want to cancel reservation \${resId}?`)) {
                    alert(`Reservation \${resId} would be cancelled here`);
                }
            });
        });
    });
</script>
SCRIPT;

// Include footer
include 'includes/footer.php';
?>