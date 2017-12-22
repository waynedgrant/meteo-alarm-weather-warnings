<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class DaysTest extends PHPUnit\Framework\TestCase {

    const days_html =
        '<html>' .
            '<body>' .
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
                '</table>' .
            '</body>' .
        '</html>';

    public function test_days() {
        $days_dom = DOMDocument::loadHTML(self::days_html);

        $testee = new Days($days_dom, 'Europe/London');

        $todaysWarnings = $testee->todaysWarnings();
        $tomorrowsWarnings = $testee->tomorrowsWarnings();

        $this->assertSame(1, sizeof($todaysWarnings));
        $this->assertSame(2, sizeof($tomorrowsWarnings));

        $this->assertSame('A spell of heavy snow is possible over parts of Scotland during Sunday.', $todaysWarnings[0]->description()->text());
        $this->assertSame('A spell of heavy snow is possible over parts of Scotland during Monday.', $testee->tomorrowsWarnings[0]->description()->text());
        $this->assertSame('Ice is expected to form across many places overnight into Tuesday morning.', $tomorrowsWarnings[1]->description()->text());

    }
}

?>
