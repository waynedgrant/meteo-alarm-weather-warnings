<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Region {

    const INPUT_DATE_TIME_FORMAT = 'D, d M Y H:i:s T'; // e.g. Fri, 22 Dec 2017 01:00:00 +0100
    const OUTPUT_DATE_TIME_FORMAT = 'l H:i T'; // e.g. Friday 00:00 GMT

    public function __construct($rss_item, $output_timezone) {
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

        $days_html = (string)$rss_item->description;
        $days_dom = DOMDocument::loadHTML($days_html);
        $this->days = new Days($days_dom, 'Europe/London');

        $parsed_pub_date = date_create_from_format(self::INPUT_DATE_TIME_FORMAT, (string)$rss_item->pubDate);
        date_timezone_set($parsed_pub_date, new DateTimeZone($output_timezone));
        $this->published = $parsed_pub_date->format(self::OUTPUT_DATE_TIME_FORMAT);
    }

    public function name() {
        return $this->name;
    }

    public function link() {
        return $this->link;
    }

    public function today() {
        return $this->days->todaysWarnings();
    }

    public function tomorrow() {
        return $this->days->tomorrowsWarnings();
    }

    public function published() {
        return $this->published;
    }
}
