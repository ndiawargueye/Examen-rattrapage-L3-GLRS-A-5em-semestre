<?php
namespace App\Model;

/**
 * Classe generique pour encapsuler le resultat d'un service.
 * Succès : success=true, data contient le resultat.
 * Erreur  : success=false, message contient l'erreur.
 */
class ServiceResult
{
    private bool $success;
    private mixed $data;
    private string $message;

    private function __construct(bool $success, mixed $data, string $message)
    {
        $this->success = $success;
        $this->data    = $data;
        $this->message = $message;
    }

    public static function ok(mixed $data = null): self
    {
        return new self(true, $data, '');
    }

    public static function fail(string $message): self
    {
        return new self(false, null, $message);
    }

    public function isSuccess(): bool   { return $this->success; }
    public function getData(): mixed    { return $this->data; }
    public function getMessage(): string { return $this->message; }
}
