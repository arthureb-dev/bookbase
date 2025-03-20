<script setup lang="ts">
import BookCard from '@/components/BookCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type Book, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ArrowUpNarrowWide, ChevronDown } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps<{ books: Book[] }>();
const { books } = props;

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Books', href: '/books' },
    { title: 'Browse Curated List of Featured Books', href: '/books' },
];

ref(false);
const sortOpen = ref(false);
const filterText = ref('');
const sortBy = ref('');

const filters = [
    {
        id: 'availability',
        name: 'Availability',
        options: [
            { value: 'available', label: 'Available' },
            { value: 'checked_out', label: 'Checked Out' },
        ],
    },
];

ref(filters.map(() => false));
ref(filters.map(() => false));

const filteredBooks = computed(() => {
    let result = books.slice();

    // Filter by search text (Title or Author)
    if (filterText.value) {
        const text = filterText.value.toLowerCase();
        result = result.filter((b) => b.title?.toLowerCase().includes(text) || b.author?.toLowerCase().includes(text));
    }

    if (sortBy.value === 'availability') {
        result = result.filter((b) => b.state === 'available');
    }

    if (sortBy.value === 'title') {
        result.sort((a, b) => (a.title || '').localeCompare(b.title || ''));
    } else if (sortBy.value === 'author') {
        result.sort((a, b) => (a.author || '').localeCompare(b.author || ''));
    }

    return result;
});
</script>

<template>
    <Head title="Books" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto w-full p-6">
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <div class="flex max-w-sm flex-1 items-center space-x-2">
                    <input
                        v-model="filterText"
                        type="text"
                        placeholder="Search by title or author..."
                        class="border-border focus:border-primary focus:ring-primary w-full rounded-md border p-2"
                    />
                </div>
                <div class="relative inline-block text-left">
                    <ArrowUpNarrowWide class="mr-2 inline-block" />
                    <button
                        type="button"
                        class="group text-foreground hover:text-foreground/80 inline-flex items-center justify-center text-sm font-medium"
                        @click="sortOpen = !sortOpen"
                    >
                        Sort
                        <ChevronDown class="text-primary group-hover:text-muted-foreground ml-1 h-5 w-5" />
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
                                    @click.prevent="
                                        sortBy = 'title';
                                        sortOpen = false;
                                    "
                                    class="text-foreground hover:bg-secondary block cursor-pointer px-4 py-2 text-sm font-medium"
                                >
                                    Title (A-Z)
                                </a>
                                <a
                                    @click.prevent="
                                        sortBy = 'author';
                                        sortOpen = false;
                                    "
                                    class="text-foreground hover:bg-secondary block cursor-pointer px-4 py-2 text-sm font-medium"
                                >
                                    Author (A-Z)
                                </a>
                                <a
                                    @click.prevent="
                                        sortBy = 'availability';
                                        sortOpen = false;
                                    "
                                    class="text-foreground hover:bg-secondary block cursor-pointer px-4 py-2 text-sm font-medium"
                                >
                                    Availability
                                </a>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>

        <!-- Books grid -->
        <div class="grid gap-4 p-6 md:grid-cols-3">
            <div v-for="book in filteredBooks" :key="book.id" class="border-sidebar-border/70 rounded-xl border">
                <BookCard :book="book" />
            </div>
        </div>
    </AppLayout>
</template>
