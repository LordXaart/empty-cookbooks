<?php
namespace Deployer;

require_once 'recipe/common.php';
require_once 'recipe/laravel.php';

require_once __DIR__ . '/deployer/functions.php';
require_once __DIR__ . '/deployer/deploy_tasks.php';

$groups = getAvailableGroups();

foreach ($groups as $group) {
    $vars = getVars($group);

    set('keep_releases', $vars['keep_releases']);
	set('repository', $vars['repository']);
	set('ssh_type', $vars['ssh_type']);
	set('ssh_multiplexing', $vars['ssh_multiplexing']);
	set('writable_mode', $vars['writable_mode']);
	set('mysql_enabled', $vars['services']['mysql']);
    set('shared_files', $vars['shared_files']);
    
    host($vars['ansible_host'])
        ->user('root')
        ->port(22)
        ->identityFile("./.ssh/" . $vars['env'])
        ->stage($vars['env'])
        ->set('deploy_path', '/var/www/' . $vars['main_domain'])
        ->set('branch', $vars['branch']);
}
