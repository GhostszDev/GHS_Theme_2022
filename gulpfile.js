import webpack from 'webpack-stream';
import gulp from 'gulp';
import yargs from 'yargs';
import babel from 'gulp-babel';
const PRODUCTION = yargs.argv.prod;
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
const sass = gulpSass(dartSass);
import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';
import postcss from 'gulp-postcss';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'autoprefixer';
import imagemin from 'gulp-imagemin';
import {deleteAsync} from 'del';
import named from 'vinyl-named';
import browserSync from "browser-sync";
import zip from "gulp-zip";
import replace from "gulp-replace";
import wpPot from "gulp-wp-pot";
import info from "./package.json" assert {type: 'json'};

console.log(PRODUCTION);

//BrowserSync
const server = browserSync.create();
export const serve = done => {
    server.init({
        proxy: "http://ghostszmusic.local/" // put your local website link here
    });
    done();
};
export const reload = done => {
    server.reload();
    done();
};

//Bundles Sass
export const styles = () => {
    return gulp.src(['src/scss/bundle.scss', 'src/scss/admin.scss'])
        .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
        .pipe(sass().on('error', sass.logError))
        .pipe(gulpif(PRODUCTION, postcss([ autoprefixer ])))
        .pipe(gulpif(PRODUCTION, cleanCss({compatibility:'ie8'})))
        .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
        .pipe(gulp.dest('dist/css'))
        .pipe(server.stream());
}

//Minify Images
export const images = () => {
  return gulp.src('src/images/**/*.{jpg,jpeg,png,svg,gif}')
      .pipe(gulpif(PRODUCTION, imagemin()))
      .pipe(gulp.dest('dist/images'));
}

//Minify scripts
export const scripts = () => {
    return gulp.src(['src/js/bundle.js','src/js/admin.js'])
        .pipe(named())
        .pipe(webpack({
            module: {
                rules: [
                    {
                        test: /\.js$/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: []
                            }
                        }
                    }
                ]
            },
            mode: PRODUCTION ? 'production' : 'development',
            devtool: !PRODUCTION ? 'inline-source-map' : false,
            output: {
                filename: '[name].js'
            },
            externals: {
                jquery: 'jQuery'
            },
        }))
        .pipe(babel())
        .pipe(gulp.dest('dist/js'));
}

//Copying files from Src/Images, Src/JS, and Src/scss
export const copy = () => {
  return gulp.src(['src/**/*','!src/{images,js,scss}','!src/{images,js,scss}/**/*'])
      .pipe(gulp.dest('dist'));
}

//Watching Files
export const watchForChanges = () => {
    gulp.watch('src/scss/**/*.scss', styles);
    gulp.watch('src/images/**/*.{jpg,jpeg,png,svg,gif}', gulp.series(images, reload));
    gulp.watch(['src/**/*','!src/{images,js,scss}','!src/{images,js,scss}/**/*'], gulp.series(copy, reload));
    gulp.watch('src/js/**/*.js', gulp.series(scripts, reload));
    gulp.watch("**/*.php", reload);
}

//Compress
export const compress = () => {
    return gulp.src([
        "**/*",
        "!node_modules{,/**}",
        "!bundled{,/**}",
        "!src{,/**}",
        "!.babelrc",
        "!.gitignore",
        "!gulpfile.babel.js",
        "!package.json",
        "!package-lock.json",
    ])
        .pipe(gulpif(
            file => file.relative.split(".").pop() !== "zip",
            replace("_themename", info.name)
            ))
        .pipe(zip(`${info.name}.zip`))
        .pipe(gulp.dest('bundled'));
};

export const pot = () => {
    return gulp.src("**/*.php")
        .pipe(
            wpPot({
                domain: "_themename",
                package: info.name
            })
        )
        .pipe(gulp.dest(`languages/${info.name}.pot`));
};

//Cleaning aka deleting Dist folder
export const clean = () => deleteAsync(['dist']);

export const dev = gulp.series(clean, gulp.parallel(styles, images, copy, scripts), serve, watchForChanges);
export const build = gulp.series(clean, gulp.parallel(styles, images, copy, scripts), pot, compress);
export default dev;