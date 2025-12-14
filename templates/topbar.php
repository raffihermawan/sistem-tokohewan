<?php $user = current_user(); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <div class="container-fluid">

    <!-- Brand/Logo -->
    <a class="navbar-brand d-flex align-items-center" href="<?php echo base_url('dashboard/index.php'); ?>">
      <i class="fas fa-paw me-2" style="color: #3498db; font-size: 1.5rem;"></i>
      <span class="fw-bold" style="color: #2c3e50;">Petshop</span>
    </a>

    <!-- Navbar Toggler for Mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Content -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto gap-2">

        <!-- User Role Badge -->
        <li class="nav-item">
          <span class="badge rounded-pill" style="background: linear-gradient(90deg, #3498db 0%, #2980b9 100%); padding: 0.5rem 1rem;">
            <i class="fas fa-user me-1"></i> <?php echo ucfirst($user['role'] ?? 'guest'); ?>
          </span>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-circle me-2" style="color: #2ecc71; font-size: 0.5rem;"></i>
            <span class="d-none d-sm-inline"><?php echo e($user['name'] ?? 'Guest'); ?></span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">

            <!-- FIX HERE: menggunakan base_url -->
            <li>
              <a class="dropdown-item" href="<?php echo base_url('users/profile.php'); ?>">
                <i class="fas fa-user-circle me-2"></i> Profile
              </a>
            </li>

            <!-- FIX HERE: menggunakan base_url -->
            <li>
              <a class="dropdown-item" href="<?php echo base_url('settings/settings.php'); ?>">
                <i class="fas fa-cog me-2"></i> Settings
              </a>
            </li>

            <li><hr class="dropdown-divider"></li>

            <!-- LOGOUT BUTTON -->
            <li>
              <a href="#" class="dropdown-item text-danger" id="logoutConfirmBtn">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
              </a>
            </li>

          </ul>
        </li>

      </ul>
    </div>

  </div>
</nav>

<!-- SWEETALERT LOGOUT SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {

  const logoutBtn = document.getElementById('logoutConfirmBtn');

  logoutBtn.addEventListener('click', function(e) {
    e.preventDefault();

    Swal.fire({
      title: 'Logout?',
      text: "Apakah Anda yakin ingin logout dari sistem?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, logout',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "<?php echo base_url('auth/logout.php'); ?>";
      }
    });
  });

});
</script>
