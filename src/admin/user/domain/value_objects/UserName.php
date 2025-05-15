<?php

namespace Src\admin\user\domain\value_objects;

class UserName
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("Name cannot be empty");
        }

        if (strlen($name) < 3 || strlen($name) > 50) {
            throw new \InvalidArgumentException("Name must be between 3 and 50 characters");
        }

        if (!preg_match("/^[a-zA-Z0-9_]+$/", $name)) {
            throw new \InvalidArgumentException("Name can only contain letters, numbers, and underscores");
        }
        $this->name = $name;
    }

    public function value(): string
    {
        return $this->name;
    }
}
