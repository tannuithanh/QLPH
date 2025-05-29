<table border="1" cellspacing="0" cellpadding="8" style="border-collapse: collapse; table-layout: auto;">
    <tr>
        <td style="white-space: nowrap; width: 1%;"><strong>Mời họp:</strong></td>
        <td>{{ $meeting->title }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;"><strong>Thời gian:</strong></td>
        <td>{{ \Carbon\Carbon::parse($meeting->date)->format('d/m/Y') }} {{ \Carbon\Carbon::parse($meeting->start_time)->format('H:i') }} ~ {{ \Carbon\Carbon::parse($meeting->end_time)->format('H:i') }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;"><strong>Phòng họp:</strong></td>
        <td>{{ $meeting->meetingRoom->name ?? 'Không rõ' }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;"><strong>Thành phần:</strong></td>
        <td>{{ implode(', ', $relatedUserNames) }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;"><strong>Chủ trì:</strong></td>
        <td>{{ $meeting->moderator }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;"><strong>Thiết bị:</strong></td>
        <td>{{ $meeting->devices }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;"><strong>Ghi chú:</strong></td>
        <td>{{ $meeting->note }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;"><strong>Thành phần chuyên môn:</strong></td>
        <td>{{ implode(', ', $specialistUserNames) }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;"><strong>Thành phần tư vấn:</strong></td>
        <td>{{ implode(', ', $advisorUserNames) }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;"><strong>Thư ký:</strong></td>
        <td>{{ implode(', ', $secretaryUserNames) }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;"><strong>Người quyết định vấn đề:</strong></td>
        <td>{{ $decisionMakerName }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;"><strong>Nơi ghi nhận kết quả:</strong></td>
        <td>{{ $meeting->result_record_location }}</td>
    </tr>
</table>

<p style="color:red;font-style:italic;"><strong>Chú ý:</strong> Đây là hệ thống Email tự động, vui lòng không Reply Email này.</p>
