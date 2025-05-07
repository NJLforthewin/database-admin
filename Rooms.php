<?php
$pageTitle = "Room Management";
$pageCss = "css/rooms.css";

$headerExtras = '<script src="js/rooms.js"></script>';

$rooms = [
    [
        'room_number' => '101',
        'type' => 'Single Room',
        'floor' => '1',
        'price' => 89.99,
        'status' => 'Available',
        'features' => 'Wi-Fi, TV, Air Conditioning, Mini Fridge',
        'last_cleaned' => '2023-08-10'
    ],
    [
        'room_number' => '102',
        'type' => 'Single Room',
        'floor' => '1',
        'price' => 89.99,
        'status' => 'Occupied',
        'features' => 'Wi-Fi, TV, Air Conditioning, Mini Fridge',
        'last_cleaned' => '2023-08-08'
    ],
    [
        'room_number' => '201',
        'type' => 'Double Room',
        'floor' => '2',
        'price' => 119.99,
        'status' => 'Available',
        'features' => 'Wi-Fi, TV, Air Conditioning, Mini Fridge, Balcony',
        'last_cleaned' => '2023-08-09'
    ],
    [
        'room_number' => '202',
        'type' => 'Double Room',
        'floor' => '2',
        'price' => 119.99,
        'status' => 'Maintenance',
        'features' => 'Wi-Fi, TV, Air Conditioning, Mini Fridge, Balcony',
        'last_cleaned' => '2023-08-07'
    ],
    [
        'room_number' => '301',
        'type' => 'Deluxe Room',
        'floor' => '3',
        'price' => 159.99,
        'status' => 'Occupied',
        'features' => 'Wi-Fi, TV, Air Conditioning, Mini Bar, Balcony, City View',
        'last_cleaned' => '2023-08-05'
    ],
    [
        'room_number' => '302',
        'type' => 'Deluxe Room',
        'floor' => '3',
        'price' => 159.99,
        'status' => 'Cleaning',
        'features' => 'Wi-Fi, TV, Air Conditioning, Mini Bar, Balcony, City View',
        'last_cleaned' => '2023-08-09'
    ],
    [
        'room_number' => '303',
        'type' => 'Deluxe Room',
        'floor' => '3',
        'price' => 159.99,
        'status' => 'Available',
        'features' => 'Wi-Fi, TV, Air Conditioning, Mini Bar, Balcony, City View',
        'last_cleaned' => '2023-08-10'
    ],
    [
        'room_number' => '401',
        'type' => 'Double Room',
        'floor' => '4',
        'price' => 119.99,
        'status' => 'Occupied',
        'features' => 'Wi-Fi, TV, Air Conditioning, Mini Fridge, Balcony',
        'last_cleaned' => '2023-08-06'
    ],
    [
        'room_number' => '402',
        'type' => 'Double Room',
        'floor' => '4',
        'price' => 119.99,
        'status' => 'Occupied',
        'features' => 'Wi-Fi, TV, Air Conditioning, Mini Fridge, Balcony',
        'last_cleaned' => '2023-08-07'
    ],
    [
        'room_number' => '501',
        'type' => 'VIP Suite',
        'floor' => '5',
        'price' => 259.99,
        'status' => 'Available',
        'features' => 'Wi-Fi, Smart TV, Air Conditioning, Full Bar, Balcony, Ocean View, Jacuzzi',
        'last_cleaned' => '2023-08-10'
    ],
    [
        'room_number' => '502',
        'type' => 'VIP Suite',
        'floor' => '5',
        'price' => 259.99,
        'status' => 'Occupied',
        'features' => 'Wi-Fi, Smart TV, Air Conditioning, Full Bar, Balcony, Ocean View, Jacuzzi',
        'last_cleaned' => '2023-08-09'
    ]
];

$roomStats = [
    'total' => 100,
    'available' => 45,
    'occupied' => 48,
    'maintenance' => 5,
    'cleaning' => 2
];

// Convert data to JSON for JavaScript
$roomsJson = json_encode($rooms);

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
                    <li class="new">Room 302 cleaning completed</li>
                    <li class="new">Maintenance request: Room 202</li>
                    <li>Room 101 is now available</li>
                    <li>New booking: Room 501</li>
                </ul>
            </div>
        </div>
        <div class="profile">
            <a href="profile.php"><img src="<?php echo $imagesPath; ?>Avatar.png" alt="Profile"></a>
        </div>
    </div>
    
    <div class="rooms-section">
        <h2>Room Management</h2>
        
        <div class="room-stats">
            <div class="stat-box">
                <h3>Total Rooms</h3>
                <p class="stat-value"><?php echo $roomStats['total']; ?></p>
            </div>
            <div class="stat-box available">
                <h3>Available</h3>
                <p class="stat-value"><?php echo $roomStats['available']; ?></p>
            </div>
            <div class="stat-box occupied">
                <h3>Occupied</h3>
                <p class="stat-value"><?php echo $roomStats['occupied']; ?></p>
            </div>
            <div class="stat-box maintenance">
                <h3>Maintenance</h3>
                <p class="stat-value"><?php echo $roomStats['maintenance']; ?></p>
            </div>
            <div class="stat-box cleaning">
                <h3>Cleaning</h3>
                <p class="stat-value"><?php echo $roomStats['cleaning']; ?></p>
            </div>
        </div>
        
        <div class="room-controls">
            <button class="add-room-btn">Add New Room</button>
            <div class="search-filter">
                <input type="text" placeholder="Search rooms..." class="search-input">
                <select class="status-filter">
                    <option value="all">All Statuses</option>
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="cleaning">Cleaning</option>
                </select>
                <select class="type-filter">
                    <option value="all">All Types</option>
                    <option value="single">Single Room</option>
                    <option value="double">Double Room</option>
                    <option value="deluxe">Deluxe Room</option>
                    <option value="vip">VIP Suite</option>
                </select>
                <select class="floor-filter">
                    <option value="all">All Floors</option>
                    <option value="1">Floor 1</option>
                    <option value="2">Floor 2</option>
                    <option value="3">Floor 3</option>
                    <option value="4">Floor 4</option>
                    <option value="5">Floor 5</option>
                </select>
            </div>
        </div>
        
        <div class="room-table-container">
            <table class="room-table">
                <thead>
                    <tr>
                        <th>Room No.</th>
                        <th>Type</th>
                        <th>Floor</th>
                        <th>Price/Night</th>
                        <th>Status</th>
                        <th>Features</th>
                        <th>Last Cleaned</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($rooms, 0, 10) as $room): ?>
                    <tr>
                        <td><?php echo $room['room_number']; ?></td>
                        <td><?php echo $room['type']; ?></td>
                        <td><?php echo $room['floor']; ?></td>
                        <td>$<?php echo number_format($room['price'], 2); ?></td>
                        <td><span class="status-<?php echo strtolower($room['status']); ?>"><?php echo $room['status']; ?></span></td>
                        <td><?php echo $room['features']; ?></td>
                        <td><?php echo $room['last_cleaned']; ?></td>
                        <td class="actions">
                            <button class="view-btn">View</button>
                            <button class="edit-btn">Edit</button>
                            <?php if ($room['status'] == 'Available'): ?>
                            <button class="book-btn">Book</button>
                            <?php elseif ($room['status'] == 'Occupied'): ?>
                            <button class="checkout-btn">Check-out</button>
                            <?php else: ?>
                            <button class="status-btn">Change Status</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="pagination">
            <button class="prev-page">Previous</button>
            <div class="page-numbers">
                <a href="javascript:void(0);" class="active">1</a>
                <?php if (count($rooms) > 10): ?>
                <a href="javascript:void(0);">2</a>
                <?php endif; ?>
            </div>
            <button class="next-page">Next</button>
        </div>
    </div>
</div>

<script>
    // Prepare room data for JavaScript
    window.roomsData = <?php echo $roomsJson; ?>;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Notification functionality
        const notificationIcon = document.querySelector(".notification img");
        const notificationContainer = document.querySelector(".notification-container");

        if (notificationIcon && notificationContainer) {
            notificationIcon.addEventListener("click", function(event) {
                event.stopPropagation();
                notificationContainer.classList.toggle("active");
            });
            
            document.addEventListener("click", function(event) {
                if (!notificationContainer.contains(event.target) && event.target !== notificationIcon) {
                    notificationContainer.classList.remove("active");
                }
            });
        }
        
        // Initialize room data
        initializeRoomData(window.roomsData);
    });
</script>

<?php
include 'includes/footer.php';
?>