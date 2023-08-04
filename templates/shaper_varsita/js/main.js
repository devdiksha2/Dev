/**
 * @package Helix3 Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (C) 2010 - 2023 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

jQuery(function ($) {
	var header = document.getElementById('sp-header');
	var headerTransparent = document.querySelector('.header-transparent');
	var sticky = header?.offsetTop;

	window.onscroll = function () {
		myFunction();
	};

	function myFunction() {
		if (window.pageYOffset > sticky) {
			header.classList.add('is-sticky');
			headerTransparent?.classList.add('is-sticky');
		} else {
			header.classList.remove('is-sticky');
			headerTransparent?.classList.remove('is-sticky');
		}
	}

	var $body = $('body'),
		$wrapper = $('.body-innerwrapper'),
		$toggler = $('#offcanvas-toggler'),
		$close = $('.close-offcanvas'),
		$offCanvas = $('.offcanvas-menu');

	$('#offcanvas-toggler').on('click', function (event) {
		event.preventDefault();
		$('body').addClass('offcanvas');
	});

	$('.close-offcanvas, .offcanvas-overlay').on('click', function (event) {
		event.preventDefault();
		$('body').removeClass('offcanvas');
	});

	var stopBubble = function (e) {
		e.stopPropagation();
		return true;
	};

	//Mega Menu
	$('.sp-megamenu-wrapper').parent().parent().css('position', 'static').parent().css('position', 'relative');
	$('.sp-menu-full').each(function () {
		$(this).parent().addClass('menu-justify');
	});

	//Tooltip
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl);
	});

	$(document).on('click', '.sp-rating .star', function (event) {
		event.preventDefault();

		var data = {
			action: 'voting',
			user_rating: $(this).data('number'),
			id: $(this).closest('.post_rating').attr('id'),
		};

		var request = {
			option: 'com_ajax',
			plugin: 'helix3',
			data: data,
			format: 'json',
		};

		$.ajax({
			type: 'POST',
			data: request,
			beforeSend: function () {
				$('.post_rating .ajax-loader').show();
			},
			success: function (response) {
				var data = $.parseJSON(response.data);

				$('.post_rating .ajax-loader').hide();

				if (data.status == 'invalid') {
					$('.post_rating .voting-result').text('You have already rated this entry!').fadeIn('fast');
				} else if (data.status == 'false') {
					$('.post_rating .voting-result').text('Somethings wrong here, try again!').fadeIn('fast');
				} else if (data.status == 'true') {
					var rate = data.action;
					$('.voting-symbol')
						.find('.star')
						.each(function (i) {
							if (i < rate) {
								$('.star')
									.eq(-(i + 1))
									.addClass('active');
							}
						});

					$('.post_rating .voting-result').text('Thank You!').fadeIn('fast');
				}
			},
			error: function () {
				$('.post_rating .ajax-loader').hide();
				$('.post_rating .voting-result').text('Failed to rate, try again!').fadeIn('fast');
			},
		});
	});
});
