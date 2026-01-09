<?php

namespace App\Lib\Http;

class Response {
    private string $content;
    private int $status;
    private array $headers;

    public function __construct(string $content, int $status, array $headers)
    {
        $this->content = $content;
        $this->status = $status;
        $this->headers = $headers;
    }

    public function getContent(): string {
        return $this->content;
    }
    
    public function getStatus(): int {
        return $this->status;
    }
    
    public function getHeaders(): array {
        return $this->headers;
    }

    public function getHeadersAsString(): string {
        $headersAsString = '';
        foreach($this->getHeaders() as $headerName => $headerValue) {
            $headersAsString .= "$headerName: $headerValue\n";
        }

        return $headersAsString;
    }
}


?>
