<?php

namespace App\Http\Controllers;

use App\Http\Integrations\GitHub\GitHubConnector;
use App\Http\Integrations\GitHub\Requests\Repositories\CreateRepository;
use App\Http\Integrations\GitHub\Requests\Repositories\GetAuthenticatedUserRepositories;
use App\Http\Integrations\GitHub\Requests\Repositories\GetRepository;
use App\Http\Integrations\GitHub\Requests\Repositories\GetUserRepositories;
use App\Http\Integrations\GitHub\Requests\Repositories\SearchRepositories;
use App\Http\Integrations\GitHub\Requests\Users\GetAuthenticatedUser;
use App\Http\Integrations\GitHub\Requests\Users\GetUser;
use App\Http\Integrations\GitHub\Requests\Users\GetUserFollowers;
use App\Http\Integrations\GitHub\Requests\Users\GetUserFollowing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Saloon\Http\Auth\TokenAuthenticator;

class GitHubApiController extends Controller
{
    public function __construct(public GitHubConnector $github) {}

    public function index(): Response
    {
        return Inertia::render('GitHubApi/Index');
    }

    public function getAuthenticatedUser(Request $request): JsonResponse
    {
        $token = $request->input('token');

        if ($token) {
            $this->github->authenticate(new TokenAuthenticator($token));
        }

        $response = $this->github->send(new GetAuthenticatedUser);

        return response()->json([
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ]);
    }

    public function getUser(Request $request): JsonResponse
    {
        $username = $request->input('username');

        $response = $this->github->send(new GetUser($username));

        return response()->json([
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ]);
    }

    public function getUserFollowers(Request $request): JsonResponse
    {
        $username = $request->input('username');
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 30);

        $response = $this->github->send(new GetUserFollowers($username, $page, $perPage));

        return response()->json([
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ]);
    }

    public function getUserFollowing(Request $request): JsonResponse
    {
        $username = $request->input('username');
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 30);

        $response = $this->github->send(new GetUserFollowing($username, $page, $perPage));

        return response()->json([
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ]);
    }

    public function getAuthenticatedUserRepositories(Request $request): JsonResponse
    {
        $token = $request->input('token');

        if ($token) {
            $this->github->authenticate(new TokenAuthenticator($token));
        }

        $type = $request->input('type', 'owner');
        $sort = $request->input('sort', 'created');
        $direction = $request->input('direction', 'desc');

        $response = $this->github->send(new GetAuthenticatedUserRepositories($type, $sort, $direction));

        return response()->json([
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ]);
    }

    public function getUserRepositories(Request $request): JsonResponse
    {
        $username = $request->input('username');
        $type = $request->input('type', 'owner');
        $sort = $request->input('sort', 'created');
        $direction = $request->input('direction', 'desc');

        $response = $this->github->send(new GetUserRepositories($username, $type, $sort, $direction));

        return response()->json([
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ]);
    }

    public function getRepository(Request $request): JsonResponse
    {
        $owner = $request->input('owner');
        $repo = $request->input('repo');

        $response = $this->github->send(new GetRepository($owner, $repo));

        return response()->json([
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ]);
    }

    public function searchRepositories(Request $request): JsonResponse
    {
        $query = $request->input('query');
        $sort = $request->input('sort');
        $order = $request->input('order', 'desc');
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 30);

        $response = $this->github->send(new SearchRepositories($query, $sort, $order, $page, $perPage));

        return response()->json([
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ]);
    }

    public function createRepository(Request $request): JsonResponse
    {
        $token = $request->input('token');

        if ($token) {
            $this->github->authenticate(new TokenAuthenticator($token));
        }

        $name = $request->input('name');
        $description = $request->input('description');
        $private = $request->boolean('private', false);
        $autoInit = $request->boolean('auto_init', false);

        $response = $this->github->send(new CreateRepository($name, $description, $private, $autoInit));

        return response()->json([
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ]);
    }
}
