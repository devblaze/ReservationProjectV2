<template>
    <div>
        <AuthenticatedLayout>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Holy smokes!</strong>
                        <span class="block sm:inline">Something seriously bad happened.</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
  </span>
                    </div>
                    <br>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ event.name }}</h2>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ event.date }}</p>
                            <p class="mt-4 text-gray-700 dark:text-gray-300">{{ event.description }}</p>

                            <div class="flex flex-row justify-between mx-1">
                                <button @click="showSeatMapModal"
                                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 w-full">
                                    Reserve Seat
                                </button>
                                <SeatMapModal v-if="isSeatMapVisible" @close="closeSeatMapModal">
                                    <!-- Include the SeatMap component within the modal -->
                                    <SeatMap @reserve="reserveSeat" />
                                </SeatMapModal>
                                <button @click="cancelEvent"
                                        class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:focus:ring-yellow-900 w-full">
                                    Edit
                                </button>
                                <button @click="cancelEvent"
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 w-full">
                                    Cancel
                                </button>
                            </div>
                            <div>
                                <button @click="cancelEvent"
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 w-full">
                                    Delete
                                </button>
                            </div>
                            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                                <div class="flex">
                                    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                                    <div>
                                        <p class="font-bold">Our privacy policy has changed</p>
                                        <p class="text-sm">Make sure you know how these changes affect you.</p>
                                    </div>
                                </div>
                            </div>

                            <button @click="showModal">Open Modal</button>
                            <EventDeletionPopup @close="closeModal" />
                            <!-- Modal toggle -->
                            <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                Toggle modal
                            </button>

                            <!-- Main modal -->
                            <div id="default-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Terms of Service
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-6 space-y-6">
                                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                                With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
                                            </p>
                                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                                The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is meant to ensure a common set of data rights in the European Union. It requires organizations to notify users as soon as possible of high-risk data breaches that could personally affect them.
                                            </p>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                            <button data-modal-hide="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
                                            <button data-modal-hide="default-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p v-if="isReserved" class="mt-4 text-green-500">Note: You have already reserved a seat for this event.</p>
                            <!--                            <div v-if="!isReserved">-->
<!--                                <button-->
<!--                                    @click="showSeatMapModal"-->
<!--                                    class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"-->
<!--                                >-->
<!--                                    Reserve Seat-->
<!--                                </button>-->

<!--                                <div class="modal fade" id="seatMapModal" tabindex="-1"-->
<!--                                     aria-labelledby="seatMapModalLabel"-->
<!--                                     aria-hidden="true">-->
<!--                                    <div class="modal-dialog modal-lg">-->
<!--                                        <div class="modal-content">-->
<!--                                            <SeatMap @reserve="reserveSeat"/>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script>
import {ref, onMounted} from 'vue';
import {usePage} from '@inertiajs/vue3';
import axios from 'axios'; // Import the axios library
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SeatMap from "@/Pages/Events/SeatMap.vue";
import EventDeletionPopup from "@/Components/EventDeletionPopup.vue";

export default {
    components: {SeatMap, AuthenticatedLayout},
    props: {
        event: Object, // Event data passed as a prop
    },
    methods: {
        showSeatMapModal() {
            this.isSeatMapVisible = true;
        },
        closeSeatMapModal() {
            this.isSeatMapVisible = false;
        },
        cancelEvent() {
            console.log('test')
        },
        reserveSeat(seats) {
            // Handle the reserved seats data (e.g., send an API request to create reservations)
            // Close the modal when reservations are confirmed
            $('#seatMapModal').modal('hide');
        },
        showModal() {
            // Show the modal when the button is clicked
            // You can control modal visibility using a data property
            this.$refs.modal.showModal();
        },
        closeModal() {
            // Handle the modal close event if needed
        },
    },

    setup() {
        const {event} = usePage();
        let isReserved = ref(false); // A flag to check if the user has already reserved a seat

        // Function to reserve a seat for the event
        const reserveSeat = async () => {
            try {
                // Make an HTTP POST request to create a reservation
                const response = await axios.post(route('reservations.store', { event: event.id }));

                // Handle the response and update the isReserved flag
                if (response.status === 200) {
                    isReserved.value = true;
                } else {
                    // Handle errors or display a message
                    console.error('Reservation failed.');
                }
            } catch (error) {
                console.error(error);
            }
        };

        // Check if the user has already reserved a seat when the component is mounted
        onMounted(() => {
            isReserved = ref(true);
        });

        return {
            isReserved,
            reserveSeat,
            isSeatMapVisible: false,
        };
    },
};
</script>


<!--<script>-->
<!--import {ref, onMounted} from 'vue';-->
<!--import {usePage} from '@inertiajs/vue3';-->
<!--import axios from 'axios';-->
<!--import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";-->
<!--import SeatMap from "@/Pages/Events/SeatMap.vue";-->

<!--export default {-->
<!--    components: {SeatMap, AuthenticatedLayout},-->
<!--    props: {-->
<!--        event: Object,-->
<!--    },-->
<!--    setup() {-->
<!--        const {event} = usePage();-->
<!--        const isReserved = ref(false);-->

<!--        // Define the reserveSeat function within setup-->
<!--        const reserveSeat = (seats) => {-->
<!--            // Handle the reserved seats data (e.g., send an API request to create reservations)-->
<!--            // Close the modal when reservations are confirmed-->
<!--            $('#seatMapModal').modal('hide');-->
<!--        };-->

<!--        // Function to show the seat map modal-->
<!--        const showSeatMapModal = () => {-->
<!--            $('#seatMapModal').modal('show');-->
<!--        };-->

<!--        // Check if the user has already reserved a seat when the component is mounted-->
<!--        onMounted(() => {-->
<!--            // You can make an API request here to check if the user has a reservation for this event-->
<!--            // and update the isReserved flag accordingly.-->
<!--        });-->

<!--        return {-->
<!--            isReserved,-->
<!--            reserveSeat,-->
<!--            showSeatMapModal,-->
<!--        };-->
<!--    },-->
<!--};-->
<!--</script>-->
