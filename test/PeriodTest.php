<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class PeriodTest extends PHPUnit\Framework\TestCase {

    public function test_period_present() {

        $period_html =
            '<td>' .
                '<b>From: </b><i>10.12.2017 05:00 CET</i><b> Until: </b><i>11.12.2017 00:55 CET</i>' .
            '</td>';

        $period_dom = DOMDocument::loadHTML($period_html);
        $period_cell = $period_dom->getElementsByTagName('td')->item(0);

        $testee = new Period($period_cell, 'Europe/London');

        $this->assertSame('Sunday 04:00 GMT', $testee->from());
        $this->assertSame('Sunday 23:55 GMT', $testee->until());
    }

    public function test_no_period_present() {

        $period_html = '<td width="28"></td>';

        $period_dom = DOMDocument::loadHTML($period_html);
        $period_cell = $period_dom->getElementsByTagName('td')->item(0);

        $testee = new Period($period_cell, 'Europe/London');

        $this->assertNull($testee->from());
        $this->assertNull($testee->until());
    }
}

?>
