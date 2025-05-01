<?php
namespace Deployer;

require 'recipe/common.php';

desc('Run NPM install and build');
task('deploy:build_assets', function () {
	within('{{release_path}}', function () {

		// Ensure the correct Node version is installed
		run('export NVM_DIR="$HOME/.nvm" && [ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh" && nvm install');

		// Install NPM dependencies
		run('export NVM_DIR="$HOME/.nvm" && [ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh" && nvm exec npm install');

		// Run production build
		run('export NVM_DIR="$HOME/.nvm" && [ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh" && nvm exec npm run prod');
	});
});

// Config

set('repository', 'git@github.com:LukeIndulge/deployer-example.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('chipmunk.indulgemedia.co.uk')
	->setRemoteUser('bcbgroup')
	->setDeployPath('/home/bcbgroup/test');

// Hooks

after('deploy:failed', 'deploy:unlock');
after('deploy:update_code', 'deploy:vendors');
after('deploy:vendors', 'deploy:build_assets');
