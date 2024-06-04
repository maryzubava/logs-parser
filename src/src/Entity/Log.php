<?php

namespace App\Entity;

use App\DTO\Log as LogDTO;
use App\Repository\LogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogRepository::class)]
class Log
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $serviceName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateTime = null;

    #[ORM\Column(length: 255)]
    private ?string $httpMethod = null;

    #[ORM\Column(length: 500)]
    private ?string $endpoint = null;

    #[ORM\Column(length: 255)]
    private ?string $protocol = null;

    #[ORM\Column]
    private ?int $statusCode = null;

    public function __construct(LogDTO $log)
    {
        $this->serviceName = $log->serviceName;
        $this->dateTime = $log->dateTime;
        $this->httpMethod = $log->httpMethod;
        $this->endpoint = $log->endpoint;
        $this->protocol = $log->protocol;
        $this->statusCode = $log->statusCode;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceName(): ?string
    {
        return $this->serviceName;
    }

    public function setServiceName(string $serviceName): static
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): static
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getHttpMethod(): ?string
    {
        return $this->httpMethod;
    }

    public function setHttpMethod(string $httpMethod): static
    {
        $this->httpMethod = $httpMethod;

        return $this;
    }

    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): static
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function getProtocol(): ?string
    {
        return $this->protocol;
    }

    public function setProtocol(string $protocol): static
    {
        $this->protocol = $protocol;

        return $this;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
