<?php
namespace Request;

class Request
{
    protected string $method;
    protected array $headers;
    protected array $body;

    public function __construct(string $method, array $headers = [], array $body = [])
    {
        $this->method = $method;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function setBody (array $body): void
    {
        $this->body = $body;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): array
    {
        return $this->body;
    }

}