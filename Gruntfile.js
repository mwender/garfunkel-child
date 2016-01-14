module.exports = function(grunt) {
  require('load-grunt-tasks')(grunt); // npm install --save-dev load-grunt-tasks

  grunt.initConfig({
    copy:{
      stylecss:{
        src: '../garfunkel/style.css',
        dest: '../garfunkel/style-copy.css',
        options:{
          process: function(content, srcpath){
            content = content.replace(/url\(images/g,'url(../garfunkel/images');
            //content = content.replace('icomoon.css','icomoon-copy.css');
            //content = content.replace(/import url/g, 'import (less) url');
            //content = content.replace(/\\9/g,'');
            return content;
          }
        }
      },
      genericonscss:{
        src: '../garfunkel/genericons/genericons.css',
        dest: '../garfunkel/genericons/genericons-copy.css',
        options:{
          process: function(content, scrpath){
            content = content.replace(/url\(\"\.\//g,'url("../garfunkel/genericons/');
            return content;
          }
        }
      }
    },
    less: {
      development: {
        options: {
          compress: false,
          cleancss: false,
          optimization: 2,
          relativeUrls: true
        },
        files: {
          // target.css file: source.less file
          'main.css': 'main.less'
        }
      },
      production: {
        options: {
          compress: true,
          cleancss: true,
          optimization: 2,
          relativeUrls: true
        },
        files: {
          // target.css file: source.less file
          'main.css': 'main.less'
        }
      }
    },
    watch: {
      options: {
        livereload: true,
      },
      styles: {
        files: ['*.less'], // which files to watch
        tasks: ['copy', 'less:development'],
        options: {
          nospawn: true
        }
      }
    }
  });

  grunt.registerTask('default', ['watch']);
  grunt.registerTask('build', ['copy', 'less:production']);
  grunt.registerTask('builddev', ['copy', 'less:development']);
};