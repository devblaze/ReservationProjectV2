<template>
    <Head title="My Venues" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="container mx-auto py-12 px-6">
                        <!-- My Venues Title -->
                        <h1 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-100 mb-8">🏛️ My Venues</h1>

                        <!-- If there are venues -->
                        <div v-if="venues.length > 0" class="bg-white dark:bg-gray-700 shadow-md rounded-lg mt-6 overflow-x-auto">
                            <table class="min-w-full table-auto border-collapse">
                                <thead class="bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-400">
                                <tr>
                                    <th class="py-3 px-4 text-left text-sm font-medium uppercase tracking-wide">Venue Name</th>
                                    <th class="py-3 px-4 text-left text-sm font-medium uppercase tracking-wide">Location</th>
                                    <th class="py-3 px-4 text-left text-sm font-medium uppercase tracking-wide">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="venue in venues"
                                    :key="venue.id"
                                    class="hover:bg-gray-100 dark:hover:bg-gray-600 border-t dark:border-gray-600"
                                >
                                    <!-- Venue Name -->
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                                        {{ venue.name }}
                                    </td>

                                    <!-- Venue Location -->
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                                        {{ venue.location }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                                        <button
                                            @click="editVenue(venue.id)"
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            @click="deleteVenue(venue.id)"
                                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- If there are no venues -->
                        <div
                            v-else
                            class="mt-6 bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-400 dark:border-yellow-500 p-4"
                        >
                            <p class="text-sm text-yellow-600 dark:text-yellow-300">
                                You currently have no venues. Create one to get started!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Props received from the Laravel backend
const props = defineProps({
    venues: Array,
});

// Edit venue function
const editVenue = (venueId) => {
    router.visit(`/venues/${venueId}/edit`);
};

// Delete venue function
const deleteVenue = (venueId) => {
    if (confirm("Are you sure you want to delete this venue?")) {
        router.delete(`/venues/${venueId}`, {
            onSuccess: () => {
                alert("Venue deleted successfully.");
            },
            onError: () => {
                alert("Failed to delete the venue.");
            },
        });
    }
};
</script>

<style scoped>
/* Add any custom styles here if needed */
</style>
