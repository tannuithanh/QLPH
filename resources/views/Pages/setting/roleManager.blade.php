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
                <ul class="list-group" id="roleList">
                    {{-- Giả sử có sẵn biến $roles --}}
                    @foreach($roles as $role)
                        <li class="list-group-item d-flex justify-content-between align-items-center role-item" data-role-id="{{ $role->id }}">
                            {{ $role->name }}
                            <span class="badge rounded-pill" style="background-color: #c06252">{{ $role->users_count ?? 0 }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- Danh sách người dùng thuộc quyền --}}
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center" style="background-color: #c06252 !important;color: white">
                <h6 class="mb-0 fw-bold">Người dùng thuộc quyền</h6>
            </div>
            <div class="card-body">
                <ul class="list-group" id="userList">
                    <li class="list-group-item text-muted text-center">Chưa có dữ liệu</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
