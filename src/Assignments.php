<?php

namespace Adamnicholson\Adamlang;

/**
 * @property array $constants
 * @property array $values
 */
class Assignments
{
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getValue(string $key)
    {
        if (!isset($this->values[$key])) {
            throw new \RuntimeException("Value $key is not defined");
        }

        return $this->values[$key];
    }

    public function getConstant(string $key)
    {
        if (!isset($this->constants[$key])) {
            throw new \RuntimeException(
                "Constant $key is not defined. Defined constants are: "
                . implode(", ", array_keys($this->constants))
            );
        }

        return $this->constants[$key];
    }
}