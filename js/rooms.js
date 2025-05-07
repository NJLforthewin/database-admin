let allRooms = [];
const itemsPerPage = 10;
let currentPage = 1;
let filteredRooms = [];

let roomTableBody;
let pageNumbers;
let prevPageBtn;
let nextPageBtn;
let searchInput;
let statusFilter;
let typeFilter;
let floorFilter;

function initializeRoomData(data) {
    roomTableBody = document.querySelector('.room-table tbody');
    pageNumbers = document.querySelector('.page-numbers');
    prevPageBtn = document.querySelector('.prev-page');
    nextPageBtn = document.querySelector('.next-page');
    searchInput = document.querySelector('.search-input');
    statusFilter = document.querySelector('.status-filter');
    typeFilter = document.querySelector('.type-filter');
    floorFilter = document.querySelector('.floor-filter');
    
    if (!roomTableBody || !pageNumbers || !prevPageBtn || !nextPageBtn || 
        !searchInput || !statusFilter || !typeFilter || !floorFilter) {
        console.error('Required DOM elements not found');
        return;
    }
    
    allRooms = data;
    filteredRooms = [...allRooms];
    
    renderRoomTable();
    setupEventListeners();
}

function renderRoomTable() {
    if (!roomTableBody) return;
    
    roomTableBody.innerHTML = '';
    
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, filteredRooms.length);
    
    for (let i = startIndex; i < endIndex; i++) {
        const room = filteredRooms[i];
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>${room.room_number}</td>
            <td>${room.type}</td>
            <td>${room.floor}</td>
            <td>$${parseFloat(room.price).toFixed(2)}</td>
            <td><span class="status-${room.status.toLowerCase()}">${room.status}</span></td>
            <td>${room.features}</td>
            <td>${room.last_cleaned}</td>
            <td class="actions">
                <button class="view-btn">View</button>
                <button class="edit-btn">Edit</button>
                ${room.status === 'Available' ? 
                    '<button class="book-btn">Book</button>' : 
                    (room.status === 'Occupied' ? 
                        '<button class="checkout-btn">Check-out</button>' : 
                        '<button class="status-btn">Change Status</button>')}
            </td>
        `;
        
        roomTableBody.appendChild(row);
    }
    
    setupActionButtons();
    updatePagination();
}

function updatePagination() {
    if (!pageNumbers || !prevPageBtn || !nextPageBtn) return;
    
    const totalPages = Math.ceil(filteredRooms.length / itemsPerPage);
    
    pageNumbers.innerHTML = '';
    
    if (filteredRooms.length > itemsPerPage) {
        for (let i = 1; i <= totalPages; i++) {
            const pageNumber = document.createElement('a');
            pageNumber.href = 'javascript:void(0);';
            pageNumber.textContent = i;
            
            if (i === currentPage) {
                pageNumber.className = 'active';
            }
            
            pageNumber.addEventListener('click', function() {
                currentPage = i;
                renderRoomTable();
            });
            
            pageNumbers.appendChild(pageNumber);
        }
        
        prevPageBtn.style.display = 'block';
        nextPageBtn.style.display = 'block';
        
        prevPageBtn.disabled = currentPage <= 1;
        nextPageBtn.disabled = currentPage >= totalPages;
    } else {
        prevPageBtn.style.display = 'none';
        nextPageBtn.style.display = 'none';
    }
}

function setupEventListeners() {
    if (!prevPageBtn || !nextPageBtn || !searchInput || 
        !statusFilter || !typeFilter || !floorFilter) return;
    
    prevPageBtn.addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            renderRoomTable();
        }
    });
    
    nextPageBtn.addEventListener('click', function() {
        const totalPages = Math.ceil(filteredRooms.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderRoomTable();
        }
    });
    
    searchInput.addEventListener('input', filterRooms);
    statusFilter.addEventListener('change', filterRooms);
    typeFilter.addEventListener('change', filterRooms);
    floorFilter.addEventListener('change', filterRooms);
    
    const addRoomBtn = document.querySelector('.add-room-btn');
    if (addRoomBtn) {
        addRoomBtn.addEventListener('click', function() {
            alert('Add new room form would appear here');
        });
    }
}

function filterRooms() {
    if (!searchInput || !statusFilter || !typeFilter || !floorFilter) return;
    
    const searchTerm = searchInput.value.toLowerCase();
    const statusValue = statusFilter.value.toLowerCase();
    const typeValue = typeFilter.value.toLowerCase();
    const floorValue = floorFilter.value.toLowerCase();
    
    filteredRooms = allRooms.filter(room => {
        const matchesSearch = 
            room.room_number.toLowerCase().includes(searchTerm) ||
            room.type.toLowerCase().includes(searchTerm) ||
            room.features.toLowerCase().includes(searchTerm);
            
        const matchesStatus = 
            statusValue === 'all' || 
            room.status.toLowerCase() === statusValue;
            
        const matchesType = 
            typeValue === 'all' || 
            room.type.toLowerCase().includes(typeValue);
            
        const matchesFloor = 
            floorValue === 'all' || 
            room.floor === floorValue;
            
        return matchesSearch && matchesStatus && matchesType && matchesFloor;
    });
    
    currentPage = 1;
    renderRoomTable();
}

function setupActionButtons() {
    document.querySelectorAll('.view-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const roomNumber = row.cells[0].textContent;
            alert(`View details for room ${roomNumber}`);
        });
    });
    
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const roomNumber = row.cells[0].textContent;
            alert(`Edit form for room ${roomNumber} would appear here`);
        });
    });
    
    document.querySelectorAll('.book-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const roomNumber = row.cells[0].textContent;
            alert(`Booking form for room ${roomNumber} would appear here`);
        });
    });
    
    document.querySelectorAll('.checkout-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const roomNumber = row.cells[0].textContent;
            if (confirm(`Are you sure you want to check-out room ${roomNumber}?`)) {
                alert(`Room ${roomNumber} would be checked out here`);
            }
        });
    });
    
    document.querySelectorAll('.status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const roomNumber = row.cells[0].textContent;
            const currentStatus = row.cells[4].textContent;
            alert(`Status change form for room ${roomNumber} (currently ${currentStatus}) would appear here`);
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.roomsData !== 'undefined') {
        initializeRoomData(window.roomsData);
    }
});