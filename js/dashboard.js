document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('occupancyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Occupancy Rate (%)',
                data: monthlyData,
                backgroundColor: '#007bff',
                borderWidth: 0,
                borderRadius: 4,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)',
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                }
            }
        }
    });
    
    const menuDots = document.querySelectorAll('.dots-menu');
    menuDots.forEach(dot => {
        dot.addEventListener('click', function() {
            alert('Menu options would appear here');
        });
    });
    
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    const currentMonthDisplay = document.getElementById('currentMonthDisplay');
    const calendarDates = document.getElementById('calendarDates');

    let busyDaysCache = {};
    
    busyDaysCache[`${currentYear}-${currentMonth}`] = busyDays;

    async function fetchBusyDays(year, month) {
        const cacheKey = `${year}-${month}`;
        
        if (busyDaysCache[cacheKey]) {
            return busyDaysCache[cacheKey];
        }
        
        try {
            const response = await fetch(`get_busy_days.php?year=${year}&month=${month}`);
            if (response.ok) {
                const data = await response.json();
                busyDaysCache[cacheKey] = data;
                return data;
            } else {
                console.error('Failed to fetch busy days');
                return [];
            }
        } catch (error) {
            console.error('Error fetching busy days:', error);
            return [];
        }
    }

    async function updateCalendar() {
        // Get days in month and first day of month
        const daysInMonth = new Date(currentDisplayYear, currentDisplayMonth, 0).getDate();
        const firstDayOfMonth = new Date(currentDisplayYear, currentDisplayMonth - 1, 1).getDay();
        
        const date = new Date(currentDisplayYear, currentDisplayMonth - 1, 1);
        currentMonthDisplay.textContent = date.toLocaleString('default', { month: 'long', year: 'numeric' });
        
        const currentBusyDays = await fetchBusyDays(currentDisplayYear, currentDisplayMonth);
        
        calendarDates.innerHTML = '';
        
        for (let i = 0; i < firstDayOfMonth; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-date empty';
            calendarDates.appendChild(emptyDay);
        }
        
        for (let day = 1; day <= daysInMonth; day++) {
            const dateCell = document.createElement('div');
            dateCell.className = 'calendar-date';
            dateCell.textContent = day;
            
            if (day === currentDay && 
                currentDisplayMonth === currentMonth && 
                currentDisplayYear === currentYear) {
                dateCell.classList.add('today');
            }
            
            if (currentBusyDays.includes(day)) {
                dateCell.classList.add('highlighted');
            }
            
            dateCell.addEventListener('click', function() {
                document.querySelectorAll('.calendar-date.selected').forEach(el => {
                    el.classList.remove('selected');
                });
                
                this.classList.add('selected');
                
                console.log('Selected: ' + currentDisplayYear + '-' + currentDisplayMonth + '-' + day);
                showDayDetails(currentDisplayYear, currentDisplayMonth, day);
            });
            
            calendarDates.appendChild(dateCell);
        }
        
        const totalCellsUsed = firstDayOfMonth + daysInMonth;
        const remainingCells = 7 - (totalCellsUsed % 7);
        
        if (remainingCells < 7) {
            for (let i = 0; i < remainingCells; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-date empty';
                calendarDates.appendChild(emptyDay);
            }
        }
    }
    
    function showDayDetails(year, month, day) {
        const dateStr = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
        console.log(`Showing details for: ${dateStr}`);
        }
    prevMonthBtn.addEventListener('click', function() {
        currentDisplayMonth--;
        if (currentDisplayMonth < 1) {
            currentDisplayMonth = 12;
            currentDisplayYear--;
        }
        updateCalendar();
    });

    nextMonthBtn.addEventListener('click', function() {
        currentDisplayMonth++;
        if (currentDisplayMonth > 12) {
            currentDisplayMonth = 1;
            currentDisplayYear++;
        }
        updateCalendar();
    });
    const viewToggle = document.getElementById('viewToggle');
    viewToggle.addEventListener('change', function() {        
        if (this.checked) {
            document.querySelector('.toggle-text').textContent = 'Monthly';
        } else {
            document.querySelector('.toggle-text').textContent = 'Weekly';
        }
    });

    updateCalendar();
});