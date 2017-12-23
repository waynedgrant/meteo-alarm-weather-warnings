<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Country {

    public function __construct($rss, $output_timezone) {
        /* e.g.
            <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
            	<channel>
            		<link>http://web.meteoalarm.eu/en_UK/0/0/UK.html</link>
            		<item>
            			<title>United Kingdom</title>
            			<...
            		</item>
            		<item>
            			<title>Dumfries and Galloway</title>
            			...
            		</item>
            		<item>
            			<title>Lothian &amp; Borders</title>
            			...
            		</item>
            	</channel>
            </rss> */

        $rss_channel = $rss->channel;
        $this->link = (string)$rss_channel->link;

        for ($i=0; $i < count($rss_channel->item); $i++) {
            if ($i !== 0) {
                $this->regions[] = new Region($rss_channel->item[$i], $output_timezone);
            }
        }
    }

    public function serialize() {
        foreach ($this->regions as $region) {
            $regions[] = $region->serialize();
        }

        return [
            'link' => $this->link,
            'regions' => $regions
        ];
    }
}
