<template>
    <Head>
        <title>Events</title>
    </Head>

    <main>
        <div>
            <!-- Search input field -->
            <input
                v-model="search"
                @input="searchEvents"
                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder="Search events"
            />

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="event in events.data" :key="event.id">
                    <div class="bg-white shadow-md p-4 rounded-lg">
                        <h2 class="text-xl font-semibold">{{ event.title }}</h2>
                        <p class="text-gray-600">{{ event.date }}</p>
                        <p class="mt-2">{{ event.description }}</p>
                    </div>
                </div>
            </div>

            <!-- Pagination component -->
            <inertia-link
                v-if="events.prev_page_url"
                :href="events.prev_page_url"
                class="btn btn-primary"
            >
                Previous
            </inertia-link>
            <inertia-link
                v-if="events.next_page_url"
                :href="events.next_page_url"
                class="btn btn-primary"
            >
                Next
            </inertia-link>
        </div>
    </main>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    components: {AuthenticatedLayout},
    props: {
        events: Object,
    },
    data() {
        return {
            search: '', // Initialize search query
        };
    },
    methods: {
        searchEvents() {
            this.$inertia.get(
                '/api/events', {
                    page: this.events.current_page,
                    search: this.search,
                }
            );
        },
    },
};
</script>
