<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Day {

    public function __construct($day_rows, $output_timezone) {
        $this->name = $day_rows[0]->getElementsByTagName('th')->item(0)->textContent;

        $this->warnings = array();

        for ($i = 1; ($i + 2) <= sizeof($day_rows); $i+=2) {
            array_push($this->warnings, new Warning($day_rows[$i], $day_rows[$i+1], $output_timezone));
        }
    }

    public function name() {
        return $this->name;
    }

    public function warnings() {
        return $this->warnings;
    }
}
