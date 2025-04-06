<script setup lang="ts">
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { type SharedData } from '@/types';
import Icon from '@/components/Icon.vue';

interface Props {
    closeable?: boolean;
};

withDefaults(defineProps<Props>(), {
    closeable: true,
});

const page = usePage<SharedData>();

const isOpen = ref(true);
const close = () => isOpen.value = false;

const bannerMessage = computed(() => page.props.flash?.banner?.message);
const bannerType = computed(() => page.props.flash?.banner?.type || 'info');
</script>

<template>
    <div
        v-if="bannerMessage && isOpen"
        class="fixed w-full min-h-16 py-4 flex justify-center items-center"
        :class="{
            'bg-blue-400 text-blue-900': bannerType === 'info',
            'bg-emerald-400 text-emerald-900': bannerType === 'success',
            'bg-amber-400 text-amber-900': bannerType === 'warning',
            'bg-red-400 text-red-900': bannerType === 'danger',
        }"
    >
        <div
            class="flex w-full justify-center items-center text-center relative"
            :class="[closeable ? 'pl-4 pr-16' : 'px-4']"
        >
            {{ bannerMessage }}

            <button
                v-if="closeable"
                @click="close"
                class="p-2 rounded-sm absolute right-4"
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
