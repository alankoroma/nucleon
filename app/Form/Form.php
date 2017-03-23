<?php

namespace App\Form;

abstract class Form
{

    use FieldValidationTrait;

    /**
     * @var array
     */
    private $input = [];

    /**
     * @var array
     */
    private $errors = [];

    /**
     * Adds an error code to the specified form field.
     *
     * @param  string $field
     * @param  string $code
     * @return null
     */
    protected function addError($field, $code)
    {
        $this->errors[$field][] = $code;
    }

    /**
     * Returns any error messages generated during validation.
     *
     * @return array
     */
    public function errors()
    {
        $messages = $this->messages();
        $output = array();
        foreach ($this->errors as $field => $codes) {
            foreach ($codes as $code) {
                if (isset($messages[$field . '.' . $code])) {
                    $output[] = $messages[$field . '.' . $code];
                }
            }
        }
        return $output;
    }

    /**
     * Returns the current value of the specified field. Returns
     * null if the field does not exist.
     *
     * @param  string $field
     * @return mixed
     */
    public function get($field)
    {
        if (!isset($this->input[$field])) {
            return null;
        }
        return $this->input[$field];
    }

    /**
     * Validates input data and returns true if no errors were
     * generated.
     *
     * @param  array $input
     * @return bool
     */
    public function validate($input)
    {
        foreach ($input as $field => $value) {
            $this->input[$field] = $value;
        }
        $this->run();
        return empty($this->errors);
    }

    /**
     * Returns a data transfer object populated with the current
     * form state.
     *
     * @return mixed
     */
    public function getTransfer()
    {
        $transfer = $this->transferObject();
        $mapping = $this->map();
        foreach ($mapping as $field => $property) {
            if (property_exists($transfer, $property)) {
                $transfer->$property = $this->get($field);
            }
        }
        return $transfer;
    }

    /**
     * Sets the form state using values from a data tranfer object.
     *
     * @param  mixed $transfer
     * @return null
     */
    public function loadTransfer($transfer)
    {
        $mapping = $this->map();
        foreach ($mapping as $field => $property) {
            if (property_exists($transfer, $property)) {
                $this->input[$field] = $transfer->$property;
            }
        }
    }

    /**
     * Returns a new transfer object populated with
     * default values.
     *
     * @return mixed
     */
    abstract protected function transferObject();

    /**
     * Returns an array mapping form fields to transfer
     * object property names.
     *
     * @return array
     */
    abstract protected function map();

    /**
     * Returns an array mapping form error codes to
     * messages for output.
     *
     * @return array
     */
    abstract protected function messages();

    /**
     * Overridden by the form to run the validation.
     *
     * @return null
     */
    abstract protected function run();
}
