<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import BookCard from '../../components/BookCard.vue';

import { ArrowUpNarrowWide, ChevronDown, X } from 'lucide-vue-next';
import { ref } from 'vue';

const mobileOpen = ref(false);
const sortOpen = ref(false);

const filters = [
    {
        id: 'category',
        name: 'Category',
        options: [
            { value: 'tees', label: 'Tees' },
            { value: 'crewnecks', label: 'Crewnecks' },
            { value: 'hats', label: 'Hats' },
        ],
    },
    {
        id: 'brand',
        name: 'Brand',
        options: [
            { value: 'clothing-company', label: 'Clothing Company' },
            { value: 'fashion-inc', label: 'Fashion Inc.' },
            { value: 'shoes-n-more', label: "Shoes 'n More" },
        ],
    },
    {
        id: 'color',
        name: 'Color',
        options: [
            { value: 'white', label: 'White' },
            { value: 'black', label: 'Black' },
            { value: 'grey', label: 'Grey' },
        ],
    },
    {
        id: 'sizes',
        name: 'Sizes',
        options: [
            { value: 's', label: 'S' },
            { value: 'm', label: 'M' },
            { value: 'l', label: 'L' },
        ],
    },
];

const sortOptions = [
    { name: 'Most Popular', href: '#' },
    { name: 'Best Rating', href: '#' },
    { name: 'Newest', href: '#' },
];

const mobileSections = ref(filters.map(() => false));
function toggleMobileSection(i: number) {
    mobileSections.value[i] = !mobileSections.value[i];
}

const desktopOpen = ref(filters.map(() => false));
function toggleDesktopSection(i: number) {
    desktopOpen.value[i] = !desktopOpen.value[i];
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Books',
        href: '/books',
    },
    {
        title: 'Browse curated list of Featured Books',
        href: '/books',
    },
];
</script>

<template>
    <Head title="Books" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="bg-sidebar">
            <transition name="fade">
                <div v-if="mobileOpen" class="relative z-40 sm:hidden" role="dialog" aria-modal="true">
                    <div class="fixed inset-0 bg-black/25" aria-hidden="true" @click="mobileOpen = false" />

                    <transition name="slide">
                        <div v-if="mobileOpen" class="fixed inset-0 z-40 flex">
                            <div class="bg-card relative ml-auto flex w-full max-w-xs flex-col overflow-y-auto py-4 pb-6 shadow-xl">
                                <div class="flex items-center justify-between px-4">
                                    <h2 class="text-foreground text-lg font-medium">Filters</h2>
                                    <button
                                        type="button"
                                        class="bg-card text-muted hover:bg-muted/10 focus:ring-primary -mr-2 flex h-10 w-10 items-center justify-center rounded-md p-2 focus:ring-2 focus:outline-none"
                                        @click="mobileOpen = false"
                                    >
                                        <span class="sr-only">Close menu</span>
                                        <X class="h-6 w-6" />
                                    </button>
                                </div>

                                <form class="mt-4">
                                    <div v-for="(section, i) in filters" :key="section.id" class="border-border border-t px-4 py-6">
                                        <button
                                            type="button"
                                            class="bg-card text-muted flex w-full items-center justify-between px-2 py-3 text-sm"
                                            @click="toggleMobileSection(i)"
                                        >
                                            <span class="text-foreground font-medium">{{ section.name }}</span>
                                            <span class="ml-6 flex items-center">
                                                <ChevronDown
                                                    :class="[
                                                        mobileSections[i] ? '-rotate-180' : 'rotate-0',
                                                        'h-5 w-5 transform transition-transform',
                                                    ]"
                                                />
                                            </span>
                                        </button>
                                        <div v-if="mobileSections[i]" class="space-y-6 pt-6">
                                            <div v-for="(option, idx) in section.options" :key="option.value" class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid h-4 w-4 grid-cols-1">
                                                        <input
                                                            :id="`mobile-${section.id}-${idx}`"
                                                            :name="`${section.id}[]`"
                                                            :value="option.value"
                                                            type="checkbox"
                                                            class="border-border bg-card checked:border-primary checked:bg-primary focus-visible:outline-primary disabled:border-border disabled:bg-muted disabled:checked:bg-muted col-start-1 row-start-1 appearance-none rounded-sm border focus-visible:outline-2 focus-visible:outline-offset-2 forced-colors:appearance-auto"
                                                        />
                                                        <svg
                                                            class="pointer-events-none col-start-1 row-start-1 h-3.5 w-3.5 self-center justify-self-center stroke-white"
                                                            viewBox="0 0 14 14"
                                                            fill="none"
                                                        >
                                                            <path
                                                                class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                            <path
                                                                class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label :for="`mobile-${section.id}-${idx}`" class="text-muted-foreground text-sm">
                                                    {{ option.label }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </transition>
                </div>
            </transition>

            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:max-w-7xl lg:px-8">
                <section aria-labelledby="filter-heading" class="border-0 py-6">
                    <h2 id="filter-heading" class="sr-only">Product filters</h2>

                    <div class="flex items-center justify-between">
                        <div class="relative inline-block text-left">
                            <ArrowUpNarrowWide />
                            <button
                                type="button"
                                class="group text-foreground hover:text-foreground/80 inline-flex justify-center text-sm font-medium"
                                @click="sortOpen = !sortOpen"
                            >
                                Sort
                                <ChevronDown class="text-primary group-hover:text-muted-foreground -mr-1 ml-1 h-5 w-5 shrink-0" />
                            </button>
                            <transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <div
                                    v-if="sortOpen"
                                    class="bg-card absolute left-0 z-10 mt-2 w-40 origin-top-left rounded-md shadow-2xl ring-1 ring-black/5 focus:outline-none"
                                >
                                    <div class="py-1">
                                        <a
                                            v-for="option in sortOptions"
                                            :key="option.name"
                                            :href="option.href"
                                            class="text-foreground hover:bg-secondary block px-4 py-2 text-sm font-medium"
                                            @click="sortOpen = false"
                                        >
                                            {{ option.name }}
                                        </a>
                                    </div>
                                </div>
                            </transition>
                        </div>

                        <button
                            type="button"
                            class="text-foreground hover:text-foreground/80 inline-block text-sm font-medium sm:hidden"
                            @click="mobileOpen = true"
                        >
                            Filters
                        </button>

                        <div class="hidden sm:flex sm:items-baseline sm:space-x-8">
                            <div v-for="(section, idx) in filters" :key="section.id" class="relative inline-block text-left">
                                <button
                                    type="button"
                                    class="group text-foreground hover:text-foreground/80 inline-flex items-center justify-center text-sm font-medium"
                                    @click="toggleDesktopSection(idx)"
                                >
                                    <span>{{ section.name }}</span>
                                    <span
                                        v-if="idx === 0"
                                        class="bg-secondary text-secondary-foreground ml-1.5 rounded-sm px-1.5 py-0.5 text-xs font-semibold tabular-nums"
                                    >
                                        1
                                    </span>
                                    <ChevronDown class="text-primary group-hover:text-muted-foreground -mr-1 ml-1 h-5 w-5 shrink-0" />
                                </button>
                                <transition
                                    enter-active-class="transition ease-out duration-100"
                                    enter-from-class="transform opacity-0 scale-95"
                                    enter-to-class="transform opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95"
                                >
                                    <div
                                        v-if="desktopOpen[idx]"
                                        class="bg-card absolute right-0 z-10 mt-2 origin-top-right rounded-md p-4 shadow-2xl ring-1 ring-black/5"
                                    >
                                        <form class="space-y-4">
                                            <div v-for="(option, optionIdx) in section.options" :key="option.value" class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid h-4 w-4 grid-cols-1">
                                                        <input
                                                            :id="`filter-${section.id}-${optionIdx}`"
                                                            :name="`${section.id}[]`"
                                                            :value="option.value"
                                                            type="checkbox"
                                                            class="border-border bg-card checked:border-primary checked:bg-primary focus-visible:outline-primary disabled:border-border disabled:bg-muted disabled:checked:bg-muted col-start-1 row-start-1 appearance-none rounded-sm border focus-visible:outline-2 focus-visible:outline-offset-2 forced-colors:appearance-auto"
                                                        />
                                                        <svg
                                                            class="pointer-events-none col-start-1 row-start-1 h-3.5 w-3.5 self-center justify-self-center stroke-white"
                                                            viewBox="0 0 14 14"
                                                            fill="none"
                                                        >
                                                            <path
                                                                class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                            <path
                                                                class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label
                                                    :for="`filter-${section.id}-${optionIdx}`"
                                                    class="text-foreground pr-6 text-sm font-medium whitespace-nowrap"
                                                >
                                                    {{ option.label }}
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="border-sidebar-border/70 dark:border-sidebar-border rounded-xl border">
                <BookCard />
            </div>
            <div class="border-sidebar-border/70 dark:border-sidebar-border rounded-xl border">
                <BookCard />
            </div>
            <div class="border-sidebar-border/70 dark:border-sidebar-border rounded-xl border">
                <BookCard />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.3s;
}
.slide-enter-from,
.slide-leave-to {
    transform: translateX(100%);
}
</style>
