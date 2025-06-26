<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { register } from 'vue-advanced-chat'
import { ref, onMounted, onBeforeUnmount } from 'vue'

register()

const currentUserId = ref('1234')
const selectedRoomId = ref('room1')
const rooms = ref([])
const messages = ref([])

// тема
const isDark = ref(false)
const chatTheme = ref('light')

function setTheme(dark) {
    isDark.value = dark
    chatTheme.value = dark ? 'dark' : 'light'

    if (dark) {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }

    localStorage.setItem('theme', dark ? 'dark' : 'light')
}

// переключение темы
function toggleTheme() {
    setTheme(!isDark.value)

    // синхронизация между компонентами
    window.dispatchEvent(new CustomEvent('theme-changed', {
        detail: { theme: isDark.value ? 'dark' : 'light' }
    }))
}

// слушаем смену темы глобально
function handleThemeChange(event) {
    const newTheme = event.detail.theme
    isDark.value = newTheme === 'dark'
    chatTheme.value = newTheme
}

onMounted(() => {
    // слушаем глобальное событие
    window.addEventListener('theme-changed', handleThemeChange)

    // установка темы из localStorage
    const savedTheme = localStorage.getItem('theme')
    if (savedTheme === 'dark') {
        setTheme(true)
    } else if (savedTheme === 'light') {
        setTheme(false)
    } else {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
        setTheme(prefersDark)
    }

    // пример комнаты и сообщений
    rooms.value = [
        {
            roomId: 'room1',
            roomName: 'Общий чат',
            avatar: 'https://i.pravatar.cc/150?img=5',
            users: [
                {
                    _id: '1234',
                    username: 'Вы',
                    avatar: 'https://i.pravatar.cc/150?img=1',
                    status: { state: 'online', lastChanged: 'today, 14:30' }
                },
                {
                    _id: '5678',
                    username: 'Бот',
                    avatar: 'https://i.pravatar.cc/150?img=2',
                    status: { state: 'online', lastChanged: 'today, 14:35' }
                }
            ],
            typingUsers: []
        }
    ]

    messages.value = [
        {
            _id: 'msg1',
            content: 'Привет! Я бот 🤖',
            senderId: '5678',
            timestamp: new Date().toISOString()
        },
        {
            _id: 'msg2',
            content: 'Привет, бот!',
            senderId: '1234',
            timestamp: new Date().toISOString()
        }
    ]
})

onBeforeUnmount(() => {
    window.removeEventListener('theme-changed', handleThemeChange)
})
</script>

<template>
    <Head title="Чат" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
                {{ $page.props.translations.chat }}
            </h2>
        </template>

        <div class="py-6 px-4">
            <vue-advanced-chat
                :current-user-id="currentUserId"
                :rooms="rooms"
                :messages="messages"
                :room-id="selectedRoomId"
                :theme="chatTheme"
                height="600px"
            />
        </div>
    </AuthenticatedLayout>
</template>
