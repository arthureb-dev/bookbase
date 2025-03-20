<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import BookCard from '@/components/BookCard.vue';
import type { Book } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import {
    Facebook as FacebookIcon,
    Instagram as InstagramIcon,
    Mail as MailIcon,
    MapPin as MapPinIcon,
    Menu as MenuIcon,
    Phone as PhoneIcon,
    Twitter as TwitterIcon,
    X as XIcon,
} from 'lucide-vue-next';
import { ref } from 'vue';

// Reactive state for mobile menu toggle
const mobileMenuOpen = ref(false);

const { books } = defineProps<{ books: Book }>();
</script>

<template>
    <Head title="Home" />

    <div class="font-serif text-gray-800">
        <!-- Header -->
        <header class="fixed z-50 w-full bg-white/95 shadow-sm backdrop-blur-sm">
            <div class="container mx-auto flex items-center justify-between px-4 py-4">
                <!-- Logo -->
                <Link :href="route('home')"><AppLogo /></Link>

                <!-- Desktop Navigation -->
                <nav class="hidden items-center space-x-8 md:flex">
                    <Link :href="route('books.index')" class="flex items-center space-x-2">Books</Link>
                    <Link href="#about" class="flex items-center space-x-2">About</Link>
                    <Link href="#contact" class="flex items-center space-x-2">Contact</Link>
                </nav>

                <!-- CTA Button -->
                <div class="hidden md:block md:space-x-3">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('books.index')"
                        class="bg-primary hover:bg-primary/90 rounded-lg px-4 py-2 text-white transition-colors"
                    >
                        Explore Books
                    </Link>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                        >
                            Log In
                        </Link>
                        <Link :href="route('register')" class="bg-primary hover:bg-primary/90 rounded-lg px-4 py-2 text-white transition-colors">
                            Sign Up
                        </Link>
                    </template>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 md:hidden">
                    <MenuIcon v-if="!mobileMenuOpen" class="h-6 w-6" />
                    <XIcon v-else class="h-6 w-6" />
                </button>
            </div>

            <!-- Mobile Menu -->
            <div v-if="mobileMenuOpen" class="border-t bg-white md:hidden">
                <div class="container mx-auto flex flex-col space-y-4 px-4 py-4">
                    <Link
                        :href="route('books.index')"
                        @click="mobileMenuOpen = false"
                        class="hover:text-primary text-sm font-medium transition-colors"
                        >Books</Link
                    >
                    <Link href="#about" @click="mobileMenuOpen = false" class="hover:text-primary text-sm font-medium transition-colors">About</Link>
                    <Link href="#contact" @click="mobileMenuOpen = false" class="hover:text-primary text-sm font-medium transition-colors"
                        >Contact</Link
                    >
                    <Link
                        v-if="$page.props.auth.user"
                        @click="mobileMenuOpen = false"
                        :href="route('books.index')"
                        class="bg-primary hover:bg-primary/90 rounded-lg px-4 py-2 text-center text-white transition-colors"
                    >
                        Explore Books
                    </Link>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            @click="mobileMenuOpen = false"
                            class="hover:text-primary rounded-sm border border-transparent text-sm font-medium transition-colors hover:border-[#19140035]"
                        >
                            Log In
                        </Link>
                        <Link
                            :href="route('register')"
                            @click="mobileMenuOpen = false"
                            class="bg-primary hover:bg-primary/90 rounded-lg px-4 py-2 text-center text-white transition-colors"
                        >
                            Sign Up
                        </Link>
                    </template>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-amber-50 to-white pt-32 pb-20">
            <div class="container mx-auto px-4">
                <div class="flex flex-col items-center md:flex-row">
                    <div class="mb-10 md:mb-0 md:w-1/2">
                        <h1 class="mb-6 text-4xl leading-tight font-bold md:text-5xl lg:text-6xl">Discover Your Next Favorite Book</h1>
                        <p class="mb-8 max-w-lg text-lg text-gray-600">
                            Explore our curated collection of bestsellers, classics, and hidden gems that will transport you to new worlds.
                        </p>
                        <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                            <Link
                                :href="route('books.index')"
                                class="bg-primary hover:bg-primary/90 rounded-lg px-6 py-3 text-center font-medium text-white transition-colors"
                                >Browse Collection</Link
                            >
                            <Link
                                href="#about"
                                class="rounded-lg border border-gray-300 px-6 py-3 text-center font-medium transition-colors hover:bg-gray-50"
                                >Learn More</Link
                            >
                        </div>
                    </div>
                    <div class="md:w-1/2">
                        <img src="../../images/hero-main.jpg" alt="Stack of Books" class="rounded-lg shadow-xl" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Books Section -->
        <section id="books" class="bg-white py-20">
            <div class="container mx-auto px-4">
                <div class="mb-16 text-center">
                    <h2 class="mb-4 text-3xl font-bold md:text-4xl">Featured Books</h2>
                    <p class="mx-auto max-w-2xl text-gray-600">Our handpicked selection of must-read books for every reader.</p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <BookCard v-for="book in books" :key="book.id" :book="book" />
                </div>

                <div class="mt-12 text-center">
                    <Link
                        :href="route('books.index')"
                        class="bg-primary hover:bg-primary/90 inline-block rounded-lg px-6 py-3 text-white transition-colors"
                    >
                        View All Books
                    </Link>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="bg-amber-50 py-20">
            <div class="container mx-auto px-4">
                <div class="flex flex-col items-center gap-12 md:flex-row">
                    <div class="md:w-1/2">
                        <img src="../../images/hero-about.jpg" alt="Bookstore Interior" class="rounded-lg shadow-xl" />
                    </div>
                    <div class="md:w-1/2">
                        <h2 class="mb-6 text-3xl font-bold md:text-4xl">Our Story</h2>
                        <p class="mb-6 text-gray-600">
                            Founded in 2010, BookBase started as a small corner bookshop with a passion for connecting readers with stories that
                            inspire, entertain, and transform.
                        </p>
                        <p class="mb-6 text-gray-600">
                            Today, we've grown into a community of book lovers dedicated to curating exceptional reading experiences for every type of
                            reader. Our team of passionate bibliophiles handpicks each title in our collection.
                        </p>
                        <p class="text-gray-600">
                            Whether you're a lifelong reader or just beginning your literary journey, we're here to help you discover books that will
                            stay with you long after the last page.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section id="explore" class="bg-primary py-20 text-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="mb-6 text-3xl font-bold md:text-4xl">Join Our Reading Community</h2>
                <p class="mx-auto mb-8 max-w-2xl text-xl">
                    Subscribe to our newsletter for book recommendations, author interviews, and special offers.
                </p>
                <div class="mx-auto max-w-md">
                    <form class="flex flex-col gap-4 sm:flex-row">
                        <input
                            type="email"
                            placeholder="Enter your email"
                            class="flex-1 rounded-lg bg-white px-4 py-3 text-gray-800 focus:ring-2 focus:ring-white focus:outline-none"
                        />
                        <button type="submit" class="text-primary rounded-lg bg-white px-6 py-3 font-medium transition-colors hover:bg-gray-100">
                            Subscribe
                        </button>
                    </form>
                    <p class="mt-4 text-sm text-white/80">We respect your privacy. Unsubscribe at any time.</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer id="contact" class="bg-gray-900 py-12 text-white">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- Company Info -->
                    <div>
                        <div class="mb-4">
                            <Link :href="route('home')"><AppLogo /></Link>
                        </div>
                        <p class="mb-4 text-gray-400">Your destination for exceptional books and literary experiences.</p>
                        <div class="flex space-x-4">
                            <Link href="#" class="text-gray-400 transition-colors hover:text-white">
                                <TwitterIcon class="h-5 w-5" />
                            </Link>
                            <Link href="#" class="text-gray-400 transition-colors hover:text-white">
                                <FacebookIcon class="h-5 w-5" />
                            </Link>
                            <Link href="#" class="text-gray-400 transition-colors hover:text-white">
                                <InstagramIcon class="h-5 w-5" />
                            </Link>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="mb-4 text-lg font-semibold">Explore</h4>
                        <ul class="space-y-2">
                            <li><Link :href="route('books.index')" class="text-gray-400 transition-colors hover:text-white">Books</Link></li>
                            <li><Link href="#" class="text-gray-400 transition-colors hover:text-white">Authors</Link></li>
                            <li><Link href="#" class="text-gray-400 transition-colors hover:text-white">Genres</Link></li>
                            <li><Link href="#" class="text-gray-400 transition-colors hover:text-white">New Releases</Link></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="mb-4 text-lg font-semibold">Contact Us</h4>
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <MapPinIcon class="mt-0.5 mr-2 h-5 w-5 text-gray-400" />
                                <span class="text-gray-400">123 Book Lane, Reading, RG1 2AB</span>
                            </li>
                            <li class="flex items-center">
                                <PhoneIcon class="mr-2 h-5 w-5 text-gray-400" />
                                <span class="text-gray-400">(555) 123-4567</span>
                            </li>
                            <li class="flex items-center">
                                <MailIcon class="mr-2 h-5 w-5 text-gray-400" />
                                <span class="text-gray-400">hello@bookbase.com</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 flex flex-col items-center justify-between border-t border-gray-800 pt-8 md:flex-row">
                    <p class="text-sm text-gray-400">&copy; {{ new Date().getFullYear() }} BookBase. All rights reserved.</p>
                    <div class="mt-4 flex space-x-6 md:mt-0">
                        <Link href="#" class="text-sm text-gray-400 transition-colors hover:text-white">Privacy Policy</Link>
                        <Link href="#" class="text-sm text-gray-400 transition-colors hover:text-white">Terms of Service</Link>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
