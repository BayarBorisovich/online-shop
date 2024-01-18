<?php

class Container
{
    private array $services;

    public function set(string $className, callable $callback): void
    {
        $this->services[$className] = $callback;
    }
    public function get(string $className): object
    {
        if (!isset($this->services[$className])) {
            return new $className();
        }

        $callback = $this->services[$className];

        return $callback($this);
    }
}