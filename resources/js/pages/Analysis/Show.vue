<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import type { SkillAnalysis } from '@/composables/useAnalysis';

defineProps<{ analysis: SkillAnalysis }>();
</script>

<template>
    <Head title="Analysis Detail" />
    <div class="space-y-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">
                    {{ analysis.application?.company }} —
                    {{ analysis.application?.role }}
                </h1>
            </div>
            <Link href="/analysis/history">
                <Button variant="outline" size="sm">Back to History</Button>
            </Link>
        </div>

        <div class="flex items-center gap-3">
            <Badge class="px-3 py-1 text-base">{{ analysis.score }}/100</Badge>
            <p class="text-sm text-muted-foreground">
                {{ analysis.summary }}
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <h3 class="mb-2 text-xs font-medium text-muted-foreground">
                    Matched Skills
                </h3>
                <div class="flex flex-wrap gap-1">
                    <Badge
                        v-for="s in analysis.matched_skills"
                        :key="s"
                        variant="secondary"
                        class="border-l-2 border-l-emerald-500 text-xs"
                    >
                        {{ s }}
                    </Badge>
                </div>
            </div>
            <div>
                <h3 class="mb-2 text-xs font-medium text-muted-foreground">
                    Missing Skills
                </h3>
                <div class="flex flex-wrap gap-1">
                    <Badge
                        v-for="s in analysis.missing_skills"
                        :key="s"
                        variant="secondary"
                        class="border-l-2 border-l-red-500 text-xs"
                    >
                        {{ s }}
                    </Badge>
                </div>
            </div>
        </div>

        <div>
            <h3 class="mb-2 text-xs font-medium text-muted-foreground">
                Recommendations
            </h3>
            <ul class="list-inside list-disc space-y-1 text-sm">
                <li v-for="(r, i) in analysis.recommendations" :key="i">
                    {{ r }}
                </li>
            </ul>
        </div>

        <div>
            <h3 class="mb-2 text-xs font-medium text-muted-foreground">
                Resume Submitted
            </h3>
            <div
                class="max-h-64 overflow-y-auto rounded-md border p-3 text-sm whitespace-pre-line"
            >
                {{ analysis.resume_text }}
            </div>
        </div>
    </div>
</template>
