<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Description {

    public function __construct($description_dom) {
        // e.g. <td>A spell of heavy snow is possible over parts of Scotland during Sunday.</td>
        $description_cell = $description_dom->getElementsByTagName('td')->item(0);

        if ($description_cell->textContent !== '') {
            $this->description = $description_cell->textContent;
        }
    }

    public function description() {
        return $this->description;
    }
}
