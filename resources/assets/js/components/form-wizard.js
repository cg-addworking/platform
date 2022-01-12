$(function() {
    $('.wizard [data-toggle="wizard"]').click(function (event) {
        event.preventDefault();

        var $wizard = $(this).parents('.wizard:first'),
            $target = $($(this).attr('href') || $(this).attr('data-target'), $wizard || document);

        if ($(this).is(':disabled') || $(this).parent('li').hasClass('disabled')) {
            return false;
        }

        $target.trigger('bs:show').removeClass('hidden').siblings().trigger('bs:hide').addClass('hidden');
    });

    $('.wizard .wizard-header li a[data-toggle="wizard"]').each(function (i, item) {
        var $target = $($(item).attr('href'));

        $target.on('bs:show', function () {
            $(item).parent('li').addClass('active').siblings().removeClass('active');
        });
    });


    (function () {
        var $items = $('.wizard-tab .form-group.has-error');

        $items.each(function (i, item) {
            var $tab    = $(item).parents('.wizard-tab:first'),
                $wizard = $(item).parents('.wizard:first');

            $('.wizard-header li a[data-toggle="wizard"][href="#' + $tab.attr('id') + '"]', $wizard)
                .parents('li:first')
                .addClass('has-error');

            if (i == $items.length -1) {
                $('.wizard-header .has-error:first a').trigger('click');
            }
        });
    })();
});
