/*
 * FUNCTIONS
 *
 * draw
 * drawText
 * readTextFile
 * stripSvgTag
 * setPatternColor
 * setIconColor
 * setTypeColor
 * disableEnableColors
 * handleFontsize
 * textOverflow
 * alignTypeHorizontaly
 * snapInnerColors
 * getInnerColorsPositions
 * setColorsUI
 *
 */

// VARIABLES

var appInitialized = false;
var appRefresh = false;
var appDel = false;
var performanceLimit = .6; //6

// DOCUMENT READY
var bannerAssetsURL = '';

jQuery(document).on('ready', function() {

    // App Start
    jQuery('#bm-step_start').on('click', function() {        
        // App layout
        appInitialize();        
    });
    
    // App close
    jQuery('#bm-gui-app_close-btn, #bm-gui-app_close_mobile-btn').on('click', function(e){
        appDelete();       
    });
    
    bannerAssetsURL = gpchBlocksAssetsURL + 'blocks/banner-maker/';
});

// WINDOW SCROLL

jQuery(window).scroll(function(){
    // App functionalities
    if (appInitialized) {
        // Snap App steps            
        //snapAppSteps(); 
        // Pause all videos
        videosPause();
        // Snap App preview
        //snapAppPreview();
        // Active step
        appGui.activeStep();
    } else {
        // Play video when is in viewport and pause it when its not
        videoControl();        
    }
});

var appGui = function() {
    var THIS = this;

    var svgPreview = jQuery('#svgPreview');
    var svgHelp = jQuery('#svgHelp');

    var textureWidth = 1400;
    var textureHeight = 700;

    this.view = undefined;
    this.mode = undefined; // static | loop
    this.webGl = true;
    this.innerColorsPos = []

    this.selections = {
        lastPattern: null,
        pattern: null,
        bgColor: null,
        shapeColor: null,
        lastIcon: null,
        icon: null,
        iconColor: null,
        iconType: null,
        type: null,//'SPEAK\nOUT'
        typeColor: null
    };

    this.disabledColors = {
        pattern: [null, null],
        icon: [],
        type: []
    };

    this.texture = undefined;
    this.generateDownloads = false;
    this.allowGenerateDownloads = false;
    
    this.$loader = jQuery('#bm-app-loader');

    this.videoExport = {
        allowGenerate: false,
        generate: false,
        fps: 30,
        $btn: jQuery('#bm-generate-video'),
        $loader: jQuery('#bm-generate-video-loader'),
        capturer: undefined,
        frameCnt: 0,
        stopGenerate: function(state) {
            this.generate = false;
            this.$loader.css({width:'0%'})
            this.$loader.text('');

            jQuery('#bm-generate-video-fps').removeClass('is-disabled');
            this.$btn.find('#bm-generate-video-title').text('Download Video');
            this.$btn.attr('data-action', 'download');

            this.frameCnt = 0;
            this.capturer.stop();
            this.capturer = undefined;

            },
        startGenerate: function(state) {
            this.generate = true;
            this.$loader.text('');  

            jQuery('#bm-generate-video-fps').addClass('is-disabled');
            this.$btn.find('#bm-generate-video-title').text('Cancel');
            this.$btn.attr('data-action', 'cancel');

            this.capturer = new CCapture({ format: 'webm', framerate: this.fps, name: `climate-justice-${this.fps}fps` });            
        }
    }

    this.getInnerColorsPositions = function() {
        // Get initial positions
        //if (!this.innerColorsPos.length) {
            this.innerColorsPos = [];
            var $wrappers = jQuery('[data-bm_gui_icontype]');
            var padding = 0;
            if ($wrappers.length) {
                for (var i = 0; i < $wrappers.length; i++) {
                    if (i==$wrappers.length-1) padding = parseInt($wrappers.eq(0).css('padding-bottom'));
                    THIS.innerColorsPos.push($wrappers.eq(i).position().top - padding);
                }
            }
        //}
    }

    this.snapInnerColors = function($selected) {
        if ($selected.length) {
            var pos = $selected.position();

            //if (THIS.view == 'default') {
                //jQuery('#bm-gui-colors-icons').css({left: parseInt(pos.left - ((jQuery('#bm-gui-colors-icons').width() - $selected.width())/2)), top: pos.top}).addClass('is-active');
            //} else { // if (THIS.view == 'mobile')
                THIS.getInnerColorsPositions();
                //
                var $selectedWrap = $selected.closest('[data-bm_gui_icontype]');
                var $selectedTitle = $selectedWrap.prev('.bm-gui-inner-title');
                var top = $selectedWrap.height() + $selectedTitle.outerHeight(true);
                if ($selectedWrap.data('bm_gui_icontype') == 'problem') {
                    top += THIS.innerColorsPos[0]
                } else {
                    top += THIS.innerColorsPos[1]
                }       
                // Snap
                jQuery('[data-bm_gui_icontype]').removeClass('is-active');
                $selectedWrap.addClass('is-active');
                jQuery('#bm-gui-colors-icons').css({top: top});
                jQuery('#bm-gui-colors-icons').addClass('is-active');        
            //}            
        }
    }

    this.activeStep = function() {
        var stepsInView = [];
        var $theStep = undefined;
        var height = undefined;

        jQuery.each(jQuery('.bm-step-JS'), function(){
            if (jQuery(this).isInViewport(.1)) {
                stepsInView.push(jQuery(this));
                jQuery(this).addClass('was-active')
            } else {
                jQuery(this).removeClass('was-active')
            }
        });
        
        jQuery('.bm-step-JS').removeClass('is-active');
        $theStep = stepsInView[stepsInView.length-1];

        if ($theStep) {
            $theStep.addClass('is-active')
        }
    }

    this.createDownloads = function(data) {
        if (this.webGl) {
            jQuery('#bm-img_preview').html('').append('<img src="' + data + '">');
            jQuery('#bm-download_image').attr('href', data);
        } else {
            jQuery('#bm-img_preview').html('').append(jQuery('#svgPreview').html());  

        }
        jQuery('#bm-download_vector').attr('href', exportSVG(document.getElementById('texture')));
        jQuery('#bm-img_preview-loader').removeClass('is-active');      
        console.log('!')
    }

    this.reset = function() {
        
        jQuery('[data-bm_gui_pattern], [data-bm_gui_icon], [data-bm_gui_type]').removeClass('is-selected');
        jQuery('[data-bm_gui_pattern="null"]').addClass('is-selected');
        jQuery('[data-bm_gui_icontype], #bm-gui-colors-icons').removeClass('is-active');
        jQuery('[data-bm_gui_color]').removeClass('shapeColor-is-selected').removeClass('bgColor-is-selected').removeClass('iconColor-is-selected').removeClass('typeColor-is-selected').removeClass('is-disabled');
        jQuery('.bm-info').removeClass('is-active');

        this.selections = {
            lastPattern: null,
            pattern: null,
            bgColor: null,
            shapeColor: null,
            lastIcon: null,
            icon: null,
            iconColor: null,
            iconType: null,
            type: null,//'SPEAK\nOUT'
            typeColor: null
        };    

        this.disabledColors = {
            pattern: [null, null],
            icon: [],
            type: []
        };

        draw();
    }

    // INITS

    // If pattern is null, don't display selection number
    setColorsUI();
    // Draw banner
    draw();
    
    // EVENTS ////////////////////////////////////////////////////////////////////////////////

    // 3d mode toggle
    jQuery('#bm-gui-app_toggle-btn').on('click', function() {
        jQuery(this).closest('#bm-gui-app_toggle').toggleClass('is-open');
    });

    /*jQuery(document).on('click', function(e){
        if ((!jQuery('#bm-gui-app_toggle').is(e.target) && jQuery('#bm-gui-app_toggle').has(e.target).length === 0)) {
            jQuery('#bm-gui-app_toggle').removeClass('is-open');
        }
    });*/

    jQuery('#bm-gui-app_toggle-confirm').on('click', function() {
        jQuery('#bm-gui-app_toggle').removeClass('is-open').addClass('is-dismissed');
        jQuery('#bm-gui-modal').removeClass('is-open');
        setTimeout(function(){
            appRefresh = 'loop';
        }, theme.times.most)
    });

    jQuery('#bm-gui-app_toggle-dismiss').on('click', function() {
        jQuery('#bm-gui-app_toggle').removeClass('is-open').addClass('is-dismissed');
        jQuery('#bm-gui-modal').removeClass('is-open');
    });

    // Disabled step

    jQuery('#bm-step_4').on('click', function () {
        jQuery(document).off('click.tooltip');
        var $this = jQuery(this);
        if ($this.hasClass('is-disabled')) {
            $this.find('.accordion-item-title').tooltip('show');
            return false;
        }
    });

    jQuery('#bm-step_4').on('shown.bs.tooltip', function () {
        jQuery(document).on('click.tooltip', function(e){
            jQuery('#bm-step_4 .accordion-item-title').tooltip('hide')
        });        
    });

    // Pattern select
    jQuery('#bm-gui-patterns').on('click', 'button', function() {
        // Reset selected pattern
        jQuery('#bm-gui-patterns button').removeClass('is-selected');
        // Set selected pattern
        THIS.selections.pattern = jQuery(this).data('bm_gui_pattern');
        jQuery(this).addClass('is-selected');
        // If pattern is null, don't display selection number
        setColorsUI();
        // Draw banner
        draw();
    });
    
    // Colors select
    jQuery('#bm-gui-colors-pattern').on('click', 'button', function() {
        var $base = jQuery(this).closest('#bm-gui-colors-pattern');
        jQuery('#bm-step_2-info').removeClass('is-active')
        // Set section as visited
        $base.addClass('is-visited');


        // Reset selected pattern color
        if (jQuery(this).hasClass('bgColor-is-selected')) {
            resetSelectedColor('pattern', 'bg', 0);
            // Draw banner
            draw();
            return false;
        } else if (jQuery(this).hasClass('shapeColor-is-selected')) {
            resetSelectedColor('pattern', 'shape', 1);
            // Draw banner
            draw();
            return false;
        }

        if (jQuery(this).hasClass('is-disabled')) return false;

        if ($base.find('.bgColor-is-selected').length && $base.find('.shapeColor-is-selected').length) {
            jQuery('#bm-step_2-info').addClass('is-active');
            return false;
        }

        // Toggle between bg and shape color        
        var currentSelect = 'bgColor';
        if (THIS.selections.pattern) {
            if ($base.find('.bgColor-is-selected').length) {
                currentSelect = 'shapeColor';
            }            
        }
        // Reset selected colors
        jQuery('#bm-gui-colors-pattern [data-bm_gui_color]').removeClass(`${currentSelect}-is-selected`);
        // Set selected color
        var color = jQuery(this).data('bm_gui_color');
        THIS.selections[currentSelect] = color;
        jQuery(this).addClass(`${currentSelect}-is-selected`);
        // Disable / enable colors
        var index = currentSelect == 'shapeColor' ? 1 : 0;
        disableEnableColors('pattern', color, index);
        // Draw banner
        draw();
    });

    // Icon select
    jQuery('#bm-gui-icons').on('click', '[data-bm_gui_icon]', function() {
        var $base = jQuery(this).closest('#bm-gui-icons');
        // Set section as visited
        $base.addClass('is-visited');

        if (!jQuery('.iconColor-is-selected').length) {
            THIS.selections.iconColor = null;
        }

        // Reset selected icon
        if (jQuery(this).hasClass('is-selected')) {
            THIS.selections.icon = null;
            THIS.selections.iconType = null;
            jQuery(this).removeClass('is-selected');
            jQuery(this).closest('[data-bm_gui_icontype]').removeClass('is-active');
            // Reset selected color
            resetSelectedColor('icon');
            // Disable Colors UI
            jQuery('#bm-gui-colors-icons').removeClass('is-active');
            // Disable step 4
            if (THIS.selections.iconType == "feeling") {
                jQuery('#bm-step_4').addClass('is-disabled');
                jQuery('#bm-step_4-info_2').addClass('is-active');
            } else {
                jQuery('#bm-step_4').removeClass('is-disabled').find('.accordion-item-title').tooltip('hide');
                jQuery('#bm-step_4-info_2').removeClass('is-active');
            }
            // Draw banner
            draw();
            return false;
        }

        jQuery('#bm-gui-icons [data-bm_gui_icon]').removeClass('is-selected');
        jQuery(this).addClass('is-selected');
        THIS.selections.icon = jQuery(this).data('bm_gui_icon');
        THIS.selections.iconType = jQuery(this).closest('[data-bm_gui_icontype]').data('bm_gui_icontype');
        // Set button icon color
        if (false && THIS.selections.iconColor) {
            jQuery('[data-bm_gui_icon] svg path').attr({'style':'fill:#A7A7A7'});        
            jQuery('[data-bm_gui_icon].is-selected svg path').attr({'style':`fill:${THIS.selections.iconColor};`}); 
        }
        //
        jQuery('[data-bm_gui_icontype]').removeClass('is-active')
        jQuery(this).closest('[data-bm_gui_icontype]').addClass('is-active')
        
        // Disable step 4
        if (THIS.selections.iconType == "feeling") {
            jQuery('#bm-step_4').addClass('is-disabled');
            jQuery('#bm-step_4-info_2').addClass('is-active');
        } else {
            jQuery('#bm-step_4').removeClass('is-disabled').find('.accordion-item-title').tooltip('hide');
            jQuery('#bm-step_4-info_2').removeClass('is-active');
        }

        // Set colors UI position
        THIS.snapInnerColors(jQuery(this));
        // Wait inner colors animation to finish
        setTimeout(function(){
            // Draw banner
            draw();
        }, theme.times.time)
    });   
    
    // Icon color select
    jQuery('#bm-gui-colors-icons').on('click', 'button', function() {

        // Reset selected icon color
        if (jQuery(this).hasClass('iconColor-is-selected')) {
            resetSelectedColor('icon');
            // Draw banner
            draw();
            return false;
        }

        if (jQuery(this).hasClass('is-disabled')) return false;

        // Reset selected colors
        jQuery('#bm-gui-colors-icons button').removeClass('iconColor-is-selected');
        // Set selected color
        var color = jQuery(this).data('bm_gui_color');
        THIS.selections.iconColor = color;        
        jQuery(this).addClass('iconColor-is-selected')
        // Set button icon color
        if (false) {
            jQuery('[data-bm_gui_icon] svg path').attr({'style':'fill:#A7A7A7'});
            jQuery('[data-bm_gui_icon].is-selected svg path').attr({'style':`fill:${THIS.selections.iconColor};`});                    
        }
        // Disable / enable colors
        disableEnableColors('icon', color);

        // Draw banner
        draw();
    });    
    
    // Type
    jQuery('#bm-gui-textarea-submit').on('click', function() {
        var $base = jQuery(this).closest('#bm-gui-type');
        // Set section as visited
        $base.addClass('is-visited');
        // Deselect any preselected text
        jQuery('[data-bm_gui_type]').removeClass('is-selected');
        if (THIS.selections.icon == 'logo') {
            THIS.selections.icon = null;
            THIS.selections.iconColor = null;            
        }

        THIS.selections.type = jQuery('#bm-gui-textarea').val();
        // Draw banner
        draw();
    });

    jQuery('#bm-gui-textarea-delete').on('click', function() {
        var $base = jQuery(this).closest('#bm-gui-type');
        jQuery('#bm-gui-textarea').val('');
        jQuery('#bm-gui-textarea-submit, #bm-gui-textarea-delete').addClass('is-inactive');
        jQuery('[data-bm_gui_type]').removeClass('is-selected');
        // Deselect any preselected text
        jQuery('[data-bm_gui_type]').removeClass('is-selected');
        if (THIS.selections.icon == 'logo') {
            THIS.selections.icon = null;
            THIS.selections.iconColor = null;            
        }

        THIS.selections.type = null;
        // Draw banner
        draw();
    });

    jQuery('#bm-gui-textarea').on('click', function() {
        if (THIS.view == 'mobile') {
            jQuery('body').addClass('textarea-is-focused');
        }
    });

    jQuery('#bm-gui-textarea').on('keyup', function() {
        if (jQuery(this).val()) {
            jQuery('#bm-gui-textarea-submit, #bm-gui-textarea-delete').removeClass('is-inactive');
        } else {
            jQuery('#bm-gui-textarea-submit, #bm-gui-textarea-delete').addClass('is-inactive');
        }
    });

    jQuery(document).on('click', function(e){
        if ((!jQuery('#bm-gui-textarea').is(e.target) && jQuery('#bm-gui-textarea').has(e.target).length === 0)) {
            jQuery('body').removeClass('textarea-is-focused')
        }
    });

    // Default type
    jQuery('#bm-gui-type').on('click', '[data-bm_gui_type]', function(){
        var $base = jQuery(this).closest('#bm-gui-type');
        // Set section as visited
        $base.addClass('is-visited');

         // Reset selected icon
        if (jQuery(this).hasClass('is-selected')) {
            THIS.selections.type = null;
            THIS.selections.typeColor = null;
            jQuery(this).removeClass('is-selected');
            jQuery('#bm-gui-textarea').val("")
            // Reset selected color
            resetSelectedColor('type');
            jQuery('#bm-gui-colors-type button').removeClass('is-active');
            if (THIS.selections.icon == 'logo') {
                // Reset selected color
                THIS.selections.icon = null;
                THIS.selections.iconColor = null;
                resetSelectedColor('icon');
            }
            // Draw banner
            draw();
            return false;
        }

        //
        jQuery('#bm-gui-textarea-delete').removeClass('is-inactive');
        // Reset selected pattern
        jQuery('#bm-gui-type button').removeClass('is-selected');
        // Set selected type
        jQuery(this).addClass('is-selected')
        jQuery('#bm-gui-textarea').val(jQuery(this).data('bm_gui_type'));
        THIS.selections.type = jQuery('#bm-gui-textarea').val();
        /*
        THIS.selections.icon = 'logo';
        jQuery('[data-bm_gui_icon]').removeClass('is-selected');
        resetSelectedColor('icon');
        THIS.selections.iconColor = THIS.selections.typeColor;
        THIS.selections.iconType = null;
        jQuery('[data-bm_gui_icontype]').removeClass('is-active');
        jQuery('#bm-gui-colors-icons').removeClass('is-active');
        */
        //
        jQuery('#bm-step_4-info').removeClass('is-active');        
        // Draw banner
        draw();
    });

    // Type color select
    jQuery('#bm-gui-colors-type').on('click', 'button', function() {

        var $base = jQuery(this).closest('#bm-gui-type');
        // Set section as visited
        $base.addClass('is-visited');

        
        if (!THIS.selections.type && !jQuery(this).hasClass('is-disabled')) {
            jQuery('#bm-step_4-info').addClass('is-active');
            return false;
        }

        // Reset selected type color
        if (jQuery(this).hasClass('typeColor-is-selected')) {
            resetSelectedColor('type');
            if (THIS.selections.icon == 'logo') {
                resetSelectedColor('icon');
            }  
            // Draw banner            
            draw();
            return false;
        }

        if (jQuery(this).hasClass('is-disabled')) return false;

        // Reset selected colors
        jQuery('#bm-gui-colors-type button').removeClass('typeColor-is-selected');
        // Set selected color
        var color = jQuery(this).data('bm_gui_color');
        THIS.selections.typeColor = color;    
        if (THIS.selections.icon == 'logo') {
            THIS.selections.iconColor = color;
        }  
        jQuery(this).addClass('typeColor-is-selected');
        // Disable / enable colors
        disableEnableColors('type', color);

        // Draw banner
        draw();
    });    

    //
    jQuery('.bm-step-JS').on('click', '[data-toggle]', function() {
        jQuery('.bm-step-JS').removeClass('is-open');
        jQuery(this).closest('.bm-step-JS').addClass('is-open');

        /*if (jQuery(this).hasClass('is-open')) {
            jQuery(this).nextAll().removeClass('is-open');
        } else {
            if (jQuery(this).prev().hasClass('is-open')) {
                jQuery(this).addClass('is-open');
            }
        }*/
    });

    // Generate

    jQuery('#bm-step_generate').on('click', function(){
        if (THIS.allowGenerateDownloads) {
            jQuery('body').addClass('downloads-is-open');
            jQuery('#bm-app_downloads-loader').addClass('is-active');
            jQuery('#bm-img_preview-loader').addClass('is-active');
            THIS.generateDownloads = true;

            if (!THIS.webGl) {
                THIS.createDownloads();
            }
        }
    });

    // Downloads

    jQuery('#bm-downloads-button').on('click', function(){
        jQuery('body').removeClass('downloads-is-open');
        jQuery('#bm-app_downloads-loader').removeClass('is-active');        
        appGui.videoExport.stopGenerate();
    });

    this.videoExport.$btn.on('click', function(){
        if (jQuery(this).attr('data-action') == 'cancel') {
            THIS.videoExport.stopGenerate();
        } else {            
            if (THIS.videoExport.allowGenerate) {
                THIS.videoExport.startGenerate();
            }
        }

    });

    jQuery('input[type=radio][name="fps"]').on('change', function(){
        if (THIS.videoExport.allowGenerate) {
            THIS.videoExport.fps = jQuery(this).val();
        } else {
            return false;
        }
    });

    // Reset
    jQuery('#bm-gui-reset-btn').on('click', function(){        
        THIS.reset();
    });

    // FUNCTIONS /////////////////////////////////////////////////////////////////////////////

    async function draw(options) {
        options = options !== undefined ? options : null;

        jQuery('#bm-step_generate').addClass('is-hidden');
        THIS.$loader.addClass('is-active');

        var svgStart = `<svg id="texture" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="${textureWidth}" height="${textureHeight}" x="0px" y="0px" viewBox="0 0 ${textureWidth} ${textureHeight}" style="enable-background:new 0 0 ${textureWidth} ${textureHeight};" xml:space="preserve">`;
        var svg = svgStart;

        svgPreview.html("");

        // Set background 
        var tmpColor = THIS.selections.bgColor == null ? '#B3B3B3' : THIS.selections.bgColor;
        svg += `<rect id="background" width="${textureWidth}" height="${textureHeight}" fill="${tmpColor}"></rect>`;
        // Insert SVG into DOM
        svgPreview.html(svg + '</svg>');
        
        if (THIS.selections.pattern !== null) {
            // Set pattern
            src = `${bannerAssetsURL}img/flag/backgrounds/${THIS.selections.pattern}.svg`;
            svg += stripSvgTag(await readTextFile(src));
            // Set pattern color
            svg = setPatternColor(svg);
            // Insert SVG into DOM
            svgPreview.html(svg + '</svg>');           
        }

        if (THIS.selections.icon !== null) {
            // Set Icon
            src = `${bannerAssetsURL}img/flag/icons/${THIS.selections.icon}.svg`;
            svg += stripSvgTag(await readTextFile(src));
            // Set Icon color
            svg = setIconColor(svg);
            // Insert SVG into DOM
            svgPreview.html(svg + '</svg>');
            // Animate Icon
            if (iconHasChanged())
            setTimeout(function(){
                jQuery('#icon').attr('class', '');
            }, 10)
            //
            THIS.selections.lastIcon = THIS.selections.icon
        }
        
        // German umlauts and French accents aren't supported by the font, we need to convert them
        replaceSpecialCharacters();
        
        if (THIS.selections.type !== null && THIS.selections.iconType !== "feeling") {
            console.log(THIS.selections.type);
            //var fontsize = options && options.fontsize ? options.fontsize : 155;{fontsize: 87.231});data-bm_gui_type
            var fontsize = jQuery('[data-bm_gui_type].is-selected').length ? 95.5 : 155;
            // Type
            svg += await handleFontsize(svgHelp, svgStart, fontsize);
            // Set Type color
            svg = setTypeColor(svg);
            // Insert SVG into DOM
            svgPreview.html(svg + '</svg>');
            // Align type lines horizontaly
            alignTypeHorizontaly();
        }        

        // Texture
        var options = {
            encoderOptions: 1,
            encoderType: 'image/png'
        }
        svgAsPngUri(document.getElementById("texture"), options).then(uri => {
            THIS.texture = uri;            
        });

        // Is generate ready?
        validate();
    }
    
    function replaceSpecialCharacters() {
        if (THIS.selections.type !== null && THIS.selections.type !== undefined) {
            // ÄÖüäöü
            // ÈèÀÀÙùÉé
            // ÂâÊêÎîÔô
            // ÛûçËëÏï
            // Ü, ü     \u00dc, \u00fc
            // Ä, ä     \u00c4, \u00e4
            // Ö, ö     \u00d6, \u00f6
            // ß        \u00df
            THIS.selections.type = THIS.selections.type.replace( /\u00dc/g,
              'UE' );
            THIS.selections.type = THIS.selections.type.replace( /\u00fc/g,
              'ue' );
            THIS.selections.type = THIS.selections.type.replace( /\u00c4/g,
              'AE' );
            THIS.selections.type = THIS.selections.type.replace( /\u00e4/g,
              'ae' );
            THIS.selections.type = THIS.selections.type.replace( /\u00d6/g,
              'OE' );
            THIS.selections.type = THIS.selections.type.replace( /\u00f6/g,
              'oe' );
            THIS.selections.type = THIS.selections.type.replace( /\u00df/g,
              'ss' );
            // È, è     \u00C8 , \u00E8
            // À, À     \u00C0 , \u00C0
            // Ù, ù     \u00D9 , \u00F9
            // É, é     \u00C9 , \\00E9
            THIS.selections.type = THIS.selections.type.replace( /\u00C8/g,
              'E' );
            THIS.selections.type = THIS.selections.type.replace( /\u00E8/g,
              'e' );
            THIS.selections.type = THIS.selections.type.replace( /\u00C0/g,
              'A' );
            THIS.selections.type = THIS.selections.type.replace( /\u00C0/g,
              'a' );
            THIS.selections.type = THIS.selections.type.replace( /\u00D9/g,
              'U' );
            THIS.selections.type = THIS.selections.type.replace( /\u00F9/g,
              'u' );
            THIS.selections.type = THIS.selections.type.replace( /\u00D9/g,
              'E' );
            THIS.selections.type = THIS.selections.type.replace( /\u00E9/g,
              'e' );
            // Â, â     \u00C2 , \u00E2
            // Ê, ê     \u00CA , \u00EA
            // Î, î     \u00CE , \u00EE
            // Ô, ô     \u00D4 , \u00F4
            THIS.selections.type = THIS.selections.type.replace( /\u00C2/g,
              'A' );
            THIS.selections.type = THIS.selections.type.replace( /\u00E2/g,
              'a' );
            THIS.selections.type = THIS.selections.type.replace( /\u00CA/g,
              'E' );
            THIS.selections.type = THIS.selections.type.replace( /\u00EA/g,
              'e' );
            THIS.selections.type = THIS.selections.type.replace( /\u00CE/g,
              'I' );
            THIS.selections.type = THIS.selections.type.replace( /\u00EE/g,
              'i' );
            THIS.selections.type = THIS.selections.type.replace( /\u00D4/g,
              'O' );
            THIS.selections.type = THIS.selections.type.replace( /\u00F4/g,
              'o' );
            // Û, û     \u00DB , \u00FB
            // ç        \u00E7
            // Ë, ë     \u00CB , \u00EB
            // Ï, ï     \u00CF , \u00EF
            THIS.selections.type = THIS.selections.type.replace( /\u00DB/g,
              'U' );
            THIS.selections.type = THIS.selections.type.replace( /\u00FB/g,
              'u' );
            THIS.selections.type = THIS.selections.type.replace( /\u00E7/g,
              'c' );
            THIS.selections.type = THIS.selections.type.replace( /\u00CB/g,
              'E' );
            THIS.selections.type = THIS.selections.type.replace( /\u00EB/g,
              'e' );
            THIS.selections.type = THIS.selections.type.replace( /\u00CF/g,
              'I' );
            THIS.selections.type = THIS.selections.type.replace( /\u00EF/g,
              'i' );
        }
    }

    function validate() {
        var condition2 = (THIS.selections.pattern !== null && THIS.selections.shapeColor !== null && THIS.selections.bgColor !== null) || (!THIS.selections.pattern && THIS.selections.bgColor !== null);
        var condition3 = THIS.selections.icon == null || THIS.selections.icon == 'logo' || (THIS.selections.icon !== null && THIS.selections.iconColor !== null);
        ///var condition4 = (THIS.selections.iconType == 'problem' && THIS.selections.type !== null && THIS.selections.typeColor !== null) || THIS.selections.iconType == 'feeling';
        var condition4 = THIS.selections.iconType == 'feeling' || (THIS.selections.type !== null && THIS.selections.typeColor !== null);

        if (condition2 && condition3 && condition4) {
            THIS.allowGenerateDownloads = true;
            THIS.videoExport.allowGenerate = true;
            jQuery('#bm-step_generate').removeClass('is-hidden');
            //jQuery('#bm-validation-msg').removeClass('is-active');
            jQuery('.accordion-item-title .validation-icon').removeClass('is-visible');            
        } else {
            THIS.allowGenerateDownloads = false;
            THIS.videoExport.allowGenerate = false;
            jQuery('#bm-step_generate').addClass('is-hidden');
            jQuery('.accordion-item-title .validation-icon').removeClass('is-visible');  
            
            if (!condition2 && (jQuery('#bm-gui-icons').hasClass('is-visited') || jQuery('#bm-gui-type').hasClass('is-visited'))) {
                jQuery('#bm-step_2 .accordion-item-title .validation-icon').addClass('is-visible');
                //jQuery('#bm-validation-msg').addClass('is-active');                  
                
            }

            if (!condition3 && jQuery('#bm-gui-type').hasClass('is-visited'))  {
                jQuery('#bm-step_3 .accordion-item-title .validation-icon').addClass('is-visible');
                jQuery('#bm-validation-msg').addClass('is-active');                
            }

            if (!condition4 && jQuery('#bm-gui-type').hasClass('is-visited') && true)  { // true was !jQuery('#bm-step_4').hasClass('is-open')
                if (THIS.selections.iconType == 'problem' || THIS.selections.iconType == null) {
                    jQuery('#bm-step_4 .accordion-item-title .validation-icon').addClass('is-visible');
                    //jQuery('#bm-validation-msg').addClass('is-active');
                }
            }
        }        
    }

    function drawText(fontsize) {
        return new Promise(function (resolve, reject) {            
            var text = THIS.selections.type.trim(' ').replace(/  +/g, ' '); // Trim spaces and replace multiple spaces with a single space
            var lines = text.split('\n');
            var linesNum = lines.length;
            var words = text.split(' ');
            var wordsNum = words.length;

            //var fontsize = 108;
            var c = 1;
            var lineheight = fontsize*.7;

            var margin = 20/c;
            var height = linesNum*lineheight + (linesNum-1)*margin;           

            opentype.load(bannerAssetsURL + 'fonts/Formanova/Formanova-Black.woff', function (err, font) {
                if (err) {
                     reject('Font could not be loaded: ' + err);
                } else {
                    var path;
                    var type = '';
                    for (var i = 0; i < linesNum; i++) {
                        path = font.getPath(lines[i], textureWidth/2, textureHeight/2 + lineheight*i - (height/2-lineheight) + margin*i, fontsize);                       
                        type += `<path style="fill:#FFFFFF;" id="type-${i}" class="banner-type" d="${path.toPathData(2)}"></path>`;
                    } 
                    
                    resolve(type);                
                }
            });        
        });
    }

    function readTextFile(file) {
        return new Promise(function (resolve, reject) {
            var rawFile = new XMLHttpRequest();
            rawFile.open("GET", file, false);
            rawFile.onreadystatechange = function () {
                if (rawFile.readyState === 4) {
                    if (rawFile.status === 200 || rawFile.status == 0) {
                        resolve(rawFile.responseText);
                    }
                }
            }
            reject(rawFile.send(null));
        });
    }

    function stripSvgTag(string) {
        return string.replace(/<[\/]{0,1}(svg|SVG)[^><]*>/g,"")
    }

    function setPatternColor(svg) {
        if (THIS.selections.shapeColor !== null) {
            var match = svg.match(/id="shape" style="fill:(.*?);"/i);
            svg = svg.replace(match[0], `id="shape" style="fill:${THIS.selections.shapeColor};"`);
        }
        return svg;
    }

    function setIconColor(svg) {
        var tmpColor = THIS.selections.iconColor == null ? '#D9D9D9' : THIS.selections.iconColor;
        var match = svg.match(/id="icon" style="fill:(.*?);"/i);
        svg = svg.replace(match[0], `id="icon" style="fill:${tmpColor};"`);
        return svg;
    }

    function setIconAnimation(svg) {
        var match = svg.match(/id="icon" style="(.*?);/i);
        svg = svg.replace(match[0], `${match[0]} transform: scale(1);`);
        var match = svg.match(/id="icon"/i);
        svg = svg.replace(match[0], 'id="icon" class="animate-initial-state"');
        return svg;
    }

    function setPatternAnimation(svg) {
        var match = svg.match(/id="shape"/i);
        svg = svg.replace(match[0], 'class="animate-initial-state" id="shape"');
        return svg;
    }

    function iconHasChanged() {
        return THIS.selections.lastIcon !== THIS.selections.icon;
    }

    function patternHasChanged() {
        return THIS.selections.lastPattern !== THIS.selections.pattern;
    }

    function setTypeColor(svg) {
        var tmpColor = THIS.selections.typeColor == null ? '#FFFFFF' : THIS.selections.typeColor;
        var match = svg.match(/style="fill:(.*?);" id="type-/g);
        if (match) {
            for (var i = 0; i < match.length; i++) {
                svg = svg.replace(match[i], `style="fill:${tmpColor};" id="type-`);
            }
        }
        return svg;   
    }

    function disableEnableColors(key, color, index) {
        if (index !== undefined && THIS.disabledColors[key][index] !== undefined) {
            THIS.disabledColors[key][index] = color;            
        } else {
            THIS.disabledColors[key][0] = color;
        }

        updateDisabledColors(key);
    }

    function updateDisabledColors(key) {
        jQuery('[data-bm_gui_color]').removeClass('is-disabled');

        //console.log(THIS.disabledColors)

        for (var key in THIS.disabledColors) {
            for (var i = 0; i < THIS.disabledColors[key].length; i++) {
                jQuery(`[data-bm_gui_color="${THIS.disabledColors[key][i]}"]`).addClass('is-disabled')
            }
        }
    }

    async function handleFontsize(svgHelp, svgStart, fontsize) {
        // Initial fontsizes 220 165 120
        // Adapted fontsizes 220 165 120

        // Check for text overflow
        var type = await drawText(fontsize);
        var overflow = textOverflow(type, svgHelp, svgStart)
        if (overflow instanceof Error) {
            if (fontsize>116) return handleFontsize(svgHelp, svgStart, fontsize/1.333);
            alert(overflow.message);
        } else {
            return await drawText(fontsize);
        }      
    }

    function textOverflow(type, svgHelp, svgStart) {
        svgHelp.html(svgStart + type + '</svg>');
        var lines = document.getElementsByClassName("banner-type");
        var overflow = 1310;

        if (lines.length > 5) return new Error('To many lines!\nPlease make soure your text length does not exeed four(5) lines.');

        for (var i = 0; i < lines.length; i++) {
            if (lines[i].getBBox().width > overflow) {
                return new Error('To many charachters for a single line!\nPlease type less charachters or change line (ENTER).');
            }
        }

        return false;
    }

    function alignTypeHorizontaly() {
        var lines = document.getElementsByClassName("banner-type");
        var translateX;
        for (var i = 0; i < lines.length; i++) {
            translateX = parseInt(lines[i].getBBox().width/2);
            lines[i].setAttribute('transform', `translate(-${translateX} 0)`);
        }
    }    

    function setColorsUI() {
        if (THIS.selections.pattern) {
            jQuery('#bm-gui-colors-pattern').removeClass('single-color').attr('data-pattern', THIS.selections.pattern);
        } else {
            jQuery('#bm-gui-colors-pattern').addClass('single-color').attr('data-pattern', null);
            resetSelectedColor('pattern', 'shape', 1);
        }        
    }

    function resetSelectedColor(value, key, index) {
        key = key !== undefined ? key : undefined;
        index = index !== undefined ? index : undefined;

        // Because pattern has 2 colors to disable
        if (key !== undefined && index !== undefined) {
            jQuery(`.${key}Color-is-selected`).removeClass(`${key}Color-is-selected`).removeClass('is-disabled');
            THIS.selections[`${key}Color`] = null;
            THIS.disabledColors[value][index] = null;            
        } else {
            jQuery(`.${value}Color-is-selected`).removeClass(`${value}Color-is-selected`).removeClass('is-disabled');
            THIS.selections[`${value}Color`] = null;
            THIS.disabledColors[value] = [];
        }

        updateDisabledColors(value);
    }

    return this;
}();

//

var exportSVG = function(svg) {
//https://stackoverflow.com/questions/38477972/javascript-save-svg-element-to-file-on-disk?rq=1
  // first create a clone of our svg node so we don't mess the original one
  var clone = svg.cloneNode(true);
  // parse the styles
  parseStyles(clone);

  // create a doctype
  var svgDocType = document.implementation.createDocumentType('svg', "-//W3C//DTD SVG 1.1//EN", "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd");
  // a fresh svg document
  var svgDoc = document.implementation.createDocument('http://www.w3.org/2000/svg', 'svg', svgDocType);
  // replace the documentElement with our clone 
  svgDoc.replaceChild(clone, svgDoc.documentElement);
  // get the data
  var svgData = (new XMLSerializer()).serializeToString(svgDoc);

  // now you've got your svg data, the following will depend on how you want to download it
  // e.g yo could make a Blob of it for FileSaver.js
  /*
  var blob = new Blob([svgData.replace(/></g, '>\n\r<')]);
  saveAs(blob, 'myAwesomeSVG.svg');
  */
  // here I'll just make a simple a with download attribute
  return 'data:image/svg+xml; charset=utf8, ' + encodeURIComponent(svgData.replace(/></g, '>\n\r<'));
};

var parseStyles = function(svg) {
  var styleSheets = [];
  var i;
  // get the stylesheets of the document (ownerDocument in case svg is in <iframe> or <object>)
  var docStyles = svg.ownerDocument.styleSheets;

  // transform the live StyleSheetList to an array to avoid endless loop
  for (i = 0; i < docStyles.length; i++) {
    styleSheets.push(docStyles[i]);
  }

  if (!styleSheets.length) {
    return;
  }

  var defs = svg.querySelector('defs') || document.createElementNS('http://www.w3.org/2000/svg', 'defs');
  if (!defs.parentNode) {
    svg.insertBefore(defs, svg.firstElementChild);
  }
  svg.matches = svg.matches || svg.webkitMatchesSelector || svg.mozMatchesSelector || svg.msMatchesSelector || svg.oMatchesSelector;


  // iterate through all document's stylesheets
  for (i = 0; i < styleSheets.length; i++) {
    var currentStyle = styleSheets[i]

    var rules;
    try {
      rules = currentStyle.cssRules;
    } catch (e) {
      continue;
    }
    // create a new style element
    var style = document.createElement('style');
    // some stylesheets can't be accessed and will throw a security error
    var l = rules && rules.length;
    // iterate through each cssRules of this stylesheet
    for (var j = 0; j < l; j++) {
      // get the selector of this cssRules
      var selector = rules[j].selectorText;
      // probably an external stylesheet we can't access
      if (!selector) {
        continue;
      }

      // is it our svg node or one of its children ?
      if ((svg.matches && svg.matches(selector)) || svg.querySelector(selector)) {

        var cssText = rules[j].cssText;
        // append it to our <style> node
        style.innerHTML += cssText + '\n';
      }
    }
    // if we got some rules
    if (style.innerHTML) {
      // append the style node to the clone's defs
      defs.appendChild(style);
    }
  }

};