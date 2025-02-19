<?php

class Objectif extends CoreClass
{
    private int $objectifId;
    private ?string $objectifLabel;
    private ?int $objectifLabelId;
    private ?float $weightObjectif;
    private ?int $workoutObjectifPerWeek;
    private ?bool $objectifState;
    private int $userId; 

    public function getObjectifId(): ?int
    {
        return $this->objectifId;
    }

    public function getObjectifLabel(): ?string
    {
        return $this->objectifLabel;
    }
    public function getObjectifLabelId(): ?int
    {
        return $this->objectifLabelId;
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
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setObjectifId(?int $objectifId): void
    {
        $this->objectifId = $objectifId;
    }

    public function setObjectifLabel(?string $objectifLabel): void
    {
        $this->objectifLabel = $objectifLabel;
    }

    public function setObjectifLabelId(?int $objectifLabelId): void
    {
        $this->objectifLabelId = $objectifLabelId;
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

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
}
