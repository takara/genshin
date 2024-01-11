<?php
require_once('src/Gensin.php');
require_once('src/Calendar.php');
require_once('vendor/autoload.php');

use Carbon\Carbon;
use App\Models\Calendar;

$dryRun=false;
$opt = getopt("hd", ['help', 'dry-run'], $idx);
if (isset($opt['dry-run']) || isset($opt['d'])) {
	$dryRun=true;
}
if (isset($opt['help']) || isset($opt['h'])) {
	$exe = basename($argv[0]);
    print "{$exe} [-hd] [resin [target]]\n".
    	"\t-h --help ヘルプ\n".
    	"\t-d --dry-run ドライラン\n".
		"\tresin 現在樹脂(デフォルト：0) \n".
    	"\ttarget 到達樹脂(デフォルト：40)\n".
    	"\n";
    exit;
}

$paths = array_slice($argv, $idx);
$resin = $paths[0] ?? 0;
$target = $paths[1] ?? 40;

$time = Resin::getInstance()
	->setTarget($target)
	->calcTime($resin);
$start = date('Y/m/d H:i:s', strtotime($time) - 60*8);
$end = $time;
$week = ["日", "月", "火", "水", "木", "金", "土"];
$idx = date("w", strtotime($time));
$w = $week[$idx];
if ($dryRun) {
	print "ドライラン\n";
} else {
	$cal = new Calendar();
	$calendarId = $cal->getConfig("calendar_id");
	$cal->create($calendarId, "樹脂{$target}", $start, $end);
}

printf("現在樹脂:%3d\n", $resin);
printf("到達樹脂:%3d\n", $target);
print str_replace(" ", "($w) ", "$start") . " - " . str_replace(" ", "($w) ", "$end\n");
