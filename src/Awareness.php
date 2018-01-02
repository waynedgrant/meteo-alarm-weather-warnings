<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Awareness {

    public function __construct($awareness_cell) {
        // e.g. <td><img src="http://web.meteoalarm.eu/documents/rss/wflag-l3-t4.jpg" alt="awt:4 level:3"></td>
        $img = $awareness_cell->getElementsByTagName('img')->item(0);

        $this->icon = $img->getAttribute('src');

        $img_alt = $img->getAttribute('alt');

        $this->parse_awareness_level($img_alt);
        $this->parse_awareness_type($img_alt);
    }

    private function parse_awareness_level($img_alt) {
        // e.g. level value from "awt:4 level:3"
        $start_awareness_level_index = strrpos($img_alt, ':') + 1;
        $awareness_level_length = strlen($img_alt) - $start_awareness_level_index;
        $this->awarenessLevel = new AwarenessLevel(intval(substr($img_alt, $start_awareness_level_index, $awareness_level_length)));
    }

    private function parse_awareness_type($img_alt) {
        if ($this->awarenessLevel->serialize()['level'] == AwarenessLevel::GREEN) {
            $this->awarenessType = new AwarenessType(AwarenessType::NO_WARNINGS); // Awareness types need to be corrected to be 'no warnings' when level is green
        } else {
            // e.g. awt value from "awt:4 level:3"
            $start_awareness_type_index = strpos($img_alt, ':') + 1;
            $awareness_type_length = strpos($img_alt, ' ') - $start_awareness_type_index;
            $this->awarenessType = new AwarenessType(intval(substr($img_alt, $start_awareness_type_index, $awareness_type_length)));
        }
    }

    public function serialize() {
        return [
            'icon' => $this->icon,
            'awareness_type' => $this->awarenessType->serialize(),
            'awareness_level' => $this->awarenessLevel->serialize()
        ];
    }
}

?>
