<?php

namespace App\Domain;

use Ramsey\Uuid\Uuid;

class EntityId
{
  /**
   * @var string
   */

   private function __construct($id)
   {
       $this->id = $id;
   }

  /**
   * Create a new Entity ID
   *
   * @return EntityId
   */
  public static function create()
  {
    return new static(Uuid::uuid4()->toString());
  }

  /**
   * Creates an existing entity ID.
   *
   * @param  string $id
   * @return EntityId
   */
  public static function restore($id)
  {
      return new static($id);
  }

  /**
   * Returns the entity ID.
   *
   * @return string
   */
  public function get()
  {
      return $this->id;
  }

  /**
   * Returns true if the provided entity ID is equal.
   *
   * @param  EntityId
   * @return bool
   */
  public function equals(EntityId $id)
  {
      return $this->id == $id->id;
  }

}
