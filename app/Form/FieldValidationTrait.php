<?php

namespace App\Form;

trait FieldValidationTrait
{
    /**
     * Returns true if the specified field is empty.
     *
     * @return boolean
     */
    protected function isEmpty($field)
    {
        return empty($this->input[$field]);
    }
}
