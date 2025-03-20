<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Star } from 'lucide-vue-next';
</script>

<template>
    <div class="group bg-card rounded-lg p-4 shadow-md transition-shadow hover:shadow-lg">
        <div class="relative overflow-hidden rounded-lg">
            <img
                src="../../images/book-card.jpg"
                alt="Book Cover"
                class="h-64 w-full object-cover transition-transform duration-300 group-hover:scale-105"
            />
            <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 transition-all duration-300 group-hover:opacity-100">
                <Link href="#" class="bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg px-4 py-2 transition-colors">
                    Quick View
                </Link>
            </div>
        </div>
        <div class="mt-4 space-y-1">
            <h3 class="text-foreground text-xl font-bold">The Silent Echo</h3>
            <p class="text-muted-foreground text-sm">by Sarah Johnson</p>
            <div class="flex items-center">
                <div class="flex space-x-1">
                    <Star class="h-4 w-4 text-yellow-400" />
                    <Star class="h-4 w-4 text-yellow-400" />
                    <Star class="h-4 w-4 text-yellow-400" />
                    <Star class="h-4 w-4 text-yellow-400" />
                    <Star class="h-4 w-4 text-yellow-400" />
                </div>
                <span class="text-muted-foreground ml-2 text-sm">(128)</span>
            </div>
        </div>
    </div>
</template>
