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
                            <thead class="thead-light">
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
                                    <th style="width:250px;text-align:center; vertical-align:middle" rowspan="2">
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
                                    <th style="width:250px;text-align:center; vertical-align:middle" rowspan="2">
                                        Nơi ghi nhận kết quả
                                    </th>
                                    <th style="width:150px;text-align:center; vertical-align:middle" rowspan="2">
                                        Người tạo
                                    </th>
                                    <th style="width:100px;text-align:center; vertical-align:middle" rowspan="2">
                                        Thời gian tạo
                                    </th>
                                    <th style="width:100px;text-align:center; vertical-align:middle" rowspan="2">
                                        Thao tác
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width:100px;text-align:center; vertical-align:middle">
                                        Ngày
                                    </th>
                                    <th style="width:20`0px;text-align:center; vertical-align:middle">
                                        Giờ
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="data">
                                @foreach ($histories as $item)
                                    <tr>
                                        <td style="text-align:center">{{ $item->meetingRoom->name ?? '-' }}</td>

                                        {{-- Ngày --}}
                                        <td style="text-align:center">
                                            {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>

                                        {{-- Giờ --}}
                                        <td style="text-align:center">
                                            {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }} →
                                            {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}
                                        </td>

                                        <td>{{ $item->title }}</td>
                                        <td style="text-align:center">{{ $item->moderator }}</td>

                                        {{-- Người liên quan --}}
                                        <td style="white-space: normal">
                                            {{ $item->relatedUsers()->pluck('name')->join(', ') }}
                                        </td>

                                        <td style="white-space: normal">{{ $item->devices }}</td>

                                        {{-- Thành phần chuyên môn --}}
                                        <td style="white-space: normal">
                                            {{ $item->specialistUsers()->pluck('name')->join(', ') }}
                                        </td>


                                        {{-- Thành phần tư vấn --}}
                                        <td style="white-space: normal">
                                            {{ $item->advisorUsers()->pluck('name')->join(', ') }}
                                        </td>


                                        {{-- Người quyết định --}}
                                        <td style="text-align:center">{{ $item->decisionMaker->name ?? '-' }}</td>

                                        {{-- Thư ký --}}
                                        <td>
                                            {{ $item->secretaryUsers()->pluck('name')->join(', ') }}
                                        </td>

                                        <td style="white-space: normal">{{ $item->note }}</td>

                                        {{-- Tệp tin đính kèm --}}
                                        <td>
                                            @if ($item->attachment_path)
                                                <a href="{{ asset($item->attachment_path) }}" target="_blank">Tải File</a>
                                            @else
                                                Không có
                                            @endif
                                        </td>
                                        <td>{{ $item->result_record_location }}</td>
                                        {{-- Người tạo --}}
                                        <td style="text-align:center">
                                            {{ \App\Models\User::find($item->created_by)?->name ?? '-' }}
                                        </td>

                                        {{-- Thời gian tạo --}}
                                        <td style="text-align:center">
                                            {{ $item->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        {{-- Thao tác --}}
                                        <td style="text-align: center">
                                            @if ($item->created_by === $user->id || $user->admin == 1)
                                                <a href="{{ route('showEditSchedule', $item->id) }}"
                                                    class="btn btn-sm btn-warning me-1">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endif

                                            @if ($user->admin == 1)
                                                <button type="button"
                                                    class="btn btn-sm btn-danger btn-delete-schedule mt-1"
                                                    data-id="{{ $item->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @endif
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


@endsection
@section('srcipts')
    <script src="{{ mix('js/Meeting/managerSchedule.js') }}"></script>
@endsection
