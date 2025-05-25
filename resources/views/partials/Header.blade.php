<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top" style="z-index: 1050;">
        <div class="container-fluid">
            <!-- Logo bên trái -->
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/login.png') }}" alt="Logo" width="70" height="70"
                    class="d-inline-block align-text-top">
            </a>

            <!-- Nút toggle trên mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Nội dung navbar -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Menu chính -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('showDashboard') ? 'active' : '' }}" href="{{ route('showDashboard') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('showManagerSchedule') ? 'active' : '' }}" href="{{ route('showManagerSchedule') }}">Lịch họp</a>
                    </li>
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Dịch vụ
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item" href="#">Thiết kế</a></li>
                            <li><a class="dropdown-item" href="#">Lập trình</a></li>
                        </ul>
                    </li> --}}
                </ul>

                <!-- Profile bên phải (demo tạm) -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                            id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/User_icon_2.png') }}" alt="avatar" class="rounded-circle me-2"
                                width="40" height="40">
                            <div class="d-flex flex-column align-items-start">
                                <span>{{ $user->name }}</span>
                                <small class="text-muted" style="font-size: 12px;">{{ $user->email }}</small>
                            </div>
                        </a>


                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <i class="bi bi-shield-lock me-2"></i> <!-- icon phân quyền -->
                                    Quản lý phân quyền
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('showUserManager') }}">
                                    <i class="bi bi-people me-2"></i> <!-- icon tài khoản -->
                                    Quản lý tài khoản
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('showDepartmentManager') }}">
                                    <i class="bi bi-building me-2"></i> <!-- icon phòng ban -->
                                    Quản lý phòng ban
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('showMeetingRoomManager') }}">
                                    <i class="bi bi-door-open me-2"></i> Quản lý phòng họp
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center change-pass" data-bs-toggle="modal" data-bs-target="#changePasswordModal" style="cursor: pointer">
                                    <i class="bi bi-key me-2"></i> Đổi mật khẩu
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> <!-- icon đăng xuất -->
                                    Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</header>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
