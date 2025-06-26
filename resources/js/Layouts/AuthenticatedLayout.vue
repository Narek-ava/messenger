<script setup>
import {onMounted, ref} from 'vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import {Link, usePage} from '@inertiajs/vue3'

const showingNavigationDropdown = ref(false)
const {page} = usePage()

const isDark = ref(false)

function setTheme(dark) {
    isDark.value = dark
    if (dark) {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }
    localStorage.setItem('theme', dark ? 'dark' : 'light')
}

function toggleTheme() {
    setTheme(!isDark.value)
    window.dispatchEvent(new CustomEvent('theme-changed', {
        detail: { theme: isDark.value ? 'dark' : 'light' }
    }))
}

onMounted(() => {
    const savedTheme = localStorage.getItem('theme')
    if (savedTheme === 'dark') {
        setTheme(true)
    } else if (savedTheme === 'light') {
        setTheme(false)
    } else {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
        setTheme(prefersDark)
    }
})
</script>

<template>
    <div
        class="min-h-screen bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
        <nav class="border-b border-gray-100 bg-white dark:bg-gray-800 dark:border-gray-700">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="flex shrink-0 items-center">
                            <Link :href="route('dashboard')">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800 dark:text-white"/>
                            </Link>
                        </div>

                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex ">
                            <NavLink
                                :href="route('dashboard')"
                                class="text-gray-700 dark:text-white"
                                :active="route().current('admin.dashboard.index')">
                                {{ $page.props.translations.dashboard}}
                            </NavLink>
                            <NavLink
                                v-if="$page.props.auth?.is_admin"
                                :href="route('admin.logs.index')"
                                class="text-gray-700 dark:text-white"
                                :active="route().current('admin.logs.index')
                                 ">
                                {{ $page.props.translations.logs}}

                            </NavLink>
                            <NavLink
                                v-if="$page.props.auth?.is_admin"
                                :href="route('admin.requests.index')"
                                class="text-gray-700 dark:text-white"
                                :active="route().current('admin.requests.index')
                                 ">
                                {{ $page.props.translations.requests}}

                            </NavLink>
                            <NavLink
                                v-if="$page.props.auth?.is_admin"
                                :href="route('admin.chat.index')"
                                class="text-gray-700 dark:text-white"
                                :active="route().current('admin.chat.index')
                                 ">
                                {{ $page.props.translations.chat}}

                            </NavLink>

                        </div>
                    </div>

                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                        <div class="relative ms-3">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button
                        type="button"
                        class="inline-flex items-center rounded-md border border-transparent bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-200 hover:text-gray-700 dark:hover:text-white transition"
                    >
                      {{ $page.props.auth.user.name }}
                      <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                           fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                      </svg>
                    </button>
                  </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">{{ $page.props.translations.profile}}</DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">{{ $page.props.translations.logout}}
                                    </DropdownLink>
                                    <button
                                        @click="toggleTheme"
                                        class="mt-2 w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 rounded transition"
                                    >
                                        {{ isDark ? '🌙 ' + $page.props.translations.dark_mode : '☀️ ' + $page.props.translations.light_mode }}
                                    </button>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 dark:focus:bg-gray-700"
                        >
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"/>
                                <path
                                    :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
                <div class="space-y-1 pb-3 pt-2">
                    <ResponsiveNavLink :href="$page.props.auth?.is_admin? route('admin.dashboard.index'):route('dashboard')" :active="$page.props.auth?.is_admin?route().current('admin.dashboard.index'):route().current('dashboard')">
                        {{ $page.props.translations.dashboard}}

                    </ResponsiveNavLink>
                    <ResponsiveNavLink v-if="$page.props.auth?.is_admin" :href="route('admin.logs.index')" :active="route().current('admin.logs.index')">
                        {{ $page.props.translations.logs}}

                    </ResponsiveNavLink>
                    <ResponsiveNavLink v-if="$page.props.auth?.is_admin" :href="route('admin.requests.index')" :active="route().current('admin.requests.index')">
                        {{ $page.props.translations.requests}}

                    </ResponsiveNavLink>
                    <ResponsiveNavLink v-if="$page.props.auth?.is_admin" :href="route('admin.chat.index')" :active="route().current('admin.chat.index')">
                        {{ $page.props.translations.chat}}

                    </ResponsiveNavLink>
                    <button
                        @click="toggleTheme"
                        class="mt-2 w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 rounded transition"
                    >
                        {{ isDark ? '🌙 Dark Mode' : '☀️ Light Mode' }}
                    </button>

                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pb-1 pt-4">
                    <div class="px-4">
                        <div class="text-base font-medium text-gray-800 dark:text-white">
                            {{ $page.props.auth.user.name }}
                        </div>
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                            {{ $page.props.auth.user.email }}
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')">Profile</ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button">Log Out</ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white dark:bg-gray-800 shadow dark:shadow-gray-900" v-if="$slots.header">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <slot name="header"/>
            </div>
        </header>

        <main>
            <slot/>
        </main>
    </div>
</template>
