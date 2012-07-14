<?php
function hubinfo_button($userName = null, $repoName = null, $twitterUsername = null) {
	$randomValue = return_random_value();
	$scriptString = null;
	$scriptString .= '<div class="hubInfo" id="' . $randomValue . '"> </div>';
	$scriptString .= '<script type="text/javascript">';
	$scriptString .= 'jQuery(document).ready(function(){';
	$scriptString .= '
	var hubInfoDiv' . $randomValue . ' = jQuery("div.hubInfo#' . $randomValue . '").hubInfo({
		user: "' . $userName . '",
		repo: "' . $repoName . '"
	});';

	if(!empty($twitterUsername)) {
		$scriptString .= '
		hubInfoDiv' . $randomValue . '.on(\'render\', function() {
			jQuery(\'<a href="https://twitter.com/share" class="twitter-share-button" data-via="' . $twitterUsername . '">Tweet</a>\')
				.insertAfter("div.hubInfo#' . $randomValue . ' .repo-forks");
			!function(d,s,id){
				var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}
			}(document,"script","twitter-wjs");
		});';
	}
	$scriptString .= "});";
	$scriptString .= '</script>';
	return $scriptString;
}

function make_seed()
{
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}

function return_random_value() {
	mt_srand(make_seed());
	return mt_rand();
}
?>