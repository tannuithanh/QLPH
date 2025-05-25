import 'bootstrap/dist/js/bootstrap.bundle.min';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

document.addEventListener('DOMContentLoaded', function () {
    const changeBtn = document.getElementById('changePass');

    changeBtn.addEventListener('click', async function () {
        const current = document.getElementById('current_password').value.trim();

        const newPass = document.getElementById('new_password').value.trim();
        const confirm = document.getElementById('confirm_password').value.trim();
        if (!current || !newPass || !confirm) {
            toastr.warning("Vui lòng điền đầy đủ thông tin.");
            return;
        }

        if (newPass !== confirm) {
            toastr.warning("Mật khẩu mới và xác nhận không khớp.");
            return;
        }

        try {
            const response = await fetch("/change_password", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json", // ✅ THÊM DÒNG NÀY
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    current_password: current,
                    new_password: newPass,
                    confirm_password: confirm
                })
            });
            const result = await response.json();

            if (response.ok && result.success) {
                toastr.success("Đổi mật khẩu thành công!");
                document.getElementById('current_password').value = '';
                document.getElementById('new_password').value = '';
                document.getElementById('confirm_password').value = '';
            } else {
                toastr.error(result.message || "Đổi mật khẩu thất bại.");
            }

        } catch (err) {
            console.error(err);
            toastr.error("Lỗi máy chủ hoặc kết nối.");
        }
    });
});

