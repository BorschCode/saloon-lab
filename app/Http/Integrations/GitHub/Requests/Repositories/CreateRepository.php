<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests\Repositories;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateRepository extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $name,
        protected ?string $description = null,
        protected bool $private = false,
        protected bool $autoInit = false,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/user/repos';
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'private' => $this->private,
            'auto_init' => $this->autoInit,
        ], fn ($value) => $value !== null && $value !== false);
    }
}
