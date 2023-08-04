/**
 * @package Helix3 Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (C) 2010 - 2023 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

jQuery(function ($) {
    'use strict';
    var observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            var newNodes = mutation.addedNodes;
            if (newNodes !== null) {
                var $nodes = $(newNodes);

                $nodes.each(function () {
                    var $node = $(this);
                    $node.find('#slide-fullwidth').each(function () {

                        // Full width Slideshow
                        var $slideFullwidth = $(this);

                        // Autoplay
                        var $autoplay = $slideFullwidth.attr("data-sppb-slide-ride");
                        if ($autoplay == "true") {
                            var $autoplay = true;
                        } else {
                            var $autoplay = false
                        }

                        // controllers
                        var $controllers = $slideFullwidth.attr("data-sppb-slide-controllers");
                        if ($controllers == "true") {
                            var $controllers = true;
                        } else {
                            var $controllers = false
                        }

                        $slideFullwidth.owlCarousel({
                            margin: 0,
                            loop: true,
                            autoplay: $autoplay,
                            animateIn: "fadeIn",
                            animateOut: "fadeOut",
                            responsive: {
                                0: {
                                    items: 1
                                },
                                600: {
                                    items: 1
                                },
                                1000: {
                                    items: 1
                                }
                            },
                            dots: $controllers,
                        });


                        $(".sppbSlidePrev").click(function () {
                            $slideFullwidth.trigger("prev.owl.carousel", [400]);
                        });

                        $(".sppbSlideNext").click(function () {
                            $slideFullwidth.trigger("next.owl.carousel", [400]);
                        });
                    });
                });
            }
        });
    });

    var config = {
        childList: true,
        subtree: true
    };
    // Pass in the target node, as well as the observer options
    observer.observe(document.body, config);
});


jQuery(function ($) {
    'use strict';
    var observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            var newNodes = mutation.addedNodes;
            if (newNodes !== null) {
                var $nodes = $(newNodes);

                $nodes.each(function () {
                    var $node = $(this);
                    $node.find('.sppb-slider-items').each(function () {

                        //Slideshow
                        var $sppbSlider = $(this);

                        // Autoplay
                        var $autoplay = $sppbSlider.attr("data-sppb-slide-ride");
                        if ($autoplay == "true") {
                            var $autoplay = true;
                        } else {
                            var $autoplay = false;
                        }

                        // controllers
                        var $controllers = $sppbSlider.attr("data-sppb-slide-controllers");
                        if ($controllers == "true") {
                            var $controllers = true;
                        } else {
                            var $controllers = false;
                        }

                        //Slider Options
                        $sppbSlider.owlCarousel({
                            animateOut: "slideOutLeft",
                            animateIn: "flipInX",
                            loop: true,
                            autoHeight: true,
                            autoplay: $autoplay,
                            center: true,
                            nav: false,
                            autoWidth: true,
                            //responsiveClass:true,
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
                            dots: $controllers,

                        });

                        $(".sppbSlidePrev").click(function () {
                            $sppbSlider.trigger("prev.owl.carousel");
                        });

                        $(".sppbSlideNext").click(function () {
                            $sppbSlider.trigger("next.owl.carousel");
                        });
                    });
                });
            }
        });
    });

    var config = {
        childList: true,
        subtree: true
    };
    // Pass in the target node, as well as the observer options
    observer.observe(document.body, config);
});
