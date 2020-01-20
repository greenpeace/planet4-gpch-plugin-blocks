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
	
	// Action Divider Block
	(function (jQuery) {
		var yesButton = jQuery('.action-divider .action-divider-question-button-yes');
		var noButton = jQuery('.action-divider .action-divider-question-button-no');
		
		jQuery(yesButton).click(function(){
			var actionDividerBlock = jQuery(this).closest('.action-divider');
			
			actionDividerBlock.find('.action-divider-question-wrapper').slideUp();
			actionDividerBlock.find('.action-divider-step2-yes').slideDown();
			
			return false;
		});
		
		jQuery(noButton).click(function(){
			var actionDividerBlock = jQuery(this).closest('.action-divider');
			
			actionDividerBlock.find('.action-divider-question-wrapper').slideUp();
			actionDividerBlock.find('.action-divider-step2-no').slideDown();
			
			return false;
		});
	})(jQuery);
});
