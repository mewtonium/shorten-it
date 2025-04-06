<script setup lang="ts">
import Icon from '@/components/Icon.vue';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';

const props = withDefaults(
    defineProps<{
        value: string;
        iconOnly?: boolean;
    }>(),
    {
        iconOnly: false,
    },
);

const emit = defineEmits<{
    copied: [value: string];
}>();

const canShow: boolean = window.location.protocol === 'https:';

if (!canShow) {
    console.warn('Copy to clipboard will only work on https://');
}

const copied = ref(false);

const copy = () => {
    if (!canShow || !props.value) {
        return;
    }

    window.navigator.clipboard.writeText(props.value).then(() => {
        emit('copied', props.value);

        copied.value = true;
        setTimeout(() => (copied.value = false), 3000);
    });
};
</script>

<template>
    <Button variant="link" v-if="canShow" @click="copy" class="gap-1 hover:no-underline">
        <Icon v-if="copied" name="Check" />
        <Icon v-else name="ClipboardCopy" />

        <span v-show="!iconOnly" v-text="copied ? 'Copied' : 'Copy'" :class="{ 'sr-only': iconOnly }" />
    </Button>
</template>
