<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests\Repositories;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAuthenticatedUserRepositories extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected ?string $type = null,
        protected ?string $sort = null,
        protected ?string $direction = null,
        protected int $perPage = 30,
        protected int $page = 1,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/user/repos';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'type' => $this->type,
            'sort' => $this->sort,
            'direction' => $this->direction,
            'per_page' => $this->perPage,
            'page' => $this->page,
        ], fn ($value) => $value !== null);
    }
}
