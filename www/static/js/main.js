$(function () {
    $('.toolbar li').tooltip();
    $('.jumbotron-toggle').on('click', jumbotronToggle);
});

function jumbotronToggle () {
    $('.overview').slideToggle(function () {
        var shown = $('.jumbotron h1').is(':visible'),
            $toggleEl = $('.jumbotron-toggle'),
            heading = $('.overview > h1').html();
        if (shown) {
            $('.toolbar > h3').fadeOut(200);
            $toggleEl.addClass('glyphicon-chevron-up').removeClass('glyphicon-chevron-down');
        } else {
            $('.toolbar')
                .prepend('<h3 class="pull-left" style="margin-top: 0px; font-weight: 100;">' + heading + '</h3')
                .hide()
                .fadeIn(500);
            $toggleEl.addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-up');
        }
    });
}
