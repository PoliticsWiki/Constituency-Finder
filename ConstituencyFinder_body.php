<?php
class ConstituencyFinder extends SpecialPage {
	function __construct() {
		parent::__construct( 'ConstituencyFinder' );
		wfLoadExtensionMessages('ConstituencyFinder');
	}
 
	function execute( $par ) {
		global $wgRequest, $wgOut;
		
 
		$this->setHeaders();
 
		# Get request data from, e.g.
		$param = $wgRequest->getText('param');
		
		$wgOut->addScript('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js?270"></script><link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css"><script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.js"></script> <script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script><script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAVZXUw4haIbsMG3nOaLlhrBTd6_saw5G7NbyQ9jAg4rzW0CWcoBQI6jPhyQxFcmtLquX2a9j4-0hHwg" type="text/javascript"></script>');
		$wgOut->addScriptFile("/extensions/ConstituencyFinder/maps.google.polygon.containsLatLng.js");
		$wgOut->addScriptFile("/extensions/ConstituencyFinder/ConstituencyFinder.js");
		
		$wgOut->addInlineStyle("div#popup div#map { height:400px}
			div#accordion {width: 900px}
			form#addressForm label.error { float: none; color: red; padding-left: .5em; vertical-align: top; width:auto; }
			form#addressForm ul { list-style-type: none; list-style-image:none}
			form#addressForm label {width: 150px; display:inline-block}
			form#addressForm input, form#addressForm select {width: 350px;}
			form#addressForm li { margin-bottom:3px}");
		
 
		$wgOut->addHtml(" <body> <div id=\"popup\"> <div id=\"map\"></div> <input value=\"Yes that's where I Live!\" onclick=\"RedirectToConstituency()\" id=\"redirectToConstituency\" type=\"submit\"/> </div> <div id=\"accordion\"> <h3><a href=\"#\">Enter your address in the box below</a></h3> <form id=\"addressForm\" onsubmit=\"return false\"> <ul> <li><label for=\"addressLine1\">Address Line 1</label> <input type=\"text\" id=\"addressLine1\"/></li> <li><label for=\"addressLine2\">Address Line 2</label> <input type=\"text\" id=\"addressLine2\"/></li> <li><label for=\"town\">Town</label> <input type=\"text\" id=\"town\" name=\"town\"/></li> <li> <label for=\"county\">County</label> <select id=\"county\" name=\"county\"> <option value=\"\">Please select a county...</option> <option value=\"Carlow\">Carlow</option> <option value=\"Cavan\">Cavan</option> <option value=\"Clare\">Clare</option> <option value=\"Cork\">Cork</option> <option value=\"Donegal\">Donegal</option> <option value=\"Dublin\">Dublin</option> <option value=\"Galway\">Galway</option> <option value=\"Kerry\">Kerry</option> <option value=\"Kildare\">Kildare</option> <option value=\"Kilkenny\">Kilkenny</option> <option value=\"Laois\">Laois</option> <option value=\"Leitrim\">Leitrim</option> <option value=\"Limerick\">Limerick</option> <option value=\"Longford\">Longford</option> <option value=\"Louth\">Louth</option> <option value=\"Mayo\">Mayo</option> <option value=\"Meath\">Meath</option> <option value=\"Monaghan\">Monaghan</option> <option value=\"Offaly\">Offaly</option> <option value=\"Roscommon\">Roscommon</option> <option value=\"Sligo\">Sligo</option> <option value=\"Tipperary\">Tipperary</option> <option value=\"Waterford\">Waterford</option> <option value=\"Westmeath\">Westmeath</option> <option value=\"Wexford\">Wexford</option> <option value=\"Wicklow\">Wicklow</option> </select> </li> </ul> <br/> <input value=\"Find My Constituency\" onclick=\"return GetCoordinateFromAddress()\" id=\"getCoordinateFromAddress\" type=\"submit\"/> </form> <h3><a href=\"#\">Privacy Policy</a></h3> <div> <p>The following privacy policies apply when using the Constituency Finder</p> <ul> <li><a href=\"http://www.politicswiki.ie/Politics_Wiki:Privacy_policy\">Politics Wiki Privacy Policy</a></li> <li><a href=\"http://www.google.com/privacypolicy.html\" target=\"_blank\">Google Privacy Policy</a></li> </ul> <p>Your postal address is not stored on PoliticsWiki.ie however it is sent to Google to be converted into a coordinate so we can find out what constituency you are in</p> </div> <h3><a href=\"#\">Licence Information</a></h3> <div id=\"licenseDescription\"> <p>I used the following when creating this:</p> <div id=\"sourcesList\"> <ul> <li><a href=\"http://jquery.com/\">jQuery</a> </li> <li><a href=\"http://code.google.com/apis/maps/\">Google Maps Api</a></li> <li><a href=\"http://appdelegateinc.com/blog/2010/05/16/point-in-polygon-checking/\">Point in Polygon Checking With Google Maps</a> </li> <li><a href=\"http://www.tallyroom.com.au/maps\">The Tally Room - Maps</a> - I changed their version to KML and the names of the polygons to map to urls in the wiki which are released under the same license the originals are</li> <li><a href=\"http://jqueryui.com/\">jQuery UI</a> </li> </ul> </div> <p>If you want to reuse the code for this web page, which is all written in javascript, please consult the above websites in order to find out how you can license their work. My work on this individual page but not any resources referenced by this page is available under the below license</p> <a rel=\"license\" href=\"http://creativecommons.org/licenses/by-sa/3.0/\"><img alt=\"Creative Commons Licence\" style=\"border-width:0\" src=\"http://i.creativecommons.org/l/by-sa/3.0/88x31.png\" /></a><br /><span xmlns:dct=\"http://purl.org/dc/terms/\" href=\"http://purl.org/dc/dcmitype/Text\" property=\"dct:title\" rel=\"dct:type\">Constituency Finder</span> by <a xmlns:cc=\"http://creativecommons.org/ns#\" href=\"http://www.politicswiki.ie\" property=\"cc:attributionName\" rel=\"cc:attributionURL\">PoliticsWiki.ie</a> is licensed under a <a rel=\"license\" href=\"http://creativecommons.org/licenses/by-sa/3.0/\">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>. </div> </div>");
	}
}