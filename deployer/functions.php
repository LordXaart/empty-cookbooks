<?php

use Symfony\Component\Yaml\Yaml;

function parseYAML(string $file): array
{
	if (!file_exists($file)) {
		throw new \Exception("File $file not exists");
	}

	return Yaml::parse(file_get_contents($file));
}

function getVars(string $group): array
{
	if ($group !== 'all') {
		$baseVars = getVars('all');
	} else {
		$baseVars = [];
	}

	$vars = parseYAML(__DIR__ . '/../group_vars/' . $group . '.yaml');

	if (!is_array($vars)) {
		throw new \Exception("Group $group is not array");
	}

	return array_merge($baseVars, $vars) ?? [];
}

function getAvailableGroups(): array
{
	$files = scandir(__DIR__ . '/../group_vars/');

	$files = array_filter($files, function ($value) {
		return $value !== 'all.yaml' && strpos($value, '.yaml');
	});

	$groups = array_map(function ($item) {
		return str_replace('.yaml', '', $item);
	}, $files);

	return array_values($groups);
}