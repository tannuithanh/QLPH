<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Laravel App')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- CSS của bạn --}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body class="d-flex flex-column min-vh-100">

    @include('partials.header')

    <main class="flex-grow-1 d-flex flex-column animate-main" id="fadeTarget">
        <div class="page-content flex-grow-1">
            <div class="container-fluid px-0">
                @yield('content')
            </div>
        </div>
    </main>

    @include('partials.footer')
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('srcipts')

    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form >
                    <div class="modal-header bg-primary text-white" style="background-color: #C06252 !important;">
                        <h5 class="modal-title" id="changePasswordModalLabel">Đổi mật khẩu</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" name="current_password" id="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" name="new_password" id="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nhập lại mật khẩu mới</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="button" class="btn btn-primary" id="changePass" style="background-color: #C06252 !important; border: 1px solid #C06252" data-bs-dismiss="modal">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>


</html>
