<?php

class NameMeal extends CoreClass
{
    private $id;
    private $label;


    public function getId()
    {
        return $this->id;
    }

    public function getLabel()
    {
        return $this->label;
    }
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setLabel($label): void
    {
        $this->label = $label;
    }

	
	
  
}