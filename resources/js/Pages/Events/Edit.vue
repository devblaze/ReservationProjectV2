<template>
    <div>
        <AuthenticatedLayout>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Edit Event</h2>
                            <form @submit.prevent="submitUpdate">
                                <div class="mb-4">
                                    <label for="title"
                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                    <input type="text" id="title" v-model="form.title"
                                           class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300"
                                           required>
                                </div>
                                <div class="mb-4">
                                    <label for="description"
                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <textarea id="description" v-model="form.description"
                                              class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300"
                                              rows="4" required></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="start_date"
                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start
                                        Date</label>
                                    <input type="datetime-local" id="start_date" v-model="form.start_date"
                                           class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300"
                                           required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date"
                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">End
                                        Date</label>
                                    <input type="datetime-local" id="end_date" v-model="form.end_date"
                                           class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300"
                                           required>
                                </div>
                                <div class="mb-4">
                                    <label for="location"
                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                                    <input type="text" id="location" v-model="form.location"
                                           class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300"
                                           required>
                                </div>
                                <div class="mb-4">
                                    <CreateSeatMap :initialItems="parsedSeatMap"
                                                   @update-layout="updateSeatMap"></CreateSeatMap>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" id="save-changes-button"
                                            class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Save Changes
                                    </button>
                                    <button type="button" @click="cancelEvent" id="cancel-button"
                                            class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:focus:ring-yellow-900">
                                        Cancel Event
                                    </button>
                                </div>
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
import axios from 'axios';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ReserveSeatMap from "@/Components/ReserveSeatMap.vue";
import {sendNotification} from "@/Components/notificationService";
import CreateSeatMap from "@/Components/CreateSeatMap.vue";

export default {
    components: {
        CreateSeatMap,
        ReserveSeatMap,
        AuthenticatedLayout,
    },
    props: {
        event: Object,
    },
    data() {
        return {
            form: {
                title: this.event.title,
                start_date: this.event.start_date,
                end_date: this.event.end_date,
                description: this.event.description,
                location: this.event.location,
                seat_map: this.event.seat_map,
            },
        };
    },
    computed: {
        parsedSeatMap() {
            try {
                return JSON.parse(this.form.seat_map) || [];
            } catch (e) {
                return [];
            }
        },
    },
    methods: {
        updateSeatMap(seats) {
            this.form.seat_map = JSON.stringify(seats);
        },
        submitUpdate() {
            axios.put(`/events/${this.event.id}`, this.form)
                .then(response => {
                    sendNotification({message: 'Event updated successfully!'}, 'success');
                    router.get(`/events/${this.event.id}`);
                })
                .catch(error => {
                    sendNotification({message: 'Failed to update event: ' + error}, 'danger');
                });
        },
        cancelEvent() {
            axios.put(`/events/${this.event.id}`, {...this.form, is_canceled: true})
                .then(response => {
                    sendNotification({message: 'Event canceled successfully!'}, 'success');
                    router.get(`/events/${this.event.id}`);
                })
                .catch(error => {
                    sendNotification({message: 'Failed to cancel event: ' + error}, 'danger');
                });
        },
    },
};
</script>
