function noticeSuccess(message) {
    var message = message || 'Proses Berhasil';

    Swal.fire({
        title: 'Success',
        text: message,
        icon: 'success',
        timer: 2000,
        showCancelButton: false,
        showConfirmButton: false
    });
}

function noticeFailed(message) {
    var message = message || 'Proses Gagal';

    Swal.fire({
        title: 'Error',
        text: message,
        icon: 'error',
        timer: 2000,
        showCancelButton: false,
        showConfirmButton: false
    });
}

$(document).ready(function () {
    $("body").tooltip({ selector: '[data-bs-toggle=tooltip]' });

    $(document).on('pjax:send', function () {
        $('#loading').show();
    });

    $(document).on('pjax:complete', function (xhr, textStatus, options) {
        $('.btn_delete_all').hide();
        if (options == 'error') {
            window.location.reload();
        }
        $('#loading').hide();
        if (textStatus.getResponseHeader('redirect-url')) {
            $.pjax({ url: textStatus.getResponseHeader('redirect-url'), container: '#pjax-table', method: 'POST' });
            return false;
        }
        $('.tooltips').tooltip({
            animation: false
        });
    });

    $(document).on('change', '#page-size', function () {
        $('#pjax-search').submit();
        return false;
    });

    $('#pjax-search').submit(function () {
        $.pjax.reload({
            container: '#pjax-table',
            type: 'POST',
            data: $(this).serialize()
        });
        return false;
    });

    $('.search').change(function () {
        $('#pjax-search').submit();
        return false;
    });

    $('#search-keyword').on('keyup', function (e) {
        if (e.keyCode != 13) {
            $('#pjax-search').submit();
        }

        return false;
    });


    $('#search-keyword').on('keydown', function (e) {
        if (e.keyCode == 13) {
            return false;
        }
    });

    $(document).on('change', '.search_status', function () {
        $(this).closest('form').submit()
        return false;
    });

    $(document).on('click', '#button-reset', function () {
        if ($(this).closest("form").find('input')) {
            $(this).closest("form").find('input').val("").change()
        }

        if ($(this).closest("form").find('select')) {
            $(this).closest("form").find('select').val("").change()
        }

        $(this).closest('form').submit()
    })

    var text;
    $(document).on('beforeValidate', 'form:not(\"#pjax-search\")', function () {
        text = $('button[type=submit]').text();
        $('button[type=submit]').addClass('disabled');
    });

    $(document).on('afterValidate', 'form:not(\"#pjax-search\")', function () {
        $('button[type=submit]').removeClass('disabled');
    });

    $(document).on('submit', 'form:not(\"#pjax-search\")', function () {
        $('button[type=submit]').addClass('disabled');
    });

    $(document).on('click', '.btn_modal', function () {
        $('#form-modal').modal('show');
        $('#form-modal').find('.modal-content').html('');
        $('#form-modal').find('.modal-content').load($(this).attr('href'));
        return false;
    });

    $(document).on('click', '.btn_modal_sm', function () {
        $('#form-modal-sm').modal('show');
        $('#form-modal-sm').find('.modal-content').html('');
        $('#form-modal-sm').find('.modal-content').load($(this).attr('href'));
        return false;
    });

    $(document).on('click', '.btn_modal_lg', function () {
        $('#form-modal-lg').modal('show');
        $('#form-modal-lg').find('.modal-content').html('');
        $('#form-modal-lg').find('.modal-content').load($(this).attr('href'));
        return false;
    });

    $(document).on('click', '.btn_delete', function () {
        $('#delete-modal').modal('show');
        $('#delete-modal').find('#btn-delete-data-modal').attr('href', $(this).attr('href'));
        return false;
    });
})