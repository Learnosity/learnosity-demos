$(function () {
    $('.toolbar li').tooltip();
    $('.jumbotron-toggle').on('click', jumbotronToggle);
});

function jumbotronToggle () {
    var shown = $('.jumbotron h1').is(':visible'),
        $toggleEl = $('.jumbotron-toggle'),
        heading = $('.overview > h1').html();
    if (shown) {
        $('.overview').fadeOut(500, function () {
            $toggleEl.addClass('glyphicon-chevron-up').removeClass('glyphicon-chevron-down');
            $('.toolbar')
                .prepend('<h3 class="pull-left" style="margin-top: 0px; font-weight: 100;">' + heading + '</h3')
                .hide()
                .fadeIn(500);
            $toggleEl.addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-up');
        });
    } else {
        $('.toolbar > h3').fadeOut(100);
        $('.overview').fadeIn('slow');
    }
}
