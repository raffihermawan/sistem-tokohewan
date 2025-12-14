// script.js - Responsive UI helpers and interactivity
console.log('Petshop Management System loaded');

document.addEventListener('DOMContentLoaded', function() {
  // ========== Sidebar Mobile Toggle ==========
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');
  const wrapper = document.getElementById('wrapper');

  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', function(e) {
      e.preventDefault();
      sidebar.classList.toggle('show');
    });

    // Close sidebar when clicking on a link (mobile)
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
      link.addEventListener('click', function() {
        if (window.innerWidth < 768) {
          sidebar.classList.remove('show');
        }
      });
    });

    // Close sidebar when clicking outside (mobile)
    document.addEventListener('click', function(event) {
      const isClickInsideSidebar = sidebar.contains(event.target);
      const isClickInsideToggle = sidebarToggle.contains(event.target);
      
      if (!isClickInsideSidebar && !isClickInsideToggle && sidebar.classList.contains('show')) {
        if (window.innerWidth < 768) {
          sidebar.classList.remove('show');
        }
      }
    });
  }

  // ========== Active Link Highlighting ==========
  const currentLocation = location.pathname;
  document.querySelectorAll('.sidebar .nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (currentLocation.includes(href)) {
      link.classList.add('active');
    }
  });

  // ========== Form Validation ==========
  const forms = document.querySelectorAll('form');
  forms.forEach(form => {
    form.addEventListener('submit', function(e) {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add('was-validated');
    });
  });

  // ========== Delete Confirmation ==========
  document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function(e) {
      if (!confirm('Are you sure you want to delete this item?')) {
        e.preventDefault();
      }
    });
  });

  // ========== Responsive Table Overflow ==========
  document.querySelectorAll('.table-responsive').forEach(container => {
    const table = container.querySelector('table');
    if (table) {
      table.classList.add('table-sm');
    }
  });

  // ========== Add Transitions to Cards ==========
  document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-4px)';
    });
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });

  // ========== Auto-hide Alerts ==========
  document.querySelectorAll('.alert').forEach(alert => {
    if (alert.classList.contains('alert-auto-close')) {
      setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      }, 5000); // Close after 5 seconds
    }
  });

  // ========== Tooltip & Popover Initialization (Bootstrap) ==========
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
  popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });

  // ========== Responsive Window Resize Handler ==========
  window.addEventListener('resize', function() {
    if (window.innerWidth >= 768 && sidebar) {
      sidebar.classList.remove('show');
    }
  });

  // ========== Add Bootstrap JS & popper if not already loaded ==========
  if (typeof bootstrap === 'undefined') {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js';
    document.head.appendChild(script);
  }
});

// ========== Utility Functions ==========
function showNotification(message, type = 'info') {
  const alertDiv = document.createElement('div');
  alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
  alertDiv.setAttribute('role', 'alert');
  alertDiv.innerHTML = `
    ${message}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;
  
  const container = document.querySelector('.container-fluid') || document.body;
  container.insertBefore(alertDiv, container.firstChild);
  
  setTimeout(() => {
    alertDiv.remove();
  }, 5000);
}

function formatCurrency(amount) {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR'
  }).format(amount);
}

function formatDate(date) {
  return new Intl.DateTimeFormat('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  }).format(new Date(date));
}

