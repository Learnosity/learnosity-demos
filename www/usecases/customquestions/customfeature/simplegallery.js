LearnosityAmd.define(['jquery-v1.10.2'], function ($) {
    'use strict';

    /*!
     * jQuery simple gallery Plugin 1.1.0
     *
     * http://fernandomoreiraweb.com/
     *
     * Copyright 2013 Fernando Moreira
     * Released under the MIT license:
     *   http://mit.fernandomoreiraweb.com/
     */
    ;(function ($, window, document, undefined) {

        $.fn.simplegallery = function (options) {

            var defaults = {
                'galltime': 300,
                'gallcontent': '.content',
                'gallthumbnail': '.thumbnail',
                'gallthumb': '.thumb'
            };

            var settings = $.extend({}, defaults, options);

            return this.each(function () {

                $(settings.gallthumb).click(function () {

                    $(settings.gallcontent).find('img').stop(true,true).fadeOut(settings.galltime).hide();

                    var img_attr = $(this).find('img').attr("id"),
                        image_id = img_attr.replace('thumb_', '');

                    $('.image_' + image_id + '').stop(true,true).fadeIn(settings.galltime);
                    return false;

                });

            });

        };

    })($, window, document);


    function SimpleGallery(init)
    {
        var $photosArray,
            $template;

        if (typeof init.feature.photos !== 'undefined') {
            $photosArray = init.feature.photos;
        } else {
            console.log("Error: Photos array undefined");
        }

        $template = buildHtml($photosArray);

        init.$el.empty().append($template);

        $template.simplegallery({
            galltime: 400,
            gallcontent: '.simplegallery-content'
        });

        init.events.trigger('ready');
    }

    function buildHtml(photosArray)
    {

        var $section = $('<section>', {id:'gallery', class: 'simplegallery'});
        var $divContent = $('<div>', {class: 'simplegallery-content'});
        var $divThumb = $('<div>', {class: 'thumbnail'});

        // Loop through photosArray to build the html
        $.each(photosArray, function ( index, value ) {

            var $img = $('<img>',{src: value.source, class:'image_' + index, alt: value.alt});

            if (index > 0) {
                $img.css('display','none');
            }

            $divContent.append($img);

            var $div = $('<div>', {class: 'thumb'});
            var $href = $('<a>', {href: '#', rel: index}).append($('<img>',{src: value.source, id:'thumb_' + index, alt: value.alt}));

            $div.append($href);
            $divThumb.append($div);

        });

        $section.append($divContent);
        $section.append($('<div>', {class: 'clear'}));
        $section.append($divThumb);

        return $section;
    }

    return {
        Feature: SimpleGallery
    };
});