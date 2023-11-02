<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/npm.php';
require 'contrib/rsync.php';

///////////////////////////////////
// Config
///////////////////////////////////

set('application', 'Orga');
set('repository', 'git@github.com:WoodyNaDobhar/orga.git'); // Git Repository
set('ssh_multiplexing', true);  // Speed up deployment
//set('default_timeout', 1000);

set('rsync_src', function () {
	return __DIR__; // If your project isn't in the root, you'll need to change this.
});
	
// Configuring the rsync exclusions.
// You'll want to exclude anything that you don't want on the server.
add('rsync', [
		'exclude' => [
				'.git',
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

task('deploy:publish', [
		'deploy:symlink2',
		'deploy:unlock',
		'deploy:cleanup',
		'deploy:success',
]);

task('deploy:symlink2', function () {
	if (get('use_atomic_symlink')) {
		run("mv -T {{deploy_path}}/release {{current_path}}");
	} else {
		// Atomic symlink does not supported.
		// Will use simple two steps switch.
		
		run("cd {{deploy_path}} && {{bin/symlink}} {{release_path}} current"); // Atomic override symlink.
		run("cd {{deploy_path}} && rm release"); // Remove release link.
	}
});
	
///////////////////////////////////
// Hosts
///////////////////////////////////
	
host('dev')
	->setHostname('chi108.greengeeks.net') // Hostname or IP address
	->set('remote_user', 'migra113') // SSH user
	->set('branch', 'development') // Git branch
	->set('deploy_path', 'www/orga'); // Deploy path
	
after('deploy:failed', 'deploy:unlock');  // Unlock after failed deploy
	
///////////////////////////////////
// Tasks
///////////////////////////////////

desc('Start of Deploy the application');

task('deploy', [
		'deploy:prepare',
		'rsync',                // Deploy code & built assets
		'deploy:secrets',       // Deploy secrets
		'deploy:vendors',
		'deploy:shared',        //
		'artisan:storage:link', //
		'artisan:view:cache',   //
		'artisan:config:cache', // Laravel specific steps
		'artisan:migrate',      //
		'artisan:queue:restart',//
		'deploy:publish',       //
]);

desc('End of Deploy the application');