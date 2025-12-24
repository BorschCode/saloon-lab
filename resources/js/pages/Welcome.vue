<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Code2, Users, FolderGit2, Search, Plus, User, UserCheck } from 'lucide-vue-next';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);

const apiEndpoints = [
    {
        category: 'User Operations',
        icon: Users,
        endpoints: [
            {
                name: 'Get Authenticated User',
                description: 'Retrieve information about the currently authenticated user',
                icon: UserCheck,
                requiresAuth: true,
            },
            {
                name: 'Get User',
                description: 'Get public information about any GitHub user by username',
                icon: User,
                requiresAuth: false,
            },
            {
                name: 'Get User Followers',
                description: 'List followers for a specified user with pagination support',
                icon: Users,
                requiresAuth: false,
            },
            {
                name: 'Get User Following',
                description: 'List users that a specified user is following',
                icon: Users,
                requiresAuth: false,
            },
        ],
    },
    {
        category: 'Repository Operations',
        icon: FolderGit2,
        endpoints: [
            {
                name: 'Get My Repositories',
                description: 'List repositories for the authenticated user with filtering options',
                icon: FolderGit2,
                requiresAuth: true,
            },
            {
                name: 'Get User Repositories',
                description: 'List public repositories for any GitHub user',
                icon: FolderGit2,
                requiresAuth: false,
            },
            {
                name: 'Get Repository',
                description: 'Get detailed information about a specific repository',
                icon: FolderGit2,
                requiresAuth: false,
            },
            {
                name: 'Search Repositories',
                description: 'Search for repositories using GitHub search syntax',
                icon: Search,
                requiresAuth: false,
            },
            {
                name: 'Create Repository',
                description: 'Create a new repository for the authenticated user',
                icon: Plus,
                requiresAuth: true,
            },
        ],
    },
];
</script>

<template>
    <Head title="GitHub API Explorer - Saloon PHP v3 Demo" />

    <div class="min-h-screen bg-background">
        <!-- Header -->
        <header class="border-b">
            <div class="container mx-auto px-4 py-4">
                <nav class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Code2 class="h-6 w-6 text-primary" />
                        <h1 class="text-xl font-bold">Nexus API Lab</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="dashboard()"
                        >
                            <Button variant="outline">Dashboard</Button>
                        </Link>
                        <template v-else>
                            <Link :href="login()">
                                <Button variant="ghost">Log in</Button>
                            </Link>
                            <Link v-if="canRegister" :href="register()">
                                <Button>Register</Button>
                            </Link>
                        </template>
                    </div>
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="container mx-auto px-4 py-12">
            <div class="mx-auto max-w-3xl text-center">
                <Badge class="mb-4" variant="secondary">
                    Saloon PHP v3 Demo
                </Badge>
                <h2 class="mb-4 text-4xl font-bold tracking-tight">
                    GitHub API Explorer
                </h2>
                <p class="mb-8 text-lg text-muted-foreground">
                    A demonstration of SaloonPHP v3 integration with Laravel, Inertia.js, and Vue 3.
                    Explore all available GitHub API endpoints with an interactive interface.
                </p>
                <Link href="/github-api">
                    <Button size="lg" class="gap-2">
                        <Code2 class="h-5 w-5" />
                        Open API Explorer
                    </Button>
                </Link>
            </div>
        </section>

        <!-- API Endpoints Overview -->
        <section class="container mx-auto px-4 py-12">
            <div class="mx-auto max-w-6xl">
                <h3 class="mb-8 text-2xl font-bold">Available API Endpoints</h3>

                <div class="grid gap-8 md:grid-cols-2">
                    <Card
                        v-for="section in apiEndpoints"
                        :key="section.category"
                    >
                        <CardHeader>
                            <div class="flex items-center gap-2">
                                <component
                                    :is="section.icon"
                                    class="h-5 w-5 text-primary"
                                />
                                <CardTitle>{{ section.category }}</CardTitle>
                            </div>
                            <CardDescription>
                                {{ section.endpoints.length }} endpoints available
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <ul class="space-y-4">
                                <li
                                    v-for="endpoint in section.endpoints"
                                    :key="endpoint.name"
                                    class="flex gap-3"
                                >
                                    <div
                                        class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-muted"
                                    >
                                        <component
                                            :is="endpoint.icon"
                                            class="h-4 w-4"
                                        />
                                    </div>
                                    <div class="flex-1">
                                        <div class="mb-1 flex items-center gap-2">
                                            <h4 class="font-semibold text-sm">
                                                {{ endpoint.name }}
                                            </h4>
                                            <Badge
                                                v-if="endpoint.requiresAuth"
                                                variant="secondary"
                                                class="text-xs"
                                            >
                                                Auth Required
                                            </Badge>
                                        </div>
                                        <p class="text-sm text-muted-foreground">
                                            {{ endpoint.description }}
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="border-t bg-muted/50 py-12">
            <div class="container mx-auto px-4">
                <div class="mx-auto max-w-6xl">
                    <h3 class="mb-8 text-2xl font-bold">Technology Stack</h3>
                    <div class="grid gap-6 md:grid-cols-3">
                        <Card>
                            <CardHeader>
                                <CardTitle class="text-lg">SaloonPHP v3</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <p class="text-sm text-muted-foreground">
                                    Beautiful, maintainable API integrations with a fluent,
                                    expressive API client builder.
                                </p>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle class="text-lg">Laravel 12</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <p class="text-sm text-muted-foreground">
                                    Modern PHP framework with elegant syntax and powerful
                                    features for rapid development.
                                </p>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle class="text-lg">Inertia.js + Vue 3</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <p class="text-sm text-muted-foreground">
                                    Build modern single-page apps using classic server-side
                                    routing and controllers.
                                </p>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="container mx-auto px-4 py-12">
            <div class="mx-auto max-w-3xl text-center">
                <h3 class="mb-4 text-2xl font-bold">Ready to Explore?</h3>
                <p class="mb-8 text-muted-foreground">
                    Start testing GitHub API endpoints with our interactive interface.
                    All endpoints are available with real-time response viewing.
                </p>
                <Link href="/github-api">
                    <Button size="lg" class="gap-2">
                        <Code2 class="h-5 w-5" />
                        Launch API Explorer
                    </Button>
                </Link>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t py-8">
            <div class="container mx-auto px-4">
                <div class="text-center text-sm text-muted-foreground">
                    <p>
                        Built with
                        <a
                            href="https://laravel.com"
                            class="font-medium underline underline-offset-4"
                            target="_blank"
                        >
                            Laravel
                        </a>
                        •
                        <a
                            href="https://docs.saloon.dev"
                            class="font-medium underline underline-offset-4"
                            target="_blank"
                        >
                            SaloonPHP
                        </a>
                        •
                        <a
                            href="https://inertiajs.com"
                            class="font-medium underline underline-offset-4"
                            target="_blank"
                        >
                            Inertia.js
                        </a>
                        •
                        <a
                            href="https://vuejs.org"
                            class="font-medium underline underline-offset-4"
                            target="_blank"
                        >
                            Vue 3
                        </a>
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
