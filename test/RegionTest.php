<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class RegionTest extends PHPUnit\Framework\TestCase {

    public function test_region() {
        $item_xml =
            '<item>' .
			    '<title>Lothian &amp; Borders</title>' .
			    '<link>http://web.meteoalarm.eu/en_UK/0/0/UK004.html</link>' .
			    '<description><![CDATA[<table border="0" cellspacing="0" cellpadding="3"><tr><th colspan="3" align="left">Today</th></tr><tr><td width="28"><img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l1-t10.jpg" alt="awt:10 level:1"></td></tr><tr><td width="28"></td><td>No special awareness required</td></tr><tr><th colspan="3" align="left"><br />Tomorrow</th></tr><tr><td width="28"><img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l1-t10.jpg" alt="awt:10 level:1"></td></tr><tr><td width="28"></td><td>No special awareness required</td></tr></table>]]></description>' .
			    '<pubDate>Fri, 22 Dec 2017 01:00:00 +0100</pubDate>' .
			    '<guid isPermaLink="false">418f52d19af464bc09619e79a6161d6a</guid>' .
            '</item>';

        $rss_item = simplexml_load_string($item_xml);

        $testee = new Region($rss_item, 'Europe/London');

        $this->assertSame('Lothian & Borders', $testee->name());
        $this->assertSame('http://web.meteoalarm.eu/en_UK/0/0/UK004.html', $testee->link());
        $this->assertSame(1, sizeof($testee->today()));
        $this->assertSame(1, sizeof($testee->tomorrow()));
        $this->assertSame('Friday 00:00 GMT', $testee->published());
    }
}

?>
