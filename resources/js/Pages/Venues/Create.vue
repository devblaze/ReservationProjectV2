<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h1 class="text-2xl font-semibold mb-6">Create Venue</h1>
                        <form @submit.prevent="createVenue">
                            <!-- Venue Name -->
                            <div>
                                <label
                                    for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >
                                    Venue Name
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    v-model="venue.name"
                                    class="input-field"
                                    placeholder="Venue Name"
                                    required
                                />
                            </div>

                            <!-- Venue Location -->
                            <div>
                                <label
                                    for="location"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >
                                    Location
                                </label>
                                <input
                                    type="text"
                                    id="location"
                                    v-model="venue.location"
                                    class="input-field"
                                    placeholder="Venue Location"
                                    required
                                />
                            </div>

                            <!-- Seat Map Builder -->
                            <div class="mt-6">
                                <h2 class="text-xl font-medium mb-4">Seat Map</h2>
                                <CreateSeatMap @update-layout="updateSeatMap" />
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="mt-4 btn-primary"
                            >
                                Create Venue
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CreateSeatMap from "@/Components/CreateSeatMap.vue";
import { sendNotification } from "@/Components/notificationService";
import axios from "axios";

export default {
    components: {
        AuthenticatedLayout,
        CreateSeatMap,
    },
    data() {
        return {
            venue: {
                name: "",
                location: "",
                seat_map: "",
            },
        };
    },
    methods: {
        createVenue() {
            // Prepare venue data
            const venueData = {
                ...this.venue,
                seat_map: JSON.stringify(this.venue.seat_map), // Serialize the seat map
            };

            // Send API request to create venue
            axios.post("/venues", venueData)
                .then(() => {
                    sendNotification(
                        { message: "Venue created successfully!" },
                        "success"
                    );
                    router.visit("/venues");
                })
                .catch((error) => {
                    console.error("Error creating venue:", error);
                    sendNotification(
                        { message: "Failed to create the venue." },
                        "danger"
                    );
                });
        },
        updateSeatMap(seatMap) {
            // Update seat map data
            this.venue.seat_map = JSON.parse(JSON.stringify(seatMap));
        },
    },
};
</script>

<style scoped>
.input-field {
    background: #f9f9f9;
    border: 1px solid #ccc;
    padding: 0.5rem;
    border-radius: 0.375rem;
    width: 100%;
    margin-bottom: 1rem;
}
.btn-primary {
    background: #4a90e2;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
}
</style>
