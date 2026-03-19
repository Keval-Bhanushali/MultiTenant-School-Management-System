// ============================================
// MAIN JAVASCRIPT - SCHOOL MANAGEMENT SYSTEM
// ============================================

// Utility Functions
const Utils = {
    /**
     * Show toast notification
     */
    showToast: (message, type = 'success') => {
        const toastHTML = `
            <div class="toast fade show" role="alert">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                    ${message}
                </div>
            </div>
        `;
        const container = document.querySelector('.toast-container') || createToastContainer();
        container.insertAdjacentHTML('beforeend', toastHTML);
        
        setTimeout(() => {
            const toasts = document.querySelectorAll('.toast');
            toasts[toasts.length - 1].remove();
        }, 3000);
    },

    /**
     * Format date
     */
    formatDate: (date) => {
        return new Date(date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    },

    /**
     * Format time
     */
    formatTime: (date) => {
        return new Date(date).toLocaleTimeString('en-US');
    },

    /**
     * Debounce function
     */
    debounce: (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    /**
     * Show loading spinner
     */
    showSpinner: (element = null) => {
        const spinner = `
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        `;
        if (element) {
            element.innerHTML = spinner;
        } else {
            document.body.innerHTML = spinner;
        }
    },

    /**
     * Validate email
     */
    validateEmail: (email) => {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    },

    /**
     * Check if element is in viewport
     */
    isInViewport: (element) => {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
};

// Create toast container if it doesn't exist
function createToastContainer() {
    const container = document.createElement('div');
    container.className = 'toast-container';
    container.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
    `;
    document.body.appendChild(container);
    return container;
}

// ===========================================
// API Handler
// ===========================================

const API = {
    /**
     * GET request
     */
    get: async (url) => {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content
                }
            });
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            Utils.showToast('Error fetching data', 'error');
        }
    },

    /**
     * POST request
     */
    post: async (url, data) => {
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify(data)
            });
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            Utils.showToast('Error sending data', 'error');
        }
    },

    /**
     * PUT request
     */
    put: async (url, data) => {
        try {
            const response = await fetch(url, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify(data)
            });
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            Utils.showToast('Error updating data', 'error');
        }
    },

    /**
     * DELETE request
     */
    delete: async (url) => {
        try {
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content
                }
            });
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            Utils.showToast('Error deleting data', 'error');
        }
    }
};

// ===========================================
// DOM Ready Initialization
// ===========================================

document.addEventListener('DOMContentLoaded', () => {
    // Initialize tooltips
    initializeTooltips();
    
    // Initialize popovers
    initializePopovers();
    
    // Lazy load images
    lazyLoadImages();
    
    // Setup responsive behavior
    setupResponsive();

    console.log('✅ UI System Loaded Successfully');
});

// Initialize Bootstrap tooltips
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
}

// Initialize Bootstrap popovers
function initializePopovers() {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
}

// Lazy load images for better performance
function lazyLoadImages() {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    images.forEach(img => imageObserver.observe(img));
}

// Setup responsive behavior
function setupResponsive() {
    // Mobile menu toggle
    const toggleMobileMenu = () => {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.classList.toggle('show');
        }
    };

    // Add event listener to menu toggle button if it exists
    const menuToggle = document.querySelector('[data-toggle="mobile-menu"]');
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleMobileMenu);
    }

    // Close sidebar on window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.remove('show');
            }
        }
    });
}

// ===========================================
// Enhanced Form Handling
// ===========================================

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', async (e) => {
        // Add loading state to submit button
        const submitBtn = form.querySelector('[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
        }
    });
});

// ===========================================
// Real-time Search/Filter
// ===========================================

const setupSearchFilter = (searchInputSelector, tableSelector) => {
    const searchInput = document.querySelector(searchInputSelector);
    const table = document.querySelector(tableSelector);

    if (searchInput && table) {
        searchInput.addEventListener('keyup', Utils.debounce(() => {
            const query = searchInput.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        }, 300));
    }
};

// ===========================================
// Confirmation Dialog
// ===========================================

function confirmAction(message = 'Are you sure?', callback = null) {
    if (confirm(message)) {
        if (typeof callback === 'function') {
            callback();
        }
        return true;
    }
    return false;
}

// ===========================================
// Export functions that can be used globally
// ===========================================

window.Utils = Utils;
window.API = API;
window.setupSearchFilter = setupSearchFilter;
window.confirmAction = confirmAction;

// ===========================================
// Performance Optimization
// ===========================================

// Preload critical resources
if ('link' in document) {
    const link = document.createElement('link');
    link.rel = 'prefetch';
    link.as = 'script';
    link.href = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js';
    document.head.appendChild(link);
}

// Use Service Worker for offline support (optional)
if ('serviceWorker' in navigator) {
    // navigator.serviceWorker.register('/sw.js').catch(e => console.log('SW registration failed'));
}

console.log('🚀 School Management System Ready');
