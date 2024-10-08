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
                                    <label for="title"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Event Title
                                    </label>
                                    <input type="text" id="title" v-model="event.title"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="Event Title"
                                           required>
                                </div>

                                <!-- Event description textarea -->
                                <div>
                                    <label for="description"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Event Description
                                    </label>
                                    <textarea id="description" v-model="event.description"
                                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                              placeholder="Event Description"
                                              required>
                                    </textarea>
                                </div>

                                <!-- Event start date input -->
                                <div>
                                    <label for="start_date"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Start Date
                                    </label>
                                    <input type="datetime-local" id="start_date" v-model="event.start_date"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           required>
                                </div>

                                <!-- Event end date input -->
                                <div>
                                    <label for="end_date"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        End Date
                                    </label>
                                    <input type="datetime-local" id="end_date" v-model="event.end_date"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           required>
                                </div>

                                <!-- Event location input -->
                                <div>
                                    <label for="location"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Location
                                    </label>
                                    <input type="text" id="location" v-model="event.location"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="Event Location"
                                           required>
                                </div>

                                <CreateSeatMap @update-layout="updateSeatMap"></CreateSeatMap>

                                <!-- Submit button -->
                                <button type="submit"
                                        class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Create Event
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script>
import axios from "axios";
import {router} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CreateSeatMap from "@/Components/CreateSeatMap.vue";
import {sendNotification} from "@/Components/notificationService";

export default {
    components: {
        CreateSeatMap,
        AuthenticatedLayout,
    },
    data() {
        return {
            event: {
                title: '',
                description: '',
                start_date: '',
                end_date: '',
                location: '',
                seat_map: '',
            },
        };
    },
    methods: {
        createEvent() {
            // Convert seat_map to a JSON string before sending it to the server
            const eventData = {
                ...this.event,
                seat_map: JSON.stringify(this.event.seat_map),
            };

            axios.post('/events', eventData)
                .then(response => {
                    sendNotification({ message: 'Event created successfully!'}, 'success');
                    router.visit('/events.index');
                })
                .catch(error => {
                    sendNotification({ message: 'There seems to be an error. Event was not created.'}, 'danger');
                    if (error.response && error.response.data && error.response.data.message) {
                        sendNotification({ message: error.response.data.message}, 'danger');
                    }
                });
        },
        updateSeatMap(seatMap) {
            this.event.seat_map = JSON.parse(JSON.stringify(seatMap));
        },
    },
};
</script>
