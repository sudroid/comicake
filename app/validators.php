<?php

Validator::extend('alpha_symbols', function($attribute, $value)
{
    return preg_match('/^[\w\d]+[!@#$%]+/', $value);
});

