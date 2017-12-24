<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Warning {

    public function __construct($awarness_period_row, $description_row) {
        // e.g. <tr><td> ... awareness ... </td><td> ... period ... </td></tr>
        $awareness_cell = $awarness_period_row->getElementsByTagName('td')->item(0);
        $this->awareness = new Awareness($awareness_cell);

        $period_cell = $awarness_period_row->getElementsByTagName('td')->item(1);
        $this->period = new Period($period_cell);

        // e.g. <tr><td /><td> ... description ... </td></tr>
        $description_cell = $description_row->getElementsByTagName('td')->item(1);
        $this->description = new Description($description_cell);
    }

    public function serialize() {
        return [
            'awareness' => $this->awareness->serialize(),
            'period' => $this->period->serialize(),
            'description' => $this->description->text
        ];
    }
}
