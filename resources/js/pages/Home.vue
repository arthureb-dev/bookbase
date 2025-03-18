<template>
    <Head title="Home" />
    <div class="font-serif text-gray-800">
        <!-- Header -->
        <header class="fixed z-50 w-full bg-white/95 shadow-sm backdrop-blur-sm">
            <div class="container mx-auto flex items-center justify-between px-4 py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="text-primary h-8 w-8">
                        <BookIcon class="h-full w-full" />
                    </div>
                    <span class="text-xl font-bold">BookBase</span>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden items-center space-x-8 md:flex">
                    <a href="#books" class="hover:text-primary text-sm font-medium transition-colors">Books</a>
                    <a href="#about" class="hover:text-primary text-sm font-medium transition-colors">About</a>
                    <a href="#contact" class="hover:text-primary text-sm font-medium transition-colors">Contact</a>
                </nav>

                <!-- CTA Button -->
                <div class="hidden md:block">
                    <a href="#explore" class="bg-primary hover:bg-primary/90 rounded-lg px-4 py-2 text-white transition-colors"> Explore Books </a>
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
                    <a href="#books" @click="mobileMenuOpen = false" class="hover:text-primary text-sm font-medium transition-colors">Books</a>
                    <a href="#about" @click="mobileMenuOpen = false" class="hover:text-primary text-sm font-medium transition-colors">About</a>
                    <a href="#contact" @click="mobileMenuOpen = false" class="hover:text-primary text-sm font-medium transition-colors">Contact</a>
                    <a
                        href="#explore"
                        @click="mobileMenuOpen = false"
                        class="bg-primary hover:bg-primary/90 rounded-lg px-4 py-2 text-center text-white transition-colors"
                    >
                        Explore Books
                    </a>
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
                            <a
                                href="#explore"
                                class="bg-primary hover:bg-primary/90 rounded-lg px-6 py-3 text-center font-medium text-white transition-colors"
                            >
                                Browse Collection
                            </a>
                            <a
                                href="#about"
                                class="rounded-lg border border-gray-300 px-6 py-3 text-center font-medium transition-colors hover:bg-gray-50"
                            >
                                Learn More
                            </a>
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
                    <!-- Book 1 -->
                    <div class="group">
                        <div class="relative mb-4 overflow-hidden rounded-lg shadow-md">
                            <img
                                src="/placeholder.svg?height=400&width=300"
                                alt="Book Cover"
                                class="h-80 w-full object-cover transition-transform duration-300 group-hover:scale-105"
                            />
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                            >
                                <a href="#" class="bg-primary hover:bg-primary/90 rounded-lg px-4 py-2 text-white transition-colors"> Quick View </a>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold">The Silent Echo</h3>
                        <p class="text-gray-600">by Sarah Johnson</p>
                        <div class="mt-2 flex items-center">
                            <div class="flex">
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                            </div>
                            <span class="ml-1 text-sm text-gray-500">(128)</span>
                        </div>
                    </div>

                    <!-- Book 2 -->
                    <div class="group">
                        <div class="relative mb-4 overflow-hidden rounded-lg shadow-md">
                            <img
                                src="/placeholder.svg?height=400&width=300"
                                alt="Book Cover"
                                class="h-80 w-full object-cover transition-transform duration-300 group-hover:scale-105"
                            />
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                            >
                                <a href="#" class="bg-primary hover:bg-primary/90 rounded-lg px-4 py-2 text-white transition-colors"> Quick View </a>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold">Midnight Chronicles</h3>
                        <p class="text-gray-600">by Michael Chen</p>
                        <div class="mt-2 flex items-center">
                            <div class="flex">
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-gray-300" />
                            </div>
                            <span class="ml-1 text-sm text-gray-500">(95)</span>
                        </div>
                    </div>

                    <!-- Book 3 -->
                    <div class="group">
                        <div class="relative mb-4 overflow-hidden rounded-lg shadow-md">
                            <img
                                src="/placeholder.svg?height=400&width=300"
                                alt="Book Cover"
                                class="h-80 w-full object-cover transition-transform duration-300 group-hover:scale-105"
                            />
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                            >
                                <a href="#" class="bg-primary hover:bg-primary/90 rounded-lg px-4 py-2 text-white transition-colors"> Quick View </a>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold">The Lost Garden</h3>
                        <p class="text-gray-600">by Emily Rodriguez</p>
                        <div class="mt-2 flex items-center">
                            <div class="flex">
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                            </div>
                            <span class="ml-1 text-sm text-gray-500">(156)</span>
                        </div>
                    </div>

                    <!-- Book 4 -->
                    <div class="group">
                        <div class="relative mb-4 overflow-hidden rounded-lg shadow-md">
                            <img
                                src="/placeholder.svg?height=400&width=300"
                                alt="Book Cover"
                                class="h-80 w-full object-cover transition-transform duration-300 group-hover:scale-105"
                            />
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                            >
                                <a href="#" class="bg-primary hover:bg-primary/90 rounded-lg px-4 py-2 text-white transition-colors"> Quick View </a>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold">Beyond the Horizon</h3>
                        <p class="text-gray-600">by David Thompson</p>
                        <div class="mt-2 flex items-center">
                            <div class="flex">
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-gray-300" />
                            </div>
                            <span class="ml-1 text-sm text-gray-500">(87)</span>
                        </div>
                    </div>
                </div>

                <div class="mt-12 text-center">
                    <a href="#explore" class="bg-primary hover:bg-primary/90 inline-block rounded-lg px-6 py-3 text-white transition-colors">
                        View All Books
                    </a>
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
                        <div class="mb-4 flex items-center space-x-2">
                            <div class="h-8 w-8 text-white">
                                <BookIcon class="h-full w-full" />
                            </div>
                            <span class="text-xl font-bold">BookBase</span>
                        </div>
                        <p class="mb-4 text-gray-400">Your destination for exceptional books and literary experiences.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 transition-colors hover:text-white">
                                <TwitterIcon class="h-5 w-5" />
                            </a>
                            <a href="#" class="text-gray-400 transition-colors hover:text-white">
                                <FacebookIcon class="h-5 w-5" />
                            </a>
                            <a href="#" class="text-gray-400 transition-colors hover:text-white">
                                <InstagramIcon class="h-5 w-5" />
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="mb-4 text-lg font-semibold">Explore</h4>
                        <ul class="space-y-2">
                            <li><a href="#books" class="text-gray-400 transition-colors hover:text-white">Books</a></li>
                            <li><a href="#" class="text-gray-400 transition-colors hover:text-white">Authors</a></li>
                            <li><a href="#" class="text-gray-400 transition-colors hover:text-white">Genres</a></li>
                            <li><a href="#" class="text-gray-400 transition-colors hover:text-white">New Releases</a></li>
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
                        <a href="#" class="text-sm text-gray-400 transition-colors hover:text-white">Privacy Policy</a>
                        <a href="#" class="text-sm text-gray-400 transition-colors hover:text-white">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import {
    Facebook as FacebookIcon,
    Instagram as InstagramIcon,
    Mail as MailIcon,
    MapPin as MapPinIcon,
    Menu as MenuIcon,
    Phone as PhoneIcon,
    Star as StarIcon,
    Twitter as TwitterIcon,
    X as XIcon,
} from 'lucide-vue-next';
import type { SVGAttributes } from 'vue';
import { h, ref, type FunctionalComponent } from 'vue';

// Custom Book icon component
const BookIcon: FunctionalComponent<SVGAttributes> = (props) => {
    return h(
        'svg',
        {
            xmlns: 'http://www.w3.org/2000/svg',
            width: '24',
            height: '24',
            viewBox: '0 0 24 24',
            fill: 'none',
            stroke: 'currentColor',
            strokeWidth: '2',
            strokeLinecap: 'round',
            strokeLinejoin: 'round',
            ...props,
        },
        [h('path', { d: 'M4 19.5A2.5 2.5 0 0 1 6.5 17H20' }), h('path', { d: 'M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z' })],
    );
};

// Reactive state for mobile menu toggle
const mobileMenuOpen = ref(false);
</script>

<style>
:root {
    --color-primary: #8b4513; /* A warm brown color for books */
    --color-primary-hover: #6b3100;
}

.bg-primary {
    background-color: var(--color-primary);
}

.bg-primary\/10 {
    background-color: rgba(139, 69, 19, 0.1);
}

.bg-primary\/5 {
    background-color: rgba(139, 69, 19, 0.05);
}

.bg-primary\/90 {
    background-color: rgba(139, 69, 19, 0.9);
}

.text-primary {
    color: var(--color-primary);
}

.border-primary {
    border-color: var(--color-primary);
}

.hover\:bg-primary\/90:hover {
    background-color: var(--color-primary-hover);
}

.hover\:bg-primary\/5:hover {
    background-color: rgba(139, 69, 19, 0.05);
}

html {
    scroll-behavior: smooth;
}

.font-serif {
    font-family: 'Georgia', serif;
}
</style>
