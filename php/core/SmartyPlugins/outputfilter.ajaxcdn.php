<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @version $Id: outputfilter.ajaxcdn.php 6300 2012-05-23 21:19:25Z SteveG $
 * 
 * @category Piwik
 * @package SmartyPlugins
 */

/**
 * Smarty AJAX Libraries CDN outputfilter plugin
 *
 * File:     outputfilter.ajaxcdn.php<br>
 * Type:     outputfilter<br>
 * Name:     ajaxcdn<br>
 * Date:     Oct 13, 2009<br>
 * Purpose:  use AJAX Libraries Content Distribution Network<br>
 * Install:  Drop into the plugin directory, call
 *           <code>$smarty->load_filter('output','ajaxcdn');</code>
 *           from application.
 *
 * @param string
 * @param Smarty
 * @return mixed
 */
function smarty_outputfilter_ajaxcdn($source, &$smarty)
{
	$jquery_version = Piwik_Config::getInstance()->General['jquery_version'];
	$jqueryui_version = Piwik_Config::getInstance()->General['jqueryui_version'];
	$swfobject_version = Piwik_Config::getInstance()->General['swfobject_version'];

	$pattern = array(
		'~<link rel="stylesheet" type="text/css" href="libs/jquery/themes/([^"]*)" />~',
		'~<script type="text/javascript" src="libs/jquery/jquery\.js([^"]*)">~',
		'~<script type="text/javascript" src="libs/jquery/jquery-ui\.js([^"]*)">~',
		'~<script type="text/javascript" src="libs/jquery/jquery-ui-18n\.js([^"]*)">~',
		'~<script type="text/javascript" src="libs/swfobject/swfobject\.js([^"]*)">~',
	);

	// IE7 and IE8 bug: downloads css twice if scheme not specified
	$requestMethod = Piwik_Url::getCurrentScheme();
	$replace = array(
		'<link rel="stylesheet" type="text/css" href="'.$requestMethod.'://ajax.googleapis.com/ajax/libs/jqueryui/'.$jqueryui_version.'/themes/\\1" />',
		'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/'.$jquery_version.'/jquery.min.js">',
		'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/'.$jqueryui_version.'/jquery-ui.min.js">',
		'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/'.$jqueryui_version.'/i18n/jquery-ui-18n.min.js">',
		'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/swfobject/'.$swfobject_version.'/swfobject.js">',
	);

	return preg_replace($pattern, $replace, $source);
}
