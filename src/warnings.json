<?php header('content-type: application/json; charset=utf-8');

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once("Config.php");
require_once("Result.php");
require_once("Warnings.php");
require_once("Region.php");
require_once("Warning.php");
require_once("Awareness.php");
require_once("AwarenessLevel.php");
require_once("AwarenessType.php");
require_once("Period.php");
require_once("Description.php");

parse_parameters();
$rss_link = generate_rss_link();
$rss = @file_get_contents($rss_link);

if (!$rss) {
    $response_code = parse_response_code($http_response_header);
    respond($response_code, create_error_json('Response code ' . $response_code . ' returned by ' . $rss_link));
}

$rss = mb_convert_encoding($rss, 'HTML-ENTITIES', 'UTF-8'); // Convert special European chars such as French accents and German umlauts appropriately

$rss = fix_rss_ampersand_escaping($rss);
$result = new Result(simplexml_load_string($rss));
$json = json_encode($result->serialize());

respond(200, $json);

function parse_parameters() {
    if (!isset($_GET['country'])) {
        respond(400, create_error_json('GET parameter country is required'));
    }

    Config::setCountry(strtoupper($_GET['country']));

    if (isset($_GET['region'])) {
        Config::setRegion($_GET['region']);
    }

    if (isset($_GET['date_time_format'])) {
        Config::setDateTimeFormat($_GET['date_time_format']);
    }

    if (isset($_GET['time_zone'])) {
        Config::setTimeZone($_GET['time_zone']);
    }
}

function generate_rss_link() {
    if (!is_null(Config::getRegion())) {
        // Request for a single region, e.g. http://meteoalarm.eu/documents/rss/uk/UK004.rss
        return sprintf('http://meteoalarm.eu/documents/rss/%s/%s%s.rss', strtolower(Config::getCountry()), Config::getCountry(), Config::getRegion());
    } else {
        // Request for an entire country, e.g. http://www.meteoalarm.eu/documents/rss/uk.rss
        return sprintf('http://www.meteoalarm.eu/documents/rss/%s.rss', strtolower(Config::getCountry()));
    }
}

function parse_response_code($headers) {
    foreach ($headers as $k=>$v) {
        if (preg_match( "#HTTP/[0-9\.]+\s+([0-9]+)#", $v, $out)) {
            $response_code = intval($out[1]);
            break;
        }
    }
    return $response_code;
}

function fix_rss_ampersand_escaping($rss) {
    /* Some ampersands are escaped in the received RSS and some are not.
       Address this by escaping them all and then fixing any resultant double escapes */
    $rss = str_replace('&', '&amp;', $rss);
    $rss = str_replace('&amp;amp;', '&amp;', $rss);
    return $rss;
}

function create_error_json($error_message) {
    return json_encode(array(
        'error' => $error_message
    ));
}

function respond($code, $json) {
    header('Status: ' . $code);
    echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
    die();
}

?>
