<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAuthenticatedUser extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/user';
    }
}
