@extends('layouts.app')
@section('title', 'Quản lý phòng họp')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 page-title">Quản lý phòng họp</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1 breadcrumb-custom">
                    <li class="breadcrumb-item">
                        <a href="{{ route('showDashboard') }}" class="text-decoration-none text-muted">
                            <i class="bi bi-house-door-fill me-1"></i> Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Phòng họp</li>
                </ol>
            </nav>
        </div>
        <button class="btn text-white" style="background-color: #C06252;" data-bs-toggle="modal"
            data-bs-target="#addMeetingRoomModal">
            + Thêm phòng họp
        </button>
    </div>

    {{-- Bảng nhân sự --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <h5 class="title-vinhgia">Danh sách phòng họp</h5>
                    <div class="table-responsive">
                        <table class="table-vinhgia">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Stt</th>
                                    <th style="text-align: center">Tên phòng họp</th>
                                    <th style="text-align: center">Người tạo</th>
                                    <th style="text-align: center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="data">
                                @forelse ($meetingRooms as $index => $room)
                                    <tr>
                                        <td style="text-align: center">{{ $index + 1 }}</td>
                                        <td style="text-align: center">{{ $room->name }}</td>
                                        <td style="text-align: center">{{ $room->creator->name ?? 'Không rõ' }}</td>
                                        <td style="text-align: center">
                                            <button class="btn btn-danger btn-sm delete-room-btn"
                                                data-id="{{ $room->id }}">Xoá</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Thêm phòng họp --}}
    <div class="modal fade" id="addMeetingRoomModal" tabindex="-1" aria-labelledby="addMeetingRoomModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form>
                    <div class="modal-header" style="background-color: #C06252;">
                        <h5 class="modal-title text-white" id="addMeetingRoomModalLabel">Thêm phòng họp mới</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên phòng họp</label>
                            <input type="text" class="form-control" id="MeetingRoomName" name="meeting_room_name"
                                placeholder="Nhập tên phòng họp">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="button" id="addMeetingRoom" class="btn text-white" style="background-color: #C06252;"
                            data-bs-dismiss="modal">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('srcipts')
    <script src="{{ mix('js/Setting/handleMeetingRoom.js') }}"></script>
@endsection
