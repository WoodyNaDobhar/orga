<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:WoodyNaDobhar/orga.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('dev')
	->setHostname('chi108.greengeeks.net') // Hostname or IP address
	->set('remote_user', 'migra113') // SSH user
	->set('branch', 'development') // Git branch
	->set('deploy_path', 'www/orga'); // Deploy path

// Hooks

after('deploy:failed', 'deploy:unlock');
