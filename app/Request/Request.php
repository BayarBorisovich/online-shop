<?php
namespace Request;

class Request
{
    protected string $method;
    protected array $body;
    protected array $headers;
    public function __construct(string $method, array $body = [], array $headers = [])
    {
        $this->method = $method;
        $this->body = $body;
        $this->headers = $headers;
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