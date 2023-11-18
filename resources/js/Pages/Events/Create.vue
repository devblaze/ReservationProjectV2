<template>
    <div>
        <AuthenticatedLayout>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h1 class="text-2xl font-semibold mb-6">Create Event</h1>
                            <form @submit.prevent="createEvent">
                                <!-- Event title input -->
                                <div>
                                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event Title</label>
                                    <input type="text" id="title" v-model="event.name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Event Title" required>
                                </div>

                                <!-- Event description textarea -->
                                <div>
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event Description</label>
                                    <textarea id="description" v-model="event.description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Event Description" required></textarea>
                                </div>

                                <!-- Event start date input -->
                                <div>
                                    <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                                    <input type="datetime-local" id="start_date" v-model="event.date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                </div>

                                <!-- Event end date input -->
                                <div>
                                    <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                                    <input type="datetime-local" id="end_date" v-model="event.end_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                </div>

                                <!-- Event location input -->
                                <div>
                                    <label for="location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                                    <input type="text" id="location" v-model="event.location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Event Location" required>
                                </div>

                                <CreateSeatMap @update-layout="handleSeatMapUpdate"></CreateSeatMap>

                                <!-- Submit button -->
                                <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Create Event</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script>
import {router} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import axios from "axios";
import CreateSeatMap from "@/Components/CreateSeatMap.vue";

export default {
    components: {
        CreateSeatMap,
        AuthenticatedLayout
    },
    data() {
        return {
            event: {
                name: '',
                date: '',
                description: '',
                start_date: '',
                end_date: '',
                location: '',
            },
        };
    },
    methods: {
        createEvent() {
            axios.post(route('events.store'), this.event)
                .then(response => {
                    console.log(response.data);
                    // router.visit(route('events.index'))
                })
                .catch(error => {
                    console.error(error);
                });
        },
        handleSeatMapUpdate(newLayout) {
            this.event.seatMapLayout = newLayout;
        },
    },
};
</script>
