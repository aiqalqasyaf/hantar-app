<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import type { SkillAnalysis } from '@/composables/useAnalysis';

defineProps<{ analyses: SkillAnalysis[] }>();
</script>

<template>
    <Head title="Analysis History" />
    <div class="space-y-6 p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold tracking-tight">
                Skill Gap Analysis
            </h1>
            <div class="flex gap-2">
                <Link href="/analysis">
                    <Button variant="outline" size="sm">Analysis</Button>
                </Link>
                <Link href="/analysis/history">
                    <Button variant="default" size="sm">History</Button>
                </Link>
            </div>
        </div>

        <div class="space-y-2">
            <Link v-for="a in analyses" :key="a.id" :href="`/analysis/${a.id}`">
                <Card class="cursor-pointer transition hover:shadow-sm">
                    <CardContent class="flex items-center justify-between py-4">
                        <div>
                            <p class="text-sm font-medium">
                                {{ a.application?.company }}
                            </p>
                            <p class="text-xs text-muted-foreground">
                                {{ a.application?.role }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <Badge variant="secondary" class="text-xs"
                                >{{ a.score }}/100</Badge
                            >
                            <span class="text-xs text-muted-foreground">{{
                                a.created_at_formatted
                            }}</span>
                        </div>
                    </CardContent>
                </Card>
            </Link>

            <p
                v-if="analyses.length === 0"
                class="py-12 text-center text-sm text-muted-foreground"
            >
                No analyses yet.
            </p>
        </div>
    </div>
</template>
