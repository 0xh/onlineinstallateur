module.exports = function (grunt) {

    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        opts: {
            css: {
                root: 'templates/frontOffice/default/assets/css',
                minFile: '<%= opts.css.root %>/min.css'
            },           
            less: {
                root: 'templates/frontOffice/default/assets/less',
                mainFile: '<%= opts.less.root %>/theme.less'
            },
            font: {
                root: 'templates/frontOffice/default/assets/fonts',                
                fontawesome: '<%= opts.font.root %>/fontawesome'
            },
            bower: {
                root: 'bower_components',
                fontawesome: {
                    font: '<%= opts.bower.root %>/fontawesome/fonts/*.*'
                }
            }
        },       
        less: {
            all: {
                options: {
                    paths: ['<%= opts.css.root %>']
                },
                files: {
                    '<%= opts.css.minFile %>': '<%= opts.less.mainFile %>'
                }
            }
        },
        cssmin: {
            target: {
                files: {
                    '<%= opts.css.minFile %>': '<%= opts.css.minFile %>'
                }
            }
        },
        copy: {
            all: {
                files: [                    
                    {
                        expand: true,
                        flatten: true,
                        dest: '<%= opts.font.fontawesome %>',
                        src: ['<%= opts.bower.fontawesome.font %>']
                    }
                ]
            }
        },
        watch: {            
            less: {
                files: ['<%= opts.less.root %>/*.less'],
                tasks: ['less'],
                options: {
                    spawn: false,
                    livereload: true
                }
            }
        }
    });

    grunt.registerTask('default', ['copy', 'less', 'cssmin']);

}
