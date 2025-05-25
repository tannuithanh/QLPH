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
                    <li class="breadcrumb-item active text-dark" aria-current="page">Lịch họp</li>
                </ol>
            </nav>
        </div>
        <a class="btn btn-theme text-white px-4 shadow-sm" href="{{ route('showRegisterSchedule') }}">
            + Đăng ký lịch họp
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="date" class="form-control" id="fromDate" placeholder="Từ ngày">
                            <span class="input-group-text">→</span>
                            <input type="date" class="form-control" id="toDate" placeholder="Đến ngày">
                            <button class="btn text-white" style="background-color: #C06252;" id="filterBtn">
                                <i class="bi bi-search me-1"></i> Tìm kiếm
                            </button>
                        </div>
                    </div>
                    <h5 class="title-vinhgia">Danh sách lịch họp</h5>
                        {{-- Bảng nhân sự --}}
                        <div class="table-responsive">
                            <table class="table-vinhgia" id="userTable">
                                <thead class="thead-light" style="font-size: 13px">
                                    <tr style="border: 1px solid #f3f3f3">
                                        <th style="width:150px;text-align:center; vertical-align:middle" rowspan="2">
                                            Phòng họp
                                        </th>
                                        <th style="text-align:center" colspan="2">
                                            Thời gian
                                        </th>
                                        <th style="width:350px;text-align:center; vertical-align:middle" rowspan="2">
                                            Nội dung
                                        </th>
                                        <th style="width:150px;text-align:center; vertical-align:middle" rowspan="2">
                                            Chủ trì
                                        </th>
                                        <th style="width:200px;text-align:center; vertical-align:middle" rowspan="2">
                                            Người liên quan trực tiếp
                                        </th>
                                        <th style="width:150px;text-align:center; vertical-align:middle" rowspan="2">
                                            Thiết bị
                                        </th>


                                        <th style="width:150px;text-align:center; vertical-align:middle" rowspan="2">
                                            Thành phần chuyên môn
                                        </th>

                                        <th style="width:150px;text-align:center; vertical-align:middle" rowspan="2">
                                            Thành phần tư vấn
                                        </th>

                                        <th style="width:150px;text-align:center; vertical-align:middle" rowspan="2">
                                            Người Quyết định
                                        </th>

                                        <th style="width:150px;text-align:center; vertical-align:middle" rowspan="2">
                                            Thư ký
                                        </th>

                                        <th style="width:150px;text-align:center; vertical-align:middle" rowspan="2">
                                            Ghi chú
                                        </th>
                                        <th style="width:250px;text-align:center; vertical-align:middle" rowspan="2">
                                            Tệp tin đính kèm
                                        </th>
                                        <th style="width:150px;text-align:center; vertical-align:middle" rowspan="2">
                                            Người tạo
                                        </th>
                                        <th style="width:100px;text-align:center; vertical-align:middle" rowspan="2">
                                            Thời gian tạo
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="width:100px;text-align:center; vertical-align:middle">
                                            Ngày
                                        </th>
                                        <th style="width:100px;text-align:center; vertical-align:middle">
                                            Giờ
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="data" style="font-size: 12px">
                                    <tr>
                                        <td style="text-align:center; vertical-align:middle">Phòng họp A</td>
                                        <td style="text-align:center; vertical-align:middle">2025-05-28</td>
                                        <td style="text-align:center; vertical-align:middle">08:30</td>
                                        <td style="text-align:left; word-break: break-word; white-space: normal;">Họp kế
                                            hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế
                                            hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3</td>
                                        <td style="text-align:center">Nguyễn Văn A</td>
                                        <td style="text-align:left">Trần B, Lê C</td>
                                        <td style="text-align:center">Máy chiếu, Micro</td>
                                        <td style="text-align:left">Phòng Kinh doanh</td>
                                        <td style="text-align:left">Cố vấn thị trường</td>
                                        <td style="text-align:center">Ông D - CEO</td>
                                        <td style="text-align:center">Nguyễn Thư Ký</td>
                                        <td style="text-align:left">Mang đủ tài liệu phân tích</td>
                                        <td style="text-align:center">
                                            <a href="#">Chiến_lược_Q3.pdf</a>
                                        </td>
                                        <td style="text-align:center">Trần Văn Admin</td>
                                        <td style="text-align:center">2025-05-25 09:42</td>
                                    </tr>

                                    <tr>
                                        <td style="text-align:center; vertical-align:middle">Phòng họp B</td>
                                        <td style="text-align:center; vertical-align:middle">2025-05-29</td>
                                        <td style="text-align:center; vertical-align:middle">14:00</td>
                                        <td style="text-align:left">Họp duyệt ngân sách phòng R&D và tân núi thành là một
                                            anh chàng điển traui</td>
                                        <td style="text-align:center">Phạm Thị B</td>
                                        <td style="text-align:left">Ngô D, Lý E</td>
                                        <td style="text-align:center">TV, Whiteboard</td>
                                        <td style="text-align:left">R&D + Kế toán</td>
                                        <td style="text-align:left">Tư vấn sản phẩm</td>
                                        <td style="text-align:center">Nguyễn GĐ Tài chính</td>
                                        <td style="text-align:center">Lê Văn Thư</td>
                                        <td style="text-align:left">Mang báo cáo tài chính in sẵn</td>
                                        <td style="text-align:center">
                                            <a href="#">duyet_ngansach.xlsx</a>
                                        </td>
                                        <td style="text-align:center">Admin Tạo</td>
                                        <td style="text-align:center">2025-05-25 10:15</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center; vertical-align:middle">Phòng họp A</td>
                                        <td style="text-align:center; vertical-align:middle">2025-05-28</td>
                                        <td style="text-align:center; vertical-align:middle">08:30</td>
                                        <td style="text-align:left; word-break: break-word; white-space: normal;">Họp kế
                                            hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế
                                            hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3</td>
                                        <td style="text-align:center">Nguyễn Văn A</td>
                                        <td style="text-align:left">Trần B, Lê C</td>
                                        <td style="text-align:center">Máy chiếu, Micro</td>
                                        <td style="text-align:left">Phòng Kinh doanh</td>
                                        <td style="text-align:left">Cố vấn thị trường</td>
                                        <td style="text-align:center">Ông D - CEO</td>
                                        <td style="text-align:center">Nguyễn Thư Ký</td>
                                        <td style="text-align:left">Mang đủ tài liệu phân tích</td>
                                        <td style="text-align:center">
                                            <a href="#">Chiến_lược_Q3.pdf</a>
                                        </td>
                                        <td style="text-align:center">Trần Văn Admin</td>
                                        <td style="text-align:center">2025-05-25 09:42</td>
                                    </tr>

                                    <tr>
                                        <td style="text-align:center; vertical-align:middle">Phòng họp B</td>
                                        <td style="text-align:center; vertical-align:middle">2025-05-29</td>
                                        <td style="text-align:center; vertical-align:middle">14:00</td>
                                        <td style="text-align:left">Họp duyệt ngân sách phòng R&D và tân núi thành là một
                                            anh chàng điển traui</td>
                                        <td style="text-align:center">Phạm Thị B</td>
                                        <td style="text-align:left">Ngô D, Lý E</td>
                                        <td style="text-align:center">TV, Whiteboard</td>
                                        <td style="text-align:left">R&D + Kế toán</td>
                                        <td style="text-align:left">Tư vấn sản phẩm</td>
                                        <td style="text-align:center">Nguyễn GĐ Tài chính</td>
                                        <td style="text-align:center">Lê Văn Thư</td>
                                        <td style="text-align:left">Mang báo cáo tài chính in sẵn</td>
                                        <td style="text-align:center">
                                            <a href="#">duyet_ngansach.xlsx</a>
                                        </td>
                                        <td style="text-align:center">Admin Tạo</td>
                                        <td style="text-align:center">2025-05-25 10:15</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center; vertical-align:middle">Phòng họp A</td>
                                        <td style="text-align:center; vertical-align:middle">2025-05-28</td>
                                        <td style="text-align:center; vertical-align:middle">08:30</td>
                                        <td style="text-align:left; word-break: break-word; white-space: normal;">Họp kế
                                            hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế
                                            hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3</td>
                                        <td style="text-align:center">Nguyễn Văn A</td>
                                        <td style="text-align:left">Trần B, Lê C</td>
                                        <td style="text-align:center">Máy chiếu, Micro</td>
                                        <td style="text-align:left">Phòng Kinh doanh</td>
                                        <td style="text-align:left">Cố vấn thị trường</td>
                                        <td style="text-align:center">Ông D - CEO</td>
                                        <td style="text-align:center">Nguyễn Thư Ký</td>
                                        <td style="text-align:left">Mang đủ tài liệu phân tích</td>
                                        <td style="text-align:center">
                                            <a href="#">Chiến_lược_Q3.pdf</a>
                                        </td>
                                        <td style="text-align:center">Trần Văn Admin</td>
                                        <td style="text-align:center">2025-05-25 09:42</td>
                                    </tr>

                                    <tr>
                                        <td style="text-align:center; vertical-align:middle">Phòng họp B</td>
                                        <td style="text-align:center; vertical-align:middle">2025-05-29</td>
                                        <td style="text-align:center; vertical-align:middle">14:00</td>
                                        <td style="text-align:left">Họp duyệt ngân sách phòng R&D và tân núi thành là một
                                            anh chàng điển traui</td>
                                        <td style="text-align:center">Phạm Thị B</td>
                                        <td style="text-align:left">Ngô D, Lý E</td>
                                        <td style="text-align:center">TV, Whiteboard</td>
                                        <td style="text-align:left">R&D + Kế toán</td>
                                        <td style="text-align:left">Tư vấn sản phẩm</td>
                                        <td style="text-align:center">Nguyễn GĐ Tài chính</td>
                                        <td style="text-align:center">Lê Văn Thư</td>
                                        <td style="text-align:left">Mang báo cáo tài chính in sẵn</td>
                                        <td style="text-align:center">
                                            <a href="#">duyet_ngansach.xlsx</a>
                                        </td>
                                        <td style="text-align:center">Admin Tạo</td>
                                        <td style="text-align:center">2025-05-25 10:15</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>


@endsection
