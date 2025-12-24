<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests\Repositories;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchRepositories extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $query,
        protected ?string $sort = null,
        protected ?string $order = null,
        protected int $perPage = 30,
        protected int $page = 1,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/search/repositories';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'q' => $this->query,
            'sort' => $this->sort,
            'order' => $this->order,
            'per_page' => $this->perPage,
            'page' => $this->page,
        ], fn ($value) => $value !== null);
    }
}
