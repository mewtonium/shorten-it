<script setup lang="ts">
import FlashBanner from '@/components/FlashBanner.vue';
import InputError from '@/components/InputError.vue';
import ShortenedUrlResults from '@/components/ShortenedUrlResults.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    url: '',
});

const submit = () => {
    form.post(route('url.shorten'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <FlashBanner />
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex min-h-screen flex-col items-center bg-background p-6 text-[#1b1b18] dark:bg-[#0a0a0a] lg:justify-center lg:p-8">
        <div class="duration-750 starting:opacity-0 flex w-full grow items-center justify-center opacity-100 transition-opacity">
            <main class="flex w-full flex-col lg:max-w-4xl">
                <h1 class="mb-10 text-center text-4xl font-bold text-blue-500 dark:text-blue-300 sm:text-5xl lg:mb-16 lg:text-6xl">
                    {{ $page.props.name }}!
                </h1>

                <form @submit.prevent="submit" class="flex flex-col gap-4">
                    <div class="grid gap-2">
                        <Label for="url" class="sr-only" aria-label="URL">URL</Label>
                        <Input
                            id="url"
                            type="text"
                            required
                            autofocus
                            :tabindex="1"
                            v-model="form.url"
                            placeholder="Enter a URL to shorten - e.g. https://www.google.co.uk"
                            class="h-12 md:text-lg"
                        />
                        <InputError :message="form.errors.url" />
                    </div>

                    <div class="flex justify-center">
                        <Button type="submit" size="xl" class="w-full text-lg sm:w-auto" :tabindex="4" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Shorten URL
                        </Button>
                    </div>
                </form>

                <ShortenedUrlResults :url="$page.props?.flash?.url" />
            </main>
        </div>
    </div>
</template>
