var gulp           = require('gulp'),
	gutil          = require('gulp-util' ),
	sass           = require('gulp-sass'),
	browserSync    = require('browser-sync'),
	concat         = require('gulp-concat'),
	uglify         = require('gulp-uglify'),
	cleanCSS       = require('gulp-clean-css'),
	rename         = require('gulp-rename'),
	del            = require('del'),
	imagemin       = require('gulp-imagemin'),
	cache          = require('gulp-cache'),
	autoprefixer   = require('gulp-autoprefixer'),
	ftp            = require('vinyl-ftp'),
	notify         = require("gulp-notify"),
	rsync          = require('gulp-rsync'),
	spritesmith    = require('gulp.spritesmith'),
	svgSprite      = require('gulp-svg-sprite'),
	cheerio        = require('gulp-cheerio'),
	svgmin         = require('gulp-svgmin'),
	replace        = require('gulp-replace');

// Скрипты проекта

gulp.task('common-js', function() {
	return gulp.src([
		'app/js/common.js',
		])
	.pipe(concat('common.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('app/js'));
});

gulp.task('js', ['common-js'], function() {
	return gulp.src([
		'app/libs/jquery/dist/jquery.min.js',
		'app/libs/owl.carousel/dist/owl.carousel.min.js',
		'app/libs/jquery.mmenu/jquery.mmenu.js',
		'app/libs/jquery.mmenu/jquery.mmenu.navbars.js',
		'app/js/common.min.js', // Всегда в конце
		])
	.pipe(concat('scripts.min.js'))
	// .pipe(uglify()) // Минимизировать весь js (на выбор)
	.pipe(gulp.dest('app/js'))
	.pipe(browserSync.reload({stream: true}));
});

gulp.task('browser-sync', function() {
	browserSync({
		server: {
			baseDir: 'app'
		},
		notify: false,
		// tunnel: true,
		// tunnel: "projectmane", //Demonstration page: http://projectmane.localtunnel.me
	});
});

gulp.task('sass', function() {
	return gulp.src('app/sass/**/*.sass')
	.pipe(sass({outputStyle: 'expand'}).on("error", notify.onError()))
	.pipe(rename({suffix: '.min', prefix : ''}))
	.pipe(autoprefixer(['last 15 versions']))
	.pipe(cleanCSS()) // Опционально, закомментировать при отладке
	.pipe(gulp.dest('app/css'))
	.pipe(browserSync.reload({stream: true}));
});

gulp.task('watch', ['sass', 'js', 'sprite', 'svgsprite', 'browser-sync'], function() {
	gulp.watch('app/sass/**/*.+(sass|scss)', ['sass']);
	gulp.watch(['libs/**/*.js', 'app/js/common.js'], ['js']);
	gulp.watch('app/*.html', browserSync.reload);
});

gulp.task('imagemin', function() {
	return gulp.src('app/img/**/*')
	.pipe(cache(imagemin()))
	.pipe(gulp.dest('dist/img')); 
});

gulp.task('svgsprite', function() {
	return gulp.src(['app/img/sprite/svg/**/*.svg'])
		
		.pipe(svgmin({
			js2svg: {
				pretty: true
			}
		}))
		
		.pipe(cheerio({
			run: function ($) {
				$('[fill]').removeAttr('fill');
				$('[stroke]').removeAttr('stroke');
				$('[style]').removeAttr('style');
			},
			parserOptions: {xmlMode: true}
		}))
		
		.pipe(replace('&gt;', '>'))
		
		.pipe(svgSprite({
			shape: {
				spacing: {
					padding: 5
				}
			},
			mode: {
				css: {
					dest: "./",
					layout: "diagonal",
					sprite: "../sprite.svg",
					bust: false,
					render: {
						scss: {
							dest: '../../sass/_spritesvg.scss',
							template: 'app/sass/_sprite_template.scss'
						}
					},
					variables: {
						mapname: "icons"
					}
				},

			}
		}))
		.pipe(gulp.dest('app/img/sprite/'));
});

gulp.task('sprite', ['cleansprite', 'madesprite']);

gulp.task('cleansprite', function() {
    return del.sync('app/img/sprite/sprite.png');
});

gulp.task('madesprite', function () {
	var spriteData = gulp.src(['app/img/sprite/*.png', '!app/img/sprite/sprite.+(png|css|sass|scss)']).pipe(spritesmith({
		imgName: 'sprite.png',
		cssName: '_sprite.sass',
		imgPath: '../img/sprite/sprite.png'   
	}));

	spriteData.img.pipe(gulp.dest('app/img/sprite/')); // путь, куда сохраняем картинку
	spriteData.css.pipe(gulp.dest('app/sass/')); // путь, куда сохраняем стили
});

gulp.task('build', ['removedist', 'imagemin', 'sass', 'js'], function() {

	var buildFiles = gulp.src([
		'app/*.html',
		'app/.htaccess',
		]).pipe(gulp.dest('dist'));

	var buildCss = gulp.src([
		'app/css/main.min.css',
		]).pipe(gulp.dest('dist/css'));

	var buildJs = gulp.src([
		'app/js/scripts.min.js',
		]).pipe(gulp.dest('dist/js'));

	var buildFonts = gulp.src([
		'app/fonts/**/*',
		]).pipe(gulp.dest('dist/fonts'));

});

gulp.task('deploy', function() {

	var conn = ftp.create({
		host:      'hostname.com',
		user:      'username',
		password:  'userpassword',
		parallel:  10,
		log: gutil.log
	});

	var globs = [
	'dist/**',
	'dist/.htaccess',
	];
	return gulp.src(globs, {buffer: false})
	.pipe(conn.dest('/path/to/folder/on/server'));

});

gulp.task('rsync', function() {
	return gulp.src('dist/**')
	.pipe(rsync({
		root: 'dist/',
		hostname: 'username@yousite.com',
		destination: 'yousite/public_html/',
		archive: true,
		silent: false,
		compress: true
	}));
});

gulp.task('removedist', function() { return del.sync('dist'); });
gulp.task('clearcache', function () { return cache.clearAll(); });

gulp.task('default', ['watch']);
