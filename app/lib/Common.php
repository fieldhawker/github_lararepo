<?php namespace app\lib;


class Common
{
    public static function test($num) {
        $parts = 'abcefghijklmnopqrstuvwxyz1234567890';
        return substr(str_shuffle($parts), 0, $num);
    }
}