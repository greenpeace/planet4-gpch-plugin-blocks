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

$(document).on('ready', function() {
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
    //var src = $(window).width() > theme.breakpoints.md ? 'desktop' : 'mobile';
    var size = 'sm';

    if ($(window).width() >= theme.breakpoints.md) {
        size = 'md';
    }

    if ($(window).width() >= theme.breakpoints.lg) {
        size = 'lg';
    } 

    if ($(window).width() >= theme.breakpoints.laptop) {
        size = 'xl';
    }  

    if (lastVideoSize !== size) {
        var rand = Math.floor(Math.random()*3)+1;
        $('#intro-video-wrap').html(`<video src="videos/intro_${size}_${rand}.mp4" id="intro-video" poster="videos/poster_intro_xl_${rand}.jpg" loop muted playsinline></video>`);
        $('#bm-video-wrap').html(`<video src="videos/app_${size}.mp4" id="app-video" poster="videos/poster_app_${size}.jpg" loop muted playsinline></video>`);
    }
    // Initialize videos
    theme.$videos = $('#app-video, #intro-video-trigger, #person_1-video, #person_2-video, #colours-video');
    lastVideoSize = size;
}

/*
 * Play video when is in viewport and pause it when its not
 *
 */

function videoControl() {
    $.each(theme.$videos, function(video) {
        var video = document.getElementById($(this).attr('id').replace("-trigger", ""));
        var $trigger = $(`#${$(this).attr('id')}`);

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
    $.each(theme.$videos, function(video) {
        var video = document.getElementById($(this).attr('id').replace("-trigger", ""));
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

    $('#debugg').html(score.toFixed(3));

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
    var height = $('#banner_maker-component').outerHeight();
    // Bannermaker App view toggle
    setAppView();
    // Todo easing
    $('#banner_maker-component').scrollToEl(theme.times.time);
    $('body').addClass('app-is-oppening');
    $( "#banner_maker-component-wrap" ).animate({
        height: height,
        }, theme.times.time, function() {
        // Layout
        $(this).attr("style", "");
        $('body').addClass('app-is-open');
        // Snap App preview
        //snapAppPreview();
        // Check client performance and select between App and App's fallback
        if (clientPerformance(performanceLimit)) {
            appRun('loop');               
        } else {
            appRun('static');
            $('#bm-gui-modal').addClass('is-open');
            //$('#bm-gui-app_toggle').removeClass('is-dismissed');
        }

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
    $('#banner_maker_intro-component').scrollToEl($('#banner_maker-component').hasClass('mobile-view') ? 0 : 0);
    $('body').removeClass('app-is-oppening');//.removeClass('preview-is-fixed');
    $( "#banner_maker-component-wrap" ).animate({
        height: 0,
        }, ($('#banner_maker-component').hasClass('mobile-view') ? 0 : 0), function() {
        // Layout
        $(this).attr("style", "");
        $('body').removeClass('app-is-open');
    });
}

/*
 * Figure out if element is in viewport
 *
 */

$.fn.isInViewport = function(offset) {
    offset = offset !== undefined ? offset : 0;
    var headerOffset = 0;

    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();
    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height()-($(window).height()*offset);

    return elementBottom > (viewportTop + headerOffset + $(window).height()/3) && (elementTop + 5) < viewportBottom;
    // + $(window).height()/3)
};

/*
 * Bannermaker App view toggle
 *
 */

function setAppView() {
    if ($(window).width() <= theme.breakpoints.md) {
        toggleAppView('mobile');
    } else {
        toggleAppView('default');
    }        
    //if ($('#banner_maker-component').hasClass('is-open')) {}
}

/*
 *
 *
 */

function toggleAppView(view) {
    if (view == 'default' && appGui.view == undefined || view == 'default' && appGui.view !== 'default') {
        $('#banner_maker-component [aria-expanded]').attr('aria-expanded', 'false');
        $('#banner_maker-component .accordion-item-content').attr('data-parent', '#accordion-bm').removeClass('show');
        // Open first item
        $('#banner_maker-component [aria-expanded]').eq(0).attr('aria-expanded', 'true');
        $('#banner_maker-component .accordion-item-content').eq(0).attr('data-parent', '#accordion-bm').addClass('show');
        // Enable click
        $('#banner_maker-component').removeClass('mobile-view');
    } else if (view == 'mobile' && appGui.view == undefined || view == 'mobile' && appGui.view !== 'mobile') {
        $('#banner_maker-component [aria-expanded]').attr('aria-expanded', 'true')
        $('#banner_maker-component .accordion-item-content').removeAttr('data-parent').addClass('show');
        // Disable click
        $('#banner_maker-component').addClass('mobile-view');
    }
    
    appGui.view = view;
}


/*
 * Scroll to #element
 *
 */

 $.fn.scrollToEl = function(duration) {
    duration = duration !== undefined ? duration : 1000;
    if ($(this).length) {
        var offset = 0;
        $('body').addClass('is-scrolling');
        $('html, body').animate({
            scrollTop: $(this).offset().top - offset
        }, duration, function(){
            $('body').removeClass('is-scrolling')
        });        
    }
}