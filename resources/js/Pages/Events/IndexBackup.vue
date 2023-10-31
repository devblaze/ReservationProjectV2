<script setup lang="ts">
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { TailwindPagination } from 'laravel-vue-pagination';
import EventsList from "@/Pages/Events/EventsList.vue";
const currentPage = ref(1); // Initialize with the default current page

// Define the function to update the current page
const updatePage = (page: number) => {
    currentPage.value = page;
    // Fetch data for the new page here if needed
};

defineProps({events: Object, user: Object})
</script>

<template>
    <Head title="Events"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Events</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-8 flex justify-between">
                            <a href="#"
                               class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Add Event
                            </a>
                            <!--                            <input v-model="search" @input="searchEvents" type="search" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Search events">-->
                            <input
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Search events">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Use a loop to render events here -->
                            <div v-for="event in events.data"
                                 class="bg-white dark:bg-gray-900 rounded-lg flex flex-col shadow-zinc-900 shadow-md">
                                <div class="relative pb-56/9 basis-56">
                                    <img class="absolute h-full w-full object-cover rounded-t-lg"
                                         src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3a/Cat03.jpg/1025px-Cat03.jpg"
                                         alt="Event Preview"/>
                                </div>
                                <div class="p-4 flex-grow">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                        {{ event.name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ event.location }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-300">{{ event.date }}</p>
                                </div>
                                <div
                                    class="mt-4 p-4 border-t border-gray-200 flex gap-x-2 justify-between items-stretch">
                                    <button class="text-blue-600 hover:text-blue-900 flex-auto">Edit</button>
                                    <button class="ml-4 text-red-600 hover:text-red-900 flex-auto">Cancel</button>
                                    <button
                                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 self-auto flex-auto">
                                        Reserve Seat
                                    </button>
                                </div>
                            </div>
                            <!-- End of loop -->
                        </div>
                        <!-- Add pagination component -->
                        <div class="mt-8">
                            <TailwindPagination
                                :data="events"
                                @pagination-change-page="events.current_page"
                            />
                            <span class="text-sm text-gray-700 dark:text-gray-400">Showing
                                <span class="font-semibold text-gray-900 dark:text-white">{{ events.from }}</span> to
                                <span class="font-semibold text-gray-900 dark:text-white">{{ events.to }}</span> of
                                <span class="font-semibold text-gray-900 dark:text-white">{{ events.total }}</span>
                                Entries
                            </span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
