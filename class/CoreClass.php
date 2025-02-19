<?php


abstract class CoreClass
{
  /**
   * Constructor: Initializes the object with provided data
   *
   * @param array $data An associative array of property values to set
   */
  public function __construct(array $data)
  {
    $this->hydrate($data);
  }

  /**
   * Hydrates the object by setting its properties based on the provided data
   *
   * @param array $data An associative array of property values to set
   * @return void
   */
  private function hydrate(array $data): void
  {
    foreach ($data as $key => $value) {
      $methodName = 'set' . ucfirst(substr($key, 4, strlen($key) - 4));

      if (method_exists($this, $methodName)) {
        $this->$methodName($value);
      }
    }
  }
}
