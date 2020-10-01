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
	
	
	// Banner Tool
	var bannerInserted = false;
	
	// Hide the form until needed
	var bannerField = jQuery('input[value="banner"]');
	var formWrapper = jQuery('.gpch-block-banner-tool .banner-submit-form');
	formWrapper.hide();
	
	// Hide step 1
	jQuery('#bm-step_start').on('click', function(){
		jQuery('#banner_maker_intro-component').hide();
	});
	
	// After banner creation, show the submit form
	jQuery('#bm-step_generate').on('click', function(){
		formWrapper.show();
		//jQuery('.bm-app').hide();
		jQuery('.bm-app .gui-col').remove();
		jQuery('.gpch-block-banner-tool .actions-col').remove();
		
		jQuery('.banner_maker-component-container').css('padding', 0);
		
		jQuery('#banner_maker-component-wrap').height(jQuery('#preview-col').height() + 20);
		
		document.querySelector('.gpch-block-banner-tool .bm-gui-preview').scrollIntoView({
			behavior: 'smooth'
		});
		
		jQuery('.gform_wrapper :input').change(function() {
			getBanner();
		});
	});
	
	// Get resulting banner and insert it into a form field
	function getBanner() {
		if (bannerInserted === false) {
			var banner = jQuery( '#bm-download_vector' ).attr( 'href' );
			var svg = document.getElementById('texture');
			console.log(banner);
			var bannerField = jQuery( 'input[value="banner"]' );
			
			bannerField.val( banner );
			bannerInserted = true;
		}
	}
	
});
