/* global module:false */
module.exports = function gruntConfig(grunt) {
  // PROJECT CONFIG
  grunt.initConfig({

    // META DATA
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
    '<%= grunt.template.today("yyyy-mm-dd") %>*/\n',

    // TASK CONFIG

    // CONCATENATE JAVASCRIPT
    // concatonate javascript files including zurb foundations, then
    // any vendor framworks, then plugins, and finally the site js
    concat: {
      options: {
        banner: '<%= banner %>',
        stripBanners: true,
      },
      dist: {
        src: [
          '<%= pkg.foundationPath %>/js/foundation.core.js',
          // '<%= pkg.foundationPath %>/js/*.js', // or just list out the modules you want
          '<%= pkg.foundationPath %>/js/foundation.util.box.js',
          '<%= pkg.foundationPath %>/js/foundation.util.keyboard.js',
          '<%= pkg.foundationPath %>/js/foundation.util.mediaQuery.js',
          '<%= pkg.foundationPath %>/js/foundation.util.motion.js',
          '<%= pkg.foundationPath %>/js/foundation.util.nest.js',
          '<%= pkg.foundationPath %>/js/foundation.util.triggers.js',
          '<%= pkg.foundationPath %>/js/foundation.dropdownMenu.js',
          '<%= pkg.foundationPath %>/js/foundation.drilldown.js',
          '<%= pkg.foundationPath %>/js/foundation.responsiveMenu.js',
          '<%= pkg.foundationPath %>/js/foundation.reveal.js',
          '<%= pkg.foundationPath %>/js/foundation.sticky.js',
          'client/js/vendor/*.js',
          'client/js/ega16/*.js',
        ],
        dest: '<%= pkg.jsPath %>/<%= pkg.name %>.src.js',
      },
    },

    // ZURB FOUNDATION BOWER TASK
    // babel is a thing now i guess
    babel: {
      options: {
        sourceMap: true,
        presets: ['es2015'],
      },
      dist: {
        files: {
          '<%= pkg.jsPath %>/<%= pkg.name %>.dist.js': '<%= concat.dist.dest %>',
        },
      },
    },

    // UGLIFY JAVASCRIPT
    // minify the concatonated javascript and put it in the same location
    uglify: {
      options: {
        banner: '<%= banner %>',
      },
      dist: {
        src: '<%= pkg.jsPath %>/<%= pkg.name %>.dist.js',
        dest: '<%= pkg.jsPath %>/<%= pkg.name %>.min.js',
      },
    },

    // JSHINT
    // helpful hinting of the javascript
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        unused: true,
        boss: true,
        eqnull: true,
        browser: true,
        globals: {
          jQuery: true,
        },
      },
      gruntfile: {
        src: 'Gruntfile.js',
      },
    },

    // WATCH TASK FOR SCSS & JAVASCRIPT
    // watch the source so i can run the build automatically as i code
    watch: {
      scripts: {
        files: [
          'client/js/**/*.js',
        ],
        tasks: ['jshint', 'concat', 'babel'],
        options: {
          debounceDelay: 250,
        },
      },
      sass: {
        files: [
          'client/sass/**/*.scss',
        ],
        tasks: ['sass:dev', 'autoprefixer:dev'],
      },
    },

    // SASS
    // the sass build. i use a distrubution and dev config so i
    // can minify my css for production and use source maps for dev.
    sass: {
      dev: {
        options: {
          outputStyle: 'expanded',
          includePaths: ['<%= pkg.foundationPath %>/scss'],
          sourceMap: true,
          sourceComments: true,
        },
        files: {
          'static/css/style.css': 'client/sass/style.scss',
        },
      },
      dist: {
        options: {
          outputStyle: 'compressed',
          includePaths: ['<%= pkg.foundationPath %>/scss'],
          sourceMap: false,
        },
        files: {
          'static/css/style.min.css': 'client/sass/style.scss',
        },
      },
    },

    // SCSS TO JSON
    // export some of the scss variables to json as a helper
    // for some of the scripts
    scss_to_json: {
      dist: {
        src: 'client/sass/ega16/_palette.scss',
        dest: 'static/js/palette.json',
      },
    },

    // AUTOPREFIXER
    // never write vendor prefixes again!
    autoprefixer: {
      dev: {
        options: {
          map: true,
          browsers: ['last 3 versions'],
        },
        src: '<%= pkg.cssPath %>/*.css',
      },
      dist: {
        options: {
          map: false,
          browsers: ['last 3 versions'],
        },
        src: '<%= pkg.cssPath %>/*.min.css',
      },
    },

  });

  // LOAD NPM MODULES
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-babel');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-scss-to-json');

  // DEFAULT TASK (dev by default)
  grunt.registerTask('default', ['scss_to_json', 'sass:dev', 'autoprefixer:dev', 'jshint', 'concat', 'babel', 'watch']);
  // PRODUCTION TASK (minified and distributed)
  grunt.registerTask('production', ['scss_to_json', 'sass:dist', 'autoprefixer:dist', 'jshint', 'concat', 'babel', 'uglify']);
};
