var gulp      = require('gulp'),
    rename    = require('gulp-rename'),     // Renommage des fichiers
    sass      = require('gulp-sass'),       // Conversion des SCSS en CSS
    minifyCss = require('gulp-minify-css'), // Minification des CSS
    uglify    = require('gulp-uglify'),     // Minification/Obfuscation des JS
  	notify = require("gulp-notify"),
    concat = require('gulp-concat'),
    pngquant = require('imagemin-pngquant'),
    imagemin = require('gulp-imagemin'),
    jshint = require('gulp-jshint'),
    map = require('map-stream');

// Debug Function
var myReporter = map(function (file, cb) {
  if (!file.jshint.success) {
    console.log('JSHINT fail in '+file.path);
    file.jshint.results.forEach(function (err) {
      if (err) {
        console.log(' '+file.path + ': line ' + err.line + ', col ' + err.character + ', code ' + err.code + ', ' + err.reason);
      }
    });
  }
  cb(null, file);
}); 


gulp.task('js', function() 
{
  return gulp.src('web/js/*.js')    // Prend en entrée les fichiers *.src.js

    .pipe(jshint())
    .pipe(jshint.reporter('default', { verbose: true }))
    .pipe(concat('main.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('web/dist/js/'))
    .pipe(notify("Finish JS!"));
});


gulp.task('sass', function() {
return gulp.src('web/sass/*.sass')    // Prend en entrée les fichiers *.scss
    .pipe(sass())                      // Compile les fichiers
    .pipe(concat('mainsass.min.css'))
    .pipe(minifyCss())                 // Minifie le CSS qui a été généré
    .pipe(gulp.dest('web/dist/css'))  // Sauvegarde le tout dans /src/style
  .pipe(notify("Finish SASS!"));

});

gulp.task('images', function()  {
    return gulp.src('web/images/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(notify("Finish IMAGES!"))
        .pipe(gulp.dest('web/dist/images'));
});

gulp.task('css', function() {
return gulp.src('web/css/*.css')    // Prend en entrée les fichiers *.scss
    .pipe(concat('main.min.css'))
    .pipe(minifyCss())                 // Minifie le CSS qui a été généré
    .pipe(gulp.dest('web/dist/css'))  // Sauvegarde le tout dans /src/style
	.pipe(notify("Finish CSS!"));

});





// WATCH TASK
gulp.task('watch', function()
{
  gulp.watch('web/css/*.css', ['css']);
  gulp.watch('web/sass/*.sass', ['sass']);
  gulp.watch('web/images/*', ['images']);
  gulp.watch('web/js/*.js', ['js']);
});


//default : watch
gulp.task('default', ['watch']);
