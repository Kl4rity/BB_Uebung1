<?php

class Switchboard {
    private $departments;
    private $jsonView;
    
    public function __construct(){
        $this->departments = array();
        $this->jsonView = new JsonView();
        $this->createDepartments();
        
    }
    
    private function createDepartments(){
        $dataFilePath = DATAPATH . "departments.json";
        $dataFile = file_get_contents($dataFilePath);
        $jsonObject = json_decode($dataFile);
        
        $rawDepartments = $jsonObject->departments;
        
        foreach($rawDepartments as $department){
            $name = $department->name;
            $number = $department->number;
            $employees = $department->employees;
            
            $currentDepartment = new Department($name, $number);
            $currentDepartment->addEmployees($employees);
            
            $hashIndex = $this->createUniqueNumber($number);
            
            $this->departments[$hashIndex] = $currentDepartment;
        };
    }
    
    private function createUniqueNumber($number){
        $trimmedNumber = trim(str_replace(" ", "", $number));
        return md5($trimmedNumber);
    }
    
    public function route(){
        
        if(isset($_GET['phoneNumber'])){
            $phoneNumber = $_GET['phoneNumber'];
            $this->callDepartment($phoneNumber);
        }
        
    }
    
    private function callDepartment($phoneNumber){
        $departmentIndex = $this->createUniqueNumber($phoneNumber);
        $department = $this->departments[$departmentIndex];
        
        $employee = $department->getRandomEmployee();
        $departmentName = $department->getName();
        
        $data = array(
            'department' => $departmentName,
            'employee' => $employee->name,
            'line' => $employee->line
        );
        
        $this->jsonView->streamOutput($data);
    }

}

