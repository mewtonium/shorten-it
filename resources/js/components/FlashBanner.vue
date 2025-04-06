<script setup lang="ts">
import Icon from '@/components/Icon.vue';
import { type SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface Props {
    closeable?: boolean;
}

withDefaults(defineProps<Props>(), {
    closeable: true,
});

const page = usePage<SharedData>();

const isOpen = ref(true);
const close = () => (isOpen.value = false);

const bannerMessage = computed(() => page.props.flash?.banner?.message);
const bannerType = computed(() => page.props.flash?.banner?.type || 'info');
</script>

<template>
    <div
        v-if="bannerMessage && isOpen"
        class="fixed flex min-h-16 w-full items-center justify-center py-4"
        :class="{
            'bg-blue-400 text-blue-900': bannerType === 'info',
            'bg-emerald-400 text-emerald-900': bannerType === 'success',
            'bg-amber-400 text-amber-900': bannerType === 'warning',
            'bg-red-400 text-red-900': bannerType === 'danger',
        }"
    >
        <div class="relative flex w-full items-center justify-center text-center" :class="[closeable ? 'pl-4 pr-16' : 'px-4']">
            {{ bannerMessage }}

            <button
                v-if="closeable"
                @click="close"
                class="absolute right-4 rounded-sm p-2"
                :class="{
                    'bg-blue-300': bannerType === 'info',
                    'bg-emerald-300': bannerType === 'success',
                    'bg-amber-300': bannerType === 'warning',
                    'bg-red-300': bannerType === 'danger',
                }"
                aria-label="Close flash banner"
            >
                <Icon name="x" :strokeWidth="3" />
            </button>
        </div>
    </div>
</template>
