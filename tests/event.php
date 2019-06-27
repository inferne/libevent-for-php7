<?php
if (!extension_loaded("libevent")) print "skip";

function foo($fd, $events, $arg)
{
	static $i;

	$i++;

	if ($i == 3) {
		event_base_loopexit($arg[1]);
		event_del($arg[0]);
		event_free($arg[0]);
	}
	$r = fread($fd, 1000);
	var_dump($r);
}

$base = event_base_new();
$event = event_new();

$fd = STDOUT;

event_set($event, $fd, EV_READ | EV_PERSIST, "foo", array($event, $base));
event_set($event, $fd, EV_READ | EV_PERSIST, "foo", array($event, $base));
event_base_set($event, $base);
event_add($event, 10);

event_base_loop($base);
