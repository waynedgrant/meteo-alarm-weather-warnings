<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class DayTest extends PHPUnit\Framework\TestCase {

    public function test_today_with_one_warning() {
        $day_html =
            '<tr>' .
                '<th colspan="3" align="left">' .
                    'Today' .
                '</th>' .
            '</tr>' .
            '<tr>' .
                '<td width="28">' .
                    '<img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l3-t2.jpg" alt="awt:2 level:3">' .
                '</td>' .
                '<td>' .
                    '<b>From: </b><i>10.12.2017 05:00 CET</i><b> Until: </b><i>11.12.2017 00:55 CET</i>' .
                '</td>' .
            '</tr>' .
            '<tr>' .
                '<td width="28">' .
                '</td>' .
                '<td>' .
                    'A spell of heavy snow is possible over parts of Scotland during Sunday.' .
                '</td>' .
            '</tr>';

        $day_dom = DOMDocument::loadHTML($day_html);
        $day_rows = iterator_to_array($day_dom->getElementsByTagName('tr'));

        $testee = new Day($day_rows, 'Europe/London');

        $this->assertSame($testee->name(), 'Today');
        $this->assertSame(1, sizeof($testee->warnings()));
        $warning = $testee->warnings()[0];
        $this->assertSame(AwarenessType::SNOW_ICE, $warning->awareness()->awarenessType()->type());
        $this->assertSame(AwarenessLevel::AMBER, $warning->awareness()->awarenessLevel()->level());
        $this->assertSame('Sunday 04:00 GMT', $warning->period()->from());
        $this->assertSame('Sunday 23:55 GMT', $warning->period()->until());
        $this->assertSame('A spell of heavy snow is possible over parts of Scotland during Sunday.', $warning->description()->text());
    }

    public function test_tomorrow_with_two_warnings() {
        $day_html =
            '<tr>' .
                '<th colspan="3" align="left">' .
                    'Tomorrow' .
                '</th>' .
            '</tr>' .
            '<tr>' .
                '<td width="28">' .
                    '<img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l3-t2.jpg" alt="awt:2 level:3">' .
                '</td>' .
                '<td>' .
                    '<b>From: </b><i>11.12.2017 05:00 CET</i><b> Until: </b><i>11.12.2017 00:55 CET</i>' .
                '</td>' .
            '</tr>' .
            '<tr>' .
                '<td width="28">' .
                '</td>' .
                '<td>' .
                    'A spell of heavy snow is possible over parts of Scotland during Sunday.' .
                '</td>' .
            '</tr>' .
            '<tr>' .
                '<td width="28">' .
                    '<img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l2-t2.jpg" alt="awt:2 level:2">' .
                '</td>' .
                '<td>' .
                    '<b>From: </b><i>11.12.2017 05:00 CET</i><b> Until: </b><i>12.12.2017 12:00 CET</i>' .
                '</td>' .
            '</tr>' .
            '<tr>' .
                '<td width="28">' .
                '</td>' .
                '<td>' .
                    'Ice is expected to form across many places overnight into Monday morning.' .
                '</td>' .
            '</tr>';

        $day_dom = DOMDocument::loadHTML($day_html);
        $day_rows = iterator_to_array($day_dom->getElementsByTagName('tr'));

        $testee = new Day($day_rows, 'Europe/London');

        $this->assertSame($testee->name(), 'Tomorrow');
        $this->assertSame(2, sizeof($testee->warnings()));
    }
}

?>
