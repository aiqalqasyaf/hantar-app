import { computed } from 'vue';

export function useStatusChartData(statusCounts: Record<string, number>) {
    return computed(() => ({
        labels: ['Applied', 'Interview', 'Offer', 'Rejected'],
        datasets: [
            {
                data: [
                    statusCounts.applied,
                    statusCounts.interview,
                    statusCounts.offer,
                    statusCounts.rejected,
                ],
                backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#ef4444'],
                borderWidth: 0,
            },
        ],
    }));
}

export function useTimeChartData(data: { date: string; count: number }[]) {
    return computed(() => ({
        labels: data.map((d) => d.date),
        datasets: [
            {
                label: 'Applications',
                data: data.map((d) => d.count),
                backgroundColor: '#3b82f6',
                borderRadius: 4,
            },
        ],
    }));
}
