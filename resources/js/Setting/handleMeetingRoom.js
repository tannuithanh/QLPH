import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import Swal from 'sweetalert2';

document.getElementById('addMeetingRoom').addEventListener('click', async function () {
    const name = document.getElementById('MeetingRoomName').value;

    if (!name.trim()) {
        toastr.warning("Vui lòng nhập tên phòng họp.");
        return;
    }

    try {
        const response = await fetch("/add_meeting_room", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: name
            })
        });

        const result = await response.json();

        if (response.ok && result.success) {
            // Ẩn modal thủ công
            const noDataRow = document.querySelector('#data tr td[colspan="4"]');
            if (noDataRow) noDataRow.parentElement.remove();

            // Reset input
            document.getElementById('MeetingRoomName').value = "";

            // Toastr thành công
            toastr.success("Thêm phòng họp thành công!");

            // Thêm dòng vào bảng
            const tbody = document.getElementById('data');
            const rowCount = tbody.rows.length;
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td style="text-align: center">${rowCount + 1}</td>
                <td style="text-align: center">${result.data.name}</td>
                <td style="text-align: center">${result.data.creator}</td>
                <td style="text-align: center">
                    <button class="btn btn-danger btn-sm delete-room-btn" data-id="${result.data.id}" >Xoá</button>
                </td>
            `;
            tbody.appendChild(newRow);
        } else {
            toastr.error(result.message || "Đã xảy ra lỗi.");
        }
    } catch (error) {
        console.error(error);
        toastr.error("Lỗi kết nối máy chủ.");
    }

});


document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.getElementById('data'); // ✅ BỔ SUNG DÒNG NÀY
    function checkEmptyTable() {
        if (tbody.children.length === 0) {
            const emptyRow = document.createElement('tr');
            emptyRow.innerHTML = `<td colspan="4" style="text-align: center">Không có dữ liệu</td>`;
            tbody.appendChild(emptyRow);
        }
    }
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('delete-room-btn')) {
            const id = e.target.getAttribute('data-id');

            Swal.fire({
                title: 'Xác nhận xoá?',
                text: 'Bạn có chắc muốn xoá phòng họp này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xoá',
                cancelButtonText: 'Huỷ',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("/delete_meeting_room", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ id })
                    })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                const row = e.target.closest('tr');
                                row.remove();
                                toastr.success("Xoá phòng họp thành công!");
                                checkEmptyTable();
                            } else {
                                toastr.error(result.message || "Không thể xoá phòng họp.");
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            toastr.error("Lỗi kết nối máy chủ.");
                        });
                }
            });
        }
    });
});


