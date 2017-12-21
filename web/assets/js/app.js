/**
 * Created by avanzu on 13.05.17.
 */
(function ($) {
    var primary = $('[data-role="primary"]'),
        aside   = $('[data-role="aside"]'),
        parent  = primary.closest('[data-role="collapse-container"]'),
        loader  = $('#loader').html();

    var switchToPrimay = function () {
        primary.collapse('show');
        aside.collapse('hide');
    };

    var switchToAside = function () {
        primary.collapse('hide');
        aside.collapse('show');
    };

    $(function () { $('select').selectpicker(); });

    $('[data-image-container]').on('change', 'input', function () {
        $self   = $(this);
        var url = $self.val(), img = $self.closest('[data-image-container]').find('img');
        img.attr('src', url);
    });

    $([primary, aside]).collapse({
        toggle : false,
        parent : parent
    });

    aside.on('click', '[data-action="cancel"]', function (e) {
        e.preventDefault();
        switchToPrimay();
    });

    aside.on('click', '[data-action="save"]', function (e) {
        var data, $self = $(this);
        e.preventDefault();
        data = $(':input', aside).serializeArray();
        $.post($self.attr('data-url'), data)
         .done(function (response) {
             var model    = response.record;
             var $applyTo = $('#' + $self.attr('data-apply-to'));
             switchToPrimay();
             $applyTo.append($('<option></option>').attr({
                 "value"    : model.id,
                 "selected" : "selected"
             }).text(model.display));
             $applyTo.selectpicker('refresh');

         })
         .fail(function (response) {
             $('[data-role="augment"]', aside).html(response.responseText);
         })
        ;
    });

    $('body').on('click', '[data-display]', function (e) {

    });

    $('body').on('click', '[data-append-button]', function (e) {

        var $self  = $(this);
        var $input = $self.closest('[data-appendable]').find(':input[id]');
        e.preventDefault();
        switchToAside();
        $('[data-role="augment"]', aside).html(loader);
        $('[data-action="save"]', aside)
            .attr('data-url', $self.attr('data-append-url'))
            .attr('data-apply-to', $input.attr('id'))
        ;

        $.get($self.attr('data-append-url'))
         .done(function (html) {
             $('[data-role="augment"]', aside).html(html);
         })
         .fail(switchToPrimay);

    });


})(jQuery);