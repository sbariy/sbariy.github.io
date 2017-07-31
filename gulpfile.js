var gulp = require('gulp'),
	concat = require('gulp-concat'),
	rename = require('gulp-rename'),
	browserSync = require('browser-sync').create(),
	reload = browserSync.reload,
	path = require('path'),
	url = require('gulp-css-url-adjuster'),
	autoprefixer = require('autoprefixer-core');
	postcss = require('gulp-postcss');

var params = {
	out: 'public',
	htmlSrc: 'index.html',
	levels: ['project.blocks', 'project.blocks' /*, light.blocks*/] /* set level is end */ 
};

getFileNames = require('html2bl').getFileNames(params);

gulp.task('default', ['server', 'build']);

gulp.task('server', function() {
	browserSync.init({
		server: params.out
	});

	gulp.watch('*.html', ['html']);
	gulp.watch(params.levels.map(function(level) {
		var cssGlob = level + '/**/*.css';
		return cssGlob;
	}), ['css']);
	
	gulp.watch(params.levels.map(function(level) {
		var jsGlob = level + '/**/*.js';
		return jsGlob;
	}), ['js']);
});

gulp.task('build', ['html', 'css', 'js', 'images', 'fonts']);

gulp.task('html', function() {
	gulp.src(params.htmlSrc)
		.pipe(rename('index.html'))
		.pipe(gulp.dest(params.out))
		.pipe(reload({ stream: true }));
});

gulp.task('css', function() {
	getFileNames.then(function(files) {
		gulp.src(files.css)
		.pipe(concat('styles.css'))
		.pipe(postcss([ autoprefixer() ]))
		.pipe(gulp.dest(params.out))
		.pipe(reload({ stream: true } ));
	})
	.done();
});

gulp.task('js', function() {
	getFileNames.then(function(source) {
		return source.dirs.map(function(dirName) {
			var jsGlob = path.resolve(dirName) + '/*.js';
			return jsGlob;
		});
	})

	.then(function(jsGlobs) {
		gulp.src(jsGlobs)
			.pipe(concat('scripts.js'))
			.pipe(gulp.dest(params.out))
			.pipe(reload({ stream: true }));
	})
	.done();
});

gulp.task('images', function() {
	getFileNames.then(function(src) {
		gulp.src(src.dirs.map(function(dir) {
			var imgGlob = path.resolve(dir) + '/img/*.{jpg,png,svg}';
			return imgGlob;
		}))
		.pipe(gulp.dest(path.join(params.out, 'images')));
	})
	.done();
});

gulp.task('fonts', function() {
	getFileNames.then(function(src) {
		gulp.src(src.dirs.map(function(dir) {
			var fontGlob = path.resolve(dir) + '/fonts/*.{eot,woff, ttf, svg}';
			return fontGlob;
		}))
		.pipe(gulp.dest(path.join(params.out, 'fonts')));
	})
	.done();
});