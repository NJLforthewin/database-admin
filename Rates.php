<?php
// Page-specific settings
$pageTitle = "Rates Management";
$pageCss = "css/rates.css";

// Define room rate data (these could later be replaced with database queries)
$roomRates = [
    [
        'room_type' => 'Single Room',
        'weekday_rate' => 89.99,
        'weekend_rate' => 109.99,
        'holiday_rate' => 129.99,
        'description' => 'Comfortable single room with all basic amenities'
    ],
    [
        'room_type' => 'Double Room',
        'weekday_rate' => 119.99,
        'weekend_rate' => 149.99,
        'holiday_rate' => 179.99,
        'description' => 'Spacious double room with king-size bed'
    ],
    [
        'room_type' => 'Deluxe Room',
        'weekday_rate' => 159.99,
        'weekend_rate' => 189.99,
        'holiday_rate' => 209.99,
        'description' => 'Luxury room with premium amenities and city view'
    ],
    [
        'room_type' => 'VIP Suite',
        'weekday_rate' => 259.99,
        'weekend_rate' => 299.99,
        'holiday_rate' => 349.99,
        'description' => 'Exclusive suite with separate living area and premium services'
    ]
];

// Define seasons and special rates
$seasons = [
    [
        'name' => 'Summer Season',
        'start_date' => '2023-06-01',
        'end_date' => '2023-08-31',
        'rate_multiplier' => 1.25
    ],
    [
        'name' => 'Winter Holiday',
        'start_date' => '2023-12-15',
        'end_date' => '2024-01-05',
        'rate_multiplier' => 1.5
    ],
    [
        'name' => 'Spring Break',
        'start_date' => '2023-03-01',
        'end_date' => '2023-04-15',
        'rate_multiplier' => 1.15
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
    
    <!-- Rates Content -->
    <div class="rates-section">
        <h2>Room Rates Management</h2>
        
        <!-- Room Rates Table -->
        <div class="rate-table-container">
            <div class="controls">
                <button class="add-rate-btn">Add New Rate</button>
                <select class="rate-filter">
                    <option value="all">All Room Types</option>
                    <option value="single">Single Room</option>
                    <option value="double">Double Room</option>
                    <option value="deluxe">Deluxe Room</option>
                    <option value="vip">VIP Suite</option>
                </select>
            </div>
            
            <table class="rate-table">
                <thead>
                    <tr>
                        <th>Room Type</th>
                        <th>Weekday Rate</th>
                        <th>Weekend Rate</th>
                        <th>Holiday Rate</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roomRates as $rate): ?>
                    <tr>
                        <td><?php echo $rate['room_type']; ?></td>
                        <td>$<?php echo number_format($rate['weekday_rate'], 2); ?></td>
                        <td>$<?php echo number_format($rate['weekend_rate'], 2); ?></td>
                        <td>$<?php echo number_format($rate['holiday_rate'], 2); ?></td>
                        <td><?php echo $rate['description']; ?></td>
                        <td class="actions">
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Seasonal Rates Section -->
        <h3>Seasonal Rates</h3>
        <div class="season-container">
            <button class="add-season-btn">Add New Season</button>
            
            <table class="season-table">
                <thead>
                    <tr>
                        <th>Season Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Rate Multiplier</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($seasons as $season): ?>
                    <tr>
                        <td><?php echo $season['name']; ?></td>
                        <td><?php echo $season['start_date']; ?></td>
                        <td><?php echo $season['end_date']; ?></td>
                        <td>x<?php echo $season['rate_multiplier']; ?></td>
                        <td class="actions">
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// Add page-specific scripts
$pageScripts = <<<SCRIPT
<script>
    // JavaScript for rate management functionalities
    document.addEventListener('DOMContentLoaded', function() {
        // Event listeners for buttons
        const addRateBtn = document.querySelector('.add-rate-btn');
        if (addRateBtn) {
            addRateBtn.addEventListener('click', function() {
                alert('Add new rate functionality would be implemented here');
            });
        }
        
        const addSeasonBtn = document.querySelector('.add-season-btn');
        if (addSeasonBtn) {
            addSeasonBtn.addEventListener('click', function() {
                alert('Add new season functionality would be implemented here');
            });
        }
        
        // Edit and Delete buttons
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const firstCell = row.querySelector('td').textContent;
                alert(`Edit functionality for \${firstCell} would be implemented here`);
            });
        });
        
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const firstCell = row.querySelector('td').textContent;
                if (confirm(`Are you sure you want to delete \${firstCell}?`)) {
                    alert(`Delete functionality for \${firstCell} would be implemented here`);
                }
            });
        });
    });
</script>
SCRIPT;

// Include footer
include 'includes/footer.php';
?>