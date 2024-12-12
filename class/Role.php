<?php 

class Role extends CoreClass {
    private $id;
    private $label;
    private $rights = [];

    public function __construct($id, $label) {
        $this->id = $id;
        $this->label = $label;
    }

    public function addRight(Right $right) {
        $this->rights[] = $right;
    }

    public function getId() {return $this->id;}

	public function getLabel() {return $this->label;}

	public function setId( $id): void {$this->id = $id;}

	public function setLabel( $label): void {$this->label = $label;}

	
}