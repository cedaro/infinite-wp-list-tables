/*jshint node:true */

module.exports = function( grunt ) {
	'use strict';

	grunt.loadNpmTasks( 'grunt-wp-i18n' );

	grunt.initConfig({
		pkg: grunt.file.readJSON( 'package.json' ),

		makepot: {
			plugin: {
				options: {
					mainFile: 'infinite-wp-list-tables.php',
					potHeaders: {
						poedit: true,
						'Report-Msgid-Bugs-To': '<%= pkg.bugs.url %>'
					},
					type: 'wp-plugin',
					updateTimestamp: false
				}
			}
		}

	});

};
