<?php

namespace Deployer;

// Include the Laravel & rsync recipes
require 'recipe/laravel.php';
require 'recipe/rsync.php';

set('application', 'ORK4');
set('ssh_multiplexing', true); // Speed up deployment

set('rsync_src', function () {
	return __DIR__; // If your project isn't in the root, you'll need to change this.
});
	
// Configuring the rsync exclusions.
// You'll want to exclude anything that you don't want on the production server.
add('rsync', [
		'exclude' => [
				'.git',
				'/.env',
				'/storage/',
				'/vendor/',
				'/node_modules/',
				'.github',
				'deploy.php',
				'/etc/'
		],
]);

// Set up a deployer task to copy secrets to the server.
// Grabs the dotenv file from the github secret
task('deploy:secrets', function () {
	file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
	upload('.env', get('deploy_path') . '/shared');
});

// Hosts

host('dev')
	->setHostname('chi201.greengeeks.net') // Hostname or IP address
	->set('remote_user', 'orkorg') // SSH user
	->set('stage', 'development')
	->set('branch', 'development')// Git branch
	->set('deploy_path', '~/www/dev.ork4.org'); // Deploy path

// Hooks

after('deploy:failed', 'deploy:unlock');
