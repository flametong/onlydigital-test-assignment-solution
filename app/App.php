<?php

namespace App;

class App
{

    private array $handler = [];

    public function post(string $route, callable $handler): void
    {
        $this->handler[] = ['POST', $route, $handler];
    }

    public function get(string $route, callable $handler): void
    {
        $this->handler[] = ['GET', $route, $handler];
    }

    public function run(): void
    {
        $uri    = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->handler as $item) {
            [$handlerMethod, $route, $handler] = $item;

            if ($method === $handlerMethod && $route === $uri) {
                echo $handler();
                return;
            }
        }
    }

}