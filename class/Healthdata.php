<?php

class Healthdata extends CoreClass
{
    private int $healthId;
    private float $actualWeight;
    private int $height;
    private  string $birthday;
    private string $sexe;



    /**
     * Calculates the Body Mass Index (BMI) based on the user's height and weight
     *
     * @return float The calculated BMI value rounded to one decimal place
     */
    public function calculateIMC(): float
    {
        // Convert height from centimeters to meters
        $heightInMeters = $this->height / 100;

        // Calculate BMI
        $imc = $this->actualWeight / ($heightInMeters * $heightInMeters);

        // Round to one decimal place
        return round($imc, 1);
    }


    /**
     * Determines the BMI category based on the calculated BMI value
     *
     * @return string The BMI category: "Underweight", "Normal weight", "Overweight", or "Obesity"
     */
    public function getIMCCategory(): string
    {
        $imc = $this->calculateIMC();

        if ($imc < 18.5) {
            return "Insuffisance pondérale";
        } elseif ($imc < 25) {
            return "Poids normal";
        } elseif ($imc < 30) {
            return "Surpoids";
        } else {
            return "Obésité";
        }
    }


    /**
     * Calculates the age based on the provided birthday
     *
     * @param string $birthday The user's birthday in 'YYYY-MM-DD' format
     * @return int The calculated age in years
     */
    public function calculateAge(string $birthday): int
    {
        $birthday = new DateTime($birthday);
        $today = new DateTime('today');
        $age = $birthday->diff($today)->y;
        return $age;
    }

    
    /**
     * Calculates daily caloric needs based on age, weight, height, and sex
     *
     * @return array An associative array of daily caloric needs for different activity levels:
     *               'Sedentary', 'Lightly active', 'Moderately active', 'Very active', 'Extra active'
     */
    public function calculateDailyCalories(): array
    {
        $age = $this->calculateAge($this->birthday);
        // Calcul  (BMR) with Mifflin-St Jeor formule
        if ($this->sexe === 'homme') {
            $bmr = (10 * $this->actualWeight) + (6.25 * $this->height) - (5 * $age) + 5;
        } else {
            $bmr = (10 * $this->actualWeight) + (6.25 * $this->height) - (5 * $age) - 161;
        }
        
        $calorieNeeds = [
            'Sédentaire' => round($bmr * 1.2),
            'Légèrement actif' => round($bmr * 1.375),
            'Modérément actif' => round($bmr * 1.55),
            'Très actif' => round($bmr * 1.725),
            'Extrêmement actif' => round($bmr * 1.9)
        ];

        return $calorieNeeds;
    }


    public function getHealthId(): int
    {
        return $this->healthId;
    }

    public function getActualWeight(): float
    {
        return $this->actualWeight;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getSexe(): string
    {
        return $this->sexe;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }


    public function setHealthId(int $healthId): void
    {
        $this->healthId = $healthId;
    }

    public function setActualWeight(float $actualWeight): void
    {
        $this->actualWeight = $actualWeight;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function setSexe(string $sexe): void
    {
        $this->sexe = $sexe;
    }

    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }
}
