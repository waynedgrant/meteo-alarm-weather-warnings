<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class AwarenessLevel {

    const WHITE = 0;
    const GREEN = 1;
    const YELLOW = 2;
    const AMBER = 3;
    const RED = 4;

    private $colours = ['White', 'Green', 'Yellow', 'Amber', 'Red'];
    private $descriptions = [
        'Unknown',
        'No particular awareness of the weather is required.',
        'The weather is potentially dangerous. The weather phenomena that have been forecast are not unusual, but be attentive if you intend to practice activities exposed to meteorological risks. Keep informed about the expected meteorological conditions and do not take any avoidable risk.',
        'The weather is dangerous. Unusual meteorological phenomena have been forecast. Damage and casualties are likely to happen. Be very vigilant and keep regularly informed about the detailed expected meteorological conditions. Be aware of the risks that might be unavoidable. Follow any advice given by your authorities.',
        'The weather is very dangerous. Exceptionally intense meteorological phenomena have been forecast. Major damage and accidents are likely, in many cases with threat to life and limb, over a wide area. Keep frequently informed about detailed expected meteorological conditions and risks. Follow orders and any advice given by your authorities under all circumstances, be prepared for extraordinary measures.'
    ];

    public function __construct($level) {
        if ($level < 0 or $level >= sizeof($this->colours)) {
            throw new InvalidArgumentException('Awareness level ' . $level . ' is not supported.');
        }

        $this->level = $level;
        $this->colour = $this->colours[$level];
        $this->description = $this->descriptions[$level];
    }

    public function serialize() {
        return [
            'level' => $this->level,
            'colour' => $this->colour,
            'description' => $this->description
        ];
    }
}

?>
