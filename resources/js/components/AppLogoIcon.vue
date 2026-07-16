<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { Send } from '@lucide/vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <Send />
</template>
