<?php

abstract class Expression{
    private static $keycount = 0;
    private $key;

    abstract function interpret(InterPretContent $content);

    function getKey(){
        if(!assert($this->key)){
            self::$keycount++;
            $this->key = self::$keycount;
        }
        return $this->key;
    }
}

class InterpretContent{
    private $expressionstore = array();
    function replace(Expression $exp,$value){
        $this->expressionstore[$exp->getKey()] = $value;
    }

    function lookup(Expression $exp){
        return $this->expressionstore[$exp->getKey()];
    }
}


class LiteralExpression extends Expression{
    private $value;
    function __construct($value){
        $this->value = $value;
    }
    function interpret(InterPretContent $content){
        $content->replace($this,$this->value);
    }
}

//$content = new InterpretContent();
//$literal = new LiteralExpression('four');
//$literal->interpret($content);
//$literal1 = new LiteralExpression('five');
//$literal1->interpret($content);
//print ($content->lookup($literal));
//print ($content->lookup($literal1));
class VariableExpression extends Expression{
    private $name;
    private $val;

    function __construct($name,$val = null){
        $this->name = $name;
        $this->val = $val;

    }

    function interpret(InterPretContent $content){
        if(!is_null($this->val)){
            $content->replace($this,$this->val);
            $this->val = null;
        }
    }

    function setValue($value){
        $this->val = $value;
    }

    function getKey(){
        return $this-name;
    }
}

abstract class OperatorExpression extends Expression{
    protected $l_op;
    protected $r_op;
    function __construct(Expression $l_op,Expression $r_op){
        $this->l_op = $l_op;
        $this->r_op = $r_op;
    }

    function interpret(InterpretContent $content){
        $this->l_op->interpret($content);
        $this->r_op->interpret($content);
        $result_l = $content->lookup($this->l_op);
        $result_r = $content->lookup($this->r_op);
        $this->doInterpret($content,$result_l,$result_r);
    }

    protected abstract function doInterpret(InterpretContent $content,$result_l,$result_r);
}


class EqualExpression extends OperatorExpression{
   function  doInterpret(InterpretContent $content,$result_l,$result_r){
       $content->replace($this,$result_l==$result_r);
   }
}

class BooleanOrExpression extends OperatorExpression{
    function  doInterpret(InterpretContent $content,$result_l,$result_r){
        $content->replace($this,$result_l||$result_r);
    }
}

class BooleanAndExpression extends OperatorExpression{
    function  doInterpret(InterpretContent $content,$result_l,$result_r){
        $content->replace($this,$result_l&&$result_r);
    }
}



//custom

$content = new InterpretContent();
$input = new VariableExpression('input');
$statement = new BooleanOrExpression(
    new EqualExpression($input,new LiteralExpression('four')),
    new EqualExpression($input,new LiteralExpression('4'))

    );


foreach(array("four","4","52") as $val){
    $input->setValue($val);
    print "$val:\n";
    $statement->interpret($content);
    if($content->lookup($statement)){
        print "yes\n";
    }else{
        print "no\n";
    }
}