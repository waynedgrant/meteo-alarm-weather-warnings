<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class WarningsTest extends PHPUnit\Framework\TestCase {

    protected function setUp() {
        Config::setCountry('UK');
    }

    public function test_warnings_for_country() {
        $rss_xml =
            '<?xml version="1.0" encoding="utf-8" ?>' .
            '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' .
            	'<channel>' .
            		'<atom:link href="http://meteoalarm.eu/documents/rss/uk.rss" rel="self" type="application/rss+xml"/>' .
            		'<title>Meteoalarm United Kingdom</title>' .
            		'<link>http://web.meteoalarm.eu/en_UK/0/0/UK.html</link>' .
            		'<description>Metoalarm actual warnings from United Kingdom</description>' .
            		'<ttl>10</ttl>' .
            		'<language>eng</language>' .
            		'<item>' .
            			'<title>United Kingdom</title>' .
            			'<link>http://web.meteoalarm.eu/en_UK/0/0/UK.html</link>' .
            			'<description><![CDATA[<table border="0" cellspacing="0" cellpadding="3"><tr><th colspan="3" align="left">Today</th><td width="28">&nbsp;&nbsp;</td><th colspan="3" align="left">Tomorrow</th></tr><tr><td width="28"><img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l1-t10.jpg" alt="awt:10 level:1"></td><td width="28"></td><td width="28"></td><td width="28">&nbsp;&nbsp;</td><td width="28"><img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l1-t10.jpg" alt="awt:10 level:1"></td><td width="28"></td><td width="28"></td></tr></table>]]></description>' .
            			'<pubDate>Fri, 22 Dec 2017 01:00:00 +0100</pubDate>' .
            			'<guid isPermaLink="false">1fe7d2aa271d77e37ba7f402e32ed7a2</guid>' .
            		'</item>' .
            		'<item>' .
            			'<title>Dumfries and Galloway</title>' .
            			'<link>http://web.meteoalarm.eu/en_UK/0/0/UK006.html</link>' .
            			'<description><![CDATA[<table border="0" cellspacing="0" cellpadding="3"><tr><th colspan="3" align="left">Today</th></tr><tr><td width="28"><img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l1-t5.jpg" alt="awt:5 level:1"></td></tr><tr><td width="28"></td><td>No special awareness required</td></tr><tr><th colspan="3" align="left"><br />Tomorrow</th></tr><tr><td width="28"><img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l1-t5.jpg" alt="awt:5 level:1"></td></tr><tr><td width="28"></td><td>No special awareness required</td></tr></table>]]></description>' .
            			'<pubDate>Fri, 22 Dec 2017 01:00:00 +0100</pubDate>' .
            			'<guid isPermaLink="false">1bda31bcc0ead6ce748cc1e39fa249a1</guid>' .
            		'</item>' .
            		'<item>' .
            			'<title>Lothian &amp; Borders</title>' .
            			'<link>http://web.meteoalarm.eu/en_UK/0/0/UK004.html</link>' .
            			'<description><![CDATA[<table border="0" cellspacing="0" cellpadding="3"><tr><th colspan="3" align="left">Today</th></tr><tr><td width="28"><img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l1-t10.jpg" alt="awt:10 level:1"></td></tr><tr><td width="28"></td><td>No special awareness required</td></tr><tr><th colspan="3" align="left"><br />Tomorrow</th></tr><tr><td width="28"><img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l1-t10.jpg" alt="awt:10 level:1"></td></tr><tr><td width="28"></td><td>No special awareness required</td></tr></table>]]></description>' .
            			'<pubDate>Fri, 22 Dec 2017 01:00:00 +0100</pubDate>' .
            			'<guid isPermaLink="false">418f52d19af464bc09619e79a6161d6a</guid>' .
            		'</item>' .
            	'</channel>' .
            '</rss>';

        $rss = simplexml_load_string($rss_xml);

        $testee = new Warnings($rss);
        $serialized = $testee->serialize();

        $this->assertSame('UK', $serialized['country']);
        $this->assertSame(2, sizeof($serialized['regions']));
        $this->assertSame('Dumfries and Galloway', $serialized['regions'][0]['name']);
        $this->assertSame('Lothian & Borders', $serialized['regions'][1]['name']);
    }

    public function test_warnings_for_single_region() {
        $rss_xml =
            '<?xml version="1.0" encoding="utf-8" ?>' .
            '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' .
            	'<channel>' .
                    '<atom:link href="http://meteoalarm.eu/documents/rss/uk/UK002.rss" rel="self" type="application/rss+xml"/>' .
                    '<title>Meteoalarm United Kingdom, Highland &amp; Islands</title>' .
                    '<link>http://web.meteoalarm.eu/en_UK/0/0/UK002.html</link>' .
                    '<description>Metoalarm actual warnings from United Kingdom, Highland &amp; Islands</description>' .
                    '<ttl>10</ttl>' .
                    '<language>eng</language>' .
                    '<item>' .
                        '<title>Highlands &amp; Islands</title>' .
                        '<link>http://web.meteoalarm.eu/en_UK/0/0/UK002.html</link>' .
                        '<description><![CDATA[<table border="0" cellspacing="0" cellpadding="3"><tr><th colspan="3" align="left">Today</th></tr><tr><td width="28"><img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l1-t5.jpg" alt="awt:5 level:1"></td></tr><tr><td width="28"></td><td>No special awareness required</td></tr><tr><th colspan="3" align="left"><br />Tomorrow</th></tr><tr><td width="28"><img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l2-t10.jpg" alt="awt:10 level:2"></td><td><b>From: </b><i>24.12.2017 01:05 CET</i><b> Until: </b><i>25.12.2017 00:55 CET</i></td></tr><tr><td width="28"></td><td>Heavy rain will affect western parts of Scotland at times during Saturday night and Sunday. Spray and flooding on roads will probably make journey times longer. This will probably also cause delays to bus and train services. There is a chance that a few homes and businesses could be flooded. This warning has been updated to extend it further east.</td></tr></table>]]></description>' .
                        '<pubDate>Sat, 23 Dec 2017 22:00:02 +0100</pubDate>' .
                        '<guid isPermaLink="false">0aefbef317686efce5152f0daeea5c1e</guid>' .
                    '</item>' .
            	'</channel>' .
            '</rss>';

        $rss = simplexml_load_string($rss_xml);

        $testee = new Warnings($rss);
        $serialized = $testee->serialize();

        $this->assertSame('UK', $serialized['country']);
        $this->assertSame(1, sizeof($serialized['regions']));
        $this->assertSame('Highlands & Islands', $serialized['regions'][0]['name']);
    }
}

?>
