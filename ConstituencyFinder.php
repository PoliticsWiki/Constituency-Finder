<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/ConstituencyFinder/ConstituencyFinder.php" );
EOT;
	exit( 1 );
}
 
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ConstituencyFinder',
	'author' => 'Stephen Lacy',
	'url' => 'http://www.politicswiki.ie/Special:ConstituencyFinder',
	'description' => 'Allows you to find your constituency using your address',
	'descriptionmsg' => 'constituencyfinder-desc',
	'version' => '0.0.0',
);
 
$dir = dirname(__FILE__) . '/';
 
$wgAutoloadClasses['ConstituencyFinder'] = $dir . 'ConstituencyFinder_body.php'; # Location of the ConstituencyFinder class (Tell MediaWiki to load this file)
$wgExtensionMessagesFiles['ConstituencyFinder'] = $dir . 'ConstituencyFinder.i18n.php'; # Location of a messages file (Tell MediaWiki to load this file)
$wgExtensionAliasesFiles['ConstituencyFinder'] = $dir . 'ConstituencyFinder.alias.php'; # Location of an alias file (Tell MediaWiki to load this file)
$wgSpecialPages['ConstituencyFinder'] = 'ConstituencyFinder'; # Tell MediaWiki about the new special page and its class name
