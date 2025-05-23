@extends('layouts.app')
@section('title', 'Quản lý phòng bàn')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Quản lý phòng ban</h4>
        <button class="btn text-white" style="background-color: #C06252;" data-bs-toggle="modal"
            data-bs-target="#addDepartmentModal">
            + Thêm phòng ban
        </button>
    </div>

    {{-- Bảng nhân sự --}}
    <div class="table-responsive">
        <table class="table-vinhgia" id="userTable">
            <thead>
                <tr>
                    <th style="text-align: center">Stt</th>
                    <th style="text-align: center">Tên phòng ban</th>
                    <th style="text-align: center">Hành động</th>
                </tr>
            </thead>
            <tbody id="data">
                @forelse($departments as $index => $department)
                    <tr>
                        <td style="text-align: center">{{ $index + 1 }}</td>
                        <td style="text-align: center">{{ $department->name }}</td>
                        <td style="text-align: center">
                             <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $department->id }}">Xoá</button>
                        </td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="3" class="text-center text-muted">Chưa có phòng ban nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Thêm phòng ban --}}
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form>
                    <div class="modal-header" style="background-color: #C06252;">
                        <h5 class="modal-title text-white" id="addDepartmentModalLabel">Thêm phòng ban mới</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên phòng ban</label>
                            <input type="text" class="form-control" id="departmentName" name="department_name"
                                placeholder="Nhập tên phòng ban">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="button" id="addDepartment" class="btn text-white"
                            style="background-color: #C06252;">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('srcipts')
    <script src="{{ mix('js/Setting/handleDepartment.js') }}"></script>
@endsection
