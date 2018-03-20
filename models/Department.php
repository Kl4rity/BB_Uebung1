<?php

class Department {
    private $phoneNumber;
    private $name;
    private $employees;
    
    public function __construct($name, $number){
        $this->name = $name;
        $this->number = $number;
        $this->employees = array();
    }
    
    public function addEmployees($employeeList){
        $this->employees = $employeeList;
    }
    
    public function getRandomEmployee(){
        $randomIndex = rand(1, count($this->employees)) -1;
        
        $randomEmployee = $this->employees[$randomIndex];
        return $randomEmployee;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function getNumber(){
        return $this->number;
    }
}

