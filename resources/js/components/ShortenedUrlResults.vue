<script setup lang="ts">
defineProps<{
    url?: {
        shortened: string,
        original: string,
        visits: number,
        lastVisitedAt?: string
    }
}>();
</script>

<template>
    <div v-if="url" class="mt-10 flex-1 rounded-lg bg-zinc-50 p-6 py-8 leading-tight shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
        <div class="flex justify-center flex-row text-center">
            <p class="text-2xl mr-2">{{ url.shortened }}</p>
        </div>

        <div class="lg:w-1/2 mx-auto pt-6 mt-6 border-t-2 space-y-3">
            <p><strong>Original URL:</strong> {{ url.original }}</p>
            <p><strong>Visits:</strong> {{ url.visits }}</p>
            <p><strong>Last visited:</strong> {{ url.lastVisitedAt || 'Never' }}</p>
        </div>
    </div>
</template>
