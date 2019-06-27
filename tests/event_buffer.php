<?php
if (!extension_loaded("libevent")) print "skip";

function foo($buf, $arg){}

function foo2($buf, $arg)
{
	static $i;

	$i++;

	if ($i == 10) {
		event_buffer_disable($buf, EV_READ | EV_WRITE);
		event_buffer_free($buf);
		event_base_loopexit($arg);
	}

	var_dump(event_buffer_read($buf, 1024));
}

$base = event_base_new();
$b = event_buffer_new(STDOUT, "foo", NULL, "foo", $base);

event_buffer_set_callback($b, "foo", NULL, "foo", $base);
event_buffer_set_callback($b, "foo2", NULL, "foo2", $base);
event_buffer_set_callback($b, NULL, NULL, NULL, $base);
event_buffer_set_callback($b, "foo2", NULL, "foo2", $base);

var_dump(event_buffer_base_set($b, $base));
var_dump(event_buffer_fd_set($b, STDIN));
event_buffer_timeout_set($b, 30, 30);
event_buffer_watermark_set($b, EV_READ, 0, 0xffffff);
event_buffer_priority_set($b, 10);
event_buffer_enable($b, EV_READ);
event_buffer_write($b, "hello world!");

event_base_loop($base);

