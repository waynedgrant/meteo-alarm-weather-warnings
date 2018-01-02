<?php

class Result {

    const SERVICE_VERSION = '1.1';
    const GITHUB_PROJECT_LINK = 'https://github.com/waynedgrant/meteo-alarm-weather-warnings';
    const COPYRIGHT_NOTICE = 'Copyright © 2018 Wayne D Grant (www.waynedgrant.com)';

    public function __construct($rss) {
        $this->warnings = new Warnings($rss);
    }

    private function createServiceUrl() {
        return 'http'.(!empty($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    }

    public function serialize() {
        return [
            'endpoint' => [
                'url' => $this->createServiceUrl(),
                'version' => self::SERVICE_VERSION,
                'github_project' => self::GITHUB_PROJECT_LINK,
                'copyright' => self::COPYRIGHT_NOTICE
            ],
            'warnings' => $this->warnings->serialize()
        ];
    }
}
?>
