<?php

class NameMeal extends CoreClass
{
    private int $id;
    private string $label;


    public function getId() : int 
    {
        return $this->id;
    }

    public function getLabel() : string 
    {
        return $this->label;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

	
	
  
}