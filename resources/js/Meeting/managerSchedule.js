import $ from 'jquery';
import Swal from 'sweetalert2';

$(document).on('click', '.btn-delete-schedule', function () {
    const scheduleId = $(this).data('id');

    Swal.fire({
        title: 'Xác nhận xoá?',
        text: 'Bạn có chắc muốn xoá lịch họp này không?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Xoá',
        cancelButtonText: 'Huỷ'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/delete_Schedule', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ id: scheduleId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã xoá!',
                        text: data.message || 'Lịch họp đã được xoá.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Lỗi', data.message || 'Không thể xoá lịch họp.', 'error');
                }
            })
            .catch(() => {
                Swal.fire('Lỗi', 'Không thể kết nối máy chủ.', 'error');
            });
        }
    });
});

// JavaScript: Tìm kiếm theo ngày cho lịch họp
$(document).ready(function () {
    $('#filterBtn').on('click', async function () {
        const fromDate = $('#fromDate').val();
        const toDate = $('#toDate').val();

        // Trường hợp rỗng hoàn toàn → reload
        if (!fromDate && !toDate) {
            location.reload();
            return;
        }

        // from > to → báo lỗi
        if (fromDate && toDate && new Date(fromDate) > new Date(toDate)) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Ngày bắt đầu không được lớn hơn ngày kết thúc'
            });
            return;
        }

        try {
            const res = await fetch('/search_Schedule', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ from: fromDate, to: toDate })
            });

            const data = await res.json();
            const $tbody = $('#data');
            $tbody.empty();

            if (res.ok && data.length > 0) {
                data.forEach(item => {
                    const related = item.related_users.map(u => `<div>${u}</div>`).join('');
                    const specialist = item.specialist_users.map(u => `<div>${u}</div>`).join('');
                    const advisor = item.advisor_users.map(u => `<div>${u}</div>`).join('');
                    const secretary = item.secretary_users.map(u => `<div>${u}</div>`).join('');

                    $tbody.append(`
                        <tr>
                            <td style="text-align:center">${item.meeting_room}</td>
                            <td style="text-align:center">${item.date}</td>
                            <td style="text-align:center">${item.start_time} → ${item.end_time}</td>
                            <td>${item.title}</td>
                            <td style="text-align:center">${item.moderator}</td>
                            <td>${related}</td>
                            <td>${item.devices ?? ''}</td>
                            <td>${specialist}</td>
                            <td>${advisor}</td>
                            <td style="text-align:center">${item.decision_maker}</td>
                            <td>${secretary}</td>
                            <td>${item.note}</td>
                            <td>
                                ${item.attachment_path ? `<a href="${item.attachment_path}" target="_blank">Tải File</a>` : 'Không có'}
                            </td>
                            <td style="text-align:center">${item.creator}</td>
                            <td style="text-align:center">${item.created_at}</td>
                            <td style="text-align:center">
                                <a href="/edit_Schedule/${item.id}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger btn-delete-schedule mt-1" data-id="${item.id}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                });
            } else {
                $tbody.append(`
                    <tr>
                        <td colspan="16" class="text-center text-muted">Không có dữ liệu</td>
                    </tr>
                `);
            }
        } catch (err) {
            console.error(err);
            Swal.fire('Lỗi', 'Không thể tìm kiếm dữ liệu', 'error');
        }
    });
});