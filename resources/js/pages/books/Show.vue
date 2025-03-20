<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { formatLabel, getStatusVariant } from '@/composables/useFormatter';
import { showToast } from '@/composables/useToasts';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Book, BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { StarIcon } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    book: Book;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Books', href: '/books' },
    { title: props.book.title || 'Book Details', href: `/books/${props.book.id}` },
];

const newReview = ref<{ comments: string; rating: number }>({
    comments: '',
    rating: 5,
});

function submitReview() {
    if (!newReview.value.comments.trim()) return;

    router.post(route('books.review', props.book.id), newReview.value, {
        onSuccess: () => {
            showToast('Review submitted successfully!', 'success');
            newReview.value = { comments: '', rating: 5 };
        },
        onError: (res) => {
            showToast(res[0], 'error');
        },
    });
}

function checkoutBook() {
    router.patch(
        route('books.checkout', props.book.id),
        {},
        {
            onBefore: () => confirm(`Are you sure you want to check out this book? It will be due in 5 days.`),
            onSuccess: () => showToast('Book checked out from library.', 'success'),
            onError: () => showToast('Something went wrong while checking out the book.', 'error'),
        },
    );
}
</script>

<template>
    <Head title="Book Details" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-4xl bg-white p-6">
            <div class="flex flex-col gap-6 md:flex-row">
                <div class="md:w-1/3">
                    <img :src="props.book.cover_image" alt="Cover Image" class="h-auto w-full rounded object-cover" />
                </div>
                <div class="md:w-2/3">
                    <h1 class="mb-2 text-3xl font-bold">{{ props.book.title }}</h1>
                    <p class="mb-4 text-gray-600">{{ props.book.description }}</p>
                    <ul class="mb-4 space-y-1">
                        <li><strong>Author:</strong> {{ props.book.author }}</li>
                        <li><strong>Publisher:</strong> {{ props.book.publisher }}</li>
                        <li><strong>Category:</strong> {{ formatLabel(props.book.category || '') }}</li>
                        <li><strong>ISBN:</strong> {{ props.book.isbn }}</li>
                        <li>
                            <strong>Status:</strong>
                            <Badge :variant="getStatusVariant(props.book.state)">{{ formatLabel(props.book.state || '') }}</Badge>
                        </li>
                        <li><strong>Published:</strong> {{ props.book.published_at }}</li>
                        <li><strong>Page Count:</strong> {{ props.book.page_count || 0 }}</li>
                    </ul>
                    <!-- Checkout Button (only if available) -->
                    <div v-if="props.book.state === 'available'">
                        <Button @click="checkoutBook">Check Out</Button>
                    </div>
                    <p v-if="props.book.state === 'checked_out'" class="text-muted-foreground text-sm">Checked out until {{ book.due_date }}</p>
                </div>
            </div>

            <!-- Review Section -->
            <div class="mt-8">
                <h2 class="mb-4 text-2xl font-semibold">Customer Reviews</h2>
                <div v-if="props.book.reviews.length > 0">
                    <div v-for="(review, reviewIdx) in props.book.reviews" :key="review.id" class="flex space-x-4 text-sm text-gray-500">
                        <div class="flex-none py-10">
                            <img :src="review.user.avatar" alt="" class="size-10 rounded-full bg-gray-100" />
                        </div>
                        <div :class="[reviewIdx === 0 ? '' : 'border-t border-gray-200', 'flex-1 py-10']">
                            <h3 class="font-medium text-gray-900">{{ review.user.name }}</h3>
                            <p>
                                <time :datetime="review.created_at">{{ review.created_at }}</time>
                            </p>

                            <div class="mt-4 flex items-center">
                                <StarIcon
                                    v-for="rating in [0, 1, 2, 3, 4]"
                                    :key="rating"
                                    :class="[review.rating > rating ? 'text-yellow-400' : 'text-gray-300', 'size-5 shrink-0']"
                                    aria-hidden="true"
                                />
                            </div>
                            <p class="sr-only">{{ review.rating }} out of 5 stars</p>

                            <div class="mt-4 text-sm/6 text-gray-500" v-html="review.comments" />
                        </div>
                    </div>
                </div>
                <div v-else>
                    <p class="text-gray-600">No reviews yet.</p>
                </div>
                <!-- Review Form -->
                <div class="mt-6 rounded-lg p-6 shadow-sm">
                    <h3 class="mb-2 text-xl font-semibold">Add a Review</h3>
                    <form @submit.prevent="submitReview" class="space-y-4">
                        <div>
                            <Textarea v-model="newReview.comments" placeholder="Write your review here..." class="w-full rounded border p-2" />
                        </div>
                        <div>
                            <label class="mb-1 block font-medium">Rating:</label>
                            <select v-model="newReview.rating" class="w-full rounded border p-2">
                                <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                            </select>
                        </div>
                        <Button type="submit">Submit Review</Button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
