<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { useAnalysis } from '@/composables/useAnalysis';

interface Application {
    id: number;
    company: string;
    role: string;
    status: 'applied' | 'interview' | 'offer' | 'rejected';
    applied_at_formatted: string;
    job_description: string | null;
}

const props = defineProps<{
    applications: Application[];
    filters: { status?: string; from?: string; to?: string };
}>();

const statusFilter = ref(props.filters.status ?? 'all');
const fromFilter = ref(props.filters.from ?? '');
const toFilter = ref(props.filters.to ?? '');

const statusColors: Record<string, string> = {
    applied: 'border-l-4 border-l-blue-500',
    interview: 'border-l-4 border-l-amber-500',
    offer: 'border-l-4 border-l-emerald-500',
    rejected: 'border-l-4 border-l-red-500',
};

function applyFilters() {
    router.get(
        '/analysis',
        {
            status:
                statusFilter.value === 'all' ? undefined : statusFilter.value,
            from: fromFilter.value || undefined,
            to: toFilter.value || undefined,
        },
        { preserveState: true, replace: true },
    );
}

const selectedApp = ref<Application | null>(null);
const dialogOpen = ref(false);
const { resumeText, isSubmitting, result, submit, reset } = useAnalysis();

function openAnalysis(app: Application) {
    selectedApp.value = app;
    reset();
    dialogOpen.value = true;
}

function runAnalysis() {
    if (!selectedApp.value) {
        return;
    }

    submit(selectedApp.value.id);
}
</script>

<template>
    <Head title="Analysis" />
    <div class="space-y-6 p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold tracking-tight">
                Skill Gap Analysis
            </h1>
            <div class="flex gap-2">
                <Link href="/analysis">
                    <Button variant="default" size="sm">Analysis</Button>
                </Link>
                <Link href="/analysis/history">
                    <Button variant="outline" size="sm">History</Button>
                </Link>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-end gap-3">
            <Select v-model="statusFilter" @update:model-value="applyFilters">
                <SelectTrigger class="w-35">
                    <SelectValue />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="all">All statuses</SelectItem>
                    <SelectItem value="applied">Applied</SelectItem>
                    <SelectItem value="interview">Interview</SelectItem>
                    <SelectItem value="offer">Offer</SelectItem>
                    <SelectItem value="rejected">Rejected</SelectItem>
                </SelectContent>
            </Select>

            <Input
                type="date"
                v-model="fromFilter"
                @change="applyFilters"
                class="w-37.5"
            />
            <Input
                type="date"
                v-model="toFilter"
                @change="applyFilters"
                class="w-37.5"
            />
        </div>

        <div class="space-y-2">
            <Card
                v-for="app in applications"
                :key="app.id"
                :class="[
                    'cursor-pointer transition hover:shadow-sm',
                    statusColors[app.status],
                ]"
                @click="openAnalysis(app)"
            >
                <CardContent class="flex items-center justify-between py-4">
                    <div>
                        <p class="text-sm font-medium">{{ app.company }}</p>
                        <p class="text-xs text-muted-foreground">
                            {{ app.role }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <Badge variant="secondary" class="text-xs capitalize">{{
                            app.status
                        }}</Badge>
                        <span class="text-xs text-muted-foreground">{{
                            app.applied_at_formatted
                        }}</span>
                    </div>
                </CardContent>
            </Card>

            <p
                v-if="applications.length === 0"
                class="py-12 text-center text-sm text-muted-foreground"
            >
                No applications match these filters.
            </p>
        </div>
    </div>

    <Dialog v-model:open="dialogOpen">
        <DialogContent class="flex max-h-[85vh] flex-col sm:max-w-3xl">
            <DialogHeader>
                <DialogTitle
                    >{{ selectedApp?.company }} —
                    {{ selectedApp?.role }}</DialogTitle
                >
            </DialogHeader>

            <div
                v-if="!result"
                class="grid flex-1 grid-cols-1 gap-4 overflow-y-auto md:grid-cols-2"
            >
                <div class="space-y-2">
                    <Label class="text-xs text-muted-foreground"
                        >Job Description</Label
                    >
                    <div
                        class="h-64 overflow-y-auto rounded-md border p-3 text-sm whitespace-pre-line"
                    >
                        {{
                            selectedApp?.job_description ||
                            'No job description provided.'
                        }}
                    </div>
                </div>
                <div class="space-y-2">
                    <Label
                        for="resume_text"
                        class="text-xs text-muted-foreground"
                        >Your Resume</Label
                    >
                    <Textarea
                        id="resume_text"
                        v-model="resumeText"
                        placeholder="Paste your resume text here..."
                        class="h-64 resize-none overflow-y-auto"
                    />
                </div>
            </div>

            <div v-else class="flex-1 space-y-4 overflow-y-auto pr-1">
                <div class="flex items-center gap-3">
                    <Badge class="px-3 py-1 text-base"
                        >{{ result.score }}/100</Badge
                    >
                    <p class="text-sm text-muted-foreground">
                        {{ result.summary }}
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <h3
                            class="mb-2 text-xs font-medium text-muted-foreground"
                        >
                            Matched Skills
                        </h3>
                        <div class="flex flex-wrap gap-1">
                            <Badge
                                v-for="s in result.matched_skills"
                                :key="s"
                                variant="secondary"
                                class="border-l-2 border-l-emerald-500 text-xs"
                            >
                                {{ s }}
                            </Badge>
                        </div>
                    </div>
                    <div>
                        <h3
                            class="mb-2 text-xs font-medium text-muted-foreground"
                        >
                            Missing Skills
                        </h3>
                        <div class="flex flex-wrap gap-1">
                            <Badge
                                v-for="s in result.missing_skills"
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
                        <li v-for="(r, i) in result.recommendations" :key="i">
                            {{ r }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <Button variant="outline" @click="dialogOpen = false"
                    >Close</Button
                >
                <Button
                    v-if="!result"
                    :disabled="isSubmitting || !resumeText"
                    @click="runAnalysis"
                >
                    {{ isSubmitting ? 'Analyzing...' : 'Run Analysis' }}
                </Button>
            </div>
        </DialogContent>
    </Dialog>
</template>
