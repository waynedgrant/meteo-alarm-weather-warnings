<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Warning {

    public function __construct($awarness_period_row, $description_row, $output_timezone) {

        $awareness_cell = $awarness_period_row->getElementsByTagName('td')->item(0);
        $this->awareness = new Awareness($awareness_cell);

        $period_cell = $awarness_period_row->getElementsByTagName('td')->item(1);
        $this->period = new Period($period_cell, $output_timezone);

        $description_cell = $description_row->getElementsByTagName('td')->item(1);
        $this->description = new Description($description_cell);
    }

    public function awareness() {
        return $this->awareness;
    }

    public function period() {
        return $this->period;
    }

    public function description() {
        return $this->description;
    }
}
