<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class DescriptionTest extends PHPUnit\Framework\TestCase {

    public function test_description_present() {
        $description_html =
            '<td>' .
                'A spell of heavy snow is possible over parts of Scotland during Sunday.' .
            '</td>';

        $description_dom = DOMDocument::loadHTML($description_html);
        $description_cell = $description_dom->getElementsByTagName('td')->item(0);

        $testee = new Description($description_cell);

        $this->assertSame('A spell of heavy snow is possible over parts of Scotland during Sunday.', $testee->text());
    }

    public function test_no_description_present() {
        $description_html = '<td></td>';

        $description_dom = DOMDocument::loadHTML($description_html);
        $description_cell = $description_dom->getElementsByTagName('td')->item(0);

        $testee = new Description($description_cell);

        $this->assertNull($testee->text());
    }
}

?>
