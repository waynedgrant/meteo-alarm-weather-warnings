<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Warnings {

    public function __construct($rss) {
        /* e.g.
            <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
            	<channel>
            		<item>
            			<title>United Kingdom</title>
            			...
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

        if (count($rss_channel->item) > 1) { // Mutiple items == warnings for each region in a country
            for ($i=0; $i < count($rss_channel->item); $i++) {
                if ($i !== 0) { // Drop the first item which is actually for the entire country
                    $this->regions[] = new Region($rss_channel->item[$i]);
                }
            }
        } else { // Single item == warning for a single region
            $this->regions[] = new Region($rss_channel->item);
        }
    }

    public function serialize() {
        foreach ($this->regions as $region) {
            $regions[] = $region->serialize();
        }

        return [
            'country' => Config::getCountry(),
            'regions' => $regions
        ];
    }
}
