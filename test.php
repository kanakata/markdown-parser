<?php

class Test{
    private string $fn;
    private string $ev;
    private array $args;
    // public function __construct(string $function_name, array $arguments, mixed $expected_value)
    // {
    //     $this->fn = $function_name;
    //     $this->args = $arguments;
    //     $this->ev = $expected_value;
    // }

    public function assertEquals(string $function_name, array $arguments, mixed $expected_value, string $expected_return_type){
        
        $this->fn = $function_name;
        $this->args = $arguments;
        $this->ev = $expected_value;
        $reflection = new ReflectionFunction($this->fn);
        $result = $reflection->invokeArgs($this->args);
        $return_type_result = $reflection->getReturnType();
        return $result == $this->ev  ? "\033[32m Test passed \033[0m\n" : "\033[31m Test failed\033[0m\n";
    }
}