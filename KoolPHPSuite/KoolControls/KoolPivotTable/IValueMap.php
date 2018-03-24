<?php

/**
 *
 * @author KoolPHP's team
 */
interface IValueMap
{
    //put your code here
    function map($value);
    function getMapFields();
}

class _identityMap implements IValueMap
{
    private function __construct()
    {
    }
    
    public static function instance()
    {
        static $_inst = NULL;
        if ($_inst === NULL) {
            $_inst = new _identityMap();
        }

        return $_inst;
    }

    function map($_value)
    {
        return $_value;
    }
    
    function getMapFields()
    {
        return array("");
    }
    
}

class _firstLetterMap implements IValueMap
{
    private $_fieldName;
    
    public function __construct($_var)
    {
        $this->_fieldName = $_var;
    }

    function map($_value)
    {
        $_s = strtoupper(substr($_value, 0, 1));
        return array(
            "First letter" => $_s, 
            $this->_fieldName => $_value
            );
    }
    
    function getMapFields()
    {
        return array("First letter", $this->_fieldName);
    }    
    
}

class dateMap implements IValueMap
{
    private static $_quarter = array(
        "01"=>"01", "02"=>"01", "03"=>"01", 
        "04"=>"02", "05"=>"02", "06"=>"02",
        "07"=>"03", "08"=>"03", "09"=>"03", 
        "10"=>"04", "11"=>"04", "12"=>"04", 
        );
    
    private $mapArr = array(
        "Year" => NULL, "Quarter" => NULL,
         "Month" => NULL, "Day" => NULL,
        );

    function map($_date)
    {
        $this->mapArr["Year"] = substr($_date, 0, 4);
        $this->mapArr["Month"] = substr($_date, 5, 2);
        $this->mapArr["Quarter"] = self::$_quarter[$this->mapArr["Month"]];
        $this->mapArr["Day"] = substr($_date, 8, 2);
        return $this->mapArr;
    }
    
    function getMapFields()
    {
        return array_keys($this->mapArr);
    }
}
