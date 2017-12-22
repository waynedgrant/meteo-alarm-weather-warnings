<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Description {

    public function __construct($description_cell) {
        // e.g. <td>A spell of heavy snow is possible over parts of Scotland during Sunday.</td>
        if (trim($description_cell->textContent) !== '') {
            $this->text = $description_cell->textContent;
        }
    }

    public function text() {
        return $this->text;
    }
}
