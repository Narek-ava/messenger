<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-white"
            >
                {{ $page.props.translations.dashboard}}

            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <a :href="route('set.locale', 'en')">English</a><br>
                        <a :href="route('set.locale', 'ru')">Русский</a><br>
                        <a :href="route('set.locale', 'zh')">中文</a>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
