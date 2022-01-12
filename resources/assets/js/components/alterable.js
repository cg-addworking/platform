(function ($) {

    $(function () {
        $('.alterable .alterable-content').click(function () {
            var $alterable = $(this).parents('.alterable').first();

            $('.alterable-content', $alterable).addClass('hidden');
            $('.alterable-input', $alterable).removeClass('hidden');
            $(':input[name="value"]:first', $alterable).focus();
        })

        $('.alterable .alterable-button-cancel').click(function () {
            var $alterable = $(this).parents('.alterable').first();

            $('.alterable-content', $alterable).removeClass('hidden');
            $('.alterable-input', $alterable).addClass('hidden');
            $('.alterable-input', $alterable).removeClass('has-error');
            $('.alterable-errors *', $alterable).remove();
        });

        $('.alterable :input[name="value"]').keyup(function (event) {
            if (event.which == 13 && !event.shiftKey) {
                var $alterable = $(this).parents('.alterable').first();

                $('.alterable-button-save', $alterable).trigger('click');
            }
        });

        $('.alterable .alterable-button-save').click(function () {
            var $alterable = $(this).parents('.alterable').first();

            $.ajax({
                url: $alterable.attr('data-action'),
                method: 'POST',
                data: {
                    value: $(':input[name="value"]', $alterable).val()
                },
                dataType: 'json',
                beforeSend: function () {
                    $('.alterable-input', $alterable).removeClass('has-error');
                    $('.alterable-errors *', $alterable).remove();
                    $('.alterable-input .alterable-button', $alterable).attr('disabled', 'disabled');
                    $('.alterable-button-save .text-success', $alterable).removeClass('text-success').addClass('text-warning');
                    $('.alterable-button-save .fa', $alterable).addClass('fa-cog fa-spin');
                },
                complete: function () {
                    $('.alterable-button-save .fa', $alterable).removeClass('fa-cog fa-spin');
                    $('.alterable-button-save .text-warning', $alterable).removeClass('text-warning').addClass('text-success');
                    $('.alterable-input .alterable-button', $alterable).removeAttr('disabled');
                },
                success: function(result) {
                    $('.alterable-value', $alterable).html(result.value);
                    $('.alterable-content', $alterable).removeClass('hidden');
                    $('.alterable-input', $alterable).addClass('hidden');
                },
                error: function (xhr, status) {
                    if (xhr.status == 422) {
                        var errors = xhr.responseJSON.errors || {};

                        $.each(errors.value || {}, function(i, item) {
                            $('.alterable-errors', $alterable).append('<p class="text-danger"><b>'+item+'</b></p>');
                        });

                        $('.alterable-input', $alterable).addClass('has-error');
                    }
                }
            });
        });
    });

})(window.jQuery);
