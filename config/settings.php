<?php
return array(
	/**
	 * Which type of store to use.
	 * 
	 * Valid options are 'json' and 'database'.
	 */
	'store' => 'json',

	/**
	 * If the json store is used, give the full path to the .json file
	 * that the store writes to.
	 */
	'path' => base_path().'/config/settings.json',

	/**
	 * If the database store is used, give the name of the database
	 * table to use.
	 */
	'table' => 'settings',
);
