<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class AwarenessType {

    const NO_WARNINGS = 0;
    const WIND = 1;
    const SNOW_ICE = 2;
    const THUNDERSTORMS = 3;
    const FOG = 4;
    const EXTREME_HIGH_TEMPERATURES = 5;
    const EXTREME_LOW_TEMPERATURES = 6;
    const COASTAL_EVENT = 7;
    const FOREST_FIRE = 8;
    const AVALANCHE = 9;
    const RAIN = 10;
    const UNAVAILABLE = 11;
    const FLOODING = 12;
    const RAIN_FLOODING = 13;

    private $descriptions = [
        'No Warnings',
        'Wind',
        'Snow/Ice',
        'Thunderstorms',
        'Fog',
        'Extreme High Temperatures',
        'Extreme Low Temperatures',
        'Costal Event',
        'Forest Fire',
        'Avalanche',
        'Rain',
        'Unavailable',
        'Flooding',
        'Rain/Flooding'
    ];

    public function __construct($type) {
        if ($type < 0 or $type >= sizeof($this->descriptions)) {
            throw new InvalidArgumentException('Awareness type ' . $type . ' is not supported.');
        }

        $this->type = $type;
        $this->description = $this->descriptions[$type];
    }

    public function serialize() {
        return [
            'type' => $this->type,
            'description' => $this->description
        ];
    }
}

?>
