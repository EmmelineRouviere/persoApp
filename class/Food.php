<?php

class Food extends CoreClass {
    private int $id;
    private string $namefood;
    private int $proteines;
    private int $lipides;
    private int $glucides;
    private int $calories;
    private int $quantity;




    public function getId() : int
    {
        return $this->id;
    }

    public function getNamefood() : string
    {
        return $this->namefood;
    }

    public function getProteines() : int
    {
        return $this->proteines;
    }

    public function getLipides() : int
    {
        return $this->lipides;
    }

    public function getGlucides() : int
    {
        return $this->glucides;
    }

    public function getCalories() : int
    {
        return $this->calories;
    }

    public function getQuantity() : int
    {
        return $this->quantity;
    }




    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNamefood(string $namefood): void
    {
        $this->namefood = $namefood;
    }

    public function setProteines(int $proteines): void
    {
        $this->proteines = $proteines;
    }

    public function setLipides(int $lipides): void
    {
        $this->lipides = $lipides;
    }

    public function setGlucides(int $glucides): void
    {
        $this->glucides = $glucides;
    }

    public function setCalories(int $calories): void
    {
        $this->calories = $calories;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
