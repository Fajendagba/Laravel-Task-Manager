<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Manager - Get Things Done</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #f3f4f6;
            --danger-color: #ef4444;
            --success-color: #10b981;
        }

        body {
            background-color: #f9fafb;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .task-item {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            cursor: move;
            transition: all 0.2s ease;
        }

        .task-item:hover {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .task-item.ui-sortable-helper {
            opacity: 0.8;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        .priority-badge {
            background: var(--primary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .quick-add-form {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 24px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 10px 24px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #4338ca;
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .task-actions {
            opacity: 0;
            transition: opacity 0.2s;
        }

        .task-item:hover .task-actions {
            opacity: 1;
        }

        .project-badge {
            background: #e5e7eb;
            color: #374151;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .task-actions {
                opacity: 1;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('tasks.index') }}">
                <i class="bi bi-check-square-fill text-primary"></i> Task Manager
            </a>
            <span class="navbar-text">
                <small class="text-muted">Organize. Prioritize. Accomplish.</small>
            </span>
        </div>
    </nav>

    <main class="container my-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @stack('scripts')
</body>
</html>