$(function() {
    $('[data-shown-if]').each(function(i, item) {
        var attr   = $(item).attr('data-shown-if'),
            values = (attr.indexOf(",") == -1) ? [attr] : attr.split(",");

        var show = function () {
            return values.some(function (value) {
                var parts = value.split(':');

                if (parts[1] == 'checked') {
                    return $(parts[0]).is(':checked');
                }

                if (typeof(parts[1]) == 'undefined') {
                    return $(parts[0]).val();
                }

                return $(parts[0]).val() == parts[1];
            })
        };

        $.each(values, function (i, value) {
            var parts = value.split(':');

            $(parts[0]).change(function (event) {
                return show() ? $(item).show() : $(item).hide();
            }).trigger('change');
        });
    });
});
