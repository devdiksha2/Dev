/**
 * @package Helix3 Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (C) 2010 - 2023 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
jQuery(function ($) {

    //event
    $('.addon-splms-events-carousel').each(function () {

        var $upcomingevent = $(this).find('.carousel-event.owl-carousel');

        $upcomingevent.owlCarousel({
            margin: 30,
            loop: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            },
            dots: false,
        });

        $(this).find('.eventPrev').click(function () {
            $upcomingevent.trigger('prev.owl.carousel', [400]);
        });

        $(this).find('.eventNext').click(function () {
            $upcomingevent.trigger('next.owl.carousel', [400]);
        });


    });
});