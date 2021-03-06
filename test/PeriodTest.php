<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class PeriodTest extends PHPUnit\Framework\TestCase {

    protected function setUp() {
        Config::setDateTimeFormat('l H:i T');
        Config::setTimezone('Europe/London');
    }

    public function test_period_present() {
        $period_html =
            '<td>' .
                '<b>From: </b><i>10.12.2017 05:00 CET</i><b> Until: </b><i>11.12.2017 00:55 CET</i>' .
            '</td>';

        $period_dom = DOMDocument::loadHTML($period_html);
        $period_cell = $period_dom->getElementsByTagName('td')->item(0);

        $testee = new Period($period_cell);
        $serialized = $testee->serialize();

        $this->assertSame('Sunday 04:00 GMT', $serialized['from']);
        $this->assertSame('Sunday 23:55 GMT', $serialized['until']);
    }

    public function test_period_with_alternative_date_time_format_and_timezone() {
        Config::setDateTimeFormat('Y-m-d H:i T');
        Config::setTimeZone('America/New_York');

        $period_html =
            '<td>' .
                '<b>From: </b><i>10.12.2017 05:00 CET</i><b> Until: </b><i>11.12.2017 00:55 CET</i>' .
            '</td>';

        $period_dom = DOMDocument::loadHTML($period_html);
        $period_cell = $period_dom->getElementsByTagName('td')->item(0);

        $testee = new Period($period_cell);
        $serialized = $testee->serialize();

        $this->assertSame('2017-12-09 23:00 EST', $serialized['from']);
        $this->assertSame('2017-12-10 18:55 EST', $serialized['until']);
    }

    public function test_no_period_present() {
        $period_html = '<td width="28"></td>';

        $period_dom = DOMDocument::loadHTML($period_html);
        $period_cell = $period_dom->getElementsByTagName('td')->item(0);

        $testee = new Period($period_cell);
        $serialized = $testee->serialize();

        $this->assertNull($serialized['from']);
        $this->assertNull($serialized['until']);
    }
}

?>
