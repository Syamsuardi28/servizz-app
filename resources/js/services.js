/**
 * Services Page - JavaScript
 * Lokasi: resources/js/services.js
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize modal auto-open on validation errors
    initModalAutoOpen();
    
    // Initialize search functionality
    initSearchTable();
});

/**
 * Auto-open modal if there are validation errors
 */
function initModalAutoOpen() {
    // Check if there's an element with errors attribute or specific error container
    const errorElements = document.querySelectorAll('.invalid-feedback');
    
    if(errorElements.length > 0) {
        const modalElement = document.getElementById('modalAdd');
        if(modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }
    }
}

/**
 * Search functionality for services table
 */
function initSearchTable() {
    const searchInput = document.getElementById('searchTable');
    
    if(!searchInput) return;
    
    searchInput.addEventListener('keyup', function(e) {
        const searchValue = e.target.value.toLowerCase().trim();
        const rows = document.querySelectorAll('.table-row');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const isMatch = text.includes(searchValue);
            
            row.style.display = isMatch ? '' : 'none';
            if(isMatch) visibleCount++;
        });
        
        // Optional: Show message if no results
        displaySearchResults(visibleCount, rows.length);
    });
    
    // Add focus styling
    searchInput.addEventListener('focus', function() {
        this.parentElement?.classList.add('focused');
    });
    
    searchInput.addEventListener('blur', function() {
        this.parentElement?.classList.remove('focused');
    });
}

/**
 * Display search results info
 */
function displaySearchResults(visibleCount, totalCount) {
    if(visibleCount === 0 && totalCount > 0) {
        console.log('Tidak ada hasil pencarian');
    }
}

/**
 * Initialize edit button functionality (ready for future implementation)
 */
function initEditButtons() {
    const editButtons = document.querySelectorAll('.svz-table-action-btn:not(.danger)');
    
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // TODO: Implement edit functionality
            console.log('Edit button clicked');
        });
    });
}

/**
 * Initialize delete button functionality (ready for future implementation)
 */
function initDeleteButtons() {
    const deleteButtons = document.querySelectorAll('.svz-table-action-btn.danger');
    
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // TODO: Implement delete with confirmation
            if(confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
                console.log('Delete confirmed');
            }
        });
    });
}

// Export functions for external use if needed
export { initModalAutoOpen, initSearchTable, initEditButtons, initDeleteButtons };
