function appRun(mode) {
    // Check if WebGL is supported by browser
    try {        
        var canvas = document.getElementById("renderCanvas");
        var engine = new BABYLON.Engine(canvas, true, { preserveDrawingBuffer: true, stencil: true });
    }
    catch (e) {
        console.log(e)
        appGui.webGl = false
        jQuery('body').addClass('no-webgl')
        jQuery('#bm-gui-preview-info').addClass('is-active')
        return;
    } 
    //
    jQuery('#banner_maker-component').removeClass('loop-mode').removeClass('static-mode').addClass(`${mode}-mode`);
    appGui.mode = mode;    
    // Reset scene
    appRefresh = false;
    //
    ///var canvas = document.getElementById("renderCanvas");
    var texture = undefined;
    var textureImg = undefined;
    var camera;
    var loadedScene;
    var sceneOptions = {
        mode: mode,
        static: {
            material: "Default",
            vScale: -2,
            vOffset: 1.5,
        },
        loop: {
            material: "material0",
            vScale: 2,
            vOffset: 1.5,
        }
    }
    // Video output
    var recordFrames = 0;

    // Executes once
    var delayCreateScene = function () {        
        loadedScene = new BABYLON.Scene(engine);
        camera = new BABYLON.ArcRotateCamera("default camera", 0, 0, 0, new BABYLON.Vector3(0, 0, 0), loadedScene);

        BABYLON.SceneLoader.ImportMesh("", gpchBlocksAssetsURL + "blocks/banner-maker/scenes/", `${sceneOptions.mode}.glb`, loadedScene, function (meshes) {
            //scene.createDefaultCameraOrLight(true, true, true);
            loadedScene.createDefaultEnvironment({createSkybox: false});
            camera.setPosition(new BABYLON.Vector3(0, 0, 1.65));
            loadedScene.clearColor = new BABYLON.Color4(0, 0, 0, .000000000000001);
            loadedScene.getMaterialByID(sceneOptions[sceneOptions.mode].material).backFaceCulling = false;

            appGui.$loader.removeClass('is-active');
        });

        camera.attachControl(canvas, true);        
        return loadedScene;
    };

    ///var engine = new BABYLON.Engine(canvas, true, { preserveDrawingBuffer: true, stencil: true });
    var scene = delayCreateScene();
    var tm0, tm1 = performance.now();
    var percent = 0;
    var estimateTime = 0;

    scene.registerBeforeRender(function () {
        // Update texture
        if (scene.getMaterialByID(sceneOptions[sceneOptions.mode].material) !== null && textureImg !== appGui.texture) {
            textureImg = appGui.texture;
            texture = new BABYLON.Texture(textureImg, scene);
            texture.vScale = sceneOptions[sceneOptions.mode].vScale;
            texture.vOffset = sceneOptions[sceneOptions.mode].vOffset;
            texture.level = 2; // todo
            scene.getMaterialByID(sceneOptions[sceneOptions.mode].material).albedoTexture = texture;

            appGui.$loader.removeClass('is-active');
        }
        //////////////////////////////////// 
        if (appGui.generateDownloads) {
            appGui.generateDownloads = false;
            engine.resize();
            // Wait engine to resize
            setTimeout(function(){
                // Create png
                BABYLON.Tools.CreateScreenshot(
                    engine,
                    camera,
                    {width:1920, height:1080},
                    function(data) {
                        appGui.createDownloads(data);                
                    });                
            }, 250);            
        }
    });

    engine.runRenderLoop(function () {

        // Refresh App
        if (appRefresh) {
            // Reset gui
            appGui.reset();
            // Reset App
            loadedScene.dispose();
            scene.dispose();
            engine.dispose()
            camera = undefined;
            appRun(appRefresh);
        }

        if (scene) {
            scene.autoClear = true;

            if (appGui.videoExport.capturer) {
                
                scene.clearColor = new BABYLON.Color3(1, 1, 1);
                scene.render();

                if (appGui.videoExport.frameCnt == 0) {
                    recordFrames = Math.ceil(13.33*appGui.videoExport.fps); // Video duration * fps
                    appGui.videoExport.capturer.start();
                }
                
                if (appGui.videoExport.frameCnt >= recordFrames) {
                    appGui.videoExport.capturer.save();
                    appGui.videoExport.stopGenerate();                   
                } else {
                    appGui.videoExport.capturer.capture(canvas);
                    percent = appGui.videoExport.frameCnt*100/recordFrames;
                    appGui.videoExport.$loader.css({width:percent.toFixed(1) + '%'});
                    appGui.videoExport.$loader.text(percent.toFixed(1) + '%');

                    /*if (appGui.videoExport.frameCnt == 0) {
                        tm0 = performance.now();
                    } else if (appGui.videoExport.frameCnt == 14) {
                        tm1 = performance.now();
                        estimateTime = (recordFrames*(tm1-tm0))/15;
                        jQuery('#bm-generate-video-message span').text(sec2time(estimateTime/1000));
                    }*/

                    appGui.videoExport.frameCnt ++;                    
                }
            } else {
                scene.clearColor = new BABYLON.Color4(0, 0, 0, .000000000000001);
                scene.render();
            }
        }

        if (appDel) {
            // Reset gui
            appGui.reset();
            // Reset App
            loadedScene.dispose();
            scene.dispose();
            engine.dispose()
            camera = undefined;
        }
    }); 

    // Resize
    window.addEventListener("resize", function () {
        engine.resize();
    });
}

function sec2time(timeInSeconds) {
    var pad = function(num, size) { return ('000' + num).slice(size * -1); },
    time = parseFloat(timeInSeconds).toFixed(3),
    hours = Math.floor(time / 60 / 60),
    minutes = Math.floor(time / 60) % 60,
    seconds = Math.floor(time - minutes * 60),
    milliseconds = time.slice(-3);

    return pad(minutes, 2) + '\'' + pad(seconds, 2) + '\"';
}