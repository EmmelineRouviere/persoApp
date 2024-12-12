<?php 


abstract class CoreClass {
    
    public function __construct(array $data)
    {
      $this->hydrate($data);
    }
  
  
    private function hydrate(array $data) :void
    {
      foreach ($data as $key => $value) 
      {
        $methodName = 'set' . ucfirst(substr($key, 4, strlen($key) - 4));
  
        if (method_exists($this, $methodName)) {
          $this->$methodName($value);
        }
      }
    }


}