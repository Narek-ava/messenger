<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// Импортируем Messenger чат (путь зависит от того, где лежит компонент)
// import Messenger from '@/Components/Messenger.vue'; // или './vendor/messenger/Messenger.vue'

</script>
<script>

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('88f32a92d9d13b500392', {
    cluster: 'ap2'
});

var channel = pusher.subscribe('some-event');
channel.bind('some-event', function(data) {
    alert(JSON.stringify(data));
});
</script>
<template>
    <Head title="Chat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
                {{ $page.props.translations.dashboard }}
            </h2>
        </template>

        <div class="py-12">
            <!-- Вот тут вставляем чат -->
            <div
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
            >
                <iframe src="/messenger"
                        class="w-full h-[800px] border-none" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
