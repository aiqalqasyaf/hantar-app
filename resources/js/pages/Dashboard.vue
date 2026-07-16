<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import {
    Chart as ChartJS,
    ArcElement,
    Tooltip,
    Legend,
    CategoryScale,
    LinearScale,
    BarElement,
} from 'chart.js';
import { Doughnut, Bar } from 'vue-chartjs';
import { Badge } from '@/components/ui/badge';
import {
    useStatusChartData,
    useTimeChartData,
} from '@/composables/useDashboard';
import { dashboard } from '@/routes';

const statusColors: Record<string, string> = {
    applied: 'border-l-4 border-l-blue-500',
    interview: 'border-l-4 border-l-amber-500',
    offer: 'border-l-4 border-l-emerald-500',
    rejected: 'border-l-4 border-l-red-500',
};

ChartJS.register(
    ArcElement,
    Tooltip,
    Legend,
    CategoryScale,
    LinearScale,
    BarElement,
);

const props = defineProps<{
    statusCounts: Record<string, number>;
    applicationsOverTime: { date: string; count: number }[];
    avgScore: number;
    analysisCount: number;
    recentAnalyses: any[];
    recentApplications: any[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Dashboard', href: dashboard() }],
    },
});

const statusChartData = useStatusChartData(props.statusCounts);
const timeChartData = useTimeChartData(props.applicationsOverTime);

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    devicePixelRatio: window.devicePixelRatio * 2,
    plugins: { legend: { labels: { boxWidth: 10, font: { size: 11 } } } },
};

const totalApplications = Object.values(props.statusCounts).reduce(
    (a, b) => a + b,
    0,
);
</script>

<template>
    <Head title="Dashboard" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
            >
                <h3 class="mb-2 text-sm font-medium text-muted-foreground">
                    Application Status
                </h3>
                <div class="h-48">
                    <Doughnut :data="statusChartData" :options="chartOptions" />
                </div>
                <p class="mt-2 text-center text-xs text-muted-foreground">
                    {{ totalApplications }} total applications
                </p>
            </div>

            <div
                class="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
            >
                <h3 class="mb-2 text-sm font-medium text-muted-foreground">
                    Applications Over Time
                </h3>
                <div class="h-48">
                    <Bar
                        :data="timeChartData"
                        :options="{
                            ...chartOptions,
                            plugins: { legend: { display: false } },
                        }"
                    />
                </div>
            </div>

            <div
                class="relative flex flex-col justify-center overflow-hidden rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
            >
                <h3 class="mb-2 text-sm font-medium text-muted-foreground">
                    Avg. Skill-Gap Score
                </h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-semibold">{{ avgScore }}</span>
                    <span class="text-lg text-muted-foreground">/100</span>
                </div>
                <p class="mt-2 text-xs text-muted-foreground">
                    Based on {{ analysisCount }} analyses run
                </p>
            </div>
        </div>

        <div
            class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border"
        >
            <h3 class="mb-4 text-sm font-medium text-muted-foreground">
                Recent Activity
            </h3>
            <div class="space-y-2">
                <div
                    v-for="app in recentApplications"
                    :key="`app-${app.id}`"
                    :class="[
                        'flex items-center justify-between rounded-md border p-3 text-sm',
                        statusColors[app.status],
                    ]"
                >
                    <div>
                        <span class="font-medium">{{ app.company }}</span>
                        <span class="text-muted-foreground">
                            — {{ app.role }}</span
                        >
                    </div>
                    <div class="flex items-center gap-2">
                        <Badge variant="secondary" class="text-xs capitalize">{{
                            app.status
                        }}</Badge>
                        <span class="text-xs text-muted-foreground">{{
                            app.applied_at_formatted
                        }}</span>
                    </div>
                </div>

                <div
                    v-for="analysis in recentAnalyses"
                    :key="`analysis-${analysis.id}`"
                    class="flex items-center justify-between rounded-md border p-3 text-sm"
                >
                    <div>
                        <span class="font-medium">{{
                            analysis.application?.company
                        }}</span>
                        <span class="text-muted-foreground">
                            — Skill Gap Analysis</span
                        >
                    </div>
                    <Badge class="text-xs">{{ analysis.score }}/100</Badge>
                </div>

                <p
                    v-if="
                        recentApplications.length === 0 &&
                        recentAnalyses.length === 0
                    "
                    class="py-12 text-center text-sm text-muted-foreground"
                >
                    No activity yet.
                </p>
            </div>
        </div>
    </div>
</template>
