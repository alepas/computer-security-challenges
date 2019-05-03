<?php

function rec_remove ($entry, $str) {
    $count = 1;
    while ($count > 0)
        $entry = str_ireplace($str, "", $entry, $count);
    return $entry;
}

function _filter($entry) {
	$entry = rec_remove($entry, " or ");
	$entry = rec_remove($entry, " and ");
	$entry = rec_remove($entry, " || ");
	$entry = rec_remove($entry, " && ");
	$entry = rec_remove($entry, "=");
	$entry = rec_remove($entry, "union");
	return $entry;
}

function filter($entry) {
	$cur = $entry;
	do {
		$prev = $cur;
		$cur = _filter($entry);
	} while ($prev !== $cur);
	return $cur;
}

?>