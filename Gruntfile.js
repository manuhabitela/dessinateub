module.exports = function(grunt) {
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		concat: {
			src: [
				'public_html/js/script.js'
			],
			dest: 'public_html/dist/scripts.js'
		},
		uglify: {
			files: {
				'public_html/dist/scripts.min.js': ['public_html/dist/scripts.js']
			}
		},
		cssmin: {
			dist: {
				files: {
					'public_html/dist/styles.min.css': ['public_html/css/style.css']
				}
			}
		}
	});
	grunt.registerTask('default', ['concat', 'uglify', 'cssmin']);
};
