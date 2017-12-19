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

        $this->assertSame(AwarenessType::SNOW_ICE, $testee->awarenessType()->type());
        $this->assertSame(AwarenessLevel::AMBER, $testee->awarenessLevel()->level());
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

        $this->assertSame(AwarenessType::NONE, $testee->awarenessType()->type());
        $this->assertSame(AwarenessLevel::GREEN, $testee->awarenessLevel()->level());
    }
}

?>
