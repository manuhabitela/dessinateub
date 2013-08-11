module.exports = function(grunt) {
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		concat: {
			dist: {
				src: [
					'public/components/jquery/jquery.js',
					'public/components/drawingboard.js/dist/drawingboard.js',
					'public/js/fingerprint.js',
					'public/js/script.js'
				],
				dest: 'public/dist/scripts.js'
			}
		},
		uglify: {
			dist: {
				files: {
					'public/dist/scripts.min.js': ['public/dist/scripts.js']
				}
			}
		},
		cssmin: {
			dist: {
				files: {
					'public/dist/styles.min.css': ['public/components/drawingboard.js/dist/drawingboard.css', 'public/css/style.css']
				}
			}
		}
	});
	grunt.registerTask('default', ['concat', 'uglify', 'cssmin']);
};
