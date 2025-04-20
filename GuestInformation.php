<?php
// Page-specific settings
$pageTitle = "Guest Information";
$pageCss = "css/guest-information.css";

// Define some variables for guest information (these could later be replaced with database queries)
$guests = [
    [
        'id' => 1,
        'name' => 'John Doe',
        'phone' => '+1-555-123-4567',
        'email' => 'john.doe@example.com',
        'room' => '101',
        'check_in' => '2023-08-01',
        'check_out' => '2023-08-05',
        'status' => 'Checked In'
    ],
    [
        'id' => 2,
        'name' => 'Jane Smith',
        'phone' => '+1-555-987-6543',
        'email' => 'jane.smith@example.com',
        'room' => '205',
        'check_in' => '2023-08-02',
        'check_out' => '2023-08-07',
        'status' => 'Checked In'
    ],
    [
        'id' => 3,
        'name' => 'Robert Johnson',
        'phone' => '+1-555-456-7890',
        'email' => 'robert.j@example.com',
        'room' => '310',
        'check_in' => '2023-08-03',
        'check_out' => '2023-08-06',
        'status' => 'Checked In'
    ]
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
    
    <!-- Guest Information Content -->
    <div class="guest-information">
        <h2>Guest Information</h2>
        
        <!-- Search and Filter Section -->
        <div class="search-filter">
            <input type="text" placeholder="Search guest..." class="search-input">
            <select class="filter-select">
                <option value="all">All Guests</option>
                <option value="checked-in">Checked In</option>
                <option value="checked-out">Checked Out</option>
                <option value="upcoming">Upcoming</option>
            </select>
            <button class="add-guest-btn">Add New Guest</button>
        </div>
        
        <!-- Guest List Table -->
        <table class="guest-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($guests as $guest): ?>
                <tr>
                    <td><?php echo $guest['id']; ?></td>
                    <td><?php echo $guest['name']; ?></td>
                    <td><?php echo $guest['phone']; ?></td>
                    <td><?php echo $guest['email']; ?></td>
                    <td><?php echo $guest['room']; ?></td>
                    <td><?php echo $guest['check_in']; ?></td>
                    <td><?php echo $guest['check_out']; ?></td>
                    <td><span class="status-<?php echo strtolower(str_replace(' ', '-', $guest['status'])); ?>"><?php echo $guest['status']; ?></span></td>
                    <td class="actions">
                        <button class="view-btn">View</button>
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
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
    // JavaScript for filtering and searching functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Example: Search functionality
        const searchInput = document.querySelector('.search-input');
        searchInput.addEventListener('input', function() {
            // Search logic would go here
            console.log('Searching for:', this.value);
        });
        
        // Example: Filter functionality
        const filterSelect = document.querySelector('.filter-select');
        filterSelect.addEventListener('change', function() {
            // Filter logic would go here
            console.log('Filtering by:', this.value);
        });
    });
</script>
SCRIPT;

// Include footer
include 'includes/footer.php';
?>