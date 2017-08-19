const {mix} = require('laravel-mix');
const fs = require('fs');
const path = require('path');

/*
 * SynthesisCMS constants start
 */

// Prevent post-compiled SASS url checking (throws errors which do not really happen)
const bProcessCssUrls = false;

// Show log output during compilation
const bLog = true;

const publicFolderTmpDirectoryPath = "public/tmp";

/*
 * SynthesisCMS constants end
 */

/*
 * SynthesisCMS functions start
 */

function log(string){
    if(bLog){
        console.log(string);
    }
}

/*
 * SynthesisCMS functions end
 */

log("Setting 'processCssUrls' to: " + bProcessCssUrls);
mix.options({processCssUrls: bProcessCssUrls});

//SynthesisCMS SASS
mix.sass('resources/assets/sass/app.scss', 'public/css/app.css');
mix.sass('resources/assets/sass/login-register.scss', 'public/css/login-register.css');

//Dragula JS + CSS
mix.copy('node_modules/dragula/dist/dragula.js', 'public/js/dragula.js');
mix.copy('node_modules/dragula/dist/dragula.css', 'public/css/dragula.css');

//MaterializeCSS SASS + JS + Roboto font
mix.sass('resources/assets/materializecss/sass/materialize.scss', 'public/css/materialize.css');
//mix.js('resources/assets/materializecss/js/bin/materialize.js', 'public/js/materialize.js');
//TODO: fix this, because self compiling causes problems with Jquery's velocity animations
mix.copy('resources/assets/materializecss/dist-js', 'public/js', false);
mix.copy('resources/assets/materializecss/fonts', 'public/fonts', false);

//Chart.js, Clipboard.js & Trumbowyg
mix.copy('node_modules/chart.js/dist/Chart.js', 'public/js');
mix.copy('node_modules/clipboard/dist/clipboard.min.js', 'public/js/clipboard.min.js');
mix.copy('node_modules/trumbowyg/dist', 'public/trumbowyg', false);

//SynthesisCMS resources, trumbowyg resources, artus9033's Trumbowyg addons, fonts
mix.copy('resources/assets/img', 'public/img', false);
mix.copy('resources/assets/fonts', 'public/fonts', false);
mix.copy('resources/assets/js-copy-only', 'public/js', false);
mix.copy('resources/assets/artus9033-trumbowyg', 'public/trumbowyg/plugins/artus9033', false);
mix.copy('resources/assets/trumbowyg-custom-icons/icons.svg', 'public/trumbowyg/ui/icons.svg');

log("Checking if SynthesisCMS public tmp directory exists...");
if (fs.existsSync(path)) {
    log("SynthesisCMS public tmp directory does not exist yet, it will be created");
    fs.mkdirSync(publicFolderTmpDirectoryPath);
} else {
    log("SynthesisCMS public tmp directory already exists, no action will be performed");
}

log("Running all tasks now...");