<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Period {

    const DATE_TIME_FORMAT = 'd.m.Y H:i T'; // e.g. 10.12.2017 05:00 CET

    public function __construct($period_cell) {
        /* e.g. <td><b>From: </b><i>10.12.2017 05:00 CET</i><b> Until: </b><i>11.12.2017 00:55 CET</i></td>
             or <td /> if there is no period, i.e. when awareness level == NO_WARNINGS */

        if (trim($period_cell->textContent) !== '') {
            $from_date_text = $period_cell->getElementsByTagName('i')->item(0)->textContent;
            $until_date_text = $period_cell->getElementsByTagName('i')->item(1)->textContent;

            $this->from = $this->parseDateTime($from_date_text);
            $this->until = $this->parseDateTime($until_date_text);
        }
    }

    private function parseDateTime($date_text) {
        $date = date_create_from_format(self::DATE_TIME_FORMAT, $date_text);
        date_timezone_set($date, new DateTimeZone(Config::getTimeZone()));
        return $date->format(Config::getDateTimeFormat());
    }

    public function serialize() {
        return [
            'from' => $this->from,
            'until' => $this->until
        ];
    }
}

?>
