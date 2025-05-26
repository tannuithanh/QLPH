@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 page-title">Trang chủ</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1 breadcrumb-custom">
                    <li class="breadcrumb-item">
                        <a href="{{ route('showDashboard') }}" class="text-decoration-none text-muted">
                            <i class="bi bi-house-door-fill me-1"></i> Trang chủ
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="title-vinhgia">Danh sách lịch họp hôm nay</h4>
                        {{-- Bảng nhân sự --}}
                        <div class="table-responsive">
                            <table class="table table-bordered" id="userTable">
                                <thead>
                                    <tr >
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
                                <tbody id="data" >
                                    <tr>
                                        <td style="text-align:center; vertical-align:middle">Phòng họp A</td>
                                        <td style="text-align:center; vertical-align:middle">2025-05-28</td>
                                        <td style="text-align:center; vertical-align:middle">08:30</td>
                                        <td style="text-align:left; word-break: break-word; white-space: normal;">Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3</td>
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
                                        <td style="text-align:left">Họp duyệt ngân sách phòng R&D và tân núi thành là một anh chàng điển traui</td>
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
                                        <td style="text-align:left; word-break: break-word; white-space: normal;">Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3</td>
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
                                        <td style="text-align:left">Họp duyệt ngân sách phòng R&D và tân núi thành là một anh chàng điển traui</td>
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
                                    </tr>  <tr>
                                        <td style="text-align:center; vertical-align:middle">Phòng họp A</td>
                                        <td style="text-align:center; vertical-align:middle">2025-05-28</td>
                                        <td style="text-align:center; vertical-align:middle">08:30</td>
                                        <td style="text-align:left;">Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3 Họp kế hoạch chiến lược Q3</td>
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
                                        <td style="text-align:left">Họp duyệt ngân sách phòng R&D và tân núi thành là một anh chàng điển traui</td>
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
