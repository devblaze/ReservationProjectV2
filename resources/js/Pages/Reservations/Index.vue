<template>
    <Head title="Reservations" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="container mx-auto py-12 px-6">
                        <!-- My Reservations Title -->
                        <h1 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-100 mb-8">💺 My Reservations</h1>

                        <!-- If there are reservations -->
                        <div v-if="reservations.length > 0" class="bg-white dark:bg-gray-700 shadow-md rounded-lg mt-6 overflow-x-auto">
                            <table class="min-w-full table-auto border-collapse">
                                <thead class="bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-400">
                                <tr>
                                    <th class="py-3 px-4 text-left text-sm font-medium uppercase tracking-wide">Event</th>
                                    <th class="py-3 px-4 text-left text-sm font-medium uppercase tracking-wide">Seat Number</th>
                                    <th class="py-3 px-4 text-left text-sm font-medium uppercase tracking-wide">Status</th>
                                    <th class="py-3 px-4 text-left text-sm font-medium uppercase tracking-wide">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="reservation in reservations" :key="reservation.id" class="hover:bg-gray-100 dark:hover:bg-gray-600 border-t dark:border-gray-600">
                                    <!-- Reservation Event Title -->
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ reservation.event.title }}</td>
                                    <!-- Reservation Seat Number -->
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ reservation.seat_number }}</td>
                                    <!-- Reservation Status -->
                                    <td class="py-3 px-4">
                                            <span
                                                :class="{
                                                    'text-green-600 dark:text-green-400 font-semibold': reservation.status === 'confirmed',
                                                    'text-red-600 dark:text-red-400 font-semibold': reservation.status === 'cancelled'
                                                }">
                                                {{ reservation.status }}
                                            </span>
                                    </td>
                                    <!-- Reservation Date -->
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ formatDate(reservation.created_at) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- If there are no reservations -->
                        <div v-else class="mt-6 bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-400 dark:border-yellow-500 p-4">
                            <p class="text-sm text-yellow-600 dark:text-yellow-300">You currently have no reservations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed } from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Props received from the Laravel backend
const props = defineProps({
    reservations: Array,
});

// Format date function
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};
</script>

<style scoped>
/* Here you can add any scoped styles if needed (though Tailwind likely covers most styling needs) */
</style>
