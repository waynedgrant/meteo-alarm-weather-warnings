<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class RegionTest extends PHPUnit\Framework\TestCase {

    private $description_html =
        '<table border="0" cellspacing="0" cellpadding="3">' .
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
            '</tr>' .
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
                    'A spell of heavy snow is possible over parts of Scotland during Monday.' .
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
                    'Ice is expected to form across many places overnight into Tuesday morning.' .
                '</td>' .
            '</tr>' .
        '</table>';

    protected function setUp() {
        Config::setDateTimeFormat('l H:i T');
        Config::setTimezone('Europe/London');
    }

    public function test_region() {
        $item_xml =
            '<item>' .
    		    '<title>Lothian &amp; Borders</title>' .
    		    '<link>http://web.meteoalarm.eu/en_UK/0/0/UK004.html</link>' .
    		    '<description><![CDATA[' . $this->description_html . ']]></description>' .
    		    '<pubDate>Fri, 22 Dec 2017 01:00:00 +0100</pubDate>' .
    		    '<guid isPermaLink="false">418f52d19af464bc09619e79a6161d6a</guid>' .
            '</item>';

        $rss_item = simplexml_load_string($item_xml);

        $testee = new Region($rss_item);
        $serialized = $testee->serialize();

        $this->assertSame('Lothian & Borders', $serialized['name']);
        $this->assertSame('http://web.meteoalarm.eu/en_UK/0/0/UK004.html', $serialized['link']);

        $this->assertSame(1, sizeof($serialized['today']));
        $this->assertSame('A spell of heavy snow is possible over parts of Scotland during Sunday.', $serialized['today'][0]['description']);

        $this->assertSame(2, sizeof($serialized['tomorrow']));
        $this->assertSame('A spell of heavy snow is possible over parts of Scotland during Monday.', $serialized['tomorrow'][0]['description']);
        $this->assertSame('Ice is expected to form across many places overnight into Tuesday morning.', $serialized['tomorrow'][1]['description']);

        $this->assertSame('Friday 00:00 GMT', $serialized['published']);
    }

    public function test_region_with_alternative_date_time_format_and_timezone() {
        Config::setDateTimeFormat('Y-m-d H:i T');
        Config::setTimeZone('America/New_York');

        $item_xml =
            '<item>' .
    		    '<title>Lothian &amp; Borders</title>' .
    		    '<link>http://web.meteoalarm.eu/en_UK/0/0/UK004.html</link>' .
    		    '<description><![CDATA[' . $this->description_html . ']]></description>' .
    		    '<pubDate>Fri, 22 Dec 2017 01:00:00 +0100</pubDate>' .
    		    '<guid isPermaLink="false">418f52d19af464bc09619e79a6161d6a</guid>' .
            '</item>';

        $rss_item = simplexml_load_string($item_xml);

        $testee = new Region($rss_item);
        $serialized = $testee->serialize();

        $this->assertSame('2017-12-21 19:00 EST', $serialized['published']);
    }
}

?>
