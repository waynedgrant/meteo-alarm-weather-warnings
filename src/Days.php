<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class Days {

    public function __construct($days_dom, $output_timezone) {
        /* e.g. <table>
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
        $rows = $days_dom->getElementsByTagName('tr');
        $tomorrows_row_index = $this->findTomorrowsRowIndex($rows);

        $this->todaysWarnings = $this->parseWarningsFromRows($rows, 1, $tomorrows_row_index, $output_timezone);
        $this->tomorrowsWarnings = $this->parseWarningsFromRows($rows, $tomorrows_row_index+1, $rows->length, $output_timezone);
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

    private function parseWarningsFromRows($rows, $start_index, $end_index, $output_timezone) {
        $warnings = array();

        for ($i = $start_index; ($i + 2) <= $end_index; $i+=2) {
            $awarness_period_row = $rows->item($i);
            $description_row = $rows->item($i+1);
            $warnings[] = new Warning($awarness_period_row, $description_row, $output_timezone);
        }

        return $warnings;
    }

    public function todaysWarnings() {
        return $this->todaysWarnings;
    }

    public function tomorrowsWarnings() {
        return $this->tomorrowsWarnings;
    }
}
