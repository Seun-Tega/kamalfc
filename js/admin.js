// Admin specific JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Admin sidebar toggle for mobile
    const adminSidebar = document.querySelector('.admin-sidebar');
    const adminContent = document.querySelector('.admin-content');
    
    // You can add sidebar toggle functionality here if needed
    
    // Form validation for admin forms
    const adminForms = document.querySelectorAll('form');
    adminForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Add any admin-specific form validation here
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.style.borderColor = '#dc3545';
                } else {
                    field.style.borderColor = '';
                }
            });
            
            if (!valid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });

    // File upload size validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            if (file && file.size > maxSize) {
                alert('File size must be less than 5MB.');
                this.value = '';
            }
        });
    });

    // Table row actions
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.classList.contains('delete-btn')) {
                if (!confirm('Are you sure you want to delete this item?')) {
                    e.preventDefault();
                }
            }
        });
    });

    // Filter functionality
    const filterButtons = document.querySelectorAll('a[href*="filter="]');
    filterButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // You can add loading indicators or other UI feedback here
        });
    });

    // Modal functionality
    window.openStatsModal = function(playerId, goals, assists, cleanSheets) {
        document.getElementById('modalPlayerId').value = playerId;
        document.getElementById('modalGoals').value = goals;
        document.getElementById('modalAssists').value = assists;
        document.getElementById('modalCleanSheets').value = cleanSheets;
        document.getElementById('statsModal').style.display = 'flex';
    };

    window.closeStatsModal = function() {
        document.getElementById('statsModal').style.display = 'none';
    };

    // Close modal when clicking outside
    const statsModal = document.getElementById('statsModal');
    if (statsModal) {
        statsModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeStatsModal();
            }
        });
    }
});

// Utility functions for admin
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 4px;
        color: white;
        z-index: 10000;
        font-weight: bold;
    `;
    
    if (type === 'success') {
        notification.style.backgroundColor = '#28a745';
    } else if (type === 'error') {
        notification.style.backgroundColor = '#dc3545';
    } else {
        notification.style.backgroundColor = '#17a2b8';
    }
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Data export functionality (can be extended)
function exportTableToCSV(tableId, filename) {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    const rows = table.querySelectorAll('tr');
    const csv = [];
    
    for (let i = 0; i < rows.length; i++) {
        const row = [], cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length; j++) {
            // Clean innerText and remove commas
            const data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ');
            row.push('"' + data + '"');
        }
        
        csv.push(row.join(','));
    }
    
    // Download CSV file
    const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
    const downloadLink = document.createElement('a');
    
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = 'none';
    
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}