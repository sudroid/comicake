<?php
//Custom validation for alpha numerica and symbols
//Created for password input
Validator::extend('alpha_symbols', function($attribute, $value)
{
    return preg_match('/^[\w\d]+[!@#$%]+/', $value);
});

