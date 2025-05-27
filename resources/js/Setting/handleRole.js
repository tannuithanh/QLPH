import $ from 'jquery';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function () {
    const userSelect = document.querySelector('#userName');

    if (userSelect) {
        new TomSelect(userSelect, {
            placeholder: 'Chọn người dùng...',
            allowEmptyOption: true,
            create: false
        });

        // Tuỳ chọn: chỉnh chiều cao dropdown
        setTimeout(() => {
            document.querySelector('.ts-control')?.style.setProperty('height', '37px');
        }, 0);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const assignAllBtn = document.getElementById('assignAllBtn');

    assignAllBtn.addEventListener('click', function () {
        const role = document.getElementById('bulkRole').value;

        if (!role) {
            toastr.warning('Vui lòng chọn quyền!');
            return;
        }

        fetch('/add_all_role_manager', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ role })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);

                const tableBody = document.getElementById('roleUserTableBody');

                // Xóa dòng "Chưa có dữ liệu" nếu có
                const emptyRow = tableBody.querySelector('.text-muted');
                if (emptyRow) {
                    emptyRow.closest('tr').remove();
                }

                // Đếm lại số dòng hiện tại
                let currentCount = tableBody.querySelectorAll('tr').length;

                // Thêm từng dòng mới
                data.users.forEach((user, index) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td style="text-align: center">${currentCount + index + 1}</td>
                        <td style="text-align: center">${user.name}</td>
                        <td style="text-align: center">${user.role}</td>
                        <td style="text-align: center">
                            <button class="btn btn-danger btn-sm delete-role-user" data-id="${user.pivot_id}">
                                Xoá
                            </button>
                        </td>
                    `;
                    tableBody.appendChild(tr);
                });
            } else {
                toastr.error(data.message || 'Đã có lỗi xảy ra');
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            toastr.error('Lỗi hệ thống!');
        });
    });

    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-role-user')) {
            const userId = e.target.getAttribute('data-id');

            Swal.fire({
                title: 'Xoá quyền người dùng?',
                text: 'Bạn có chắc chắn muốn xoá phân quyền này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xoá',
                cancelButtonText: 'Huỷ bỏ',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/delete_role_manager', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ user_id: userId })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message);

                            // Xoá dòng
                            e.target.closest('tr')?.remove();

                            // Nếu bảng trống → thêm dòng "chưa có dữ liệu"
                            const tableBody = document.getElementById('roleUserTableBody');
                            if (tableBody.querySelectorAll('tr').length === 0) {
                                const emptyRow = document.createElement('tr');
                                emptyRow.innerHTML = `
                                    <td colspan="4" class="text-center text-muted">Chưa có dữ liệu phân quyền</td>
                                `;
                                tableBody.appendChild(emptyRow);
                            }
                        } else {
                            toastr.warning(data.message || 'Không thể xoá phân quyền.');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        toastr.error('Lỗi hệ thống!');
                    });
                }
            });
        }
    });

    const addBtn = document.getElementById('addRoleUser');

    // 👉 Xử lý Thêm quyền cho 1 người
    addBtn.addEventListener('click', function () {
        const userId = document.getElementById('userName').value;
        const roleId = document.getElementById('userRole').value;

        if (!userId || !roleId) {
            toastr.warning('Vui lòng chọn người dùng và quyền!');
            return;
        }

        fetch('/add_role_manager_single', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ user_id: userId, role_id: roleId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);

                const tableBody = document.getElementById('roleUserTableBody');
                const emptyRow = tableBody.querySelector('.text-muted');
                if (emptyRow) {
                    emptyRow.closest('tr').remove();
                }

                const currentCount = tableBody.querySelectorAll('tr').length;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td style="text-align: center">${currentCount + 1}</td>
                    <td style="text-align: center">${data.user.name}</td>
                    <td style="text-align: center">${data.user.role}</td>
                    <td style="text-align: center">
                        <button class="btn btn-danger btn-sm delete-role-user" data-id="${data.user.pivot_id}">
                            Xoá
                        </button>
                    </td>
                `;
                tableBody.appendChild(tr);

                document.getElementById('userName').value = '';
            } else {
                toastr.warning(data.message || 'Không thể thêm phân quyền.');
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            toastr.error('Lỗi hệ thống!');
        });
    });
});

