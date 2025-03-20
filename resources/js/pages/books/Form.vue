<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { formatLabel } from '@/composables/useFormatter';
import { showToast } from '@/composables/useToasts';
import AppLayout from '@/layouts/AppLayout.vue';
import { cn } from '@/lib/utils';
import { Book, BookCategories, BookStates, BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { DateFormatter, type DateValue, getLocalTimeZone, parseDate } from '@internationalized/date';
import { Calendar as CalendarIcon, Plus } from 'lucide-vue-next';
import { computed } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Books', href: '/books' },
    { title: 'Manage Books', href: '/books/manage' },
];

const props = defineProps<{
    book?: Book;
    bookCategories: BookCategories;
    bookStates: BookStates;
}>();

const isEdit = computed(() => !!props.book);

const df = new DateFormatter('en-US', { dateStyle: 'short' });

const form = useForm<Book>({
    title: props.book?.title || '',
    description: props.book?.description || '',
    author: props.book?.author || '',
    publisher: props.book?.publisher || '',
    category: props.book?.category || '',
    isbn: props.book?.isbn || '',
    state: props.book?.state || '',
    published_at: props.book?.published_at || '',
    cover_image: null,
});

const publishedAtComputed = computed({
    get() {
        return form.published_at ? parseDate(form.published_at) : undefined;
    },
    set(newValue: DateValue | undefined) {
        form.published_at = newValue ? newValue.toDate(getLocalTimeZone()).toISOString().split('T')[0] : '';
    },
});

function submit() {
    if (isEdit.value) {
        const payload = { ...form.data(), _method: 'put' };
        router.post(route('books.update', props.book?.id), payload, {
            forceFormData: true,
            onSuccess: () => showToast('Great! Book updated successfully.', 'success'),
            onError: () => showToast('Oops! We couldn’t update the book.', 'error'),
        });
    } else {
        form.post(route('books.store'), {
            forceFormData: true,
            onSuccess: () => showToast('A new book has been added successfully!', 'success'),
            onError: () => showToast('We couldn’t save that. Check the form for errors.', 'error'),
        });
    }
}
</script>

<template>
    <Head title="Books" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-2xl p-6">
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-2xl font-bold" v-if="isEdit">Update Book</h1>
                <h1 class="text-2xl font-bold" v-else>Add New Book</h1>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid gap-2">
                    <Label for="title" class="required">Title</Label>
                    <Input id="title" class="mt-1 block w-full" v-model="form.title" placeholder="Title" />
                    <InputError class="mt-2" :message="form.errors.title" />
                </div>
                <div class="grid gap-2">
                    <Label for="description" class="required">Description</Label>
                    <Textarea id="description" v-model="form.description" class="mt-1 block w-full" placeholder="Type book description here..." />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="author" class="required">Author</Label>
                        <Input id="author" class="mt-1 block w-full" v-model="form.author" placeholder="Author" />
                        <InputError class="mt-2" :message="form.errors.author" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="publisher" class="required">Publisher</Label>
                        <Input id="publisher" class="mt-1 block w-full" v-model="form.publisher" placeholder="Publisher" />
                        <InputError class="mt-2" :message="form.errors.publisher" />
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="category" class="required">Category</Label>
                        <Select id="category" v-model="form.category">
                            <SelectTrigger>
                                <SelectValue placeholder="Select a category" />
                            </SelectTrigger>
                            <SelectContent class="sm:min-w-76">
                                <SelectGroup>
                                    <SelectLabel>Book Categories</SelectLabel>
                                    <SelectItem v-for="(label, value) in bookCategories" :key="value" :value="value">
                                        {{ label }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.category" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="isbn" class="required">ISBN</Label>
                        <Input id="isbn" class="mt-1 block w-full" v-model="form.isbn" placeholder="ISBN" />
                        <InputError class="mt-2" :message="form.errors.isbn" />
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="published_at" class="required">Published Date</Label>
                        <Popover>
                            <PopoverTrigger as-child>
                                <Button
                                    variant="outline"
                                    :class="cn('w-[280px] justify-start text-left font-normal', !form.published_at && 'text-muted-foreground')"
                                >
                                    <CalendarIcon class="mr-2 h-4 w-4" />
                                    {{ publishedAtComputed ? df.format(publishedAtComputed.toDate(getLocalTimeZone())) : 'Pick a date' }}
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent class="w-auto p-0">
                                <Calendar v-model="publishedAtComputed" initial-focus />
                            </PopoverContent>
                        </Popover>
                        <InputError :message="form.errors.published_at" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="state" class="required">Status</Label>
                        <Select id="state" v-model="form.state">
                            <SelectTrigger>
                                <SelectValue placeholder="Select book status" />
                            </SelectTrigger>
                            <SelectContent class="sm:min-w-76">
                                <SelectGroup>
                                    <SelectLabel>Book Statuses</SelectLabel>
                                    <SelectItem v-for="value in bookStates" :key="value" :value="value">
                                        {{ formatLabel(value) }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.state" />
                    </div>
                </div>
                <div class="grid gap-2">
                    <Label for="cover_image" :class="isEdit ? '' : 'required'">Cover Image</Label>
                    <Input
                        id="cover_image"
                        type="file"
                        accept="image/*"
                        class="mt-1 block w-full"
                        @input="form.cover_image = $event.target.files[0]"
                        placeholder="Cover Image"
                    />
                    <InputError class="mt-2" :message="form.errors.cover_image" />
                </div>
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">{{ form.progress.percentage }}%</progress>
                <div class="grid gap-2">
                    <Button type="submit" :disabled="form.processing">
                        <Plus class="mr-1 h-4 w-4" />{{ isEdit ? 'Update Book' : 'Add Book' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
