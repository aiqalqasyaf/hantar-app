<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogFooter,
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
import { useApplications } from '@/composables/useApplications';
import type { Application } from '@/composables/useApplications';

const props = defineProps<{ applications: Application[] }>();

const { form, resetForm, editApplication, submit, destroy, errors } =
    useApplications();

const dialogOpen = ref(false);

const columns = [
    { key: 'applied', label: 'Applied' },
    { key: 'interview', label: 'Interview' },
    { key: 'offer', label: 'Offer' },
    { key: 'rejected', label: 'Rejected' },
] as const;

const statusColors: Record<string, string> = {
    applied: 'border-l-4 border-l-blue-500',
    interview: 'border-l-4 border-l-amber-500',
    offer: 'border-l-4 border-l-emerald-500',
    rejected: 'border-l-4 border-l-red-500',
};

const grouped = computed(() => {
    return columns.reduce(
        (acc, col) => {
            acc[col.key] = props.applications.filter(
                (a) => a.status === col.key,
            );

            return acc;
        },
        {} as Record<string, Application[]>,
    );
});

function openCreate() {
    resetForm();
    dialogOpen.value = true;
}

function openEdit(app: Application) {
    editApplication(app);
    dialogOpen.value = true;
}

function handleSubmit() {
    submit(() => {
        dialogOpen.value = false;
        resetForm();
    });
}

function handleDelete(id: number) {
    if (window.confirm('Are you sure you want to delete this item?')) {
        destroy(id);
    }
}
</script>

<template>
    <Head title="Applications" />
    <div class="space-y-6 p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold tracking-tight">Applications</h1>
            <Button @click="openCreate">Add Application</Button>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div v-for="col in columns" :key="col.key" class="space-y-3">
                <div class="flex items-center justify-between px-1">
                    <h2 class="text-sm font-medium text-muted-foreground">
                        {{ col.label }}
                    </h2>
                    <span class="text-xs text-muted-foreground">{{
                        grouped[col.key].length
                    }}</span>
                </div>

                <div class="space-y-3">
                    <Card
                        v-for="app in grouped[col.key]"
                        :key="app.id"
                        :class="[
                            'cursor-pointer transition hover:shadow-sm',
                            statusColors[app.status],
                        ]"
                        @click="openEdit(app)"
                    >
                        <CardHeader>
                            <CardTitle class="text-md font-semibold">{{
                                app.company
                            }}</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-2 pt-0">
                            <p class="text-sm text-muted-foreground">
                                {{ app.role }}
                            </p>
                            <div class="flex items-center justify-between">
                                <Badge variant="outline" class="text-xs">{{
                                    app.applied_at_formatted
                                }}</Badge>
                                <div class="flex gap-2">
                                    <Button
                                        v-if="app.job_url"
                                        :href="app.job_url"
                                        as="a"
                                        target="_blank"
                                        variant="default"
                                        class="h-6 px-2 text-xs"
                                        @click.stop
                                    >
                                        Go to job
                                    </Button>
                                    <Button
                                        variant="destructive"
                                        size="sm"
                                        class="h-6 px-2 text-xs text-destructive hover:text-destructive"
                                        @click.stop="handleDelete(app.id)"
                                    >
                                        Delete
                                    </Button>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </div>

    <Dialog v-model:open="dialogOpen">
        <DialogContent
            class="flex max-h-[85vh] flex-col sm:max-w-md"
            @openAutoFocus="(e) => e.preventDefault()"
        >
            <DialogHeader>
                <DialogTitle>{{
                    form.id ? 'Edit Application' : 'New Application'
                }}</DialogTitle>
            </DialogHeader>

            <div class="flex-1 space-y-4 overflow-y-auto px-1">
                <div class="space-y-2">
                    <Label for="company">Company</Label>
                    <Input
                        id="company"
                        v-model="form.company"
                        placeholder="Acme Inc."
                    />
                    <p v-if="errors.company" class="text-xs text-destructive">
                        {{ errors.company }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="role">Role</Label>
                    <Input
                        id="role"
                        v-model="form.role"
                        placeholder="Software Developer"
                    />
                    <p v-if="errors.role" class="text-xs text-destructive">
                        {{ errors.role }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-0">
                    <div class="space-y-2">
                        <Label>Status</Label>
                        <Select v-model="form.status">
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent class="p-1">
                                <SelectItem
                                    v-for="col in columns"
                                    :key="col.key"
                                    :value="col.key"
                                >
                                    {{ col.label }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                    <p v-if="errors.status" class="text-xs text-destructive">
                        {{ errors.status }}
                    </p>

                    <div class="space-y-2">
                        <Label for="applied_at">Date Applied</Label>
                        <Input
                            id="applied_at"
                            v-model="form.applied_at"
                            type="date"
                        />
                        <p
                            v-if="errors.applied_at"
                            class="text-xs text-destructive"
                        >
                            {{ errors.applied_at }}
                        </p>
                    </div>
                </div>

                <div class="space-y-2">
                    <Label for="job_url">Job URL</Label>
                    <Input
                        id="job_url"
                        v-model="form.job_url"
                        placeholder="https://..."
                    />
                    <p v-if="errors.job_url" class="text-xs text-destructive">
                        {{ errors.job_url }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="job_description">Job Description</Label>
                    <Textarea
                        id="job_description"
                        v-model="form.job_description"
                        placeholder="Paste job description here"
                        class="h-32 resize-none overflow-y-auto"
                    />
                    <p
                        v-if="errors.job_description"
                        class="text-xs text-destructive"
                    >
                        {{ errors.job_description }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="notes">Notes</Label>
                    <Textarea
                        id="notes"
                        v-model="form.notes"
                        placeholder="Any notes..."
                        class="h-24 resize-none overflow-y-auto"
                    />
                </div>
                <p v-if="errors.notes" class="text-xs text-destructive">
                    {{ errors.notes }}
                </p>
            </div>

            <DialogFooter>
                <Button variant="outline" @click="dialogOpen = false"
                    >Cancel</Button
                >
                <Button @click="handleSubmit">{{
                    form.id ? 'Save' : 'Create'
                }}</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
