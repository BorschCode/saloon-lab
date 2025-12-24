<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests\Repositories;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetRepository extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $owner,
        protected string $repo,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/repos/{$this->owner}/{$this->repo}";
    }
}
