jQuery(document).ready(function () {
	// Accordion Block
	(function (jQuery) {

		var allPanels = jQuery('.accordion > dd').hide();
		var allLinks = jQuery('.accordion > dt > a');

		jQuery('.accordion > dt > a').click(function () {
			$this = jQuery(this);
			$target = $this.parent().next();

			if (!$target.hasClass('active')) {
				allPanels.removeClass('active').slideUp(200);
				allLinks.removeClass('active');
				$target.addClass('active').slideDown(200);
				$this.addClass('active');
			}

			return false;
		});

	})(jQuery);
});
