<!--<template>-->
<!--    <Head>-->
<!--        <title>Events</title>-->
<!--    </Head>-->

<!--    <AuthenticatedLayout>-->
<!--        <slot>-->
<!--            <div>-->
<!--                &lt;!&ndash; Search input field &ndash;&gt;-->
<!--                <input-->
<!--                    v-model="search"-->
<!--                    @input="searchEvents"-->
<!--                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"-->
<!--                    placeholder="Search events"-->
<!--                />-->

<!--                &lt;!&ndash; Event list &ndash;&gt;-->
<!--                <div class="flex flex-wrap">-->
<!--                    <div v-for="event in events.data" :key="event.id" class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 p-4">-->
<!--                        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">-->
<!--                            <a :href="'/events/' + event.id">-->
<!--&lt;!&ndash;                                <img :src="event.image_url" alt="Event Image" class="rounded-t-lg" />&ndash;&gt;-->
<!--                                <img src="https://i.pinimg.com/originals/ba/92/7f/ba927ff34cd961ce2c184d47e8ead9f6.jpg" alt="Event Image" class="rounded-t-lg" />-->
<!--                            </a>-->
<!--                            <div class="p-5">-->
<!--                                <a :href="'/events/' + event.id">-->
<!--                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ event.name }}</h5>-->
<!--                                </a>-->
<!--                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ event.date }}</p>-->
<!--                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ event.description }}</p>-->
<!--                                <a-->
<!--                                    :href="'/events/' + event.id"-->
<!--                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"-->
<!--                                >-->
<!--                                    Read more-->
<!--                                    <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">-->
<!--                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>-->
<!--                                    </svg>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

<!--                &lt;!&ndash; Pagination component &ndash;&gt;-->
<!--                <div class="mt-4">-->
<!--                    <inertia-link v-if="events.prev_page_url" :href="events.prev_page_url" class="btn btn-primary">-->
<!--                        Previous-->
<!--                    </inertia-link>-->
<!--                    <inertia-link v-if="events.next_page_url" :href="events.next_page_url" class="btn btn-primary">-->
<!--                        Next-->
<!--                    </inertia-link>-->
<!--                </div>-->
<!--            </div>-->
<!--        </slot>-->
<!--    </AuthenticatedLayout>-->
<!--</template>-->
<template>
    <AuthenticatedLayout>
        <slot>
            <div>
                <div class="flex flex-row m-8">
                    <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Your Email</label>
                    <button id="dropdown-button" data-dropdown-toggle="dropdown" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">All categories <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg></button>
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                            <li>
                                <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mockups</button>
                            </li>
                            <li>
                                <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Templates</button>
                            </li>
                            <li>
                                <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Design</button>
                            </li>
                            <li>
                                <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Logos</button>
                            </li>
                        </ul>
                    </div>
                    <div class="relative w-full">
                        <input
                            v-model="search"
                            @input="searchEvents"
                            type="search"
                            id="search-dropdown"
                            class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                            placeholder="Search for events..." required>
                        <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div>
                <!-- Search input field -->
<!--                <input-->
<!--                    v-model="search"-->
<!--                    @input="searchEvents"-->
<!--                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"-->
<!--                    placeholder="Search events"-->
<!--                />-->

                <!-- Event list -->
                <div class="flex grid grid-cols-4 grid-rows-4 gap-2 mx-8 justify-center md:justify-items-center">
                    <div v-for="event in events.data" :key="event.id" class="">
                        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <a :href="'/events/' + event.id">
                                <!--                                <img :src="event.image_url" alt="Event Image" class="rounded-t-lg" />-->
                                <img src="https://i.pinimg.com/originals/ba/92/7f/ba927ff34cd961ce2c184d47e8ead9f6.jpg" alt="Event Image" class="rounded-t-lg" />
                            </a>
                            <div class="p-5">
                                <a :href="'/events/' + event.id">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ event.name }}</h5>
                                </a>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ event.date }}</p>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ event.description }}</p>
                                <a
                                    :href="'/events/' + event.id"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                >
                                    Reserve
                                    <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination component -->
                <div class="mt-4">
                    <a :href="events.prev_page_url" class="btn btn-primary" v-if="events.prev_page_url">
                        Previous
                    </a>
                    <a :href="events.next_page_url" class="btn btn-primary" v-if="events.next_page_url">
                        Next
                    </a>
                </div>
            </div>
        </slot>
    </AuthenticatedLayout>
</template>


<script>
import {ref, watch, onMounted} from 'vue';
import {usePage} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import axios from "axios";

export default {
    components: {AuthenticatedLayout},
    setup() {
        const {data, post, router} = usePage();
        const search = ref('');

        // Define a default empty events object
        const events = ref([]);

        // Function to fetch events based on search query
        const searchEvents = async () => {
            // Use try-catch to handle any errors
            try {
                const response = await axios.get(route('events.index'), {
                    params: { search: search.value },
                    headers: { Accept: 'application/json' }
                });

                events.value = response.data;
            } catch (error) {
                console.error(error);
            }
        };

        // Function to cancel an event
        const cancelEvent = async (eventId) => {
            try {
                // Make a request to cancel the event using Axios or Inertia's post method
                // Example: const response = await axios.post(route('api.events.cancel', eventId));
                // You'll need to define the 'api.events.cancel' route in your Laravel routes
                // Then, update the events list or show a success message as needed.
            } catch (error) {
                console.error(error);
            }
        };

        // Function to reserve a seat for an event
        const reserveSeat = async (eventId) => {
            try {
                // Make a request to reserve a seat for the event using Axios or Inertia's post method
                // Example: const response = await axios.post(route('api.events.reserve', eventId));
                // You'll need to define the 'api.events.reserve' route in your Laravel routes
                // Then, update the events list or show a success message as needed.
            } catch (error) {
                console.error(error);
            }
        };

        // Watch for changes in the search query and trigger search
        watch(search, searchEvents);

        onMounted(() => {
            searchEvents();
        });

        return {
            search,
            events,
            searchEvents,
            cancelEvent,
            reserveSeat,
        };
    },
};
</script>
