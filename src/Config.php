<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Config {

    private static $country;
    private static $region;
    private static $dateTimeFormat = 'l H:i T'; // e.g. Sunday 04:00 GMT
    private static $timeZone = 'Europe/London';

    public static function getCountry() {
        return self::$country;
    }

    public static function setCountry($country) {
        self::$country = $country;
    }

    public static function getRegion() {
        return self::$region;
    }

    public static function setRegion($region) {
        self::$region = $region;
    }

    public static function getDateTimeFormat() {
        return self::$dateTimeFormat;
    }

    public static function setDateTimeFormat($dateTimeFormat) {
        self::$dateTimeFormat = $dateTimeFormat;
    }

    public static function getTimeZone() {
        return self::$timeZone;
    }

    public static function setTimeZone($timeZone) {
        self::$timeZone = $timeZone;
    }
}

?>
