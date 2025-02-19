<?php

class Daymeal extends CoreClass
{
	private int $id;
	private string $date;
	private int $totalProteines;
	private int $totalLipides;
	private int $totalGlucides;
	private int $totalCalories;
	private string $nameMeal;
	private string $mealName;
	private ?string $descriptionMeal;
	private int $mealId;
	private int $dayId;


	public function getId(): int
	{
		return $this->id;
	}

	public function getDate(): string
	{
		return $this->date;
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

	public function getMealName() : string 
	{
		return $this->mealName;
	}

	public function getDescriptionMeal() : ?string 
	{
		return $this->descriptionMeal;
	}

	public function getMealId(): int
	{
		return $this->mealId;
	}
	public function getDayId(): int
	{
		return $this->dayId;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}

	public function setDate(string $date): void
	{
		$this->date = $date;
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

	public function setMealName(string $mealName): void
	{
		$this->mealName = $mealName;
	}
	public function setDescriptionMeal(?string $descriptionMeal): void
	{
		$this->descriptionMeal = $descriptionMeal;
	}

	public function setMealId(int $mealId): void
	{
		$this->mealId = $mealId;
	}
	public function setDayId(int $dayId): void
	{
		$this->dayId = $dayId;
	}
}
