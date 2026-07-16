import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

export interface SkillAnalysis {
    id: number;
    application_id: number;
    resume_text: string;
    score: number;
    matched_skills: string[];
    missing_skills: string[];
    recommendations: string[];
    summary: string | null;
    created_at: string;
    created_at_formatted: string;
    application?: {
        id: number;
        company: string;
        role: string;
    };
}

export function useAnalysis() {
    const resumeText = ref('');
    const isSubmitting = ref(false);
    const result = ref<SkillAnalysis | null>(null);

    function submit(applicationId: number, onSuccess?: () => void) {
        isSubmitting.value = true;
        router.post(
            '/analysis',
            { application_id: applicationId, resume_text: resumeText.value },
            {
                preserveScroll: true,
                onSuccess: (page) => {
                    result.value = (page.props.flash as any)?.analysis ?? null;
                    isSubmitting.value = false;
                    onSuccess?.();
                },
                onError: () => {
                    isSubmitting.value = false;
                },
            },
        );
    }

    function reset() {
        resumeText.value = '';
        result.value = null;
    }

    return { resumeText, isSubmitting, result, submit, reset };
}
