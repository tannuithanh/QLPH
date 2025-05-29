@extends('layouts.app')

@section('title', 'Đăng ký lịch họp')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 page-title">Đăng ký lịch họp</h4>
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
                    <li class="breadcrumb-item active" aria-current="page">Đăng ký lịch họp</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4 title-vinhgia">Thông tin lịch họp</h5>
                    <div class="row g-3">
                        {{-- Phòng họp --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Phòng họp</label>
                            <select class="form-select" name="room" required>
                                <option value="">-- Chọn phòng họp --</option>
                                @foreach ($meetingRooms as $index => $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nội dung --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Nội dung</label>
                            <input type="text" class="form-control" name="title" placeholder="Nội dung cuộc họp"
                                required>
                        </div>

                        {{-- Thời gian bắt đầu / kết thúc --}}
                        <div class="col-md-3">
                            <label class="label-vinhgia">Thời gian bắt đầu</label>
                            <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime"
                                required>
                        </div>
                        <div class="col-md-3">
                            <label class="label-vinhgia">Thời gian kết thúc</label>
                            <input type="datetime-local" class="form-control" name="end_datetime" id="end_datetime"
                                required>
                        </div>


                        {{-- Người liên quan --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Người liên quan trực tiếp</label>
                            <select class="form-select" name="related_people[]" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Thiết bị --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Thiết bị</label>
                            <input type="text" class="form-control" name="devices"
                                placeholder="Ví dụ: Máy chiếu, Micro...">
                        </div>

                        {{-- Thành phần chuyên môn --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Thành phần chuyên môn</label>
                            <select class="form-select" name="specialists[]" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Thành phần tư vấn --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Thành phần tư vấn</label>
                            <select class="form-select" name="advisors[]" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Người quyết định --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Người quyết định</label>
                            <select class="form-select" name="decision_maker">
                                <option value="">-- Chọn người quyết định --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Thư ký --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Thư ký</label>
                            <select class="form-select" name="secretaries[]" multiple>
                                <option value="">-- Thư ký --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Chủ trì --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Người chủ trì</label>
                            <input type="text" class="form-control" name="moderator"
                                placeholder="Nhập tên người chủ trì">
                        </div>

                        {{-- File đính kèm --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Tệp đính kèm</label>
                            <input type="file" class="form-control" name="attachment">
                        </div>

                        {{-- Ghi chú --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Ghi chú</label>
                            <textarea class="form-control" name="note" rows="1" placeholder="Ghi chú thêm nếu có"></textarea>
                        </div>

                        {{-- Hạng mục --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Nơi ghi nhận kết quả</label>
                            <select class="form-select" name="result_record_location" required>
                                <option value="Biên bản cuộc họp">Biên bản cuộc họp</option>
                                <option value="Gửi email cuộc họp">Gửi email cuộc họp</option>
                                <option value="CAP tại biên bản báo cáo sự không phù hợp">CAP tại biên bản báo cáo sự không
                                    phù hợp</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" id="registerSchedule" class="btn text-white px-4"
                            style="background-color: #C06252;">
                            <i class="bi bi-calendar-plus me-1"></i> Đăng ký lịch họp
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <b><i class="text-danger underline">Lưu ý:</i></b><br>

    - Cột Thành phần chuyên môn và thành phần tư vấn nếu không có thì được quyền để trống, không cần chọn.<br>
    - Cột Người liên quan và Người quyết định bắt buộc phải chọn<br>
    - Các thành phần không được trùng nhau, nếu đã là Người liên quan thì không được chọn ở các thành phần khác.<br>
    - Người đăng ký lịch họp không cần chọn ở các thành phần khác, trừ khi là book lịch giúp cho BGĐ/BĐH.<br>
    - Những cuộc họp chỉ có 1 người là Người quyết định thì ở Người liên quan chọn tên của người Book lịch họp<br>
    - File đính kèm chỉ giới hạn 8MB nên vui lòng kiểm tra lại dung lượng trước khi đính kèm File<br>
    - Có những cuộc họp ở xa nên thành phần họp cần thời gian di chuyển giữa các cuộc họp, vui lòng cân nhắc thời gian Book
    lịch họp cho phù hợp.<br>
    - Các cuộc phòng Book sai quy trình sẽ được phòng IT gởi Email cho người đăng ký và cc cho phòng QTHT (Mr. Chức) làm căn
    cứ đánh giá lỗi.<br>


@endsection
@section('srcipts')
    <script src="{{ mix('js/Meeting/registerSchedule.js') }}"></script>
@endsection
