module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        dev: {
            "css": "assets/desenvolvimento/sass/",
            "cssOutput": "assets/css/",
            "js": "assets/desenvolvimento/javascript/",
            "jsOutput": "assets/js/"
        },

        sass: {
            prod: { // Target
                options: { // Target options
                    style: "compressed"
                },
                files: { // Dictionary of files
                    "<%= dev.cssOutput %>main.css": ["<%= dev.css %>default.scss"] // 'destination': 'source'                    
                }
            }
        },

        autoprefixer: {
            autoprefixer: {
                options: {
                    browsers: ['last 2 versions', 'ie 8', 'ie 9']
                },
                your_target: {
                    prod: "<%= dev.cssOutput %>main.css"
                },
            }
        },

        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                src: '<%= dev.js %>main.js',
                dest: '<%= dev.jsOutput %>main.js'
            }
        },

        watch: {
            sass: {
                files: '<%= dev.css %>*.scss',
                tasks: ['sass'],
                options: {
                    livereload: true,
                },
            },
            scripts: {
                files: '<%= dev.js %>*.js',
                tasks: ['uglify'],
                options: {
                    livereload: true,
                },
            },
        }


    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Default task(s).
    grunt.registerTask('default', ['sass', 'autoprefixer', 'uglify', 'watch']);

};