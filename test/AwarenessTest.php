<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class AwarenessTest extends PHPUnit\Framework\TestCase {

    public function test_warning() {
        $awareness_html =
            '<td width="28">' .
                '<img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l3-t2.jpg" alt="awt:2 level:3">' .
            '</td>';

        $awareness_dom = DOMDocument::loadHTML($awareness_html);
        $awareness_cell = $awareness_dom->getElementsByTagName('td')->item(0);

        $testee = new Awareness($awareness_cell);
        $serialized = $testee->serialize();

        $this->assertSame('http://web.meteoalarm.eu/documents/rss/wflag-l3-t2.jpg', $serialized['icon']);
        $this->assertSame(AwarenessType::SNOW_ICE, $serialized['awareness_type']['type']);
        $this->assertSame(AwarenessLevel::AMBER, $serialized['awareness_level']['level']);
    }

    public function test_no_warning() {
        // Any awareness type other than 'None' makes no sense when level is 'Green'
        $awareness_html =
            '<td width="28">' .
                '<img border="1" src="http://web.meteoalarm.eu/documents/rss/wflag-l2-t2.jpg" alt="awt:3 level:1">' .
            '</td>';

        $awareness_dom = DOMDocument::loadHTML($awareness_html);
        $awareness_cell = $awareness_dom->getElementsByTagName('td')->item(0);

        $testee = new Awareness($awareness_cell);
        $serialized = $testee->serialize();

        $this->assertSame(AwarenessType::NO_WARNINGS, $serialized['awareness_type']['type']);
        $this->assertSame(AwarenessLevel::GREEN, $serialized['awareness_level']['level']);
    }
}

?>
