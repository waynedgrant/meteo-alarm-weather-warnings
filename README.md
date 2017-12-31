# meteo-alarm-weather-warnings

Copyright © 2018 Wayne D Grant

Licensed under the MIT License

JSON formatted Web Service API to fetch weather warnings from [Metoalarm](http://www.meteoalarm.eu/). Written in PHP.

## Overview

## Requirements

1. PHP version 5 or above installed on the web server

## Installation

* Download the source code for the [latest release](https://github.com/waynedgrant/meteo-alarm-weather-warnings/releases) and unzip it

* Upload all **.php** and **.json** files in **meteo-alarm-weather-warnings/src** to a location on your web server

* Modify your web server to process **.json** files using PHP. For example, for Apache add the following to your **.htaccess** file:

```
AddHandler application/x-httpd-php5 .json
```

* Alternatively rename the **warning.json** file to be named **warning.php**.

## Execution

Hit the URL of your deployed **warning.json** file using a web browser or other REST client. Both JSON and JSONP are supported.

The following GET parameters are supported:

| GET Parameter    | Description                                                                                                                                                 | Required? | Default Value          |
|------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------|------------------------|
| country          | Country to fetch weather warnings for. e.g. UK, DE, FR, etc. See [Metoalarm](http://www.meteoalarm.eu/) for a full list.                                    | Yes       | N/A                    |
| region           | Region within country to fetch weather warnings for, e.g. 004 is Lothian & Borders in the UK. See [Metoalarm](http://www.meteoalarm.eu/) for a full list.   | No        | All regions in country |
| date_time_format | Format string to use for fetched date/time values. See [datetime.createfromformat.php](http://php.net/manual/en/datetime.createfromformat.php) for details. | No        | l H:i T                |
| time_zone        | Timezone used to express for fetched date/time values. See [timezones.php](http://php.net/manual/en/timezones.php) for a full list of supported values.     | No        | Europe/London          |

For example:

All weather warnings for the UK:

```
/warnings.json?country=UK
```

Weather warnings for the Gelderland region of the Netherlands:

```
/warnings.json?country=NL&region=014
```

Weather warnings for Germany with a specialized date/time format expressed in the local timezone:

```
/warnings.json?country=DE&date_time_format=Y/M/d H:i T&time_zone=Europe/Berlin
```

## Response Fields

## Unit Testing

* Install [PHPUnit](https://phpunit.de/)
* cd meteo-alarm-weather-warnings
* phpunit --bootstrap bootstrap.php test/
