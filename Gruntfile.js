/*jshint node:true */

module.exports = function( grunt ) {
	'use strict';

	require( 'matchdep' ).filterDev( 'grunt-*' ).forEach( grunt.loadNpmTasks );

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
