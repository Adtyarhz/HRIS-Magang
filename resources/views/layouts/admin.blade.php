<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'HRIS Panel')</title>

    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>

    @stack('styles')
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="sidebar-brand-text mx-3">HRIS <sup>Magang</sup></div>
            </a>

            <hr class="sidebar-divider my-0">

            @foreach ($menu ?? [] as $item)
                @php
                    $url = '#';
                    if ($item['route'] !== '#') {
                        try {
                            $url = isset($item['params'])
                                ? route($item['route'], $item['params'])
                                : route($item['route']);
                        } catch (Exception $e) {
                            $url = '#';
                        }
                    }
                    // Cek Active State
                    $isActive = request()->routeIs($item['route']) ||
                        (isset($item['submenu']) &&
                            collect($item['submenu'])->contains(function ($subitem) {
                                return request()->routeIs($subitem['route']);
                            }));
                @endphp

                <li class="nav-item {{ $isActive ? 'active' : '' }}">
                    <a class="nav-link" href="{{ $url }}" 
                       @if ($url === '#') onclick="alert('This feature is under development')" @endif>
                        
                        {{-- Icon Logic --}}
                        <span class="iconify" data-icon="{{ $item['icon'] ?? 'mdi:circle-small' }}" style="font-size: 1.1rem; margin-right: 0.5rem;"></span>
                        
                        <span>{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
                        <div class="d-flex align-items-center">
                            <span class="@yield('header_icon', '') mr-2"></span>
                            <h1 class="h4 mb-0 text-gray-800">@yield('content_header', '')</h1>
                        </div>
                    </div>

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span class="badge badge-danger badge-counter">
                                        {{ auth()->user()->unreadNotifications->count() }}+
                                    </span>
                                @endif
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifications Center
                                </h6>
                                
                                @forelse(auth()->user()->notifications->take(5) as $notification)
                                    @php
                                        $message = $notification->data['message'] ?? 'Notification';
                                        $isUnread = is_null($notification->read_at);
                                    @endphp
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('notifications.readAndRedirect', ['id' => $notification->id]) }}">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                            <span class="{{ $isUnread ? 'font-weight-bold' : '' }}">
                                                {!! $message !!}
                                            </span>
                                        </div>
                                    </a>
                                @empty
                                    <a class="dropdown-item text-center small text-gray-500" href="#">No New Notification</a>
                                @endforelse

                                <a class="dropdown-item text-center small text-gray-500" href="{{ route('notifications.index') }}">Show All Notifications</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            @php
                                $user = Auth::user();
                                $employee = $user?->employee;
                                $profileImg = $employee && $employee->photo 
                                    ? asset('storage/' . $employee->photo) 
                                    : 'https://placehold.co/160x160/9A3B3B/FFFFFF?text=' . strtoupper(substr($user->name, 0, 1));
                            @endphp
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ $user->name ?? 'User' }}
                                    <br>
                                    <small>{{ $employee->division->name ?? ($user->role ?? '') }}</small>
                                </span>
                                <img class="img-profile rounded-circle" src="{{ $profileImg }}">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                
                                {{-- Logic Profil --}}
                                @if ($user && $user->role === 'superadmin')
                                    <a class="dropdown-item" href="#" onclick="alert('Superadmin does not have personal data')">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                                    </a>
                                @elseif ($employee)
                                    <a class="dropdown-item" href="{{ route('employees.show', $employee->id) }}">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                                    </a>
                                @else
                                    <a class="dropdown-item" href="#" onclick="alert('Employee data not yet available')">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                                    </a>
                                @endif

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <div class="container-fluid">

                    @include('partials.alert')
                    @include('partials.validation-errors')

                    @hasSection('content-wrapper')
                        @yield('content-wrapper')
                    @else
                         @yield('content')
                    @endif

                </div>
                </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; HRIS {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

    <script>
        function showDeletePopup(id) {
            $('#deletePopup-' + id).modal('show');
        }

        function closeDeletePopup(id) {
            $('#deletePopup-' + id).modal('hide');
        }
    </script>

    @stack('scripts')
    @stack('js')
</body>

</html>