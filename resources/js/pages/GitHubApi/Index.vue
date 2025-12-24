<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import axios from 'axios';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'GitHub API Explorer',
        href: '/github-api',
    },
];

const activeTab = ref('users');
const loading = ref(false);
const response = ref<any>(null);
const errorMessage = ref('');

// Form data
const token = ref('');
const username = ref('');
const owner = ref('');
const repo = ref('');
const query = ref('');
const page = ref(1);
const perPage = ref(30);
const sort = ref('created');
const direction = ref('desc');
const order = ref('desc');
const type = ref('owner');
const repoName = ref('');
const repoDescription = ref('');
const isPrivate = ref(false);
const autoInit = ref(false);

const resetResponse = () => {
    response.value = null;
    errorMessage.value = '';
};

const handleApiCall = async (endpoint: string, data: any) => {
    loading.value = true;
    resetResponse();

    try {
        const result = await axios.post(endpoint, data);
        response.value = result.data;
        loading.value = false;
    } catch (error: any) {
        errorMessage.value = error.response?.data?.message || error.message || 'Request failed';
        loading.value = false;
    }
};

const getAuthenticatedUser = () => {
    handleApiCall('/github-api/users/authenticated', { token: token.value });
};

const getUser = () => {
    handleApiCall('/github-api/users/get', { username: username.value });
};

const getUserFollowers = () => {
    handleApiCall('/github-api/users/followers', {
        username: username.value,
        page: page.value,
        per_page: perPage.value,
    });
};

const getUserFollowing = () => {
    handleApiCall('/github-api/users/following', {
        username: username.value,
        page: page.value,
        per_page: perPage.value,
    });
};

const getAuthenticatedUserRepos = () => {
    handleApiCall('/github-api/repositories/authenticated', {
        token: token.value,
        type: type.value,
        sort: sort.value,
        direction: direction.value,
    });
};

const getUserRepos = () => {
    handleApiCall('/github-api/repositories/user', {
        username: username.value,
        type: type.value,
        sort: sort.value,
        direction: direction.value,
    });
};

const getRepository = () => {
    handleApiCall('/github-api/repositories/get', {
        owner: owner.value,
        repo: repo.value,
    });
};

const searchRepositories = () => {
    handleApiCall('/github-api/repositories/search', {
        query: query.value,
        sort: sort.value,
        order: order.value,
        page: page.value,
        per_page: perPage.value,
    });
};

const createRepository = () => {
    handleApiCall('/github-api/repositories/create', {
        token: token.value,
        name: repoName.value,
        description: repoDescription.value,
        private: isPrivate.value,
        auto_init: autoInit.value,
    });
};

const formattedResponse = computed(() => {
    if (!response.value) {
        return '';
    }
    return JSON.stringify(response.value, null, 2);
});
</script>

<template>
    <Head title="GitHub API Explorer" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-4">
            <div>
                <h1 class="text-3xl font-bold">GitHub API Explorer</h1>
                <p class="text-muted-foreground mt-2">
                    Test all available GitHub API endpoints using Saloon PHP v3
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <!-- API Testing Panel -->
                <div class="space-y-4">
                    <Card>
                        <CardHeader>
                            <CardTitle>API Endpoints</CardTitle>
                            <CardDescription>
                                Select an endpoint and provide required parameters
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="w-full">
                                <div class="flex gap-2 mb-6 border-b">
                                    <Button
                                        variant="ghost"
                                        @click="activeTab = 'users'"
                                        :class="[
                                            'rounded-b-none',
                                            activeTab === 'users'
                                                ? 'border-b-2 border-primary'
                                                : '',
                                        ]"
                                    >
                                        Users
                                    </Button>
                                    <Button
                                        variant="ghost"
                                        @click="activeTab = 'repositories'"
                                        :class="[
                                            'rounded-b-none',
                                            activeTab === 'repositories'
                                                ? 'border-b-2 border-primary'
                                                : '',
                                        ]"
                                    >
                                        Repositories
                                    </Button>
                                </div>

                                <!-- Users Tab -->
                                <div v-show="activeTab === 'users'" class="space-y-6 mt-6">
                                    <!-- Get Authenticated User -->
                                    <div class="space-y-3 p-4 border rounded-lg">
                                        <h3 class="font-semibold">
                                            Get Authenticated User
                                        </h3>
                                        <div class="space-y-2">
                                            <Label for="auth-token">
                                                GitHub Token (optional)
                                            </Label>
                                            <Input
                                                id="auth-token"
                                                v-model="token"
                                                type="password"
                                                placeholder="ghp_xxxxxxxxxxxx"
                                            />
                                        </div>
                                        <Button
                                            @click="getAuthenticatedUser"
                                            :disabled="loading"
                                            class="w-full"
                                        >
                                            Get Current User
                                        </Button>
                                    </div>

                                    <!-- Get User -->
                                    <div class="space-y-3 p-4 border rounded-lg">
                                        <h3 class="font-semibold">Get User</h3>
                                        <div class="space-y-2">
                                            <Label for="username">Username</Label>
                                            <Input
                                                id="username"
                                                v-model="username"
                                                placeholder="octocat"
                                            />
                                        </div>
                                        <Button
                                            @click="getUser"
                                            :disabled="loading || !username"
                                            class="w-full"
                                        >
                                            Get User
                                        </Button>
                                    </div>

                                    <!-- Get User Followers -->
                                    <div class="space-y-3 p-4 border rounded-lg">
                                        <h3 class="font-semibold">
                                            Get User Followers
                                        </h3>
                                        <div class="space-y-2">
                                            <Label for="followers-username">
                                                Username
                                            </Label>
                                            <Input
                                                id="followers-username"
                                                v-model="username"
                                                placeholder="octocat"
                                            />
                                        </div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="space-y-2">
                                                <Label for="page">Page</Label>
                                                <Input
                                                    id="page"
                                                    v-model.number="page"
                                                    type="number"
                                                    min="1"
                                                />
                                            </div>
                                            <div class="space-y-2">
                                                <Label for="per-page">
                                                    Per Page
                                                </Label>
                                                <Input
                                                    id="per-page"
                                                    v-model.number="perPage"
                                                    type="number"
                                                    min="1"
                                                    max="100"
                                                />
                                            </div>
                                        </div>
                                        <Button
                                            @click="getUserFollowers"
                                            :disabled="loading || !username"
                                            class="w-full"
                                        >
                                            Get Followers
                                        </Button>
                                    </div>

                                    <!-- Get User Following -->
                                    <div class="space-y-3 p-4 border rounded-lg">
                                        <h3 class="font-semibold">
                                            Get User Following
                                        </h3>
                                        <div class="space-y-2">
                                            <Label for="following-username">
                                                Username
                                            </Label>
                                            <Input
                                                id="following-username"
                                                v-model="username"
                                                placeholder="octocat"
                                            />
                                        </div>
                                        <Button
                                            @click="getUserFollowing"
                                            :disabled="loading || !username"
                                            class="w-full"
                                        >
                                            Get Following
                                        </Button>
                                    </div>
                                </div>

                                <!-- Repositories Tab -->
                                <div
                                    v-show="activeTab === 'repositories'"
                                    class="space-y-6 mt-6"
                                >
                                    <!-- Get Authenticated User Repos -->
                                    <div class="space-y-3 p-4 border rounded-lg">
                                        <h3 class="font-semibold">
                                            Get My Repositories
                                        </h3>
                                        <div class="space-y-2">
                                            <Label for="repo-token">
                                                GitHub Token
                                            </Label>
                                            <Input
                                                id="repo-token"
                                                v-model="token"
                                                type="password"
                                                placeholder="ghp_xxxxxxxxxxxx"
                                            />
                                        </div>
                                        <div class="grid grid-cols-3 gap-2">
                                            <div class="space-y-2">
                                                <Label>Type</Label>
                                                <Input
                                                    v-model="type"
                                                    placeholder="owner"
                                                />
                                            </div>
                                            <div class="space-y-2">
                                                <Label>Sort</Label>
                                                <Input
                                                    v-model="sort"
                                                    placeholder="created"
                                                />
                                            </div>
                                            <div class="space-y-2">
                                                <Label>Direction</Label>
                                                <Input
                                                    v-model="direction"
                                                    placeholder="desc"
                                                />
                                            </div>
                                        </div>
                                        <Button
                                            @click="getAuthenticatedUserRepos"
                                            :disabled="loading"
                                            class="w-full"
                                        >
                                            Get My Repos
                                        </Button>
                                    </div>

                                    <!-- Get User Repos -->
                                    <div class="space-y-3 p-4 border rounded-lg">
                                        <h3 class="font-semibold">
                                            Get User Repositories
                                        </h3>
                                        <div class="space-y-2">
                                            <Label for="user-repos-username">
                                                Username
                                            </Label>
                                            <Input
                                                id="user-repos-username"
                                                v-model="username"
                                                placeholder="octocat"
                                            />
                                        </div>
                                        <Button
                                            @click="getUserRepos"
                                            :disabled="loading || !username"
                                            class="w-full"
                                        >
                                            Get User Repos
                                        </Button>
                                    </div>

                                    <!-- Get Repository -->
                                    <div class="space-y-3 p-4 border rounded-lg">
                                        <h3 class="font-semibold">
                                            Get Repository
                                        </h3>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="space-y-2">
                                                <Label for="owner">Owner</Label>
                                                <Input
                                                    id="owner"
                                                    v-model="owner"
                                                    placeholder="laravel"
                                                />
                                            </div>
                                            <div class="space-y-2">
                                                <Label for="repo">Repo</Label>
                                                <Input
                                                    id="repo"
                                                    v-model="repo"
                                                    placeholder="framework"
                                                />
                                            </div>
                                        </div>
                                        <Button
                                            @click="getRepository"
                                            :disabled="loading || !owner || !repo"
                                            class="w-full"
                                        >
                                            Get Repository
                                        </Button>
                                    </div>

                                    <!-- Search Repositories -->
                                    <div class="space-y-3 p-4 border rounded-lg">
                                        <h3 class="font-semibold">
                                            Search Repositories
                                        </h3>
                                        <div class="space-y-2">
                                            <Label for="query">Search Query</Label>
                                            <Input
                                                id="query"
                                                v-model="query"
                                                placeholder="laravel stars:>1000"
                                            />
                                        </div>
                                        <Button
                                            @click="searchRepositories"
                                            :disabled="loading || !query"
                                            class="w-full"
                                        >
                                            Search
                                        </Button>
                                    </div>

                                    <!-- Create Repository -->
                                    <div class="space-y-3 p-4 border rounded-lg bg-muted/50">
                                        <h3 class="font-semibold text-orange-600 dark:text-orange-400">
                                            Create Repository
                                        </h3>
                                        <div class="space-y-2">
                                            <Label for="create-token">
                                                GitHub Token (required)
                                            </Label>
                                            <Input
                                                id="create-token"
                                                v-model="token"
                                                type="password"
                                                placeholder="ghp_xxxxxxxxxxxx"
                                            />
                                        </div>
                                        <div class="space-y-2">
                                            <Label for="repo-name">
                                                Repository Name
                                            </Label>
                                            <Input
                                                id="repo-name"
                                                v-model="repoName"
                                                placeholder="my-new-repo"
                                            />
                                        </div>
                                        <div class="space-y-2">
                                            <Label for="repo-desc">
                                                Description
                                            </Label>
                                            <Input
                                                id="repo-desc"
                                                v-model="repoDescription"
                                                placeholder="My awesome project"
                                            />
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center space-x-2">
                                                <Checkbox
                                                    id="private"
                                                    v-model:checked="isPrivate"
                                                />
                                                <Label for="private">Private</Label>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <Checkbox
                                                    id="auto-init"
                                                    v-model:checked="autoInit"
                                                />
                                                <Label for="auto-init">
                                                    Auto Init
                                                </Label>
                                            </div>
                                        </div>
                                        <Button
                                            @click="createRepository"
                                            :disabled="loading || !token || !repoName"
                                            variant="destructive"
                                            class="w-full"
                                        >
                                            Create Repository
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Response Panel -->
                <div>
                    <Card class="sticky top-4">
                        <CardHeader>
                            <CardTitle>Response</CardTitle>
                            <CardDescription>
                                API response will appear here
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div
                                v-if="loading"
                                class="flex items-center justify-center p-8"
                            >
                                <div
                                    class="h-8 w-8 animate-spin rounded-full border-4 border-primary border-t-transparent"
                                ></div>
                            </div>

                            <div
                                v-else-if="errorMessage"
                                class="rounded-lg bg-destructive/10 p-4 text-destructive"
                            >
                                <p class="font-semibold">Error</p>
                                <p class="text-sm mt-1">{{ errorMessage }}</p>
                            </div>

                            <div
                                v-else-if="response"
                                class="space-y-3"
                            >
                                <div class="flex items-center gap-2">
                                    <span
                                        :class="[
                                            'px-2 py-1 rounded text-xs font-semibold',
                                            response.success
                                                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100'
                                                : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100',
                                        ]"
                                    >
                                        Status: {{ response.status }}
                                    </span>
                                </div>
                                <pre
                                    class="overflow-x-auto rounded-lg bg-muted p-4 text-sm max-h-[600px] overflow-y-auto"
                                >{{ formattedResponse }}</pre>
                            </div>

                            <div
                                v-else
                                class="flex flex-col items-center justify-center p-12 text-muted-foreground"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-12 w-12 mb-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>
                                <p class="text-center">
                                    Select an endpoint and click a button to see the
                                    response
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
