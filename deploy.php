<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/npm.php';
require 'deploy/npm.php';

// Config

set('repository', 'git@github.com:vladimirbalin/e-com-laravel.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
host('151.248.126.31')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/var/www/html');

// Hooks

after('deploy:failed', 'deploy:unlock');
after('deploy:update_code', 'npm:install');
after('npm:install', 'npm:build');
