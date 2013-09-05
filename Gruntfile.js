module.exports = function(grunt) {
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	var pkg = grunt.file.readJSON('package.json');
	var config = {
		concat: {
			dist: {
				src: [
					'public/components/jquery/jquery.js',
					'public/components/drawingboard.js/dist/drawingboard.js',
					'public/components/moment/moment.js',
					'public/components/moment/min/lang/fr.js',
					'public/components/color-thief/js/color-thief.js',
					'public/js/fingerprint.js',
					'public/js/detect.js',
					'public/js/script.js'
				]
			}
		},
		uglify: { dist: { files: {} } },
		cssmin: { dist: { files: {}	} }
	};
	config.concat.dist.dest = 'public/dist/js/scripts.' + pkg.version + '.js';
	config.uglify.dist.files['public/dist/js/scripts.' + pkg.version + '.min.js'] = ['public/dist/js/scripts.' + pkg.version + '.js'];
	config.cssmin.dist.files['public/dist/css/styles.' + pkg.version + '.min.css'] = ['public/components/drawingboard.js/dist/drawingboard.css', 'public/css/style.css'];
	config.cssmin.dist.files['public/dist/css/fonts.' + pkg.version + '.min.css'] = ['public/css/fonts.css'];

	grunt.initConfig(config);
	grunt.registerTask('default', ['concat', 'uglify', 'cssmin']);
};
