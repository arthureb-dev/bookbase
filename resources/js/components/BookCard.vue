<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { formatLabel, getStatusVariant } from '@/composables/useFormatter';
import type { Book } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Star } from 'lucide-vue-next';

const { book } = defineProps<{ book: Book }>();
</script>

<template>
    <div class="group bg-card h-full rounded-lg p-4 shadow-md transition-shadow hover:shadow-lg">
        <div class="relative overflow-hidden rounded-lg">
            <img :src="book.cover_image" alt="Book Cover" class="h-64 w-full object-cover transition-transform duration-300 group-hover:scale-105" />
            <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 transition-all duration-300 group-hover:opacity-100">
                <Link
                    :href="route('books.show', book.id)"
                    class="bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg px-4 py-2 transition-colors"
                >
                    View Details
                </Link>
            </div>
        </div>
        <div class="mt-4 space-y-1">
            <h3 class="text-foreground text-xl font-bold">{{ book.title }}</h3>
            <p class="text-muted-foreground text-sm">Author: {{ book.author }}</p>
            <div class="flex items-center">
                <div class="flex space-x-1">
                    <Star v-for="n in 5" :key="n" :class="[book.average_rating >= n ? 'text-yellow-400' : 'text-gray-300']" class="h-4 w-4" />
                </div>
                <span class="text-muted-foreground ml-2 text-sm">({{ book.review_count }})</span>
            </div>
            <p class="text-muted-foreground my-2 text-sm">{{ book.description }}</p>
            <Badge :variant="getStatusVariant(book.state)">{{ formatLabel(book.state || '') }}</Badge>
        </div>
    </div>
</template>
