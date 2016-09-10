<?php
namespace KSL\Controllers;

use \Interop\Container\ContainerInterface;

class Base
{
    protected $ci;
    
    public function __construct(ContainerInterface $ci) {
        $this->ci = $ci;
    }
}