<?php

namespace Deployer;

task('success_update', function () {
    writeln('<info>Successfully updated!</info>');
});

task('artisan:optimize', function () {
    // missed
})->desc('Miss optimize');

task('artisan:key:generate', function () {
    run('{{bin/php}} {{release_path}}/artisan key:generate');
})->desc('Miss optimize');

task('artisan:migrate', function () {
	if (get('mysql_enabled')) {
	    run('{{bin/php}} {{release_path}}/artisan migrate --force');
	}
});

task('artisan:db:seed', function () {
	if (get('mysql_enabled')) {
    	$output = run('{{bin/php}} {{release_path}}/artisan db:seed --force');
    	writeln('<info>' . $output . '</info>');
	}
});

task('artisan:migrate:fresh', function () {
	if (get('mysql_enabled')) {
    	run('{{bin/php}} {{release_path}}/artisan migrate:fresh --force');
    }
});

task('artisan:clear:all', function () {
    run('{{bin/php}} {{release_path}}/artisan cache:clear');
    run('{{bin/php}} {{release_path}}/artisan config:cache');
    run('{{bin/php}} {{release_path}}/artisan view:clear');
    try {
    	run('{{bin/php}} {{release_path}}/artisan route:cache');	
    } catch (\Exception $e) {
    	unset($e);
    }
})->desc('Clear all cache');

task('permissions', function () {
    run('sudo chown -R www-data.www-data {{deploy_path}}');
});

// release
task('release', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:key:generate',
    'artisan:storage:link',
    'artisan:clear:all',
    'artisan:migrate',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);

task('update', [
    'deploy:info',
    'deploy:update_code',
    'deploy:vendors',
    'artisan:clear:all',
]);

// other tasks
after('deploy:symlink', 'permissions');
after('release', 'success');
after('release', 'success_update');
after('artisan:migrate', 'artisan:db:seed');

fail('release', 'deploy:unlock');
fail('artisan:migrate', '');
