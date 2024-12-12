<?php 

class Meal extends CoreClass {
    private $id;
    private $totalProteines;
    private $totalLipides;
    private $totalGlucides;
    private $totalCalories;
    private $nameMeal;
    private $descriptionMeal;
    private $nameMealId;
    // private $foods = [];


    // public function addFood(Food $food) {
    //     $this->foods[] = $food;
    // }

    public function getId()
    {
        return $this->id;
    }

    public function getTotalProteines()
    {
        return $this->totalProteines;
    }

    public function getTotalLipides()
    {
        return $this->totalLipides;
    }

    public function getTotalGlucides()
    {
        return $this->totalGlucides;
    }

    public function getTotalCalories()
    {
        return $this->totalCalories;
    }

    public function getNameMeal()
    {
        return $this->nameMeal;
    }

    public function getDescriptionMeal()
    {
        return $this->descriptionMeal;
    }

    public function getNameMealId()
    {
        return $this->nameMealId;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setTotalProteines($totalProteines): void
    {
        $this->totalProteines = $totalProteines;
    }

    public function setTotalLipids($totalLipides): void
    {
        $this->totalLipides = $totalLipides;
    }

    public function setTotalGlucides($totalGlucides): void
    {
        $this->totalGlucides = $totalGlucides;
    }

    public function setTotalCalories($totalCalories): void
    {
        $this->totalCalories = $totalCalories;
    }

    public function setNameMeal($nameMeal): void
    {
        $this->nameMeal = $nameMeal;
    }
    public function setDescriptionMeal($descriptionMeal): void
    {
        $this->descriptionMeal = $descriptionMeal;
    }

    public function setNameMealId($nameMealId): void
    {
        $this->nameMealId = $nameMealId;
    }

	
    
}