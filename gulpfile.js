const { watch, series, parallel, src, dest } = require('gulp');
var rename = require( 'gulp-rename' );
var sass = require( 'gulp-sass' );
var uglify = require( 'gulp-uglify' );
var autoprefixer = require( 'gulp-autoprefixer' );
var sourcemaps = require( 'gulp-sourcemaps' );
var browserify = require( 'browserify' );
var babelify = require( 'babelify' );
var source = require( 'vinyl-source-stream' );
var buffer = require( 'vinyl-buffer' );
var browserSync = require( 'browser-sync' ).create();
// var reload = browserSync.reload;

// When adding scss files to the .../src/scss/ folder, 
// register save them as a variable here and add the variable
// to the 'function style() src(...)' below.
var styleGENERAL = './src/scss/peak15link-general.scss';
var styleADMIN = './src/scss/peak15link-admin.scss';
var styleFORMS = './src/scss/peak15link-forms.scss';
var styleDIST = './dist/css/';
var styleWatch = './src/scss/**/*.scss';

// When adding js files to the .../src/js/ folder, 
// register save them as a variable here and add the variable
// to the 'jsFILES' array below.
var jsADMIN = 'peak15link-admin.js';
var jsFORMS = 'peak15link-ajaxforms.js';
var jsFOLDER = './src/js/';
var jsDIST = './dist/js/';
var jsWatch = './src/js/**/*.js';
var jsFILES = [ jsADMIN, jsFORMS ];

var htmlWatch = '**/*.html';
var phpWatch = '**/*.php';


function browser_sync( done ) {
    browserSync.init({
        open: false,
        injectChanges: true,
        proxy: 'http://localhost:8888/biketravel/wp-admin/admin.php?page=peak15_link'
    });

    done();

};

function reload ( done ) {
    browserSync.reload();

    done();
    
}
function style() {
    return src( [ styleGENERAL, styleADMIN, styleFORMS ] )
        .pipe( sourcemaps.init() )
        .pipe( sass({
            errorLogToConsole: true,
            outputStyle: 'compressed'
        }) )
        .on( 'error', console.error.bind( console ) )
        .pipe( autoprefixer({
            cascade: false
        }) )
        .pipe( rename( { suffix: '.min' } ) )
        .pipe( sourcemaps.write( './' ) )
        .pipe( dest( styleDIST ) )
        .pipe( browserSync.stream() );
};

function js( done ) {

    jsFILES.map(function( entry ) {
        return browserify({
            entries: [jsFOLDER + entry]
        })
        .transform( babelify, { presets: ['@babel/preset-env'] } )
        .bundle()
        .pipe( source( entry ) )
        .pipe( rename({ extname: '.min.js' }) )
        .pipe( buffer() )
        .pipe( sourcemaps.init({ loadMaps: true }) )
        .pipe( uglify() )
        .pipe( sourcemaps.write( './' ) )
        .pipe( dest( jsDIST ) )
        .pipe( browserSync.stream() );
    });

    done();

}; 

function watch_files() {
    watch( htmlWatch, reload );
    watch( phpWatch, reload );
    watch( styleWatch, series(style, reload));
    watch( jsWatch, series(js, reload));
}

exports.browser_sync = browser_sync;
exports.style = style;
exports.js = js;
exports.default = parallel( style, js );
exports.watch = parallel( browser_sync, watch_files );