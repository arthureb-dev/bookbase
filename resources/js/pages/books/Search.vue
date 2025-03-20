<script setup lang="ts">
import BookCard from '@/components/BookCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Book, BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{ books: Book[]; search?: string }>();
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Books', href: '/books' },
    { title: 'Search Books', href: '/books/search' },
];

const form = useForm({
    q: props.search || '',
});

function submitSearch() {
    form.get(route('books.search'), {
        preserveState: true,
        preserveScroll: true,
    });
}

function decodeHTMLEntities(text: string): string {
    const txt = document.createElement('textarea');
    txt.innerHTML = text;
    return txt.value;
}
</script>

<template>
    <Head title="Books" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto p-6">
            <form @submit.prevent="submitSearch" class="mx-auto mb-6 flex w-full max-w-3xl gap-2">
                <input
                    v-model="form.q"
                    type="text"
                    placeholder="Search by title, author, etc."
                    class="border-border focus:border-primary focus:ring-primary w-full flex-1 rounded-md border p-2"
                />
                <button type="submit" class="bg-primary text-primary-foreground hover:bg-primary/90 rounded-md px-4 py-2">Search</button>
            </form>

            <div class="grid gap-4 md:grid-cols-3">
                <div v-for="book in books.data" :key="book.id" class="border-sidebar-border/70 rounded-xl border">
                    <BookCard :book="book" />
                </div>
            </div>

            <div class="mt-6">
                <Link v-for="link in books.meta.links" :key="link.label" :href="link.url" class="mx-1">
                    {{ decodeHTMLEntities(link.label) }}
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
