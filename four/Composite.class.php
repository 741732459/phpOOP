<?php

abstract class Unit{
    protected  $power = 0;
    abstract function addUnit(Unit $unit);
    abstract function removeUnit(Unit $unit);
    abstract function bombardStrength();
}


class Army extends Unit{
    private $units = array();

    function addUnit(Unit $unit){
        if(!in_array($unit,$this->units,true)){
            array_push($this->units,$unit);
        }
    }

    function removeUnit(Unit $unit){
        $this->units = array_udiff($this->units,array($unit),function($a,$b){
           return ($a===$b)?0:1;
        });
    }

    function bombardStrength(){
        foreach ($this->units as $unit){
            $this->power += $unit->bombardStrength();
        }
        return $this->power;
    }
}

class UnitException extends Exception{}
class Archer extends Unit{
    function addUnit(Unit $unit){
        throw new UnitException(get_class($this)."is a leaf");
    }

    function removeUnit(Unit $unit){
        throw new UnitException(get_class($this)."is a leaf");
    }

    function bombardStrength(){
         $this->power = 4;
        return $this->power;
    }
}


//$archer1 = new Archer();
//$archer2 = new Archer();
//$army = new Army();
//$army->addUnit($archer1);
//$army->addUnit($archer2);
//echo $army->bombardStrength();


//拆分职责
abstract class newUnit{
    abstract function bombardStrength();

    function getComposite(){
        return null;
    }
}

abstract class CompositeUnit extends newUnit{
    private $units = array();
    function getComposite(){
        return $this;
    }

    function addUnit(Unit $unit){
        if(!in_array($unit,$this->units,true)){
            array_push($this->units,$unit);
        }
    }

    function removeUnit(Unit $unit){
        $this->units = array_udiff($this->units,array($unit),function($a,$b){
           return ($a===$b)?0:1;
        });
        return $this->units;
    }
    
}
