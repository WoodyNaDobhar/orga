<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/php-fpm.php';
require 'contrib/npm.php';

set('application', 'Orga');
set('repository', 'git@github.com:WoodyNaDobhar/orga.git'); // Git Repository
set('php_fpm_version', '8.2');
set('ssh_multiplexing', true);  // Speed up deployment
	
host('dev')
	->setHostname('chi108.greengeeks.net') // Hostname or IP address
	->set('remote_user', 'migra113') // SSH user
	->set('branch', 'development') // Git branch
	->set('deploy_path', 'www/orga.interquestonline.com'); // Deploy path
	
task('deploy', [
		'deploy:prepare',
		'deploy:vendors',
		'artisan:storage:link',
		'artisan:view:cache',
		'artisan:config:cache',
		'artisan:migrate',
		'npm:install',
		'npm:run:prod',
		'deploy:publish',
		'php-fpm:reload',
]);
	
task('npm:run:prod', function () {
	cd('{{release_or_current_path}}');
	run('npm run prod');
});
	
after('deploy:failed', 'deploy:unlock');