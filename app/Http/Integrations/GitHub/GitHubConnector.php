<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class GitHubConnector extends Connector
{
    use AcceptsJson;

    public function __construct(
        protected ?string $token = null,
    ) {}

    public function resolveBaseUrl(): string
    {
        return 'https://api.github.com';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/vnd.github+json',
            'X-GitHub-Api-Version' => '2022-11-28',
        ];
    }

    protected function defaultAuth(): ?Authenticator
    {
        if ($this->token) {
            return new TokenAuthenticator($this->token, 'Bearer');
        }

        return null;
    }
}
