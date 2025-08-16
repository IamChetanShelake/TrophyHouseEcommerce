{{-- resources/views/admin/designer/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Designer Panel</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: #333;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #f1f1f1;
            border-left: 3px solid #007bff;
            color: #007bff;
        }

        .main-content {
            padding: 30px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-md-3 col-lg-2 sidebar p-3">
                <h5 class="text-primary mb-4">🎨 Designer Panel</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('designer/requests') ? 'active' : '' }}"
                            href="{{ route('requests') }}">
                            📝 Requests
                        </a>
                    </li>
                    <!--<li class="nav-item">-->
                    <!--    <a class="nav-link {{ request()->is('designer/recustomizations') ? 'active' : '' }}" href="{{ route('recustomizations') }}">-->
                    <!--        🔁 Re-Customizations-->
                    <!--    </a>-->
                    <!--</li>-->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('designer/chats') ? 'active' : '' }}"
                            href="{{ route('chats') }}">
                            💬 Chats
                        </a>
                    </li>
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                        <a class="nav-link d-flex align-items-center gap-2"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            style="cursor: pointer;">
                            <i class="mdi mdi-power">Logout</i>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Main content --}}
            <div class="col-md-9 col-lg-10 main-content">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
