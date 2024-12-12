<?php

class Objectif extends CoreClass
{
    private int $id;
    private string $label;
    private bool $state;

    
    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getState(): bool
    {
        return $this->state;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function setState(bool $state): void
    {
        $this->state = $state;
    }
}
