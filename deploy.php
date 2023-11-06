<?php

namespace Deployer;

// Include the Laravel & rsync recipes
require 'recipe/laravel.php';
require 'contrib/rsync.php';

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
set('forward_agent', false);
set('http_user', 'orkorg');
host('dev')
	->setHostname('chi201.greengeeks.net') // Hostname or IP address
	->set('remote_user', 'orkorg') // SSH user
	->set('stage', 'development')
	->set('repository', 'git@github.com:WoodyNaDobhar/orga.git')
	->set('branch', 'development')// Git branch
	->set('deploy_path', '~/www/dev.ork4.org')
	->set('writable_mode', 'chmod');

// Hooks

after('deploy:failed', 'deploy:unlock');
