<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Period {

    const INPUT_DATE_TIME_FORMAT = 'd.m.Y H:i T'; // e.g. 10.12.2017 05:00 CET
    const OUTPUT_DATE_TIME_FORMAT = 'l H:i T'; // e.g. Sunday 04:00 GMT

    public function __construct($period_cell, $output_timezone) {
        /* e.g. <td><b>From: </b><i>10.12.2017 05:00 CET</i><b> Until: </b><i>11.12.2017 00:55 CET</i></td>
             or <td /> if there is no period, i.e. when awareness level == NONE */

        if ($period_cell->textContent !== '') {
            $from_date_text = $period_cell->getElementsByTagName('i')->item(0)->textContent;
            $until_date_text = $period_cell->getElementsByTagName('i')->item(1)->textContent;

            $this->from = $this->parse_date_time($from_date_text, $output_timezone);
            $this->until = $this->parse_date_time($until_date_text, $output_timezone);
        }
    }

    private function parse_date_time($date_text, $output_timezone) {
        $date = date_create_from_format(self::INPUT_DATE_TIME_FORMAT, $date_text);
        date_timezone_set($date, new DateTimeZone($output_timezone));
        return $date->format(self::OUTPUT_DATE_TIME_FORMAT);
    }

    public function from() {
        return $this->from;
    }

    public function until() {
        return $this->until;
    }
}

?>
