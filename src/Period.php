<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Period {

    const INPUT_DATE_TIME_FORMAT = 'd.m.Y H:i T'; // e.g. 10.12.2017 05:00 CET
    const OUTPUT_DATE_TIME_FORMAT = 'l H:i T'; // e.g. Sunday 04:00 GMT

    public function __construct($period_dom, $output_timezone) {
        // e.g. <td>From: 23.10.2017 09:00 CET Until: 24.10.2017 00:00 CET</td> or <td />
        $from_until_cell = $period_dom->getElementsByTagName('td')->item(0);
        $from_until_text = $from_until_cell->textContent;

        if ($from_until_text !== '') { // From/Until not present when awareness level == NONE
            $this->parse_from_date_time($from_until_text, $output_timezone);
            $this->parse_until_date_time($from_until_text, $output_timezone);
        }
    }

    private function parse_from_date_time($from_until_text, $output_timezone) {
        // e.g. "From: 23.10.2017 09:00 CET Until: ..."
        $from_text = substr($from_until_text, 6, strpos($from_until_text, 'Until:') - 7);
        $from_date = date_create_from_format(self::INPUT_DATE_TIME_FORMAT, $from_text);
        date_timezone_set($from_date, new DateTimeZone($output_timezone));
        $this->from = $from_date->format(self::OUTPUT_DATE_TIME_FORMAT);
    }

    private function parse_until_date_time($from_until_text, $output_timezone) {
        // e.g. "From: ... Until: 24.10.2017 00:00 CET"
        $until_text = substr($from_until_text, strpos($from_until_text, 'Until: ') + 7);
        $until_date = date_create_from_format(self::INPUT_DATE_TIME_FORMAT, $until_text);
        date_timezone_set($until_date, new DateTimeZone($output_timezone));
        $this->until = $until_date->format(self::OUTPUT_DATE_TIME_FORMAT);
    }

    public function from() {
        return $this->from;
    }

    public function until() {
        return $this->until;
    }
}

?>
