/**
 * Gulp File
 *
 * Used for automating development tasks.
 */

/* Modules (Can be installed with "npm install" command using package.json) */
var gulp = require('gulp'),
    sort = require('gulp-sort'),
    wpPot = require('gulp-wp-pot'),
    checktextdomain = require('gulp-checktextdomain'),
	rename = require("gulp-rename"),
	cleanCSS = require('gulp-clean-css'),
	jsmin = require('gulp-jsmin');

/* POT file task */
gulp.task('pot', function () {
    return gulp.src('**/*.php')
        .pipe(sort())
        .pipe(wpPot({
            package: 'Press Elements',
            domain: 'press-elements', //textdomain
            destFile: 'press-elements.pot',
            lastTranslator: '',
            team: 'Rami Yushuvaev <r_a_m_i@hotmail.com>'
        }))
        .pipe(gulp.dest('language'));
});

/* Text-domain task */
gulp.task('textdomain', function () {
    var options = {
        text_domain: 'press-elements',
        keywords: [
            '__:1,2d',
            '_e:1,2d',
            '_x:1,2c,3d',
            'esc_html__:1,2d',
            'esc_html_e:1,2d',
            'esc_html_x:1,2c,3d',
            'esc_attr__:1,2d',
            'esc_attr_e:1,2d',
            'esc_attr_x:1,2c,3d',
            '_ex:1,2c,3d',
            '_n:1,2,4d',
            '_nx:1,2,4c,5d',
            '_n_noop:1,2,3d',
            '_nx_noop:1,2,3c,4d'
        ],
		correct_domain: true
    };
    return gulp.src('**/*.php')
        .pipe(checktextdomain(options))
});

/* Styles task */
gulp.task('css', function () {
	return gulp.src('assets/css/*.css')
		.pipe(cleanCSS())
		.pipe(rename({suffix:".min"}))
		.pipe(gulp.dest('assets/css/'));
});

/* Scripts task */
gulp.task('js', function () {
	return gulp.src('assets/js/*.js')
		.pipe(jsmin())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('assets/js/'));
});

/* Default Gulp task */
gulp.task('default', function () {
    // Run all the tasks!
    gulp.start('textdomain','pot','css','js');
});
