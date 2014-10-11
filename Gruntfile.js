module.exports = function(grunt){
    'use strict';

    // banner
    grunt.log.writeln("");
    grunt.log.writeln("   <<<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>");
    grunt.log.writeln("");
    grunt.log.writeln("       Just what do you think you're doing, Matthias?    ");
    grunt.log.writeln("");
    grunt.log.writeln("   <<<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>");
    grunt.log.writeln("");

    // Grunt config
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // less
        less: {
            dist: {
                options: {
                    compress: true,
                    cleancss: true,
                    report: 'min'
                },
                files: {
                    'badged/admin/assets/css/badged.min.css' : 'badged/admin/assets/less/badged.less',
                    'badged/admin/assets/css/badged-ios6.min.css' : 'badged/admin/assets/less/badged-ios6.less',
                    'badged/admin/assets/css/admin.min.css' : 'badged/admin/assets/less/admin.less',
                },
            },
        },

        // image optimization
        imagemin: {
            dist: {
                options: {
                    optimizationLevel: 7
                },
                files: [
                    {
                        expand: true,
                        cwd: 'badged/admin/assets/img/',
                        src: ['**/*.{png,jpg,jpeg,gif}'],
                        dest: 'badged/admin/assets/img/'
                    },
                    {
                        expand: true,
                        cwd: 'assets/',
                        src: ['**/*.{png,jpg,jpeg,gif}'],
                        dest: 'assets/'
                    }
                ]
            }
        },
        
        // svg optimization
        svgmin: {
            dist: {
                files: [
                    {
                        expand: true,
                        cwd: 'badged/admin/assets/img/',
                        src: ['**/*.svg'],
                        dest: 'badged/admin/assets/img/'
                    },
                    {
                        expand: true,
                        cwd: 'assets/',
                        src: ['**/*.svg'],
                        dest: 'assets/'
                    }
                ]
            }
        },

        // watch
        watch: {
            less: {
                files: ['badged/admin/assets/less/*.less'],
                tasks: ['less']
            }
        }

    });

    // Load NPM Tasks, smart code stolen from @bluemaex <https://github.com/bluemaex>
    require('fs').readdirSync('node_modules').filter(function (file) {
        return file && file.indexOf('grunt-') > -1;
    }).forEach(function (file) {
        grunt.loadNpmTasks(file);
    });

    // Default Task
    grunt.registerTask('default', [
        'watch'
    ]);

    // Dev server
    grunt.registerTask('server', [
        'less',
        'watch'
    ]);

    // Production build
    grunt.registerTask('build', [
        'imagemin',
        'svgmin',
        'less'
    ]);

};