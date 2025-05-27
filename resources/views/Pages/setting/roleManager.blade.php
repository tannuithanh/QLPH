@extends('layouts.app')
@section('title', 'Quản lý phân quyền')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 page-title">Quản lý phân quyền</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1 breadcrumb-custom">
                    <li class="breadcrumb-item">
                        <a href="{{ route('showDashboard') }}" class="text-decoration-none text-muted">
                            <i class="bi bi-house-door-fill me-1"></i> Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Phân quyền</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        {{-- Danh sách quyền --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #c06252 !important; color: white">
                    <h6 class="mb-0 fw-bold">Danh sách quyền</h6>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">Danh sách quyền</h6>
                    <ul class="list-group" id="roleList">
                        {{-- Giả sử có sẵn biến $roles --}}
                        @foreach ($roles as $role)
                            <li class="list-group-item d-flex justify-content-between align-items-center role-item"
                                data-role-id="{{ $role->id }}">
                                {{ $role->display_name }}
                                <span class="badge rounded-pill"
                                    style="background-color: #c06252">{{ $role->users_count ?? 0 }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <!-- Form: Thêm người dùng -->
                    <div class="mt-3">
                        <h6 class="fw-bold">Thêm người dùng với quyền</h6>
                        <div class="d-flex gap-2">
                            <select id="userName" class="form-select">
                                <option value="">Chọn người dùng...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>

                            <select id="userRole" class="form-select">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                            <button type="button" id="addRoleUser" class="btn btn-primary"
                                style="background-color: #c06252; border: 1px solid #c06252;">Thêm</button>
                        </div>
                    </div>

                    <!-- Button: Gán quyền cho tất cả -->
                    <div class="mt-3">
                        <h6 class="fw-bold">Gán quyền cho tất cả người dùng</h6>
                        <div class="d-flex gap-2">
                            <select id="bulkRole" class="form-select">
                                <option value="admin">Quản trị hệ thống</option>
                                <option value="staff">Nhân viên</option>
                            </select>
                            <button id="assignAllBtn" class="btn btn-success" style="background-color: #c06252; border: 1px solid #c06252;">Thêm</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        {{-- Danh sách người dùng thuộc quyền --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center"
                    style="background-color: #c06252 !important;color: white">
                    <h6 class="mb-0 fw-bold">Người dùng thuộc quyền</h6>
                </div>
                <div class="card-body">
                     <h6 class="fw-bold">Danh sách người dùng được phân quyền</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center">Stt</th>
                                <th style="text-align: center">Người dùng</th>
                                <th style="text-align: center">Quyền</th>
                                <th style="text-align: center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="roleUserTableBody">
                            @forelse ($roleUsers as $index => $ru)
                                <tr>
                                    <td style="text-align: center">{{ $index + 1 }}</td>
                                    <td style="text-align: center">{{ $ru->user->name ?? 'N/A' }}</td>
                                    <td style="text-align: center">{{ $ru->role->display_name ?? 'N/A' }}</td>
                                    <td style="text-align: center">
                                        <button class="btn btn-danger btn-sm delete-role-user" data-id="{{ $ru->user_id }}">
                                            Xoá
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Chưa có dữ liệu phân quyền</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('srcipts')
    <script src="{{ mix('js/Setting/handleRole.js') }}"></script>
@endsection
