import $ from 'jquery';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import 'select2/dist/css/select2.min.css';
import 'select2';

$(document).ready(function () {
    // Khởi tạo Select2
    const selectNames = ['related_people[]', 'specialists[]', 'advisors[]', 'secretaries[]'];
    selectNames.forEach(name => {
        const $select = $(`select[name="${name}"]`);
        $select.select2({ placeholder: "Chọn người", width: '100%' });
        $select.on('change', () => clearError($select));
    });

    const $decisionSelect = $('select[name="decision_maker"]');
    $decisionSelect.select2({ placeholder: "Chọn người quyết định", width: '100%' });
    $decisionSelect.on('change', () => clearError($decisionSelect));

    $('#registerSchedule').on('click', async function () {
        clearAllErrors();

        const related = $(`select[name="related_people[]"]`).select2('val') || [];
        const specialists = $(`select[name="specialists[]"]`).select2('val') || [];
        const advisors = $(`select[name="advisors[]"]`).select2('val') || [];
        const secretaries = $(`select[name="secretaries[]"]`).select2('val') || [];
        const decisionMaker = $decisionSelect.val();
        const file = $('input[name="attachment"]')[0]?.files[0];
        const startRaw = $('input[name="start_datetime"]').val();
        const endRaw = $('input[name="end_datetime"]').val();
        const title = $('input[name="title"]').val()?.trim();

        if (!title) {
            markError('input[name="title"]', 'Nội dung cuộc họp là bắt buộc');
            toastr.error('Vui lòng nhập nội dung cuộc họp');
            return;
        }
        let hasError = false;

        if (!startRaw || !endRaw) {
            markError('input[name="start_datetime"]', 'Chưa chọn thời gian bắt đầu');
            markError('input[name="end_datetime"]', 'Chưa chọn thời gian kết thúc');
            toastr.error('Vui lòng chọn đầy đủ thời gian bắt đầu và kết thúc');
            return;
        }

        const start = new Date(startRaw);
        const end = new Date(endRaw);

        const sameDate =
            start.getFullYear() === end.getFullYear() &&
            start.getMonth() === end.getMonth() &&
            start.getDate() === end.getDate();

        if (!sameDate) {
            markError('input[name="start_datetime"]', 'Ngày phải trùng nhau');
            markError('input[name="end_datetime"]');
            toastr.error('Ngày bắt đầu và kết thúc phải giống nhau');
            return;
        }

        if (start.getTime() >= end.getTime()) {
            markError('input[name="start_datetime"]', 'Giờ không hợp lệ');
            markError('input[name="end_datetime"]');
            toastr.error('Giờ bắt đầu phải nhỏ hơn giờ kết thúc');
            return;
        }

        if (!decisionMaker) {
            markError('select[name="decision_maker"]', 'Phải chọn người quyết định');
            hasError = true;
        }

        if (related.length === 0) {
            markError('select[name="related_people[]"]', 'Phải chọn ít nhất một người liên quan');
            hasError = true;
        }

        const all = [...related, ...specialists, ...advisors, ...secretaries];
        if (all.includes(decisionMaker)) {
            markError('select[name="decision_maker"]', 'Không trùng vai trò');
            hasError = true;
        }

        const duplicates = findDuplicates([...all, decisionMaker]);
        if (duplicates.length > 0) {
            toastr.error('Một người không được chọn trùng vai trò');
            [...selectNames, 'decision_maker'].forEach(name => markError(`select[name="${name}"]`));
            hasError = true;
        }

        if (file && file.size > 8 * 1024 * 1024) {
            markError('input[name="attachment"]', 'File vượt quá 8MB');
            toastr.error('File đính kèm vượt quá 8MB');
            hasError = true;
        }

        if (hasError) {
            toastr.error('Vui lòng kiểm tra lại các trường');
            return;
        }

        // Gửi form bằng fetch
        const formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('meeting_room_id', $('select[name="room"]').val());
        formData.append('title', $('input[name="title"]').val());
        formData.append('start_datetime', startRaw);
        formData.append('end_datetime', endRaw);
        formData.append('decision_maker', decisionMaker);
        formData.append('moderator', $('input[name="moderator"]').val());
        formData.append('note', $('textarea[name="note"]').val());
        formData.append('devices', $('input[name="devices"]').val());
        formData.append('result_record_location', $('select[name="result_record_location"]').val());
        formData.append('related_people', JSON.stringify(related));
        formData.append('specialists', JSON.stringify(specialists));
        formData.append('advisors', JSON.stringify(advisors));
        formData.append('secretaries', JSON.stringify(secretaries));
        if (file) formData.append('attachment', file);

        try {
            $('#registerSchedule').prop('disabled', true).html('<i class="bi bi-clock-history me-1"></i> Đang xử lý...');

            const res = await fetch('/Handle_Register_Schedule', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const data = await res.json();
            if (res.ok) {
                $('#registerSchedule').hide(); // Ẩn nút sau khi thành công
                toastr.success(data.message || 'Đăng ký thành công');
                setTimeout(() => window.location.href = '/manager_shedule', 1500); // Chuyển trang sau 2s
            } else {
                $('#registerSchedule').prop('disabled', false).html(`<i class="bi bi-calendar-plus me-1"></i> Đăng ký lịch họp`);
                toastr.error(data.message || 'Có lỗi xảy ra khi gửi');
            }
        } catch (err) {
            toastr.error('Lỗi kết nối máy chủ');
            console.error(err);
        }
    });

    // Helpers
    function markError(selector, message = '') {
        const $el = $(selector);
        $el.addClass('is-invalid');
        const $container = $el.closest('.col-md-6, .col-md-3');
        $container.find('.error-message').remove();
        if (message) {
            $('<div class="text-danger mt-1 error-message"></div>').text(message).appendTo($container);
        }
    }

    function clearError($el) {
        $el.removeClass('is-invalid');
        $el.closest('.col-md-6, .col-md-3').find('.error-message').remove();
    }

    function clearAllErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.error-message').remove();
    }

    function findDuplicates(array) {
        const seen = new Set();
        return array.filter(item => {
            if (seen.has(item)) return true;
            seen.add(item);
            return false;
        });
    }
});

