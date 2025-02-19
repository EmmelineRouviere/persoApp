<?php

class User extends CoreClass
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;
    private string $birthday;
    private string $sexe;
    private int $roleId;
    private int $healthId;
    private float $actualWeight;
    private int $height;
    private ?int $objectifId;
    private ?string $objectifLabel;
    private ?float $weightObjectif;
    private ?int $workoutObjectifPerWeek;
    private ?bool $objectifState;


    // FONCTIONS METIERS 

    public function calculateIMC(): float
    {
        // Convertir la taille de cm en mètres
        $heightInMeters = $this->height / 100;

        // Calculer l'IMC
        $imc = $this->actualWeight / ($heightInMeters * $heightInMeters);

        // Arrondir à 1 décimale
        return round($imc, 1);
    }

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

    public function calculateAge(string $birthday): int
    {
        $birthday = new DateTime($birthday);
        $today = new DateTime('today');
        $age = $birthday->diff($today)->y;
        return $age;
    }

    public function calculateDailyCalories(): array
    {
        $age = $this->calculateAge($this->birthday);
        // Calcul du métabolisme de base (BMR) selon la formule de Mifflin-St Jeor
        if ($this->sexe === 'homme') {
            $bmr = (10 * $this->actualWeight) + (6.25 * $this->height) - (5 * $age) + 5;
        } else {
            $bmr = (10 * $this->actualWeight) + (6.25 * $this->height) - (5 * $age) - 161;
        }

        // Calcul des besoins caloriques pour différents niveaux d'activité
        $calorieNeeds = [
            'Sédentaire' => round($bmr * 1.2),
            'Légèrement actif' => round($bmr * 1.375),
            'Modérément actif' => round($bmr * 1.55),
            'Très actif' => round($bmr * 1.725),
            'Extrêmement actif' => round($bmr * 1.9)
        ];

        return $calorieNeeds;
    }


    // -----------------------GETTERS-------------------------------

    // GETTERS USER 

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

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getSexe(): string
    {
        return $this->sexe;
    }
    public function getRoleId(): int
    {
        return $this->roleId;
    }

    // GETTERS HEALTH USER

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

    // GETTERS OBJECTIF USER 

    public function getObjectifId(): ?int
    {
        return $this->objectifId;
    }

    public function getObjectifLabel(): ?string
    {
        return $this->objectifLabel;
    }

    public function getWeightObjectif(): ?float
    {
        return $this->weightObjectif;
    }

    public function getWorkoutObjectifPerWeek(): ?int
    {
        return $this->workoutObjectifPerWeek;
    }

    public function getObjectifState(): ?bool
    {
        return $this->objectifState;
    }



    // ------------------------SETTERS-----------------------------

    // SETTER USERS
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

    public function setSexe(string $sexe): void
    {
        $this->sexe = $sexe;
    }
    public function setRoleId(int $roleId): void
    {
        $this->roleId = $roleId;
    }

    // SETTERS HEALTH USER

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

    // SETTERS OBJECTIF USER 

    public function setObjectifId(?int $objectifId): void
    {
        $this->objectifId = $objectifId;
    }

    public function setObjectifLabel(?string $objectifLabel): void
    {
        $this->objectifLabel = $objectifLabel;
    }

    public function setWeightObjectif(?float $weightObjectif): void
    {
        $this->weightObjectif = $weightObjectif;
    }

    public function setWorkoutObjectifPerWeek(?int $workoutObjectifPerWeek): void
    {
        $this->workoutObjectifPerWeek = $workoutObjectifPerWeek;
    }

    public function setObjectifState(?bool $objectifState): void
    {
        $this->objectifState = $objectifState;
    }
}
