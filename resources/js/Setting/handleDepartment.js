import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('data');
    const modalEl = document.getElementById('addDepartmentModal');
    const input = document.getElementById('departmentName');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    initAddDepartment();
    initDeleteDepartment();

    //THÊM PHÒNG BAN
    function initAddDepartment() {
        const addButton = document.getElementById('addDepartment');

        addButton.addEventListener('click', function () {
            const departmentName = input.value.trim();

            if (departmentName === '') {
                toastr.warning('Vui lòng nhập tên phòng ban!');
                return;
            }

            fetch('/add_department', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ department_name: departmentName })
            })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error(text); });
                    }
                    return response.json();
                })
                .then(data => {
                    closeModal();

                    // Xoá hàng trống nếu có
                    const emptyRow = tableBody.querySelector('.empty-row');
                    if (emptyRow) {
                        emptyRow.remove();
                    }

                    // Thêm dòng mới
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                    <td style="text-align: center"></td>
                    <td style="text-align: center">${data.department_name}</td>
                    <td style="text-align: center">
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data.id}">Xoá</button>
                    </td>
                `;
                    tableBody.appendChild(newRow);
                    reindexTable();

                    input.value = '';
                    toastr.success('Thêm phòng ban thành công!');
                })
                .catch(error => {
                    toastr.error('Thêm thất bại: ' + error.message);
                });
        });
    }

    //XÓA PHÒNG BAN
    function initDeleteDepartment() {
        tableBody.addEventListener('click', function (e) {
            if (!e.target.classList.contains('delete-btn')) return;

            const button = e.target;
            const id = button.getAttribute('data-id');

            // Xác nhận bằng SweetAlert2
            Swal.fire({
                title: 'Xác nhận xoá?',
                text: 'Bạn có chắc muốn xoá phòng ban này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xoá',
                cancelButtonText: 'Huỷ',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (!result.isConfirmed) return;

                // Gửi request xoá
                fetch('/delelte_department', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ id })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error(text); });
                    }
                    return response.json();
                })
                .then(() => {
                    const row = button.closest('tr');
                    row.remove();
                    reindexTable();

                    if (tableBody.querySelectorAll('tr').length === 0) {
                        renderEmptyRow();
                    }

                    // ✅ Thông báo bằng Toastr
                    toastr.success('Phòng ban đã được xoá thành công!');
                })
                .catch(error => {
                    // ❌ Báo lỗi bằng Toastr
                    toastr.error('Xoá thất bại: ' + error.message);
                });
            });
        });
    }



    function reindexTable() {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            const sttCell = row.querySelector('td');
            if (sttCell) sttCell.textContent = index + 1;
        });
    }

    function renderEmptyRow() {
        const row = document.createElement('tr');
        row.classList.add('empty-row');
        row.innerHTML = `
            <td colspan="3" class="text-center text-muted">Chưa có phòng ban nào.</td>
        `;
        tableBody.appendChild(row);
    }

    function closeModal() {
        modalEl.classList.remove('show');
        modalEl.setAttribute('aria-hidden', 'true');
        modalEl.style.display = 'none';
        document.body.classList.remove('modal-open');
        document.body.style = '';
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    }
});
