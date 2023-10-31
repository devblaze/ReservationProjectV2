<template>
    <div>
        <AuthenticatedLayout>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
