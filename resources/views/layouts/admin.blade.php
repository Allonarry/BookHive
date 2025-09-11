<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'BookHive')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --deep-teal: #2a5c5a;
            --warm-terracotta: #c76b4a;
            --ivory: #f8f5f0;
            --oxblood: #76323f;
            --charcoal: #1e1e24;
            --soft-sage: #8a9b8a;
        }

        /* Admin Panel Specific Styles */
        .admin-container {
            padding: 2rem 0;
        }

        .admin-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .admin-card-header {
            background-color: var(--deep-teal);
            color: white;
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-card-title {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 600;
        }

        .admin-card-body {
            padding: 1.5rem;
        }

        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .admin-table th {
            background-color: var(--ivory);
            color: var(--deep-teal);
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            border-bottom: 2px solid var(--soft-sage);
        }

        .admin-table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .admin-table tr:hover td {
            background-color: rgba(138, 155, 138, 0.05);
        }

        .admin-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-featured {
            background-color: rgba(199, 107, 74, 0.1);
            color: var(--warm-terracotta);
        }

        .badge-not-featured {
            background-color: rgba(30, 30, 36, 0.1);
            color: var(--charcoal);
        }

        .badge-active {
            background-color: rgba(42, 92, 90, 0.1);
            color: var(--deep-teal);
        }

        .badge-blocked {
            background-color: rgba(118, 50, 63, 0.1);
            color: var(--oxblood);
        }

        .admin-btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-feature {
            background-color: var(--warm-terracotta);
            color: white;
        }

        .btn-feature:hover {
            background-color: #b55d3f;
        }

        .btn-block {
            background-color: var(--oxblood);
            color: white;
        }

        .btn-block:hover {
            background-color: #5c2732;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #bb2d3b;
        }

        .alert-dismissible {
            animation: slideDown 0.5s ease-out;
            margin-top: 1rem;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .admin-table {
                display: block;
                overflow-x: auto;
            }
            
            .admin-card-header {
                padding: 1rem;
            }
            
            .admin-card-body {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--deep-teal);">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">BookHive Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.books') }}">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users') }}">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.genres') }}">Genres</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
  const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;

  // Store original button texts
  const originalTexts = new WeakMap();

  // Handle all AJAX form submissions
  document.querySelectorAll('form[data-ajax]').forEach(form => {
    form.addEventListener('submit', async function(e) {
      e.preventDefault();

      // Optional confirm
      const confirmMessage = this.getAttribute('data-confirm');
      if (confirmMessage && !confirm(confirmMessage)) return;

      // Disable submit buttons
      const buttons = this.querySelectorAll('button[type="submit"], button[form]');
      buttons.forEach(btn => {
        originalTexts.set(btn, btn.innerHTML);
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
      });

      // Method spoofing support
      const spoofMethod = this.querySelector('input[name="_method"]')?.value;
      const method = (spoofMethod || this.method || 'POST').toUpperCase();

      try {
        const res = await fetch(this.action, {
          method,
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: method === 'GET' ? null : new FormData(this)
        });

        let data = {};
        try { data = await res.json(); } catch (_) {}

        // Accept both {ok:true} and {success:true}
        const ok = (typeof data.ok !== 'undefined') ? !!data.ok : !!data.success;

        if (!res.ok || !ok) {
          throw new Error(data.message || 'An error occurred. Please try again.');
        }

        // ROUTE-AWARE ACTION HANDLERS
        // Prefer explicit data-action="" when present
        const actionType = this.dataset.action || '';

        // 1) DELETE book
        if (actionType === 'delete' || method === 'DELETE') {
          // Try to remove row by id if provided; else remove the nearest <tr>
          const id = data.id;
          const row = (id && document.getElementById(`book-row-${id}`)) || this.closest('tr');
          if (row) row.remove();
          showAlert('success', data.message || 'Book deleted');
          return;
        }

        // 2) Block/Unblock user
        // URL looks like /admin/users/block/{user}
        if (actionType === 'user-block' || this.action.includes('/admin/users/block')) {
          updateUserBlockUI(this, data);
          showAlert('success', data.message || 'Updated');
          return;
        }

        // 3) Feature/Unfeature book
        // URL looks like /admin/books/feature/{book}
        if (actionType === 'book-feature' || this.action.includes('/admin/books/feature')) {
          updateBookFeatureUI(this, data);
          showAlert('success', data.message || 'Updated');
          return;
        }

        // Default success
        showAlert('success', data.message || 'Done');
      } catch (error) {
        showAlert('danger', error?.message || 'An error occurred. Please try again.');
      } finally {
        // Re-enable buttons
        buttons.forEach(btn => {
          btn.disabled = false;
          btn.innerHTML = originalTexts.get(btn) || btn.innerHTML;
        });
      }
    });
  });

  function updateUserBlockUI(form, data) {
    const button = form.querySelector('button[type="submit"]');
    const statusBadge = form.closest('tr')?.querySelector('.badge');

    const isBlocked = ('is_blocked' in data) ? !!data.is_blocked : false;

    if (isBlocked) {
      button.classList.remove('btn-block');
      button.classList.add('btn-feature');
      button.innerHTML = '<i class="fas fa-lock-open me-1"></i> Unblock';
      if (statusBadge) {
        statusBadge.classList.remove('badge-active');
        statusBadge.classList.add('badge-blocked');
        statusBadge.textContent = 'Blocked';
      }
    } else {
      button.classList.remove('btn-feature');
      button.classList.add('btn-block');
      button.innerHTML = '<i class="fas fa-lock me-1"></i> Block';
      if (statusBadge) {
        statusBadge.classList.remove('badge-blocked');
        statusBadge.classList.add('badge-active');
        statusBadge.textContent = 'Active';
      }
    }
  }

  function updateBookFeatureUI(form, data) {
    const button = form.querySelector('button[type="submit"]');
    const row = form.closest('tr');
    const titleCell = row?.querySelector('td:first-child');

    const featured = ('featured' in data) ? !!data.featured : false;

    if (featured) {
      button.innerHTML = '<i class="fas fa-star me-1"></i> Unfeature';
      if (titleCell && !titleCell.querySelector('.badge-featured')) {
        const badge = document.createElement('span');
        badge.className = 'badge badge-featured ms-2';
        badge.textContent = 'Featured';
        titleCell.appendChild(badge);
      }
    } else {
      button.innerHTML = '<i class="fas fa-star-half-alt me-1"></i> Feature';
      const featuredBadge = titleCell?.querySelector('.badge-featured');
      if (featuredBadge) featuredBadge.remove();
    }
  }

  function showAlert(type, message) {
    // Remove existing alerts
    document.querySelectorAll('.alert-dismissible').forEach(alert => {
      const bsAlert = bootstrap.Alert.getInstance(alert);
      if (bsAlert) bsAlert.close(); else alert.remove();
    });

    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-dismissible`;
    alertDiv.innerHTML = `
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    const mainElement = document.querySelector('main');
    if (mainElement) mainElement.insertBefore(alertDiv, mainElement.firstChild);
    else document.querySelector('.container')?.prepend(alertDiv);

    new bootstrap.Alert(alertDiv);
    setTimeout(() => {
      const bsAlert = bootstrap.Alert.getInstance(alertDiv);
      if (bsAlert) bsAlert.close();
    }, 5000);
  }

  // Confirm support for non-AJAX forms
  document.querySelectorAll('form:not([data-ajax])').forEach(form => {
    form.addEventListener('submit', function(e) {
      const confirmMessage = this.getAttribute('data-confirm');
      if (confirmMessage && !confirm(confirmMessage)) {
        e.preventDefault();
        return false;
      }
    });
  });
});
</script>
</body>
</html>