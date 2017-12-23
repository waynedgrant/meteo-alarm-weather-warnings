<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class WarningTest extends PHPUnit\Framework\TestCase {

    public function test_warning() {
        $awarness_period_html =
            '<tr>' .
                '<td width="28">' .
                    '<img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l3-t2.jpg" alt="awt:2 level:3">' .
                '</td>' .
                '<td>' .
                    '<b>From: </b><i>10.12.2017 05:00 CET</i><b> Until: </b><i>11.12.2017 00:55 CET</i>' .
                '</td>' .
            '</tr>';

        $awarness_period_dom = DOMDocument::loadHTML($awarness_period_html);
        $awarness_period_row = $awarness_period_dom->getElementsByTagName('tr')->item(0);

        $description_html =
            '<tr>' .
                '<td width="28">' .
                '</td>' .
                '<td>' .
                    'A spell of heavy snow is possible over parts of Scotland during Sunday.' .
                '</td>' .
            '</tr>';

        $description_dom = DOMDocument::loadHTML($description_html);
        $description_row = $description_dom->getElementsByTagName('tr')->item(0);

        $testee = new Warning($awarness_period_row, $description_row, 'Europe/London');
        $serialized = $testee->serialize();

        $this->assertSame(AwarenessType::SNOW_ICE, $serialized['awareness']['awareness_type']['type']);
        $this->assertSame(AwarenessLevel::AMBER, $serialized['awareness']['awareness_level']['level']);
        $this->assertSame('Sunday 04:00 GMT', $serialized['period']['from']);
        $this->assertSame('Sunday 23:55 GMT', $serialized['period']['until']);
        $this->assertSame('A spell of heavy snow is possible over parts of Scotland during Sunday.', $serialized['description']);
    }
}

?>
