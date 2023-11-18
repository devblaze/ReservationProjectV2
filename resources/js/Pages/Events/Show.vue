<template>
    <div>
        <AuthenticatedLayout>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        :class="{ 'hidden': !hasReservedSeat }"
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3"
                        role="alert">
                        <strong class="font-bold">Holy smokes!</strong>
                        <span class="block sm:inline">Something seriously bad happened.</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path
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
                                        <p class="font-bold">Our privacy policy has changed</p>
                                        <p class="text-sm">Make sure you know how these changes affect you.</p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white event-name">{{
                                    event.name
                                }}</h2>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ event.date }}</p>
                            <p class="mt-4 text-gray-700 dark:text-gray-300 mb-7">{{ event.description }}</p>

                            <div class="flex flex-row justify-between mx-1">
                                <button @click="showSeatMapModal"
                                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 w-full">
                                    Reserve Seat
                                </button>
                                <!--                                <SeatMapModal v-if="isSeatMapVisible" @close="closeSeatMapModal">-->
                                <!--                                    &lt;!&ndash; Include the SeatMap component within the modal &ndash;&gt;-->
                                <!--                                    <SeatMap @reserve="reserveSeat" />-->
                                <!--                                </SeatMapModal>-->
                                <button @click="cancelEvent"
                                        class="focus:outline-none text-white bg-blue-700 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:focus:ring-blue-600 w-full">
                                    Edit
                                </button>
                                <button @click="cancelEvent"
                                        class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:focus:ring-yellow-900 w-full">
                                    Cancel
                                </button>
                            </div>
                            <div>
                                <button @click="openDeleteModal"
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 w-full delete-event-button">
                                    Delete
                                </button>
                            </div>

                            <EventDeletionPopup v-if="showModal" type="danger" title="Confirm Action" width="sm"
                                                v-on:close="closeDeleteModal()">
                                <p class="text-gray-800">
                                    Are you sure you want you delete your event? This action cannot be undone.
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
                            </EventDeletionPopup>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script>
import {usePage, router} from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SeatMap from "@/Pages/Events/SeatMap.vue";
import EventDeletionPopup from "@/Components/DangerousActionConfirmation.vue";

export default {
    components: {
        SeatMap,
        AuthenticatedLayout,
        EventDeletionPopup
    },
    data() {
        return {
            hasReservedSeat: false,
            isSeatMapVisible: false,
            showModal: false,
            deleteButtonDisabled: true,
            countdown: 1,
            countdownReset: 2
        };
    },
    props: {
        event: Object,
    },
    methods: {
        showSeatMapModal() {
            this.isSeatMapVisible = true;
        },
        closeSeatMapModal() {
            this.isSeatMapVisible = false;
        },
        cancelEvent() {
            axios.put(route('events.update', this.event.id), {is_canceled: true})
                .then(response => {
                    console.log('Event canceled:', response.data.success);

                    this.event.is_canceled = true;
                })
                .catch(error => console.log(error))
        },
        reserveSeat(seats) {
            // Handle the reserved seats data (e.g., send an API request to create reservations)
            // Close the modal when reservations are confirmed
            $('#seatMapModal').modal('hide');
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
        async deleteEvent() {
            axios.delete(route('events.destroy', this.event.id))
                .then(response => {
                    console.log('Status:', response.data.success);

                    setTimeout(() => {
                        router.visit(route('events.index'))
                    }, 2000);
                })
                .catch(error => console.log(error));
        }
    },

    // setup() {
    //     const {event} = usePage();
    //
    //     // Function to reserve a seat for the event
    //     const reserveSeat = async () => {
    //         try {
    //             // Make an HTTP POST request to create a reservation
    //             const response = await axios.post(route('reservations.store', { event: event.id }));
    //
    //             // Handle the response and update the isReserved flag
    //             if (response.status === 200) {
    //                 this.hasReservedSeat = true;
    //             } else {
    //                 // Handle errors or display a message
    //                 console.error('Reservation failed.');
    //             }
    //         } catch (error) {
    //             console.error(error);
    //         }
    //     };
    //
    //     // Check if the user has already reserved a seat when the component is mounted
    //     onMounted(() => {
    //         this.hasReservedSeat = false;
    //     });
    // },
};
</script>
