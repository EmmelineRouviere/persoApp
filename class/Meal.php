<?php 

class Meal extends CoreClass {
    private int $id;
    private int $totalProteines;
    private int $totalLipides;
    private int $totalGlucides;
    private int $totalCalories;
    private string $nameMeal;
    private ?string $descriptionMeal;
    private string $nameMealId;
    private int $userId;
    private string $mealOwner;
 

    public function getId() : int 
    {
        return $this->id;
    }

    public function getTotalProteines() : int 
    {
        return $this->totalProteines;
    }

    public function getTotalLipides() : int 
    {
        return $this->totalLipides;
    }

    public function getTotalGlucides() : int 
    {
        return $this->totalGlucides;
    }

    public function getTotalCalories() : int 
    {
        return $this->totalCalories;
    }

    public function getNameMeal() : string 
    {
        return $this->nameMeal;
    }

    public function getDescriptionMeal() : ?string 
    {
        return $this->descriptionMeal;
    }

    public function getNameMealId() : int 
    {
        return $this->nameMealId;
    }
    public function getUserId() : int 
    {
        return $this->userId;
    }

    public function getMealOwner() : string 
    {
        return $this->mealOwner;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTotalProteines(int $totalProteines): void
    {
        $this->totalProteines = $totalProteines;
    }

    public function setTotalLipides(int $totalLipides): void
    {
        $this->totalLipides = $totalLipides;
    }

    public function setTotalGlucides(int $totalGlucides): void
    {
        $this->totalGlucides = $totalGlucides;
    }

    public function setTotalCalories(int $totalCalories): void
    {
        $this->totalCalories = $totalCalories;
    }

    public function setNameMeal(string $nameMeal): void
    {
        $this->nameMeal = $nameMeal;
    }
    public function setDescriptionMeal(?string $descriptionMeal): void
    {
        $this->descriptionMeal = $descriptionMeal;
    }

    public function setNameMealId(int $nameMealId): void
    {
        $this->nameMealId = $nameMealId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
    public function setMealOwner(string $mealOwner): void
    {
        $this->mealOwner = $mealOwner;
    }

    
}