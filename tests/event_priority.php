<?php
if (!extension_loaded("libevent")) print "skip";

function foo($fd, $events, $arg)
{
	static $i;

	$i++;

	if ($i == 3) {
		event_base_loopexit($arg[1]);
	}
	var_dump("$fd foo $i");
	var_dump(fread($fd, 1000));
}

$base = event_base_new();
var_dump(event_base_priority_init($base, 20));

$e = event_new();
$fd = STDOUT;
event_set($e, $fd, EV_READ | EV_PERSIST, "foo", array($e, $base));
event_base_set($e, $base);
event_add($e, 10);
var_dump(event_priority_set($e, 10));
fwrite($fd, "hello event!");

event_base_loop($base);
