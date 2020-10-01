<section class="bm-app">
    <div id="banner_maker_intro-component" class="component banner_maker_intro-component ratio-16-9 bg-white">
        <div class="container">
            <div class="row row-30-20">
                <div class="col-12">
                    <header class="row">
                        <h1 class="h-xxxxl col-sm-12 col-xl-8">BANNER<BR>MAKER</h1>
                        <div class="editor col-sm-12 col-xl-4 padding_inner-xl-h">Banner maker is a custom tool helps you to create your own banner. How it works, choose your colour of preference, choose your climate justice campaign icon and then choose your preferred message or type your own. Click on generate. Enjoy!</div>
                    </header>
                </div>

                <div class="col-md-12 d-flex justify-content-center">
                    <div id="bm-video-wrap"></div>
                </div>

                <div class="col-12 d-flex justify-content-center">
                    <button id="bm-step_start" class="mybtn margin-t">Create</button>
                </div>
            </div>
        </div>
    </div>

    <div id="banner_maker-component-wrap" class="component banner_maker-component-wrap">
        <div id="banner_maker-component" class="component banner_maker-component d-flex align-items-xl-center">                        
            <div class="banner_maker-component-container container d-flex">
                <div class="row align-items-center">
                    <div class="col-xl-5 d-flex flex-column gui-col">
                        <div id="accordion-bm" class="accordion">
                            <div id="bm-step_1" class="accordion-item bm-step bm-step-JS">
                                <div id="heading-0" class="accordion-item-header" data-toggle="collapse" data-target="#collapse-0" aria-expanded="true" aria-controls="collapse-0">
                                    <div class="accordion-item-title"><span>Step&nbsp;1<span class="validation-icon">*</span></span></div>
                                    <div class="accordion-item-subtitle"><span class="text-sm">Background</span><br>Choose your preferred background between solid or pattern</div>
                                </div>

                                <div id="collapse-0" class="collapse accordion-item-content collapse show" aria-labelledby="heading-0" data-parent="#accordion-bm">
                                    <div id="bm-gui-patterns" class="bm-gui-patterns bm-gui">
                                        <div class="bm-gui-container">
                                            <div class="buttons-wrap">
                                                <div class="button-wrap">
                                                    <button class="is-selected" data-bm_gui_pattern="null"></button>
                                                </div>
                                                <div class="button-wrap">
                                                    <button style="background-image:url(img/flag/backgrounds/stripe_horizontal.svg)" data-bm_gui_pattern="stripe_horizontal"></button>
                                                </div>
                                                <div class="button-wrap">
                                                    <button style="background-image:url(img/flag/backgrounds/stripe_diagonial.svg)" data-bm_gui_pattern="stripe_diagonial"></button>
                                                </div>
                                                <div class="button-wrap">
                                                    <button style="background-image:url(img/flag/backgrounds/stripe_vertical.svg)" data-bm_gui_pattern="stripe_vertical"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="bm-step_1-info" class="bm-info __warning"><span class="bm-info-content"><span class='info-icon'>!</span><span class="bm-info-text"></span></span></div>
                                </div>  
                            </div>

                            <div id="bm-step_2" class="accordion-item bm-step bm-step-JS">
                                <div id="heading-1" class="accordion-item-header" data-toggle="collapse" data-target="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                                    <div class="accordion-item-title"><span>Step&nbsp;2<span class="validation-icon">*</span></span></div>
                                    <div class="accordion-item-subtitle"><span class="text-sm">Background Colour</span><br>Then choose background/pattern colour(s) based on the campaign’s colour palette</div>
                                </div>

                                <div id="collapse-1" class="collapse accordion-item-content" aria-labelledby="heading-1" data-parent="#accordion-bm">
                                    <div id="bm-gui-colors-pattern" class="bm-gui-colors bm-gui">
                                        <div class="bm-gui-container">
                                            <button style="background-color:#39B54A" data-bm_gui_color="#39B54A"><span class="disabled-icon"></span><span class="shape"></span></button>
                                            <button style="background-color:#0038A8" data-bm_gui_color="#0038A8"><span class="disabled-icon"></span><span class="shape"></span></button>
                                            <button style="background-color:#F9D33C" data-bm_gui_color="#F9D33C"><span class="disabled-icon"></span><span class="shape"></span></button>
                                            <button style="background-color:#ED3F1D" data-bm_gui_color="#ED3F1D"><span class="disabled-icon"></span><span class="shape"></span></button>
                                            <button style="background-color:#00C1FF" data-bm_gui_color="#00C1FF"><span class="disabled-icon"></span><span class="shape"></span></button>
                                            <button style="background-color:#FF92F4" data-bm_gui_color="#FF92F4"><span class="disabled-icon"></span><span class="shape"></span></button>
                                        </div>
                                    </div>

                                    <div id="bm-step_2-info" class="bm-info __warning"><span class="bm-info-content"><span class='info-icon'>!</span><span class="bm-info-text">Deselect a colour first!</span></span></div>
                                </div>  
                            </div>

                            <div id="bm-step_3" class="accordion-item bm-step bm-step-JS">
                                <div id="heading-2" class="accordion-item-header" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                    <div class="accordion-item-title"><span>Step&nbsp;3<span class="validation-icon">*</span></span></div>
                                    <div class="accordion-item-subtitle"><span class="text-sm">Icons</span><br>Now choose your preferred icon between problems or feelings. Don't forget to chose a colour</div>
                                </div>

                                <div id="collapse-2" class="collapse accordion-item-content" aria-labelledby="heading-2" data-parent="#accordion-bm">
                                    <div id="bm-gui-icons" class="bm-gui-icons bm-gui">
                                        <div class="bm-gui-container">
                                            <div class="bm-gui-inner">
                                                <div class="bm-gui-inner-title">Problems</div>

                                                <div data-bm_gui_icontype="problem">

                                                    <button data-bm_gui_icon="problem_1">
                                                        <i class="svg-icon"><?php echo file_get_contents("img/flag/icons/problem_1.svg"); ?></i>
                                                        <span>Wildfires</span>
                                                    </button>

                                                    <button data-bm_gui_icon="problem_2">
                                                        <i class="svg-icon"><?php echo file_get_contents("img/flag/icons/problem_2.svg"); ?></i>
                                                        <span>Floods</span>
                                                    </button>

                                                    <button data-bm_gui_icon="problem_3">
                                                        <i class="svg-icon"><?php echo file_get_contents("img/flag/icons/problem_3.svg"); ?></i>
                                                        <span>Tropical cyclones</span>
                                                    </button>

                                                    <button data-bm_gui_icon="problem_4">
                                                        <i class="svg-icon"><?php echo file_get_contents("img/flag/icons/problem_4.svg"); ?></i>
                                                        <span>Rising sea levels</span>
                                                    </button>

                                                    <button data-bm_gui_icon="problem_5">
                                                        <i class="svg-icon"><?php echo file_get_contents("img/flag/icons/problem_5.svg"); ?></i>
                                                        <span>Droughts</span>
                                                    </button>

                                                    <button data-bm_gui_icon="problem_6">
                                                        <i class="svg-icon"><?php echo file_get_contents("img/flag/icons/problem_6.svg"); ?></i>
                                                        <span>Heatwaves</span>
                                                    </button>                                                                
                                                </div>

                                                <div class="column-break"></div>

                                                <div class="bm-gui-inner-title">Feelings</div>

                                                <div data-bm_gui_icontype="feeling">
                                                    <button data-bm_gui_icon="feeling_3">
                                                        <i class="svg-icon"><?php echo file_get_contents("img/flag/icons/feeling_3.svg"); ?></i>
                                                        <span>Empowered</span>
                                                    </button>

                                                    <button data-bm_gui_icon="feeling_7">
                                                        <i class="svg-icon"><?php echo file_get_contents("img/flag/icons/feeling_7.svg"); ?></i>
                                                        <span>Empathy</span>
                                                    </button>

                                                    <button data-bm_gui_icon="feeling_5">
                                                        <i class="svg-icon"><?php echo file_get_contents("img/flag/icons/feeling_5.svg"); ?></i>
                                                        <span>Encouraged/Inspired</span>
                                                    </button>

                                                    <button data-bm_gui_icon="feeling_6">
                                                        <i class="svg-icon"><?php echo file_get_contents("img/flag/icons/feeling_6.svg"); ?></i>
                                                        <span>Belonging</span>
                                                    </button>
                                                </div>

                                                <div id="bm-gui-colors-icons" class="bm-gui-inner_colors">
                                                    <button style="background-color:#FFFFFF" data-bm_gui_color="#FFFFFF"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#39B54A" data-bm_gui_color="#39B54A"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#0038A8" data-bm_gui_color="#0038A8"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#F9D33C" data-bm_gui_color="#F9D33C"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#ED3F1D" data-bm_gui_color="#ED3F1D"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#00C1FF" data-bm_gui_color="#00C1FF"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#FF92F4" data-bm_gui_color="#FF92F4"><span class="disabled-icon"></span></button>
                                                </div>                                                    
                                            </div>
                                        </div>
                                    </div>

                                    <div id="bm-step_3-info" class="bm-info __warning"><span class="bm-info-content"><span class='info-icon'>!</span><span class="bm-info-text"></span></span></div>
                                </div>  
                            </div>


                            <div id="bm-step_4" class="accordion-item bm-step bm-step-JS"><!-- is-disabled -->
                                <div id="heading-3" class="accordion-item-header" data-toggle="collapse" data-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                    <div class="accordion-item-title"><span>Step&nbsp;4<span class="validation-icon">*</span></span></div>
                                    <div class="accordion-item-subtitle"><span class="text-sm">Message</span><br>Finally choose from existing messages or type your own. Don't forget to chose a colour</div>
                                </div>

                                <div id="collapse-3" class="collapse accordion-item-content collapse show" aria-labelledby="heading-3" data-parent="#accordion-bm">
                                    <div id="bm-gui-type" class="bm-gui-type bm-gui">
                                        <div class="bm-gui-container">
                                            <div class="bm-gui-inner">
                                                <div class="buttons-wrap">
                                                    <div class="button-wrap">
                                                        <button data-bm_gui_type="VOICES FOR&#10;CLIMATE&#10;ACTION.&#10;JUSTICE FOR&#10;THE PEOPLE"><span>VOICES FOR<br>CLIMATE<br>ACTION.<br>JUSTICE FOR<br>THE PEOPLE</span></button>
                                                    </div>
                                                    <div class="button-wrap">
                                                        <button data-bm_gui_type="RAISE YOUR&#10;VOICE FOR&#10;CLIMATE&#10;JUSTICE"><span>RAISE YOUR<br>VOICE FOR<br>CLIMATE<br>JUSTICE</span></button>
                                                    </div>
                                                    <div class="button-wrap">
                                                        <button data-bm_gui_type="THE CLIMATE&#10;CRISIS IS A&#10;HUMAN RIGHTS&#10;CRISIS"><span>THE CLIMATE<br>CRISIS IS A<br>HUMAN RIGHTS<br>CRISIS</span></button>
                                                    </div>
                                                </div>


                                                <div class="bm-gui-textarea-wrap">
                                                    <textarea id="bm-gui-textarea" class="text-xs" placeholder="TYPE YOUR OWN&#10;MESSAGE" rows="5"></textarea>

                                                    <div class="bm-gui-textarea-options">
                                                        <div class="button-wrap">
                                                            <button id="bm-gui-textarea-submit" class="mybtn __full-width __outline __bg-transparent bm-gui-textarea-submit margin-t-10 text-xs is-inactive">Submit</button>
                                                        </div>

                                                        <div class="button-wrap">
                                                            <button id="bm-gui-textarea-delete" class="mybtn __full-width __outline __bg-transparent bm-gui-textarea-submit margin-t-10 text-xs is-inactive">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="bm-gui-colors-type" class="bm-gui-inner_colors is-active">
                                                    <button style="background-color:#FFFFFF" data-bm_gui_color="#FFFFFF"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#000000" data-bm_gui_color="#000000"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#39B54A" data-bm_gui_color="#39B54A"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#0038A8" data-bm_gui_color="#0038A8"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#F9D33C" data-bm_gui_color="#F9D33C"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#ED3F1D" data-bm_gui_color="#ED3F1D"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#00C1FF" data-bm_gui_color="#00C1FF"><span class="disabled-icon"></span></button>
                                                    <button style="background-color:#FF92F4" data-bm_gui_color="#FF92F4"><span class="disabled-icon"></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="bm-step_4-info" class="bm-info __warning"><span class="bm-info-content"><span class='info-icon'>!</span><span class="bm-info-text">Select or submit a message first!</span></span></div>
                                </div>
                                <div id="bm-step_4-info_2" class="bm-info __simply"><span class="bm-info-content"><span class="bm-info-text">Feelings need no words</span></span></div>
                            </div>
                        </div>                                    
                    </div>

                    <div id="preview-col" class="col-xl-7 d-flex align-items-center preview-col">
                        <div class="bm-gui-preview bm-gui-renderCanvas bm-gui">
                            <div class="bm-gui-container">
                                <div class="bm-preview">
                                    <canvas id="renderCanvas" width="1920" height="1080"></canvas>

                                    <div id="bm-app-loader" class="loader-text is-active">
                                        Loading&nbsp;<span></span>&nbsp;<span></span>
                                    </div>                             
                                </div>
                            </div>
                        </div>
                        
                        <div class="bm-gui-preview bm-gui-svgPreview bm-gui">
                            <div class="bm-gui-container">
                                <div class="bm-preview">
                                    <div id="svgPreview"></div>
                                </div>
                                <div id="svgHelp"></div>
                                <div id="test"></div>
                            </div>
                        </div>

                        <div id="bm-gui-preview-info" class="bm-info __warning"><span class="bm-info-content"><span class="bm-info-text">WebGL disabled or unavailable. <a href="https://get.webgl.org/" target="_balnk">Learn&nbsp;more</a></span></span></div>
                    </div>

                    <div class="actions-col col-xl-5 margin-t-30">
                        <div class="actions-col-content">
                            <div class="buttons-wrap">
                                <div class="button-wrap">
                                    <button id="bm-gui-reset-btn" class="mybtn __bg-transparent __outline __size-sm">Reset</button>                                        
                                </div>

                                <div class="button-wrap">
                                    <button id="bm-step_generate" class="mybtn __size-sm is-hidden">Generate</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="banner_maker-options-wrap">
                <div class="container bm-options">
                    <div class="bm-options-content">
                        <!--<button id="bm-gui-reset-btn" class="bm-gui-reset-btn">
                            reset
                        </button>-->

                        <button id="bm-gui-app_close-btn" class="bm-gui-app_close-btn">
                            <div class="hamburger hamburger--3dx js-hamburger is-active">
                                <div class="hamburger-box">
                                        <div class="hamburger-inner"></div>
                                </div>
                            </div>
                        </button>                                    
                    </div>
                </div>
            </div>

            <div id="bm-step_downloads" class="bm-step_downloads d-flex align-items-center bg-white">
                <div class="container height-100">
                    <div class="row height-100 justify-content-center">
                        <div class="col-12 col-xl-9 bm-img_preview-wrap">
                            <div id="bm-img_preview"></div>
                            <div id="bm-img_preview-loader" class="loader-text is-active">
                                Loading&nbsp;<span></span>&nbsp;<span></span>
                            </div>
                        </div>

                        <div class="bm-step_downloads-actions col-12 d-flex">
                            <div class="row row-30-25 justify-content-center">
                                <div class="col-12 col-md-auto d-flex justify-content-center">
                                    <a href="#" id="bm-download_vector" class="mybtn __bg-gray" download="climate-justice-vector">Download Vector</a>
                                </div>

                                <div class="col-12 col-md-auto d-flex justify-content-center download_photo-col">
                                    <a href="#" id="bm-download_image" class="mybtn __bg-gray" download="climate-justice-image">Download Photo</a>
                                </div>

                                <div class="col-12 col-md-auto d-flex justify-content-around align-items-center download_video-col flex-column">
                                    <button id="bm-generate-video" class="mybtn __bg-gray">
                                        <span id="bm-generate-video-title">Download Video</span>
                                        <div id="bm-generate-video-loader" class="loader-bar"></div>
                                        <!--<div id="bm-generate-video-message" class="bm-generate-video-message">Time estimation about&nbsp;<span></span><br>Please dont leave this page until the download is complete.</div>-->
                                    </button>

                                    <div id="bm-generate-video-fps" class="radio-group __style-bar">
                                        <input id="bm-generate-video-30" type="radio" name="fps" value="30" checked="">
                                        <label for="bm-generate-video-30">30 FPS</label>
                                        <input id="bm-generate-video-60" type="radio" name="fps" value="60">
                                        <label for="bm-generate-video-60">60 FPS</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                            
                </div>
            </div>
        </div>

        <div id="bm-gui-modal" class="bm-gui-modal">
            <div id="bm-gui-app_toggle" class="bm-gui-app_toggle is-open __warning">
                <button id="bm-gui-app_toggle-btn" class="bm-gui-app_toggle-btn info-icon">!</button>
                <div class="bm-gui-app_toggle-content-wrap">
                    <div class="bm-gui-app_toggle-content">
                        <div class="bm-gui-app_toggle-title">VIDEO<br>MODE</div>
                        <div class="bm-gui-app_toggle-text">
                            <p>Confirm video mode for full Experience. This may couse performance issues to your device.</p>
                        </div>
                        <div class="bm-gui-app_toggle-ui">
                            <div class="button-wrap">
                                <button id="bm-gui-app_toggle-dismiss" class="mybtn __size-sm __full-width __bg-light_blue">Dismiss</button>
                            </div>
                            <div class="button-wrap">
                                <button id="bm-gui-app_toggle-confirm" class="mybtn __size-sm __full-width __bg-red">Confirm</button>
                            </div>
                        </div>
                    </div>                                            
                </div>
            </div>
        </div>
    </div>
</section>