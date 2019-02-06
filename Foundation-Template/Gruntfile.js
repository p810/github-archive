module.exports = function (grunt) {
    grunt.initConfig({
        compass: {
            dev: {
                options: {
                    config:  'config.rb',
                    sassDir: 'sass',
                    cssDir:  'css'
                }
            }
        },

        sass: {
            dist: {
                options: {
                    loadPath: ['node_modules/foundation-sites/scss']
                }
            }
        },

        watch: {
            compass: {
                files: ['**/*.{scss,sass}'],
                tasks: ['compass:dev', 'cssmin']
            }
        },

        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd:    'css',
                    src:    ['*.css', '!*.min.css'],
                    dest:   'css',
                    ext:    '.min.css'
                }]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.registerTask('default', ['compass:dev', 'watch']);
}
