<?php

class User extends CoreClass
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;
    private string $birthday;
    private string $town;
    private bool $sex;
    private float $weight;
    private string $objective;
    private float $weightObjective;
    private int $workoutObjectivePerWeek;
    private int $roleId;
    private array $meals = [];
    private array $foods = [];


    public function addMeal(Meal $meal, $date)
    {
        $this->meals[] = ['meal' => $meal, 'date' => $date];
    }

    public function addFood(Food $food)
    {
        $this->foods[] = $food;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getTown()
    {
        return $this->town;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getObjective()
    {
        return $this->objective;
    }

    public function getWeightObjective()
    {
        return $this->weightObjective;
    }

    public function getWorkoutObjectivePerWeek()
    {
        return $this->workoutObjectivePerWeek;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function setBirthday($birthday): void
    {
        $this->birthday = $birthday;
    }

    public function setTown($town): void
    {
        $this->town = $town;
    }

    public function setSex($sex): void
    {
        $this->sex = $sex;
    }

    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    public function setObjective($objective): void
    {
        $this->objective = $objective;
    }

    public function setWeightObjective($weightObjective): void
    {
        $this->weightObjective = $weightObjective;
    }

    public function setWorkoutObjectivePerWeek($workoutObjectivePerWeek): void
    {
        $this->workoutObjectivePerWeek = $workoutObjectivePerWeek;
    }

    public function setRoleId($roleId): void
    {
        $this->roleId = $roleId;
    }
}
