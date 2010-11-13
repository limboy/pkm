<?php
require 'markdown.php';

preg_match_all('/{{{(.*)}}}/sU', file_get_contents('data.txt'), $matches);

if (!empty($matches[1])) {
	$data = array();
	$latest_cnts = array();
	foreach (array_reverse($matches[1]) as $i => $item) {
		$tags_content = explode(PHP_EOL, $item, 2);
		$tags = $tags_content[0];
		$content = $tags_content[1];
		if ($i < 10) {
			$latest_cnts[] = array($tags, $content);
		}
		foreach(explode(' ', $tags) as $tag) {
			if (empty($tag))
				continue;
			$data[$tag][] = $content."<br />tag: ".$tags;
		}
	}
}

uasort($data, function($a, $b){
	return (count($a) > count($b)) ? 0 : 1;
});

$data = json_encode($data);
$latest_cnts = json_encode($latest_cnts);

require 'view.php';
