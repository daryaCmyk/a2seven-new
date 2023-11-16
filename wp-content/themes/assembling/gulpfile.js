// Base
const path              = require('path');
const gulp              = require('gulp');
const notify            = require('gulp-notify');
const plumber           = require('gulp-plumber');

// General
const sourcemaps        = require('gulp-sourcemaps');

// Scripts
const webpack           = require('webpack')
const webpackStream     = require('webpack-stream');

// Styles
const sass              = require('gulp-sass');
const autoprefixer      = require('gulp-autoprefixer');

// Images
const tinypng           = require('gulp-tinypng-compress');
const svgSprite         = require('gulp-svg-sprites');
const replace           = require('gulp-replace');
const cheerio           = require('gulp-cheerio');

// Paths
const paths = {
    build:  path.join(__dirname, '.'),
    node:   path.join(__dirname, 'node_modules'),
    src: {
        self:       path.join(__dirname, 'src'),
        js:         'src/js/',
        sass:       'src/scss/',
        images:     'src/images/',
        pug:        'src/jade/',
    },
    static: {
        self:       'static/',
        js:         'static/js/',
        css:        'static/css/',
        images:     'static/images',
    },
    watch: {
        html: "src/html/**/*.html",
        fonts: "src/fonts/*.ttf",
        img: "src/images/*.{jpg,png,jpeg}",
        sprite: "src/images/*.svg",
        staticSprite: "src/images/static/*.svg",
        js: ["src/js/**/*.{js,ts}"],
        scss: "src/scss/**/*.{scss,css}"
    },
    html: './'
}

let webpackConfig = {
    mode: "development",
    entry: {
        script: path.join(paths.src.self, "js", "script.js"),
        index: path.join(paths.src.self, "js", "index.js"),
        portfolio: path.join(paths.src.self, "js", "portfolio-page.js"),
        blog: path.join(paths.src.self, "js", "blog-page.js"),
        vacancy: path.join(paths.src.self, "js", "vacancy-page.js"),
        text: path.join(paths.src.self, "js", "text-page.js"),
    },
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                      presets: ['@babel/preset-env'],
                      plugins: ['@babel/plugin-proposal-class-properties']
                    }
                }
            },
        ]
    },
    resolve: {
        extensions: ["*", ".js", ".jsx"],
        modules: [
            paths.node,
            paths.src.self,
        ]
    },
    output: {
        path: paths.build,
        publicPath: "/wp-content/themes/assembling/static/js/",
        filename: "static/js/[name].bundle.js",
        chunkFilename: '[name].bundle.js',
        library: "[name]"
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
        })
    ]
}

gulp.task("js", function() {
    gulp.src(path.join(paths.src.self, "js", "index.js"))
        .pipe(webpackStream(webpackConfig))
        .pipe(gulp.dest(paths.build));
});
  
gulp.task("js-build", function() {
    let config = webpackConfig
    config.mode = "production"
    gulp.src(path.join(paths.src.self, "js", "index.js"))
        .pipe(webpackStream(webpackConfig))
        .pipe(gulp.dest(paths.build));
});
  
gulp.task('sass', function () {
    gulp.src(path.join(paths.src.sass, "*.+(scss|sass|css)"))
    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle: "compressed"}).on("error", sass.logError))
    .pipe(autoprefixer("last 2 version"))
    .pipe(sourcemaps.write("./", { sourceRoot: "/source/scss" }))
    .pipe(gulp.dest(paths.static.css))
});

gulp.task('sass-build', function () {
    gulp.src(path.join(paths.src.sass, "*.+(scss|sass|css)"))
    .pipe(sass({outputStyle: "compressed"}).on("error", sass.logError))
    .pipe(autoprefixer("last 2 version"))
    .pipe(gulp.dest(paths.static.css))
});

gulp.task('tinypng', function () {
    gulp.src(paths.src.images + '/*.{png,jpg,jpeg}')
    .pipe(tinypng({
        key: 'odthLyLlVCQlfl9KLbpWcDBGEAqaBK8T',
        sigFile: paths.static.images + '/.tinypng-sigs'
    }))
    .pipe(gulp.dest(paths.static.images))
});

gulp.task('svg', function () {
    gulp
        .src(paths.src.images + '*.svg')
        .pipe(cheerio({
            run: function ($) {
                $('[fill]').removeAttr('fill');
                $('[style]').removeAttr('style');
                $('[clip-path]').removeAttr('clip-path');
                $('[filter]').removeAttr('filter');
            },
            parserOptions: { xmlMode: true }
        }))
        .pipe(replace('&gt;', '>'))
        .pipe(
            svgSprite({
                mode: "symbols",
                preview: false,
                selector: "%f",
                svg: {
                symbols: 'sprite.svg' 
            },
            transformData: function (data, config) {
                for(var i in data.svg) {
                    var result = data.svg[i].data.match(/path id="([a-z]+)"/ig );
                    if (null !== result) {
                        for(var j in result) {
                            var regexp = /\"([a-z]+)\"/i;
                            var matches = regexp.exec(result[j]);
                            matches[0] = matches[0].replace(/\"/g, '');

                            var k = 0;

                            var regexp = new RegExp('(path id\=\"|xlink\:href\=\"#)('+matches[0]+'){1}', 'g');
                            data.svg[i].data = data.svg[i].data.replace(regexp, function(str, p1, p2, offset, s)
                                {
                                    return p1 + "" + i + "" + j + "" + p2;
                                });
                        }
                    }
                }
                return data;
            },
        }
        ))
        .pipe(replace('NaN ', '-'))
        .pipe(gulp.dest(paths.static.images))
});

gulp.task('static-svg', function () {
    gulp
        .src(paths.src.images + 'static/*.svg')
        .pipe(replace('&gt;', '>'))
        .pipe(
            svgSprite({
                mode: "symbols",
                preview: false,
                selector: "%f",
                svg: {
                symbols: 'static-sprite.svg' 
            },
            transformData: function (data, config) {
                for(var i in data.svg) {
                    var result = data.svg[i].data.match(/path id="([a-z]+)"/ig );
                    if (null !== result) {
                        for(var j in result) {
                            var regexp = /\"([a-z]+)\"/i;
                            var matches = regexp.exec(result[j]);
                            matches[0] = matches[0].replace(/\"/g, '');

                            var k = 0;

                            var regexp = new RegExp('(path id\=\"|xlink\:href\=\"#)('+matches[0]+'){1}', 'g');
                            data.svg[i].data = data.svg[i].data.replace(regexp, function(str, p1, p2, offset, s)
                                {
                                    return p1 + "" + i + "" + j + "" + p2;
                                });
                        }
                    }
                }
                return data;
            },
        }
        ))
        .pipe(replace('NaN ', '-'))
        .pipe(gulp.dest(paths.static.images))
});

gulp.task('watch', function (){
    gulp.watch([paths.watch.scss],["sass"])
    gulp.watch(paths.watch.js,["js"])
    gulp.watch([paths.watch.sprite],["svg"])
    gulp.watch([paths.watch.staticSprite],["static-svg"])
    gulp.watch([paths.src.images + '/*.{png,jpg,jpeg}'], ["tinypng"])
});


gulp.task('default', ['watch', 'js', 'sass', 'svg', 'static-svg', 'tinypng']);
gulp.task('build', ['js-build', 'sass-build']);