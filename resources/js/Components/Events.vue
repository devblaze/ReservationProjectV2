<template>
    <div>
        <!-- Search input field -->
        <input
            v-model="search"
            @input="searchEvents"
            class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            placeholder="Search events"
        />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Display events as before -->
        </div>

        <!-- Pagination component -->
        <pagination :data="events" @pagination-change-page="loadEvents" />
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            events: [],
            search: '', // Initialize search query
        };
    },
    created() {
        this.loadEvents();
    },
    methods: {
        loadEvents(page = 1) {
            axios
                // .get(`/api/events?page=${page}&search=${this.search}`)
                .get(route('events.index', page), { search: this.search })
                .then((response) => {
                    this.events = response.data;
                });
        },
        searchEvents() {
            this.loadEvents(); // Reload events with updated search query
        },
    },
};
</script>
