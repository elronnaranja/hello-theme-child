/*
 * CWD starter: all jQuery for the site lives in this one file.
 * Sections: GLOBAL, HEADER, SLIDERS (Slick), PAGES.
 */
(function ($) {
	$(function () {

		/***********************************************************/
		/** GLOBAL *************************************************/
		/***********************************************************/

		/***********************************************************/
		/** HEADER *************************************************/
		/***********************************************************/
		// Adds .sticky to #header-main after scrolling (styles in style.css > HEADER)
		var $header = $('#header-main');
		if ($header.length) {
			var toggleSticky = function () {
				$header.toggleClass('sticky', $(window).scrollTop() > 10);
			};
			toggleSticky();
			$(window).on('scroll', toggleSticky);
		}

		/***********************************************************/
		/** SLIDERS (Slick) ****************************************/
		/***********************************************************/
		// Give the Elementor container the class "slider-container"; its direct children become slides.
		// $('.slider-container > .e-con-inner, .slider-container.e-con-full').slick({
		// 	slidesToShow: 3,
		// 	slidesToScroll: 1,
		// 	arrows: true,
		// 	dots: false,
		// 	responsive: [
		// 		{ breakpoint: 1025, settings: { slidesToShow: 2 } },
		// 		{ breakpoint: 768, settings: { slidesToShow: 1 } }
		// 	]
		// });

		/***********************************************************/
		/** PAGES **************************************************/
		/***********************************************************/

	});
})(jQuery);
