<template>
    <AuthenticatedLayout>
        <slot>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-row m-8">
                    <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Your Email</label>
                    <button id="dropdown-button" data-dropdown-toggle="dropdown" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">All categories <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                    </button>
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                            <li>
                                <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mockups</button>
                            </li>
                            <li>
                                <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Templates</button>
                            </li>
                            <li>
                                <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Design</button>
                            </li>
                            <li>
                                <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Logos</button>
                            </li>
                        </ul>
                    </div>
                    <div class="relative w-full">
                        <input
                            v-model="search"
                            @input="searchEvents"
                            type="search"
                            id="search-dropdown"
                            class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                            placeholder="Search for events..." required>
                        <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div>
                <div class="flex grid grid-cols-4 grid-rows-4 gap-5 mx-8 justify-center md:justify-items-center">
                    <div v-for="event in events.data" :key="event.id" class="flex h-auto">
                        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
<!--                            <a :href="'/events/' + event.id">-->
                            <a :href="event.url">
                                <!--                                <img :src="event.image_url" alt="Event Image" class="rounded-t-lg" />-->
                                <img src="https://i.pinimg.com/originals/ba/92/7f/ba927ff34cd961ce2c184d47e8ead9f6.jpg" alt="Event Image" class="rounded-t-lg" />
                            </a>
                            <div class="p-5">
                                <a :href="'/events/' + event.id">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white event-name">
                                        {{ event.title }}
                                    </h5>
                                </a>
<!--                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Start Date: {{ formatEventDate(event.date) }}</p>-->
<!--                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Start Time: {{ formatEventTime(event.date) }}</p>-->
<!--                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">End Date: {{ formatEventDate(event.date) }}</p>-->
<!--                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">End Timne: {{ formatEventTime(event.date) }}</p>-->
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ displayDateTime(event) }}</p>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ truncatedDescription(event.description) }}</p>
                                <a
                                    :href="'/events/' + event.id"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                >
                                    Reserve
                                    <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination component -->
                <div v-if="events.meta" class="container pt-8 pb-4 px-4 mx-auto flex justify-center select-none">
                    <template v-if="events.meta">
                        <a
                            v-if="events.meta.current_page > 1"
                            @click.prevent="changePage(events.links[0].url)"
                            href="#"
                            class="block border px-4 py-2 rounded-l hover:bg-gray-200 text-gray-600"
                            rel="prev"
                        >
                            &larr;
                        </a>
                        <span
                            v-else
                            class="block border px-4 py-2 rounded-l text-gray-400 cursor-not-allowed"
                        >
                            &larr;
                        </span>

                        <template v-for="(link, index) in events.links.slice(1, -1)" :key="index">
                            <a
                                v-if="link.url"
                                @click.prevent="changePage(link.url)"
                                href="#"
                                :class="[
                                    'block border px-4 py-2 hover:bg-gray-200 text-gray-600',
                                    { 'bg-indigo-500 text-white': link.active }
                                ]"
                            >
                                {{ link.label }}
                            </a>
                            <span
                                v-else
                                class="border px-4 py-2 cursor-not-allowed text-gray-400"
                            >
                                {{ link.label }}
                            </span>
                        </template>

                        <a
                            v-if="events.meta.current_page < events.meta.last_page"
                            @click.prevent="changePage(events.links[events.links.length - 1].url)"
                            href="#"
                            class="block border px-4 py-2 rounded-r hover:bg-gray-200 text-gray-600"
                            rel="next"
                        >
                            &rarr;
                        </a>
                        <span
                            v-else
                            class="block border px-4 py-2 rounded-r text-gray-400 cursor-not-allowed"
                        >
                            &rarr;
                        </span>
                    </template>
                </div>
            </div>
        </slot>
    </AuthenticatedLayout>
</template>


<script>
import {ref, watch, onMounted} from 'vue';
import {usePage, router} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import axios from "axios";
import { format, isSameDay } from 'date-fns';

export default {
    components: {
        AuthenticatedLayout
    },
    methods: {
        truncatedDescription(description) {
            const maxLength = 50; // Maximum number of characters to show
            if (description.length > maxLength) {
                return description.substring(0, maxLength) + '...'; // Truncate and add ellipsis
            }
            return description; // Return the full description if it's short enough
        },
        formatEventDate(date) {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }; // Example format: December 17, 1995
            return new Date(date).toLocaleDateString(undefined, options);
        },
        formatDate(date) {
            // return format(new Date(date), 'MMMM do, yyyy'); // e.g., March 1, 2023
            return format(new Date(date), 'MMMM dd, yyyy'); // e.g., March 01, 2023
        },
        formatTime(date) {
            return format(new Date(date), 'HH:mm'); // e.g., 15:00
        },
        displayDateTime(event) {
            const startDate = new Date(event.start_date);
            const endDate = event.end_date ? new Date(event.end_date) : null;

            let dateTimeDisplay = this.formatDate(startDate);

            if (endDate && isSameDay(startDate, endDate)) {
                // If the event starts and ends on the same day, show the date once and both times
                dateTimeDisplay += ` from ${this.formatTime(startDate)} to ${this.formatTime(endDate)}`;
            } else {
                // If the event only has a start time, or spans multiple days, just show the start date and time
                dateTimeDisplay += ` at ${this.formatTime(startDate)}`;
            }

            return dateTimeDisplay;
        },
    },
    setup() {
        const {data, post, router} = usePage();
        const search = ref('');
        const events = ref({
            data: [],
            meta: null,
            links: {}
        });

        const searchEvents = async (page = 1) => {
            try {
                const response = await axios.get('/events', {
                    params: { 
                        search: search.value,
                        page: page
                    },
                    headers: { Accept: 'application/json' }
                });

                events.value = {
                    data: response.data.data,
                    meta: {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                        total: response.data.total
                    },
                    links: response.data.links
                };
            } catch (error) {
                console.error('Error fetching events:', error);
            }
        };

        const generatePageNumbers = (meta) => {
            const current = meta.current_page;
            const last = meta.last_page;
            const delta = 2;
            const range = [];
            const rangeWithDots = [];
            let l;

            for (let i = 1; i <= last; i++) {
                if (i === 1 || i === last || (i >= current - delta && i <= current + delta)) {
                    range.push(i);
                }
            }

            for (let i of range) {
                if (l) {
                    if (i - l === 2) {
                        rangeWithDots.push(l + 1);
                    } else if (i - l !== 1) {
                        rangeWithDots.push('...');
                    }
                }
                rangeWithDots.push(i);
                l = i;
            }

            return rangeWithDots;
        };

        const generatePageUrl = (page) => {
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            return url.toString();
        };

        const changePage = (url) => {
            if (url) {
                const page = new URL(url).searchParams.get('page');
                searchEvents(page);
            }
        };

        watch(search, () => searchEvents());

        onMounted(() => {
            searchEvents();
        });

        return {
            search,
            events,
            searchEvents,
            generatePageNumbers,
            generatePageUrl,
            router,
            changePage,
        };
    },
};
</script>

