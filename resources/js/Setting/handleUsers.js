import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('addUsers');
    const modal = document.getElementById('addUserModal');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    btn.addEventListener('click', function () {
        const name = document.getElementById('userName').value.trim();
        const email = document.getElementById('userEmail').value.trim();
        const phone = document.getElementById('userPhone').value.trim();
        const department = document.getElementById('userDepartment').value;
        const isAdmin = document.getElementById('isAdminCheckbox').checked;

        if (!name || !email || !phone || !department) {
            toastr.warning('Vui lòng điền đầy đủ thông tin.');
            return;
        }

        fetch('/add_users', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                name: name,
                email: email,
                phone: phone,
                department_id: department,
                is_admin: isAdmin ? 1 : 0
            })
        })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text); });
                }
                return response.json();
            })
            .then(data => {
                // Đóng modal
                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');
                document.body.style = '';
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                // Reset form
                document.getElementById('userName').value = '';
                document.getElementById('userEmail').value = '';
                document.getElementById('userPhone').value = '';
                document.getElementById('userDepartment').selectedIndex = 0;
                document.getElementById('isAdminCheckbox').checked = false;

                // ✅ Thêm vào bảng
                const tableBody = document.getElementById('data');
                const rowCount = tableBody.querySelectorAll('tr').length + 1;

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${rowCount}</td>
                    <td>${data.name}</td>
                    <td>${data.email}</td>
                    <td>${data.department}</td>
                    <td>${data.phone ?? '---'}</td>
                    <td>
                        ${data.is_admin
                                    ? '<span class="badge bg-success">✓</span>'
                                    : '<span class="badge bg-secondary">-</span>'}
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary edit-user-btn" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="${data.user_id}">Sửa</a>
                        <a href="#" class="btn btn-sm btn-danger delete-user-btn" data-id="${data.user_id}">Xoá</a>
                    </td>
                `;
                tableBody.appendChild(newRow);

                toastr.success('Thêm nhân sự thành công!');
            })

            .catch(error => {
                toastr.error('Thêm thất bại: ' + error.message);
            });
    });
});


// Gán sự kiện delete và edit cho bảng
document.getElementById('data').addEventListener('click', function (e) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const button = e.target;
    const row = button.closest('tr');
    const id = button.getAttribute('data-id');

    // ✅ XÓA NGƯỜI DÙNG
    if (button.classList.contains('delete-user-btn')) {
        Swal.fire({
            title: 'Xác nhận xoá?',
            text: 'Bạn có chắc muốn xoá nhân sự này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xoá',
            cancelButtonText: 'Huỷ',
            confirmButtonColor: '#d33'
        }).then(result => {
            if (!result.isConfirmed) return;

            fetch('/delete_users', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ id })
            })
            .then(res => {
                if (!res.ok) throw new Error('Xoá thất bại');
                row.remove();
                toastr.success('Đã xoá nhân sự thành công!');
            })
            .catch(err => toastr.error(err.message));
        });
    }

    // ✅ SỬA NGƯỜI DÙNG
    if (button.classList.contains('edit-user-btn')) {
        const modal = document.getElementById('editUserModal');
        const inputName = modal.querySelector('#userNameEdit');
        const inputEmail = modal.querySelector('#userEmailEdit');
        const inputPhone = modal.querySelector('#userPhoneEdit');
        const inputDepartment = modal.querySelector('#userDepartmentEdit');
        const inputIsAdmin = modal.querySelector('#isAdminCheckboxEdit');
        const saveBtn = modal.querySelector('#editUserSubmit');

        const cells = row.querySelectorAll('td');
        inputName.value = cells[1].textContent.trim();
        inputEmail.value = cells[2].textContent.trim();
        inputPhone.value = cells[4].textContent.trim();
        const departmentName = cells[3].textContent.trim();

        // Ưu tiên lấy từ data-dept-id
        const deptId = cells[3].getAttribute('data-dept-id');

        if (deptId) {
            inputDepartment.value = deptId;
        } else {
            // Fallback nếu không có dept-id → chọn theo tên
            const options = inputDepartment.querySelectorAll('option');
            options.forEach(option => {
                option.selected = option.textContent.trim() === departmentName;
            });
        }
        inputIsAdmin.checked = cells[5].querySelector('.bg-success') !== null;
        console.log()
        saveBtn.setAttribute('data-id', id);
        saveBtn.setAttribute('data-row-index', row.rowIndex);

        // Đảm bảo không bị gắn trùng
        const newSaveHandler = async () => {
            try {
                const res = await fetch('/edit_users', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        id,
                        name: inputName.value.trim(),
                        email: inputEmail.value.trim(),
                        phone: inputPhone.value.trim(),
                        department_id: inputDepartment.value,
                        is_admin: inputIsAdmin.checked ? 1 : 0
                    })
                });

                const body = await res.json();
                if (res.status === 422) {
                    const msg = Object.values(body.errors)[0][0];
                    throw new Error(msg);
                }

                const cells = row.querySelectorAll('td');
                cells[1].textContent = body.user.name;
                cells[2].textContent = body.user.email;
                cells[3].textContent = body.user.department;
                cells[3].setAttribute('data-dept-id', body.user.department_id);
                cells[4].textContent = body.user.phone;
                cells[5].innerHTML = body.user.is_admin
                    ? '<span class="badge bg-success">✓</span>'
                    : '<span class="badge bg-secondary">-</span>';

                toastr.success('Cập nhật nhân sự thành công!');
                closeModal(modal);
            } catch (err) {
                toastr.error('Cập nhật thất bại: ' + err.message);
            }
        };

        // Gỡ sự kiện cũ rồi gán mới
        saveBtn.replaceWith(saveBtn.cloneNode(true));
        const freshBtn = modal.querySelector('#editUserSubmit');
        freshBtn.setAttribute('data-id', id);
        freshBtn.setAttribute('data-row-index', row.rowIndex);
        freshBtn.addEventListener('click', newSaveHandler);

        // Mở modal
        modal.classList.add('show');
        modal.style.display = 'block';
        document.body.classList.add('modal-open');
    }
});


function closeModal(modalEl) {
    modalEl.classList.remove('show');
    modalEl.setAttribute('aria-hidden', 'true');
    modalEl.style.display = 'none';
    document.body.classList.remove('modal-open');
    document.body.style = '';
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
}