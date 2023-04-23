<?php

use Illuminate\Support\Str;

if (! function_exists('generateToken')) {
    function generateToken(int $length = 64): string
    {
        $random = sha1(Str::random($length) . microtime());
        return Str::limit($random, 255, '');
    }
}
