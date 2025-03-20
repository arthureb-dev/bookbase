<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuCheckboxItem, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { formatLabel, getStatusVariant } from '@/composables/useFormatter';
import { showToast } from '@/composables/useToasts';
import AppLayout from '@/layouts/AppLayout.vue';
import { cn, valueUpdater } from '@/lib/utils';
import type { Book, BreadcrumbItem, ColumnFiltersState, ExpandedState, SortingState, VisibilityState } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    createColumnHelper,
    FlexRender,
    getCoreRowModel,
    getExpandedRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    useVueTable,
} from '@tanstack/vue-table';
import { ArrowUpDown, ChevronDown, Plus } from 'lucide-vue-next';
import { h, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Books', href: '/books' },
    { title: 'Manage Books', href: '/books/manage' },
];

const props = defineProps<{
    books: Book[];
}>();

const columnHelper = createColumnHelper<Book>();

const columns = [
    columnHelper.accessor('cover_image', {
        header: 'Cover Image',
        cell: ({ row }) => h('img', { class: 'size-10 rounded object-contain', src: row.getValue('cover_image') }, row.getValue('cover_image')),
    }),
    columnHelper.accessor('title', {
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    class: 'p-1',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Title', h(ArrowUpDown, { class: 'ml-1 h-4 w-4' })],
            );
        },
        cell: ({ row }) => h('div', { class: 'truncate max-w-[100px]' }, row.getValue('title')),
    }),
    columnHelper.accessor('author', {
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    class: 'p-1',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Author', h(ArrowUpDown, { class: 'ml-1 h-4 w-4' })],
            );
        },
        cell: ({ row }) => h('div', row.getValue('author')),
    }),
    columnHelper.accessor('publisher', {
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    class: 'p-1',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Publisher', h(ArrowUpDown, { class: 'ml-1 h-4 w-4' })],
            );
        },
        cell: ({ row }) => h('div', row.getValue('publisher')),
    }),
    columnHelper.accessor('category', {
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    class: 'p-1',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Category', h(ArrowUpDown, { class: 'ml-1 h-4 w-4' })],
            );
        },
        cell: ({ row }) => h('div', { class: 'capitalize' }, formatLabel(row.getValue('category'))),
    }),
    columnHelper.accessor('state', {
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    class: 'p-1',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Status', h(ArrowUpDown, { class: 'ml-1 h-4 w-4' })],
            );
        },
        cell: ({ row }) => h(Badge, { class: 'capitalize', variant: getStatusVariant(row.getValue('state')) }, formatLabel(row.getValue('state'))),
    }),
    columnHelper.accessor('published_at', {
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    class: 'p-1',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Published Date', h(ArrowUpDown, { class: 'ml-1 h-4 w-4' })],
            );
        },
        cell: ({ row }) => h('div', row.getValue('published_at')),
    }),
    columnHelper.display({
        header: 'Actions',
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const book = row.original;
            return h('div', { class: 'relative flex space-x-2 w-full items-center' }, [
                h(Button, { as: 'a', size: 'sm', href: route('books.show', book.id), class: '' }, 'View'),
                h(Button, { as: 'a', variant: 'outline', size: 'sm', href: route('books.edit', book.id), class: '' }, 'Edit'),
                h(
                    Button,
                    {
                        size: 'sm',
                        variant: 'destructive',
                        onClick: () => {
                            router.delete(route('books.destroy', book.id), {
                                onBefore: () => confirm(`Are you sure you want to delete "${book.title}"?`),
                                onSuccess: () => {
                                    router.reload();
                                    showToast('Book has been removed from library.', 'success');
                                },
                                onError: () => showToast('Something went wrong while deleting the book.', 'error'),
                            });
                        },
                    },
                    'Delete',
                ),
            ]);
        },
    }),
];

const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);
const columnVisibility = ref<VisibilityState>({});
const rowSelection = ref({});
const expanded = ref<ExpandedState>({});

const table = useVueTable({
    data: props.books,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: (updaterOrValue) => valueUpdater(updaterOrValue, rowSelection),
    onExpandedChange: (updaterOrValue) => valueUpdater(updaterOrValue, expanded),
    state: {
        get sorting() {
            return sorting.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
        get columnVisibility() {
            return columnVisibility.value;
        },
        get rowSelection() {
            return rowSelection.value;
        },
        get expanded() {
            return expanded.value;
        },
        columnPinning: { left: ['select'] },
    },
});
</script>

<template>
    <Head title="Manage Books" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-2xl font-bold">All Books</h1>
                <Link
                    :href="route('books.create')"
                    class="bg-primary hover:bg-primary/90 flex items-center rounded-lg px-4 py-2 text-white transition-colors"
                >
                    <Plus class="mr-1 h-4 w-4" /> Create Book
                </Link>
            </div>

            <div class="w-full">
                <div class="flex items-center gap-2 py-4">
                    <Input
                        class="max-w-sm"
                        placeholder="Filter title..."
                        :model-value="table.getColumn('title')?.getFilterValue() as string"
                        @update:model-value="table.getColumn('title')?.setFilterValue($event)"
                    />
                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <Button variant="outline" class="ml-auto"> Columns <ChevronDown class="ml-2 h-4 w-4" /> </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                            <DropdownMenuCheckboxItem
                                v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
                                :key="column.id"
                                class="capitalize"
                                :model-value="column.getIsVisible()"
                                @update:model-value="
                                    (value) => {
                                        column.toggleVisibility(!!value);
                                    }
                                "
                            >
                                {{ formatLabel(column.id) }}
                            </DropdownMenuCheckboxItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>

                <div class="rounded-md border">
                    <Table>
                        <TableHeader>
                            <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                                <TableHead
                                    v-for="header in headerGroup.headers"
                                    :key="header.id"
                                    :data-pinned="header.column.getIsPinned()"
                                    :class="
                                        cn(
                                            { 'bg-background/95 sticky': header.column.getIsPinned() },
                                            header.column.getIsPinned() === 'left' ? 'left-0' : 'right-0',
                                        )
                                    "
                                >
                                    <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <template v-if="table.getRowModel().rows?.length">
                                <template v-for="row in table.getRowModel().rows" :key="row.id">
                                    <TableRow :data-state="row.getIsSelected() && 'selected'">
                                        <TableCell
                                            v-for="cell in row.getVisibleCells()"
                                            :key="cell.id"
                                            :data-pinned="cell.column.getIsPinned()"
                                            :class="
                                                cn(
                                                    { 'bg-background/95 sticky': cell.column.getIsPinned() },
                                                    cell.column.getIsPinned() === 'left' ? 'left-0' : 'right-0',
                                                )
                                            "
                                        >
                                            <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                        </TableCell>
                                    </TableRow>
                                    <TableRow v-if="row.getIsExpanded()">
                                        <TableCell :colspan="row.getAllCells().length">
                                            {{ row.original }}
                                        </TableCell>
                                    </TableRow>
                                </template>
                            </template>

                            <TableRow v-else>
                                <TableCell :colspan="columns.length" class="h-24 text-center"> No results. </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>

                <div class="flex items-center justify-end space-x-2 py-4">
                    <div class="text-muted-foreground flex-1 text-sm">
                        {{ table.getFilteredSelectedRowModel().rows.length }} of {{ table.getFilteredRowModel().rows.length }} row(s) selected.
                    </div>
                    <div class="space-x-2">
                        <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()" @click="table.previousPage()"> Previous </Button>
                        <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()" @click="table.nextPage()"> Next </Button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
