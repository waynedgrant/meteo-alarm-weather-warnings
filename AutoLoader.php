<?php

# Copyright 2018 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class AutoLoader {

    static private $classNames = array();

    public static function registerDirectory($dirName) {
        $di = new DirectoryIterator($dirName);

        foreach ($di as $file) {

            if ($file->isDir() && !$file->isLink() && !$file->isDot()) {
                self::registerDirectory($file->getPathname());
            }
            elseif (substr($file->getFilename(), -4) === '.php') {
                $className = substr($file->getFilename(), 0, -4);
                AutoLoader::registerClass($className, $file->getPathname());
            }
        }
    }

    public static function registerClass($className, $fileName) {
        AutoLoader::$classNames[$className] = $fileName;
    }

    public static function loadClass($className) {
        if (isset(AutoLoader::$classNames[$className])) {
            require_once(AutoLoader::$classNames[$className]);
        }
     }

}

spl_autoload_register(array('AutoLoader', 'loadClass'));

?>
