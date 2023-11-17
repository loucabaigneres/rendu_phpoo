<?php

class Utils
{
    public static function generateRandomNumber($min, $max)
    {
        return rand($min, $max);
    }
}