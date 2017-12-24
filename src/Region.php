<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Region {

    const DATE_TIME_FORMAT = 'D, d M Y H:i:s T'; // e.g. Fri, 22 Dec 2017 01:00:00 +0100

    public function __construct($rss_item) {
        /* e.g.
    		<item>
                <title>Lothian &amp; Borders</title>
                <link>http://web.meteoalarm.eu/en_UK/0/0/UK004.html</link>
    			<description>![CDATA[...]]</description>
    			<pubDate>Sun, 19 Nov 2017 10:12:02 +0100</pubDate>
    		</item>
        */

        $this->name = (string)$rss_item->title;
        $this->link = (string)$rss_item->link;
        $this->code = $this->parseRegionCodeFromLink();

        $description_html = (string)$rss_item->description;

        $this->parseWarningsFromDescription($description_html);

        $parsed_pub_date = date_create_from_format(self::DATE_TIME_FORMAT, (string)$rss_item->pubDate);
        date_timezone_set($parsed_pub_date, new DateTimeZone(Config::getTimeZone()));
        $this->published = $parsed_pub_date->format(Config::getDateTimeFormat());
    }

    private function parseRegionCodeFromLink() {
        // e.g. extract '004' from http://web.meteoalarm.eu/en_UK/0/0/UK004.html
        $start = strripos($this->link, Config::getCountry()) + strlen(Config::getCountry());
        $length = strripos($this->link, '.html') - $start;

        return substr($this->link, $start, $length);
    }

    private function parseWarningsFromDescription($description_html) {
        /* e.g.
            <table>
                <tr><th>Today</th></tr>
                <tr><!-- Today's 1st warning awareness/period --></tr>
                <tr><!-- Today's 1st warning description --></tr>
                ...
                <tr><!-- Today's nth warning awareness/period --></tr>
                <tr><!-- Today's nth warning description --></tr>

                <tr><th>Tomorrow</th></tr>
                <tr><!-- Tomorrow's 1st warning awareness/period --></tr>
                <tr><!-- Tomorrow's 1st warning description --></tr>
                ...
                <tr><!-- Tomorrow's nth warning awareness/period --></tr>
                <tr><!-- Tomorrow's nth warning description --></tr>
            </table>
        */

        $description_dom = DOMDocument::loadHTML($description_html);

        $rows = $description_dom->getElementsByTagName('tr');
        $tomorrows_row_index = $this->findTomorrowsRowIndex($rows);

        $this->todaysWarnings = $this->parseWarningsFromRows($rows, 1, $tomorrows_row_index);
        $this->tomorrowsWarnings = $this->parseWarningsFromRows($rows, $tomorrows_row_index+1, $rows->length);
    }

    private function findTomorrowsRowIndex($rows) {
        for ($i = 0; $i < $rows->length; $i++) { // Find <tr><th>Tomorrow</th></tr>
            $row = $rows->item($i);

            if ((sizeof($row->childNodes->length) === 1) && ($row->childNodes->item(0)->nodeName === 'th'))  {

                if (trim($row->childNodes->item(0)->textContent) === 'Tomorrow') {
                    $tomorrows_row_index = $i;
                    break;
                }
            }
        }

        return $tomorrows_row_index;
    }

    private function parseWarningsFromRows($rows, $start_index, $end_index) {
        $warnings = array();

        for ($i = $start_index; ($i + 2) <= $end_index; $i+=2) {
            $awarness_period_row = $rows->item($i);
            $description_row = $rows->item($i+1);
            $warnings[] = new Warning($awarness_period_row, $description_row);
        }

        return $warnings;
    }

    public function serialize() {
        foreach ($this->todaysWarnings as $warning) {
            $todaysWarnings[] = $warning->serialize();
        }

        foreach ($this->tomorrowsWarnings as $warning) {
            $tomorrowsWarnings[] = $warning->serialize();
        }

        return [
            'name' => $this->name,
            'code' => $this->code,
            'link' => $this->link,
            'today' => $todaysWarnings,
            'tomorrow' => $tomorrowsWarnings,
            'published' => $this->published
        ];
    }
}
