@extends('layouts.app')

@section('title', 'Quản lý lịch họp')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 page-title">Quản lý lịch họp</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1 breadcrumb-custom">
                    <li class="breadcrumb-item">
                        <a href="{{ route('showDashboard') }}" class="text-decoration-none text-muted">
                            <i class="bi bi-house-door-fill me-1"></i> Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('showDashboard') }}" class="text-decoration-none text-muted">
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
                <h5 class="mb-4 title-vinhgia">Đăng ký lịch họp</h5>

                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        {{-- Phòng họp --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Phòng họp</label>
                            <select class="form-select" name="room" required>
                                <option value="">-- Chọn phòng họp --</option>
                                <option value="Phòng họp A">Phòng họp A</option>
                                <option value="Phòng họp B">Phòng họp B</option>
                            </select>
                        </div>

                        {{-- Nội dung --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Nội dung</label>
                            <input type="text" class="form-control" name="title" placeholder="Nội dung cuộc họp" required>
                        </div>

                        {{-- Thời gian bắt đầu / kết thúc --}}
                        <div class="col-md-3">
                            <label class="label-vinhgia">Ngày bắt đầu</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-3">
                            <label class="label-vinhgia">Giờ bắt đầu</label>
                            <input type="time" class="form-control" name="start_time" required>
                        </div>
                        <div class="col-md-3">
                            <label class="label-vinhgia">Ngày kết thúc</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                        <div class="col-md-3">
                            <label class="label-vinhgia">Giờ kết thúc</label>
                            <input type="time" class="form-control" name="end_time" required>
                        </div>

                        {{-- Người liên quan --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Người liên quan trực tiếp</label>
                            <input type="text" class="form-control" name="related_people" placeholder="Ngăn cách bằng dấu phẩy">
                        </div>

                        {{-- Thiết bị --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Thiết bị</label>
                            <input type="text" class="form-control" name="devices" placeholder="Ví dụ: Máy chiếu, Micro...">
                        </div>

                        {{-- Thành phần chuyên môn --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Thành phần chuyên môn</label>
                            <input type="text" class="form-control" name="specialists" placeholder="Ngăn cách bằng dấu phẩy">
                        </div>

                        {{-- Thành phần tư vấn --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Thành phần tư vấn</label>
                            <input type="text" class="form-control" name="advisors" placeholder="Ngăn cách bằng dấu phẩy">
                        </div>

                        {{-- Người quyết định --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Người quyết định</label>
                            <input type="text" class="form-control" name="decision_maker">
                        </div>

                        {{-- Thư ký --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Thư ký</label>
                            <input type="text" class="form-control" name="secretary">
                        </div>

                        {{-- File đính kèm --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Tệp đính kèm</label>
                            <input type="file" class="form-control" name="attachment">
                        </div>

                        {{-- Ghi chú --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Ghi chú</label>
                            <textarea class="form-control" name="note" rows="2" placeholder="Ghi chú thêm nếu có"></textarea>
                        </div>

                        {{-- Hạng mục --}}
                        <div class="col-md-6">
                            <label class="label-vinhgia">Hạng mục</label>
                            <input type="text" class="form-control" name="category">
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn text-white px-4" style="background-color: #C06252;">
                            <i class="bi bi-calendar-plus me-1"></i> Đăng ký lịch họp
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
