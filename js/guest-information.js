// Store all guest data in JavaScript
let allGuests = [];

// Pagination settings
const itemsPerPage = 10;
let currentPage = 1;
let filteredGuests = [];

// DOM elements - with safety checks
let guestTableBody, pageNumbers, prevPageBtn, nextPageBtn, searchInput, statusFilter;

// Initialize with data passed from PHP
function initializeGuestData(data) {
    // Initialize DOM elements
    guestTableBody = document.getElementById('guest-table-body');
    pageNumbers = document.getElementById('page-numbers');
    prevPageBtn = document.getElementById('prev-page');
    nextPageBtn = document.getElementById('next-page');
    searchInput = document.getElementById('guest-search');
    statusFilter = document.getElementById('status-filter');
    
    // Safety check for DOM elements
    if (!guestTableBody || !pageNumbers || !prevPageBtn || !nextPageBtn || !searchInput || !statusFilter) {
        console.error('Required DOM elements not found. Make sure all IDs exist in the HTML.');
        return;
    }
    
    // Initialize data
    allGuests = data;
    filteredGuests = [...allGuests];
    
    // Render the initial table
    renderGuestTable();
    
    // Set up event handlers
    setupEventListeners();
}

// Render the guest table with current page data
function renderGuestTable() {
    // Safety check
    if (!guestTableBody) return;
    
    // Clear the table
    guestTableBody.innerHTML = '';
    
    // Calculate start and end indices for current page
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, filteredGuests.length);
    
    // Render rows for current page
    for (let i = startIndex; i < endIndex; i++) {
        const guest = filteredGuests[i];
        const statusClass = guest.status.toLowerCase().replace(' ', '-');
        
        const row = document.createElement('tr');
        row.className = 'guest-row';
        row.setAttribute('data-index', i);
        
        row.innerHTML = `
            <td>${guest.id}</td>
            <td>${guest.name}</td>
            <td>${guest.email}</td>
            <td>${guest.phone}</td>
            <td>${guest.room}</td>
            <td>${guest.check_in}</td>
            <td>${guest.check_out}</td>
            <td>
                <span class="status-badge ${statusClass}">
                    ${guest.status}
                </span>
            </td>
            <td class="actions">
                <button class="action-btn view">View</button>
                <button class="action-btn edit">Edit</button>
                <button class="action-btn delete">Delete</button>
            </td>
        `;
        
        guestTableBody.appendChild(row);
    }
    
    // Add event listeners to action buttons
    setupActionButtons();
    
    // Update pagination
    updatePagination();
}

// Update pagination controls
function updatePagination() {
    // Safety check
    if (!pageNumbers || !prevPageBtn || !nextPageBtn) return;
    
    // Calculate total pages
    const totalPages = Math.ceil(filteredGuests.length / itemsPerPage);
    
    // Clear page numbers
    pageNumbers.innerHTML = '';
    
    // Only show pagination if we have more than 10 items
    if (filteredGuests.length > itemsPerPage) {
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
                renderGuestTable();
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
    if (!prevPageBtn || !nextPageBtn || !searchInput || !statusFilter) return;
    
    // Previous page button
    prevPageBtn.addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            renderGuestTable();
        }
    });
    
    // Next page button
    nextPageBtn.addEventListener('click', function() {
        const totalPages = Math.ceil(filteredGuests.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderGuestTable();
        }
    });
    
    // Search input
    searchInput.addEventListener('input', function() {
        filterGuests();
    });
    
    // Status filter
    statusFilter.addEventListener('change', function() {
        filterGuests();
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
    
    // Add new guest button
    const addGuestBtn = document.querySelector('.add-guest-btn');
    if (addGuestBtn) {
        addGuestBtn.addEventListener('click', function() {
            alert('Add new guest form would appear here');
        });
    }
}

// Filter guests based on search and status filter
function filterGuests() {
    // Safety check
    if (!searchInput || !statusFilter) return;
    
    const searchTerm = searchInput.value.toLowerCase();
    const statusValue = statusFilter.value.toLowerCase();
    
    filteredGuests = allGuests.filter(guest => {
        // Filter by search term (match against name, email, ID)
        const matchesSearch = 
            guest.id.toLowerCase().includes(searchTerm) ||
            guest.name.toLowerCase().includes(searchTerm) ||
            guest.email.toLowerCase().includes(searchTerm) ||
            guest.room.toLowerCase().includes(searchTerm);
        
        // Filter by status
        const matchesStatus = 
            statusValue === 'all' || 
            guest.status.toLowerCase().replace(' ', '-') === statusValue;
            
        return matchesSearch && matchesStatus;
    });
    
    // Reset to first page and render
    currentPage = 1;
    renderGuestTable();
}

// Setup action buttons for current page
function setupActionButtons() {
    // View buttons
    document.querySelectorAll('.action-btn.view').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const guestId = row.cells[0].textContent;
            alert(`View details for guest ${guestId}`);
        });
    });
    
    // Edit buttons
    document.querySelectorAll('.action-btn.edit').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const guestId = row.cells[0].textContent;
            alert(`Edit information for guest ${guestId}`);
        });
    });
    
    // Delete buttons
    document.querySelectorAll('.action-btn.delete').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const guestId = row.cells[0].textContent;
            if (confirm(`Are you sure you want to delete guest ${guestId}?`)) {
                alert(`Guest ${guestId} would be deleted here`);
            }
        });
    });
}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Data will be initialized from the PHP file
    // This is just a safety fallback if script was included manually
    if (typeof window.guestData !== 'undefined') {
        initializeGuestData(window.guestData);
    }
});