@extends('layouts.app')

@section('title', 'Sửa lịch họp')
@section('styles')
<meta name="schedule-id" content="{{ $history->id }}">
@endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 page-title">Sửa lịch họp</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1 breadcrumb-custom">
                    <li class="breadcrumb-item">
                        <a href="{{ route('showDashboard') }}" class="text-decoration-none text-muted">
                            <i class="bi bi-house-door-fill me-1"></i> Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('showManagerSchedule') }}" class="text-decoration-none text-muted">
                            Lịch họp
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Sửa lịch họp</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4 title-vinhgia">Sửa lịch họp</h5>

                    <div class="row g-3">
                        {{-- Phòng họp --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Phòng họp</label>
                            <select class="form-select" name="room" required>
                                <option value="">-- Chọn phòng họp --</option>
                                @foreach ($meetingRooms as $room)
                                    <option value="{{ $room->id }}"
                                        {{ $history->meeting_room_id == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nội dung --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Nội dung</label>
                            <input type="text" class="form-control" name="title" value="{{ $history->title }}"
                                required>
                        </div>

                        {{-- Thời gian --}}
                        <div class="col-md-3">
                            <label class="label-vinhgia">Thời gian bắt đầu</label>
                            <input type="datetime-local" class="form-control" name="start_datetime"
                                value="{{ $history->date . 'T' . $history->start_time }}">
                        </div>
                        <div class="col-md-3">
                            <label class="label-vinhgia">Thời gian kết thúc</label>
                            <input type="datetime-local" class="form-control" name="end_datetime"
                                value="{{ $history->date . 'T' . $history->end_time }}">
                        </div>

                        {{-- Người liên quan --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Người liên quan trực tiếp</label>
                            <select class="form-select" name="related_people[]" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, $history->related_users ?? []) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Thiết bị --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Thiết bị</label>
                            <input type="text" class="form-control" name="devices" value="{{ $history->devices }}">
                        </div>

                        {{-- Thành phần chuyên môn --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Thành phần chuyên môn</label>
                            <select class="form-select" name="specialists[]" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, $history->specialist_users ?? []) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Thành phần tư vấn --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Thành phần tư vấn</label>
                            <select class="form-select" name="advisors[]" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, $history->advisor_users ?? []) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Người quyết định --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Người quyết định</label>
                            <select class="form-select" name="decision_maker" required>
                                <option value="">-- Chọn người quyết định --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $history->decision_maker_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Thư ký --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Thư ký</label>
                            <select class="form-select" name="secretaries[]" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, $history->secretary_users ?? []) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Chủ trì --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Người chủ trì</label>
                            <input type="text" class="form-control" name="moderator" value="{{ $history->moderator }}">
                        </div>

                        {{-- File đính kèm --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Tệp đính kèm</label>
                            <input type="file" class="form-control" name="attachment">
                            @if ($history->attachment_path)
                                <small class="text-muted">File hiện tại:
                                    <a href="{{ asset($history->attachment_path) }}" target="_blank">Tải xuống</a>
                                </small>
                            @endif
                        </div>

                        {{-- Ghi chú --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Ghi chú</label>
                            <textarea class="form-control" name="note" rows="1">{{ $history->note }}</textarea>
                        </div>

                        {{-- Hạng mục --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Nơi ghi nhận kết quả</label>
                            <select class="form-select" name="result_record_location" required>
                                <option value="Biên bản cuộc họp"
                                    {{ $history->result_record_location == 'Biên bản cuộc họp' ? 'selected' : '' }}>Biên
                                    bản cuộc họp</option>
                                <option value="Gửi email cuộc họp"
                                    {{ $history->result_record_location == 'Gửi email cuộc họp' ? 'selected' : '' }}>Gửi
                                    email cuộc họp</option>
                                <option value="CAP tại biên bản báo cáo sự không phù hợp"
                                    {{ $history->result_record_location == 'CAP tại biên bản báo cáo sự không phù hợp' ? 'selected' : '' }}>
                                    CAP tại biên bản báo cáo sự không phù hợp
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" id="updateSchedule" class="btn text-white px-4"
                            style="background-color: #C06252;">
                            <i class="bi bi-save me-1"></i> Cập nhật lịch họp
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection
@section('srcipts')
    <script src="{{ mix('js/Meeting/editSchedule.js') }}"></script>
@endsection
