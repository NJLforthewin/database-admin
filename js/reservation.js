// Store all reservation data in JavaScript
let allReservations = [];

// Pagination settings
const itemsPerPage = 10;
let currentPage = 1;
let filteredReservations = [];

// DOM elements - with safety checks
let reservationTableBody, pageNumbers, prevPageBtn, nextPageBtn, searchInput;

// Initialize with data passed from PHP
function initializeReservationData(data) {
    // Initialize DOM elements
    reservationTableBody = document.getElementById('reservation-table-body');
    pageNumbers = document.getElementById('page-numbers');
    prevPageBtn = document.getElementById('prev-page');
    nextPageBtn = document.getElementById('next-page');
    searchInput = document.getElementById('reservation-search');
    
    // Safety check for DOM elements
    if (!reservationTableBody || !pageNumbers || !prevPageBtn || !nextPageBtn || !searchInput) {
        console.error('Required DOM elements not found. Make sure all IDs exist in the HTML.');
        return;
    }
    
    // Initialize data
    allReservations = data;
    filteredReservations = [...allReservations];
    
    // Render the initial table
    renderReservationTable();
    
    // Set up event handlers
    setupEventListeners();
}

// Render the reservation table with current page data
function renderReservationTable() {
    // Safety check
    if (!reservationTableBody) return;
    
    // Clear the table
    reservationTableBody.innerHTML = '';
    
    // Calculate start and end indices for current page
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, filteredReservations.length);
    
    // Render rows for current page
    for (let i = startIndex; i < endIndex; i++) {
        const reservation = filteredReservations[i];
        const statusClass = reservation.status.toLowerCase().replace(' ', '-');
        
        const row = document.createElement('tr');
        row.className = 'reservation-row';
        row.setAttribute('data-index', i);
        
        row.innerHTML = `
            <td>${reservation.id}</td>
            <td>${reservation.name}</td>
            <td>${reservation.room_number}</td>
            <td>$ ${reservation.total_amount}</td>
            <td>$ ${reservation.amount_paid}</td>
            <td>${reservation.room_type}</td>
            <td>
                <span class="status-indicator ${statusClass}">
                    ${reservation.status}
                </span>
            </td>
            <td>${reservation.payment_status}</td>
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
        `;
        
        reservationTableBody.appendChild(row);
    }
    
    // Add event listeners to action menus
    setupActionMenus();
    
    // Update pagination
    updatePagination();
}

// Update pagination controls
function updatePagination() {
    // Safety check
    if (!pageNumbers || !prevPageBtn || !nextPageBtn) return;
    
    // Calculate total pages
    const totalPages = Math.ceil(filteredReservations.length / itemsPerPage);
    
    // Clear page numbers
    pageNumbers.innerHTML = '';
    
    // Only show pagination if we have more than 10 items
    if (filteredReservations.length > itemsPerPage) {
        // Add page numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageNumber = document.createElement('a');
            pageNumber.href = 'javascript:void(0);';
            pageNumber.textContent = i;
            
            if (i === currentPage) {
                pageNumber.className = 'active';
            }
            
            pageNumber.addEventListener('click', function() {
                currentPage = i;
                renderReservationTable();
            });
            
            pageNumbers.appendChild(pageNumber);
        }
        
        // Show previous/next buttons
        prevPageBtn.style.display = 'block';
        nextPageBtn.style.display = 'block';
        
        // Enable/disable previous button
        prevPageBtn.disabled = currentPage <= 1;
        
        // Enable/disable next button - critical fix
        nextPageBtn.disabled = currentPage >= totalPages;
        
        // Ensure button is clickable if not disabled
        if (currentPage < totalPages) {
            nextPageBtn.classList.remove('disabled');
        } else {
            nextPageBtn.classList.add('disabled');
        }
    } else {
        // Hide pagination if only one page
        prevPageBtn.style.display = 'none';
        nextPageBtn.style.display = 'none';
    }
}

// Setup event listeners
function setupEventListeners() {
    // Safety check
    if (!prevPageBtn || !nextPageBtn || !searchInput) return;
    
    // Previous page button
    prevPageBtn.addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            renderReservationTable();
        }
    });
    
    // Next page button
    nextPageBtn.addEventListener('click', function() {
        const totalPages = Math.ceil(filteredReservations.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderReservationTable();
        }
    });
    
    // Search input
    searchInput.addEventListener('input', function() {
        filterReservations();
    });
    
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
    
    // Action buttons
    const checkInBtn = document.querySelector('.check-in');
    const checkOutBtn = document.querySelector('.check-out');
    const editResBtn = document.querySelector('.edit-res');
    const filterBtn = document.querySelector('.filter-btn');
    
    if (checkInBtn) {
        checkInBtn.addEventListener('click', function() {
            alert('Check-in process would start here');
        });
    }
    
    if (checkOutBtn) {
        checkOutBtn.addEventListener('click', function() {
            alert('Check-out process would start here');
        });
    }
    
    if (editResBtn) {
        editResBtn.addEventListener('click', function() {
            alert('Edit reservation form would appear here');
        });
    }
    
    if (filterBtn) {
        filterBtn.addEventListener('click', function() {
            alert('Filter options would appear here');
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.matches('.action-dots')) {
            document.querySelectorAll('.action-dropdown.active').forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        }
    });
}

// Filter reservations based on search
function filterReservations() {
    // Safety check
    if (!searchInput) return;
    
    const searchTerm = searchInput.value.toLowerCase();
    
    filteredReservations = allReservations.filter(reservation => {
        return reservation.id.toLowerCase().includes(searchTerm) ||
               reservation.name.toLowerCase().includes(searchTerm) ||
               reservation.room_number.toLowerCase().includes(searchTerm) ||
               reservation.room_type.toLowerCase().includes(searchTerm);
    });
    
    // Reset to first page and render
    currentPage = 1;
    renderReservationTable();
}

// Setup action menus for current page
function setupActionMenus() {
    // Action dots toggle
    const actionDots = document.querySelectorAll('.action-dots');
    actionDots.forEach(dots => {
        dots.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Close all other open dropdowns
            document.querySelectorAll('.action-dropdown.active').forEach(dropdown => {
                if (dropdown !== this.nextElementSibling) {
                    dropdown.classList.remove('active');
                }
            });
            
            // Toggle current dropdown
            const dropdown = this.nextElementSibling;
            dropdown.classList.toggle('active');
        });
    });
    
    // View details action
    document.querySelectorAll('.view-details').forEach(link => {
        link.addEventListener('click', function() {
            const row = this.closest('tr');
            const reservationId = row.cells[0].textContent;
            alert(`View details for reservation ${reservationId}`);
        });
    });
    
    // Edit reservation action
    document.querySelectorAll('.edit-reservation').forEach(link => {
        link.addEventListener('click', function() {
            const row = this.closest('tr');
            const reservationId = row.cells[0].textContent;
            alert(`Edit form for reservation ${reservationId} would appear here`);
        });
    });
    
    // Cancel reservation action
    document.querySelectorAll('.cancel-reservation').forEach(link => {
        link.addEventListener('click', function() {
            const row = this.closest('tr');
            const reservationId = row.cells[0].textContent;
            if (confirm(`Are you sure you want to cancel reservation ${reservationId}?`)) {
                alert(`Reservation ${reservationId} would be cancelled here`);
            }
        });
    });
}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Data will be initialized from the PHP file
    // This is just a safety fallback if script was included manually
    if (typeof window.reservationData !== 'undefined') {
        initializeReservationData(window.reservationData);
    }
});