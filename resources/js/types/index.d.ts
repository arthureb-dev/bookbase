import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export type { ColumnFiltersState, ExpandedState, SortingState, VisibilityState } from '@tanstack/vue-table';

export interface Auth {
    user: User;
    permissions: {
        book: {
            manage: boolean;
        };
    };
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
    permission?: string;
    children?: NavItem[];
}

export interface SharedData extends PageProps {
    name: string;
    auth: Auth;
    ziggy: Config & { location: string };
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface BookCategories {
    [key: string]: string;
}

export interface BookStates {
    [index: number]: string;
}

export interface Review {
    id?: string;
    user?: User | null;
    comments: string;
    rating: number;
    created_at?: string | null;
}

export interface Book {
    id?: string;
    slug?: string;
    title?: string;
    description?: string;
    author?: string;
    publisher?: string;
    category?: string;
    isbn?: string;
    state?: string;
    cover_image?: File | string | null;
    published_at?: string | null;
    page_count?: number;
    checked_out_at?: string | null;
    due_date?: string | null;
    checked_out_by?: User | null;
    deleted_at?: string | null;
    average_rating?: number;
    review_count?: number;
    reviews?: Review[];
}

export type BreadcrumbItemType = BreadcrumbItem;
