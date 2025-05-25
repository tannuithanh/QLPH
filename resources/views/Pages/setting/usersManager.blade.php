@extends('layouts.app')
@section('title', 'Quản lý tài khoản')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 page-title">Quản lý tài khoản</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1 breadcrumb-custom">
                    <li class="breadcrumb-item">
                        <a href="{{ route('showDashboard') }}" class="text-decoration-none text-muted">
                            <i class="bi bi-house-door-fill me-1"></i> Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Phòng ban</li>
                </ol>
            </nav>
        </div>
        <button class="btn text-white" style="background-color: #C06252;" data-bs-toggle="modal"
            data-bs-target="#addUserModal">
            + Thêm nhân sự
        </button>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Ô tìm kiếm --}}
                    <div class="mb-3">
                        <input type="text" class="form-control" id="userSearchInput"
                            placeholder="Tìm kiếm nhân sự theo tên, email..." />
                    </div>

                    {{-- Bảng nhân sự --}}
                    <div class="table-responsive">
                        <table class="table-vinhgia" id="userTable">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Phòng ban</th>
                                    <th>Số điện thoại</th>
                                    <th>Admin</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="data">
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->department->name ?? 'Chưa có' }}</td>
                                        <td>{{ $user->phone_number ?? '---' }}</td>
                                        <td>
                                            @if ($user->admin)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary edit-user-btn"
                                                data-bs-toggle="modal" data-bs-target="#editUserModal"
                                                data-id="{{ $user->id }}">Sửa</a>
                                            <a href="#" class="btn btn-sm btn-danger delete-user-btn"
                                                data-id="{{ $user->id }}">Xoá</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Thêm Nhân Sự --}}
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #C06252;">
                    <h5 class="modal-title text-white" id="addUserModalLabel">Thêm nhân sự mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="userName" name="name"
                            placeholder="Nhập tên nhân sự">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email"
                            placeholder="email@domain.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="userPhone" name="phone" placeholder="0123456789">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phòng ban</label>
                        <select class="form-select" name="department_id" id="userDepartment">
                            <option selected disabled>Chọn phòng ban</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="isAdminCheckbox" name="admin">
                        <label class="form-check-label" for="isAdminCheckbox">
                            Là quản trị viên (Admin)
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    <button type="button" id="addUsers" class="btn text-white"
                        style="background-color: #C06252;">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal sửa nhận sử --}}
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #C06252;">
                    <h5 class="modal-title text-white" id="editUserModalLabel">Sửa thông tin nhân sự</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="userNameEdit" name="name"
                            placeholder="Nhập tên nhân sự">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmailEdit" name="email"
                            placeholder="email@domain.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="userPhoneEdit" name="phone"
                            placeholder="0123456789">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phòng ban</label>
                        <select class="form-select" name="department_id" id="userDepartmentEdit">
                            <option selected disabled>Chọn phòng ban</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="isAdminCheckboxEdit" name="admin">
                        <label class="form-check-label" for="isAdminCheckbox">
                            Là quản trị viên (Admin)
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    <button type="button" id="editUserSubmit" class="btn text-white"
                        style="background-color: #C06252;">Sửa người dùng</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('srcipts')
    <script src="{{ mix('js/Setting/handleUsers.js') }}"></script>
@endsection
