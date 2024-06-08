<template>
    <div>
        <AuthenticatedLayout>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        :class="{ 'hidden': !hasReservedSeat }"
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3"
                        role="alert">
                        <strong class="font-bold">Holy smokes!</strong><br>
                        <span class="block sm:inline">Something seriously bad happened.</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <title>Close</title>
        <path
        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
  </span>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div
                                class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
                                role="alert">
                                <div class="flex">
                                    <div class="py-1">
                                        <svg class="fill-current h-6 w-6 text-teal-500 mr-4"
                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path
                                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold">Notice</p>
                                        <p class="text-sm">You have already a reserved seat for this event.</p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white event-name">{{
                                    event.title
                                }}</h2>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ event.date }}</p>
                            <p class="mt-4 text-gray-700 dark:text-gray-300 mb-7">{{ event.description }}</p>
                            <ReserveSeatMap :initialItems="event.seat_map"
                                           @selected-seats="selectedSeats">
                            </ReserveSeatMap>
                            <div class="grid grid-cols-2 grid-row-3 gap-1">
                                <div class="col-span-2">
                                    <button @click="reserveSeats"
                                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 w-full">
                                        Reserve Seat
                                    </button>
                                </div>
                                <div>
                                    <button @click="editEvent" id="edit-event-button"
                                            class="focus:outline-none text-white bg-blue-700 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:focus:ring-blue-600 w-full">
                                        Edit
                                    </button>
                                </div>
                                <div class="col-span-2">
                                    <button @click="openDeleteModal"
                                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 w-full delete-event-button">
                                        Delete
                                    </button>

                                    <DangerousActionConfirmation
                                        v-if="showModal"
                                        type="danger"
                                        title="Event Deletion Confirmation"
                                        width="sm"
                                        v-on:close="closeDeleteModal()"
                                        class="flex flex-row justify-between mx-2"
                                    >
                                        <p class="text-gray-800">
                                            Are you sure you want you delete your event? This action cannot be
                                            undone.
                                        </p>

                                        <div class="text-right mt-4">
                                            <button @click="closeDeleteModal()"
                                                    class="px-4 py-2 text-sm text-gray-600 focus:outline-none hover:underline">
                                                Cancel
                                            </button>
                                            <button
                                                type="button"
                                                @click="deleteEvent"
                                                :class="{ 'cursor-not-allowed opacity-50': deleteButtonDisabled }"
                                                class="mr-2 px-4 py-2 text-sm rounded text-white bg-red-500 focus:outline-none hover:bg-red-400 delete-event-confirm"
                                                :disabled="deleteButtonDisabled">
                                                Delete {{ countdown < countdownReset ? `(${countdown})` : '' }}
                                            </button>
                                        </div>
                                    </DangerousActionConfirmation>
                                </div>
                            </div>
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
import CreateSeatMap from "@/Components/CreateSeatMap.vue";
import DangerousActionConfirmation from "@/Components/DangerousActionConfirmation.vue";
import {sendNotification} from "@/Components/notificationService";

export default {
    components: {
        ReserveSeatMap,
        AuthenticatedLayout,
        DangerousActionConfirmation,
        CreateSeatMap,
    },
    data() {
        return {
            hasReservedSeat: false,
            showModal: false,
            deleteButtonDisabled: true,
            countdown: 1,
            countdownReset: 2,
            requestedSeatsToReserve: []
        };
    },
    props: {
        event: Object,
    },
    methods: {
        reserveSeats() {
            const storeRequestData = {
                "event_id": this.event.id,
                "selectedSeats": this.requestedSeatsToReserve
            }
            console.log(storeRequestData);
            axios.post(route('reservations.store', this.event.id), storeRequestData, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                }
            })
                .then(response => {
                    console.log(response)
                })
                .catch(error => console.log(error))
        },
        editEvent() {
            console.log("Navigating to edit page for event id:", this.event.id);
            router.get(route('events.edit', this.event.id), {
                onSuccess: (page) => {
                    console.log('Navigation successful', page);
                },
                onError: (errors) => {
                    console.error('Navigation failed', errors);
                }
            });
        },
        openDeleteModal() {
            this.showModal = true;
            this.startDeleteCountdown();
        },
        closeDeleteModal() {
            this.showModal = false;
        },
        startDeleteCountdown() {
            // Disable the "Delete" button
            this.deleteButtonDisabled = true;
            const countdownInterval = setInterval(() => {
                if (this.countdown > 0) {
                    this.countdown--;
                } else {
                    clearInterval(countdownInterval);
                    this.deleteButtonDisabled = false;
                    this.countdown = this.countdownReset;
                }
            }, 1000)
        },
        selectedSeats(seats) {
            // console.log('Updating seat map with:', JSON.parse(JSON.stringify(seatMap)));// Debugging line
            console.log(JSON.stringify(seats))
            this.requestedSeatsToReserve = JSON.parse(JSON.stringify(seats));
        },
        async deleteEvent() {
            axios.delete(route('events.destroy', this.event.id))
                .then(response => {
                    console.log('Status:', response.data.success);
                    sendNotification({message: 'Event deleted successfully!'}, 'success');
                    setTimeout(() => {
                        router.visit(route('events.index'));
                    }, 1000);
                })
                .catch(error => {
                    console.log(error);
                    sendNotification({message: 'Event deleted successfully!'}, 'danger');
                });
        }
    },
};
</script>
