<?php

class Settings{
    static $COMMSTYLE = "bloggs";
}

interface  CommsManager{
  function encode();
}

class BloggsCommsManager implements CommsManager{
    function encode(){
        return "bloggscommsmanager";
    }
}

class MegaCommsManager implements CommsManager{
    function encode(){
        return "megacommsmanager";
    }
}

class Appconfig{
    private static $instance;
    private $commsManager;

    private function  __construct(){
        $this->init();
    }
    private function init(){
        switch(Settings::$COMMSTYLE){
            case "mega":
                $this->commsManager = new MegaCommsManager();
                break;
            default:
                $this->commsManager = new BloggsCommsManager();
        }
    }

    static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;

    }

    function getCommsManager(){
        return $this->commsManager;
    }
}

$commsManager = Appconfig::getInstance()->getCommsManager();
echo $commsManager->encode();
?>