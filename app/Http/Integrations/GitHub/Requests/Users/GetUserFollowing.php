<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetUserFollowing extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $username,
        protected int $perPage = 30,
        protected int $page = 1,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/users/{$this->username}/following";
    }

    protected function defaultQuery(): array
    {
        return [
            'per_page' => $this->perPage,
            'page' => $this->page,
        ];
    }
}
