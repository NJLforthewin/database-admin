<?php
$pageTitle = "Guest Information";
$pageCss = "css/guest-information.css";

// Sample guest data - expanded to 12 entries to test pagination
$allGuests = [
    [
        'id' => 'G001',
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'phone' => '+1-555-123-4567',
        'room' => '101',
        'check_in' => '2023-08-01',
        'check_out' => '2023-08-05',
        'status' => 'Checked In'
    ],
    [
        'id' => 'G002',
        'name' => 'Jane Smith',
        'email' => 'jane.smith@example.com',
        'phone' => '+1-555-987-6543',
        'room' => '205',
        'check_in' => '2023-08-02',
        'check_out' => '2023-08-07',
        'status' => 'Reserved'
    ],
    [
        'id' => 'G003',
        'name' => 'Robert Johnson',
        'email' => 'robert.j@example.com',
        'phone' => '+1-555-456-7890',
        'room' => '310',
        'check_in' => '2023-08-03',
        'check_out' => '2023-08-06',
        'status' => 'Checked Out'
    ],
    [
        'id' => 'G004',
        'name' => 'Emily Davis',
        'email' => 'emily.d@example.com',
        'phone' => '+1-555-789-1234',
        'room' => '412',
        'check_in' => '2023-08-05',
        'check_out' => '2023-08-10',
        'status' => 'Checked In'
    ],
    [
        'id' => 'G005',
        'name' => 'Michael Wilson',
        'email' => 'michael.w@example.com',
        'phone' => '+1-555-321-6547',
        'room' => '201',
        'check_in' => '2023-08-05',
        'check_out' => '2023-08-08',
        'status' => 'Checked In'
    ],
    [
        'id' => 'G006',
        'name' => 'Sarah Brown',
        'email' => 'sarah.b@example.com',
        'phone' => '+1-555-654-9870',
        'room' => '115',
        'check_in' => '2023-08-07',
        'check_out' => '2023-08-09',
        'status' => 'Reserved'
    ],
    [
        'id' => 'G007',
        'name' => 'David Lee',
        'email' => 'david.l@example.com',
        'phone' => '+1-555-147-2583',
        'room' => '308',
        'check_in' => '2023-08-02',
        'check_out' => '2023-08-06',
        'status' => 'Checked Out'
    ],
    [
        'id' => 'G008',
        'name' => 'Jessica Taylor',
        'email' => 'jessica.t@example.com',
        'phone' => '+1-555-369-8521',
        'room' => '405',
        'check_in' => '2023-08-08',
        'check_out' => '2023-08-12',
        'status' => 'Reserved'
    ],
    [
        'id' => 'G009',
        'name' => 'Thomas Anderson',
        'email' => 'thomas.a@example.com',
        'phone' => '+1-555-951-7532',
        'room' => '203',
        'check_in' => '2023-08-01',
        'check_out' => '2023-08-04',
        'status' => 'Checked Out'
    ],
    [
        'id' => 'G010',
        'name' => 'Jennifer Martin',
        'email' => 'jennifer.m@example.com',
        'phone' => '+1-555-753-9512',
        'room' => '302',
        'check_in' => '2023-08-04',
        'check_out' => '2023-08-09',
        'status' => 'Checked In'
    ],
    [
        'id' => 'G011',
        'name' => 'Christopher White',
        'email' => 'chris.w@example.com',
        'phone' => '+1-555-852-3697',
        'room' => '110',
        'check_in' => '2023-08-10',
        'check_out' => '2023-08-15',
        'status' => 'Reserved'
    ],
    [
        'id' => 'G012',
        'name' => 'Amanda Clark',
        'email' => 'amanda.c@example.com',
        'phone' => '+1-555-258-7413',
        'room' => '215',
        'check_in' => '2023-08-05',
        'check_out' => '2023-08-07',
        'status' => 'Checked Out'
    ]
];

$headerExtras = '<script src="js/guest-information.js"></script>';

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
                    <li class="new">New guest check-in: John Doe</li>
                    <li class="new">Check-out reminder: Room 205</li>
                    <li>Guest information updated: G002</li>
                </ul>
            </div>
        </div>
        <div class="profile">
            <a href="profile.php"><img src="<?php echo $imagesPath; ?>Avatar.png" alt="Profile"></a>
        </div>
    </div>
    
    <div class="guest-section">
        <h2>Guest Information</h2>
        
        <div class="controls">
            <div class="search-box">
                <input type="text" placeholder="Search Guest" id="guest-search">
            </div>
            
            <select class="filter-select" id="status-filter">
                <option value="all">All Guests</option>
                <option value="checked-in">Checked In</option>
                <option value="checked-out">Checked Out</option>
                <option value="reserved">Reserved</option>
            </select>
            
            <button class="add-guest-btn">Add New Guest</button>
        </div>
        
        <div class="guest-table-container">
            <table class="guest-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Room</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="guest-table-body">
                    <?php foreach (array_slice($allGuests, 0, 10) as $guest): ?>
                    <tr class="guest-row">
                        <td><?php echo $guest['id']; ?></td>
                        <td><?php echo $guest['name']; ?></td>
                        <td><?php echo $guest['email']; ?></td>
                        <td><?php echo $guest['phone']; ?></td>
                        <td><?php echo $guest['room']; ?></td>
                        <td><?php echo $guest['check_in']; ?></td>
                        <td><?php echo $guest['check_out']; ?></td>
                        <td>
                            <span class="status-badge <?php echo strtolower(str_replace(' ', '-', $guest['status'])); ?>">
                                <?php echo $guest['status']; ?>
                            </span>
                        </td>
                        <td class="actions">
                            <button class="action-btn view">View</button>
                            <button class="action-btn edit">Edit</button>
                            <button class="action-btn delete">Delete</button>
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
                <?php if (count($allGuests) > 10): ?>
                <a href="javascript:void(0);">2</a>
                <?php endif; ?>
            </div>
            <button class="pagination-btn next" id="next-page">Next</button>
        </div>
    </div>
</div>

<?php
$pageScripts = '<script>document.addEventListener("DOMContentLoaded", function() { initializeGuestData(' . json_encode($allGuests) . '); });</script>';

include 'includes/footer.php';
?>