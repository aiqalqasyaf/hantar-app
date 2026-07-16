<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Briefcase, LineChart, Sparkles } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { dashboard, login, register } from '@/routes';
</script>

<template>
    <Head title="Hantar" />

    <div class="flex min-h-screen flex-col bg-background text-foreground">
        <header class="flex items-center justify-between p-6">
            <div class="flex items-center gap-2 font-semibold">
                <Briefcase class="h-5 w-5" />
                Hantar
            </div>
            <nav class="flex items-center gap-3">
                <Link v-if="$page.props.auth.user" :href="dashboard()">
                    <Button size="sm">Dashboard</Button>
                </Link>
                <template v-else>
                    <Link :href="login()">
                        <Button variant="ghost" size="sm">Log in</Button>
                    </Link>
                    <Link :href="register()">
                        <Button size="sm">Register</Button>
                    </Link>
                </template>
            </nav>
        </header>

        <main
            class="flex flex-1 flex-col items-center justify-center gap-10 px-6 text-center"
        >
            <div class="space-y-4">
                <h1 class="text-4xl font-semibold tracking-tight">
                    Track your job hunt, without the spreadsheet.
                </h1>
                <p class="mx-auto max-w-md text-muted-foreground">
                    Organize applications, spot skill gaps against real job
                    descriptions, and know exactly where you stand.
                </p>
                <div class="flex justify-center gap-3 pt-2">
                    <Link
                        :href="$page.props.auth.user ? dashboard() : register()"
                    >
                        <Button size="lg">Get Started</Button>
                    </Link>
                    <Link :href="login()" v-if="!$page.props.auth.user">
                        <Button variant="outline" size="lg">Log in</Button>
                    </Link>
                </div>
            </div>

            <div class="grid w-full max-w-2xl grid-cols-1 gap-4 sm:grid-cols-3">
                <Card>
                    <CardContent
                        class="flex flex-col items-center gap-2 p-6 text-center"
                    >
                        <Briefcase class="h-5 w-5 text-muted-foreground" />
                        <p class="text-sm font-medium">Application Tracking</p>
                        <p class="text-xs text-muted-foreground">
                            Kanban board for every stage
                        </p>
                    </CardContent>
                </Card>
                <Card>
                    <CardContent
                        class="flex flex-col items-center gap-2 p-6 text-center"
                    >
                        <Sparkles class="h-5 w-5 text-muted-foreground" />
                        <p class="text-sm font-medium">Skill Gap Analysis</p>
                        <p class="text-xs text-muted-foreground">
                            AI-powered resume matching
                        </p>
                    </CardContent>
                </Card>
                <Card>
                    <CardContent
                        class="flex flex-col items-center gap-2 p-6 text-center"
                    >
                        <LineChart class="h-5 w-5 text-muted-foreground" />
                        <p class="text-sm font-medium">Dashboard Insights</p>
                        <p class="text-xs text-muted-foreground">
                            See your pipeline at a glance
                        </p>
                    </CardContent>
                </Card>
            </div>
        </main>

        <footer class="p-6 text-center text-xs text-muted-foreground">
            Built by Aiqal Qasyaf
        </footer>
    </div>
</template>
