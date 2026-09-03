<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin · BJJD Journal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: #f7f8fc;
      font-family: 'Inter', sans-serif;
      color: #000000;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      min-height: 100vh;
      background: #00004d;
      position: sticky;
      top: 0;
      box-shadow: 2px 0 6px rgba(0, 0, 0, 0.15);
    }

    .sidebar h4 {
      font-size: 24px;
      letter-spacing: .5px;
      font-weight: 600;
      color: #ffffff;
    }

    .sidebar a {
      color: #d1d5db;
      text-decoration: none;
      display: flex;
      align-items: center;
      padding: .65rem 1rem;
      border-radius: .5rem;
      font-size: 18px;
      gap: .75rem;
      transition: all .25s ease-in-out;
    }

    .sidebar a.active,
    .sidebar a:hover {
      background: #cc7a00;
      color: #ffffff;
    }

    .sidebar a i {
      font-size: 1.1rem;
    }

    /* Topbar */
    .topbar {
      background: #ffffff;
      border-bottom: 2px solid #e5e7eb;
      padding: .75rem 1.25rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .topbar h6 {
      color: #00004d;
    }

    .topbar i.bi-bell {
      color: #cc7a00;
      cursor: pointer;
      transition: .2s;
    }

    .topbar i.bi-bell:hover {
      color: #003300;
    }

    /* Content */
    .content-wrapper {
      padding: 1.5rem;
      background: #ffffff;
      min-height: calc(100vh - 60px);
      border-radius: 10px;
      margin: 1rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    /* Logout button */
    .logout-btn {
      margin-top: 1rem;
    }

    .logout-btn button {
      background: #cc7a00;
      border: none;
      font-weight: 600;
      transition: .2s;
    }

    .logout-btn button:hover {
      background: #003300;
    }

    /* Dropdown */
    .dropdown-menu {
      border-radius: 8px;
      overflow: hidden;
      border: 1px solid #e5e7eb;
    }

    .dropdown-item:hover {
      background: #cc7a00;
      color: #ffffff;
    }

    /* Profile Styles */
    .profile-card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      margin-bottom: 20px;
    }

    .profile-header {
      background-color: #00004d;
      color: white;
      border-radius: 10px 10px 0 0;
      padding: 15px 20px;
    }

    .profile-body {
      padding: 20px;
    }

    .form-label {
      font-weight: 500;
      color: #00004d;
    }

    .btn-primary {
      background-color: #cc7a00;
      border-color: #cc7a00;
    }

    .btn-primary:hover {
      background-color: #003300;
      border-color: #003300;
    }

    .profile-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #cc7a00;
    }

    .toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
    }

    .toast {
      background-color: #00004d;
      color: white;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Mobile Sidebar */
    @media (max-width: 992px) {
      .sidebar {
        position: fixed;
        left: -260px;
        transition: all .3s;
        z-index: 1050;
      }

      .sidebar.active {
        left: 0;
      }

      .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .4);
        z-index: 1040;
      }

      .overlay.show {
        display: block;
      }
    }

    /* Profile Form Specific Styles */
    .profile-form-container {
      padding: 20px 0;
    }

    .profile-info-card {
      background-color: #f8f9fa;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
    }

    .profile-info-title {
      color: #00004d;
      font-weight: 600;
      margin-bottom: 15px;
      padding-bottom: 10px;
      border-bottom: 2px solid #cc7a00;
    }

    .password-form-card {
      background-color: #f8f9fa;
      border-radius: 10px;
      padding: 20px;
    }
  </style>
</head>

<body>
  <div class="d-flex">
    {{-- Sidebar --}}
    <aside class="sidebar p-3" id="sidebar">
      <h4 class="mb-3">BJDD Admin</h4>
      <nav class="d-grid gap-1">
        <li class="nav-item">
          <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>

        <li class="nav-item">
          <a class="{{ request()->routeIs('admin.current-issue.*') ? 'active' : '' }}"
            href="{{ route('admin.current-issue.edit') }}">
            <i class="bi bi-calendar-event"></i> Home
          </a>
        </li>

        <a class="{{ request()->routeIs('admin.submissions*') ? 'active' : '' }}" href="{{ route('admin.submissions.index') }}">
          <i class="bi bi-journal-text"></i> Submissions
        </a>
        {{-- <a class="{{ request()->routeIs('admin.articles*') ? 'active' : '' }}" href="{{ route('admin.articles.index') }}">
        <i class="bi bi-file-earmark-text"></i> Articles
        </a> --}}

        <a class="nav-link {{ request()->routeIs('admin.journal-team*') ? 'active' : '' }}" href="{{ route('admin.journal-team.index') }}">
          <i class="bi bi-people-fill"></i> Journal Team
        </a>
        {{-- <a class="{{ request()->routeIs('admin.authors*') ? 'active' : '' }}" href="{{ route('admin.authors.index') }}">
        <i class="bi bi-person"></i> Authors
        </a> --}}
        <a class="{{ request()->routeIs('admin.contact-submissions*') ? 'active' : '' }}" href="{{ route('admin.contact-submissions.index') }}">
          <i class="bi bi-envelope"></i> Contact
        </a>
        <a class="{{ request()->routeIs('admin.issues*') ? 'active' : '' }}" href="{{ route('admin.issues.index') }}">
          <i class="bi bi-journal-bookmark"></i> Issues
        </a>
        <a class="nav-link {{ request()->routeIs('admin.archive*') ? 'active' : '' }}" href="{{ route('admin.archive.edit') }}">
          <i class="bi bi-archive"></i> Archive
        </a>
        <a class="nav-link {{ request()->routeIs('admin.publications*') ? 'active' : '' }}" href="{{ route('admin.publications.index') }}">
          <i class="bi bi-journal-text"></i> Publications
        </a>
        <a class="nav-link {{ request()->routeIs('admin.index-partners*') ? 'active' : '' }}"
          href="{{ route('admin.index-partners.index') }}">
          <i class="bi bi-journal-text"></i> Index Partner
        </a>
          <a class="nav-link {{ request()->routeIs('admin.blogs*') ? 'active' : '' }}"
          href="{{ route('admin.blogs.index') }}">
          <i class="bi bi-journal-text"></i> Blogs
        </a>
        <form class="logout-btn" method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button class="btn btn-sm btn-danger w-100">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>
        </form>
      </nav>
    </aside>

    {{-- Main Content --}}
    <div class="flex-fill">
      {{-- Topbar --}}
      <div class="topbar">
        <button class="btn btn-sm btn-outline-secondary d-lg-none" id="toggleSidebar">
          <i class="bi bi-list"></i>
        </button>
        <h6 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h6>
        <div class="d-flex align-items-center gap-3">
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle fs-4 me-2 text-dark"></i>
              <span>Admin</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">Profile</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <form method="POST" action="{{ route('admin.logout') }}">
                  @csrf
                  <button class="dropdown-item text-danger">Logout</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>

      {{-- Page Content --}}
      <main class="content-wrapper">
        @yield('content')
      </main>
    </div>
  </div>

  <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form method="POST" action="{{ url('admin/profile/update') }}">
          @csrf
          <div class="modal-header profile-header">
            <h5 class="modal-title" id="profileModalLabel">Admin Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body profile-body">
            <div class="row mb-4">
              <div class="col-md-3 text-center">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=cc7a00&color=fff&size=120"
                  class="profile-img mb-3" alt="Admin Profile">
                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                <p class="text-muted">Administrator</p>
              </div>
              <div class="col-md-9">
                <div class="profile-form-container">
                  <div class="profile-info-card">
                    <h5 class="profile-info-title">Account Information</h5>
                    <div class="mb-3">
                      <label class="form-label">Email Address</label>
                      <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                    </div>
                  </div>

                  <div class="password-form-card">
                    <h5 class="profile-info-title">Update Password</h5>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">Current Password</label>
                          <input type="password" name="current_password" class="form-control" placeholder="Enter current password">
                          <small class="text-muted">Required to change your password</small>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">New Password</label>
                          <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">Confirm Password</label>
                          <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm new password">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="overlay" id="overlay"></div>

  <!-- Toast container for notifications -->
  <div class="toast-container" id="toastContainer"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      overlay.classList.toggle('show');
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.remove('active');
      overlay.classList.remove('show');
    });

    // Function to show toast notifications
    function showToast(message, type = 'success') {
      const toastContainer = document.getElementById('toastContainer');
      const toastId = 'toast-' + Date.now();

      const toast = document.createElement('div');
      toast.className = `toast ${type}`;
      toast.id = toastId;
      toast.setAttribute('role', 'alert');
      toast.setAttribute('aria-live', 'assertive');
      toast.setAttribute('aria-atomic', 'true');

      toast.innerHTML = `
      <div class="toast-header">
        <strong class="me-auto">BJJD Admin</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        ${message}
      </div>
    `;

      toastContainer.appendChild(toast);

      const bsToast = new bootstrap.Toast(toast);
      bsToast.show();

      // Remove toast from DOM after it hides
      toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
      });
    }

    // Profile form functionality
    document.addEventListener('DOMContentLoaded', function() {
      // Profile form validation
      const profileForm = document.querySelector('#profileModal form');
      if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
          const currentPassword = document.querySelector('input[name="current_password"]');
          const newPassword = document.querySelector('input[name="new_password"]');
          const confirmPassword = document.querySelector('input[name="new_password_confirmation"]');

          // Only validate if any password field has value
          if (currentPassword.value || newPassword.value || confirmPassword.value) {
            if (!currentPassword.value) {
              e.preventDefault();
              showToast('Please enter your current password to make changes', 'error');
              return;
            }

            if (newPassword.value !== confirmPassword.value) {
              e.preventDefault();
              showToast('New passwords do not match!', 'error');
              return;
            }

            if (newPassword.value.length < 8) {
              e.preventDefault();
              showToast('New password must be at least 8 characters long', 'error');
              return;
            }
          }
        });
      }
    });
  </script>
</body>

</html>
