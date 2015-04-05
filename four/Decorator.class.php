<?php
abstract class Tile{
    abstract  function getWealthFactory();

}

abstract class TileDecorator extends Tile{
    protected $tile;
    public function __construct(Tile $tile){
        $this->tile = $tile;
    }
}

class Plains extends Tile{
    private $wealthfactor = 2;
    function getWealthFactory(){
        return $this->wealthfactor;
    }
}

class DiamondDecorator extends TileDecorator{
    function getWealthFactory(){
        return $this->tile->getWealthFactory()+8;
    }
}

class PollutionDecorator extends  TileDecorator{
    function  getWealthFactory(){
        return $this->tile->getWealthFactory()-4;
    }
}

$tile = new Plains();
//print $tile->getWealthFactory();

$tile = new PollutionDecorator(new DiamondDecorator(new Plains()));
//echo $tile->getWealthFactory();

class RequestHelper{}

abstract class ProcessRequest{
    abstract function process(RequestHelper $req);
}

class MainRequest extends ProcessRequest{
    function  process(RequestHelper $req){
        print __CLASS__."doing something useful with request\n\t";
    }
}

abstract class DecorateProcess extends ProcessRequest{
    protected  $processrequest;
    function __construct(ProcessRequest $pr){
        $this->processrequest = $pr;
    }
}


class LogRequest extends DecorateProcess{
    function process(RequestHelper $req){
        print __CLASS__."logging request\n\t";
        $this->processrequest->process($req);
    }
}

class AuthRequest extends DecorateProcess{
    function process(RequestHelper $req){
        print __CLASS__."ahthing request\n\t";
        $this->processrequest->process($req);
    }
}


$process = new AuthRequest(new LogRequest(new MainRequest()));

$process->process(new RequestHelper());