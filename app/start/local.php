<?php

//This will log all executing queries in the query.log file
Event::listen('illuminate.query', function($sql, $bindings)
{
    foreach ($bindings as $i => $val) {
        $bindings[$i] = "'$val'";
    }
    
    $sql_with_bindings = array_reduce($bindings, function ($result, $item) {
        return substr_replace($result, $item, strpos($result, '?'), 1);
    }, $sql);

    Log::info($sql_with_bindings);
});