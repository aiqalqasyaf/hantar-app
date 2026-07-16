import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';

export interface Application {
    id: number;
    company: string;
    role: string;
    status: 'applied' | 'interview' | 'offer' | 'rejected';
    applied_at: string;
    applied_at_formatted: string;
    job_url: string | null;
    notes: string | null;
}

export function useApplications() {
    const form = reactive({
        id: null as number | null,
        company: '',
        role: '',
        status: 'applied' as Application['status'],
        applied_at: '',
        job_url: '',
        notes: '',
    });

    function resetForm() {
        form.id = null;
        form.company = '';
        form.role = '';
        form.status = 'applied';
        form.applied_at = '';
        form.job_url = '';
        form.notes = '';
    }

    function editApplication(app: Application) {
        form.id = app.id;
        form.company = app.company;
        form.role = app.role;
        form.status = app.status;
        form.applied_at = app.applied_at;
        form.job_url = app.job_url ?? '';
        form.notes = app.notes ?? '';
    }

    function submit(onSuccess: () => void) {
        const payload = { ...form };

        if (form.id) {
            router.put(`/applications/${form.id}`, payload, {
                onSuccess,
                preserveScroll: true,
            });
        } else {
            router.post('/applications', payload, {
                onSuccess,
                preserveScroll: true,
            });
        }
    }

    function updateStatus(app: Application, status: Application['status']) {
        router.put(
            `/applications/${app.id}`,
            { ...app, status },
            { preserveScroll: true },
        );
    }

    function destroy(id: number) {
        router.delete(`/applications/${id}`, { preserveScroll: true });
    }

    return { form, resetForm, editApplication, submit, updateStatus, destroy };
}
