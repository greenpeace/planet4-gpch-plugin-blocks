var theme = {};
theme.breakpoints = {
    xxs: 360,
    xs: 440,
    sm: 576,
    md: 768,
    lg: 992,
    xl: 1200,
    laptop: 1440,
    container: 1780,
    hd: 1920
}
theme.times = {
    least: 125,
    less: 250,
    time: 500,
    more: 750,
    most: 1000
}
theme.grid = {
    headerHeight: 100
}
theme.$videos = undefined;

var lastVideoSize = undefined;

// DOCUMENT READY

jQuery(document).on('ready', function() {
    // Initialize videos & load proper size file
    videoSrcset();
    // Play video when is in viewport and pause it when its not
    videoControl();
});

/*
 * Initialize videos & load proper size file
 *
 */

function videoSrcset() {
    //var src = jQuery(window).width() > theme.breakpoints.md ? 'desktop' : 'mobile';
    var size = 'sm';

    if (jQuery(window).width() >= theme.breakpoints.md) {
        size = 'md';
    }

    if (jQuery(window).width() >= theme.breakpoints.lg) {
        size = 'lg';
    } 

    if (jQuery(window).width() >= theme.breakpoints.laptop) {
        size = 'xl';
    }  

    if (lastVideoSize !== size) {
        var rand = Math.floor(Math.random()*3)+1;
        var assetsURL = gpchBlocksAssetsURL + 'blocks/banner-maker/'
        
        jQuery('#intro-video-wrap').html(`<video src="${assetsURL}videos/intro_${size}_${rand}.mp4" id="intro-video" poster="${assetsURL}videos/poster_intro_xl_${rand}.jpg" loop muted playsinline></video>`);
        jQuery('#bm-video-wrap').html(`<video src="${assetsURL}videos/app_${size}.mp4" id="app-video" poster="${assetsURL}videos/poster_app_${size}.jpg" loop muted playsinline></video>`);
    }
    // Initialize videos
    theme.$videos = jQuery('#app-video, #intro-video-trigger, #person_1-video, #person_2-video, #colours-video');
    lastVideoSize = size;
}

/*
 * Play video when is in viewport and pause it when its not
 *
 */

function videoControl() {
    jQuery.each(theme.$videos, function(video) {
        var video = document.getElementById(jQuery(this).attr('id').replace("-trigger", ""));
        var $trigger = jQuery(`#${jQuery(this).attr('id')}`);

        if ($trigger.isInViewport(0)) {
            video.play();
        } else {
            video.pause();
        }
    })
}

/*
 * Pause all videos
 *
 */

function videosPause() {
    jQuery.each(theme.$videos, function(video) {
        var video = document.getElementById(jQuery(this).attr('id').replace("-trigger", ""));
        video.pause();
    })
}

/*
 * Check client performance
 *
 */

function clientPerformance(limit) {
    var t0 = performance.now();
    for (var i = 0; i < 5000; i++) {
        var cpu = i;
    }
    var t1 = performance.now();
    var score = t1 - t0;

    jQuery('#debugg').html(score.toFixed(3));

    if (score >= limit) {  //.5
        return 0; // low
    } return 1; // high
}

/*
 * Initialize App
 *
 */

function appInitialize() {   
    // Initialize App GUI
    appInitialized = true;
    appDel = false;
    //
    var height = jQuery('#banner_maker-component').outerHeight();
    // Bannermaker App view toggle
    setAppView();
    // Todo easing
    jQuery('#banner_maker-component').scrollToEl(theme.times.time);
    jQuery('body').addClass('app-is-oppening');
    jQuery( "#banner_maker-component-wrap" ).animate({
        height: height,
        }, theme.times.time, function() {
        // Layout
        //jQuery(this).attr("style", "");
        jQuery('body').addClass('app-is-open');
        // Snap App preview
        //snapAppPreview();
        // Check client performance and select between App and App's fallback
        if (clientPerformance(performanceLimit)) {
            appRun('loop');               
        } else {
            appRun('static');
            jQuery('#bm-gui-modal').addClass('is-open');
            //jQuery('#bm-gui-app_toggle').removeClass('is-dismissed');
        }
        
        jQuery( "#banner_maker-component-wrap" ).css('height', 'auto');
    });
    
    
}

/*
 * Delete App
 *
 */

function appDelete() {  
    // Delete App GUI
    appInitialized = false;
    appDel = true;
    //
    jQuery('#banner_maker_intro-component').scrollToEl(jQuery('#banner_maker-component').hasClass('mobile-view') ? 0 : 0);
    jQuery('body').removeClass('app-is-oppening');//.removeClass('preview-is-fixed');
    jQuery( "#banner_maker-component-wrap" ).animate({
        height: 0,
        }, (jQuery('#banner_maker-component').hasClass('mobile-view') ? 0 : 0), function() {
        // Layout
        jQuery(this).attr("style", "");
        jQuery('body').removeClass('app-is-open');
    });
}

/*
 * Figure out if element is in viewport
 *
 */

jQuery.fn.isInViewport = function(offset) {
    offset = offset !== undefined ? offset : 0;
    var headerOffset = 0;

    var elementTop = jQuery(this).offset().top;
    var elementBottom = elementTop + jQuery(this).outerHeight();
    var viewportTop = jQuery(window).scrollTop();
    var viewportBottom = viewportTop + jQuery(window).height()-(jQuery(window).height()*offset);

    return elementBottom > (viewportTop + headerOffset + jQuery(window).height()/3) && (elementTop + 5) < viewportBottom;
    // + jQuery(window).height()/3)
};

/*
 * Bannermaker App view toggle
 *
 */

function setAppView() {
    if (jQuery(window).width() <= theme.breakpoints.md) {
        toggleAppView('mobile');
    } else {
        toggleAppView('default');
    }        
    //if (jQuery('#banner_maker-component').hasClass('is-open')) {}
}

/*
 *
 *
 */

function toggleAppView(view) {
    if (view == 'default' && appGui.view == undefined || view == 'default' && appGui.view !== 'default') {
        jQuery('#banner_maker-component [aria-expanded]').attr('aria-expanded', 'false');
        jQuery('#banner_maker-component .accordion-item-content').attr('data-parent', '#accordion-bm').removeClass('show');
        // Open first item
        jQuery('#banner_maker-component [aria-expanded]').eq(0).attr('aria-expanded', 'true');
        jQuery('#banner_maker-component .accordion-item-content').eq(0).attr('data-parent', '#accordion-bm').addClass('show');
        // Enable click
        jQuery('#banner_maker-component').removeClass('mobile-view');
    } else if (view == 'mobile' && appGui.view == undefined || view == 'mobile' && appGui.view !== 'mobile') {
        jQuery('#banner_maker-component [aria-expanded]').attr('aria-expanded', 'true')
        jQuery('#banner_maker-component .accordion-item-content').removeAttr('data-parent').addClass('show');
        // Disable click
        jQuery('#banner_maker-component').addClass('mobile-view');
    }
    
    appGui.view = view;
}


/*
 * Scroll to #element
 *
 */

 jQuery.fn.scrollToEl = function(duration) {
    duration = duration !== undefined ? duration : 1000;
    if (jQuery(this).length) {
        var offset = 0;
        jQuery('body').addClass('is-scrolling');
        jQuery('html, body').animate({
            scrollTop: jQuery(this).offset().top - offset
        }, duration, function(){
            jQuery('body').removeClass('is-scrolling')
        });        
    }
}