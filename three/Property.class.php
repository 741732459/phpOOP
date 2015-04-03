<?php

class Sea{

}

class EarthSea extends Sea{

}

class MarsSea extends Sea{

}

class Plains{

}

class EarthPlains extends Plains{

}

class MarsPlains extends Plains{

}

class Forest{

}

class EarthForest extends Forest{

}

class MarsForest extends Forest{

}

class TerrainFactory{
    private $sea;
    private $forest;
    private $plains;

    function __construct(Sea $sea,Forest $forest,Plains $plains){
        $this->forest = $forest;
        $this->plains = $plains;
        $this->sea = $sea;
    }

    function getSea(){
        return clone $this->sea;
    }

    function  getPlains(){
        return clone $this->plains;
    }
    function  getForest(){
        return clone $this->forest;
    }
}


$factory = new TerrainFactory(new EarthSea(),new EarthForest(),new Plains());
print_r($factory->getForest());
?>