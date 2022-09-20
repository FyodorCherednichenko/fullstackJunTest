<?php
# Можно использовать список:

$list = array(
    '09:00-11:00',
    '11:00-13:00',
    '15:00-16:00',
    '17:00-20:00',
    '20:30-21:30',
    '21:30-22:30',
);


function time_interval_check(string $interval): bool
{
    if (!preg_match("/([01]\d|2[0-3]):[0-5]\d-([01]\d|2[0-3]):[0-5]\d/", $interval)) {
        return false;
    }

    $interval_part = explode('-', $interval);

    if (strtotime($interval_part[0]) > strtotime($interval_part[1])) {
        return false;
    }

    return true;
}


function add_interval(array $intervals, string $interval): bool
{
    if (!preg_match("/([01]\d|2[0-3]):[0-5]\d-([01]\d|2[0-3]):[0-5]\d/", $interval)) {
        return false;
    }

    $interval = explode('-', $interval);
    foreach ($intervals as $each_interval) {
        $each_interval = explode('-', $each_interval);

        if ((strtotime($interval[0]) >= strtotime($each_interval[0])) && ((strtotime($interval[0]) < strtotime($each_interval[1])))) {
            return false;
        } elseif ((strtotime($interval[1]) >= strtotime($each_interval[0])) && ((strtotime($interval[1]) < strtotime($each_interval[1])))) {
            return false;
        }
    }

    return true;
}

var_dump(time_interval_check($argv[1]));
var_dump(add_interval($list, $argv[1]));
