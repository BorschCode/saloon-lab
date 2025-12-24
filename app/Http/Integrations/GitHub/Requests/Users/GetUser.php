<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetUser extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $username,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/users/{$this->username}";
    }
}
