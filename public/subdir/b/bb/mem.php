<?php

if (preg_match('/^MemTotal: +(\d+ *kB)$/m', file_get_contents('/proc/meminfo'), $matches)) {
	error_log($matches[1]);
}
