<!--<template>-->
<!--    <AuthenticatedLayout>-->
<!--        <div>-->
<!--            <h1>Events</h1>-->
<!--            <table>-->
<!--                <thead>-->
<!--                <tr>-->
<!--                    <th>Title</th>-->
<!--                    <th>Description</th>-->
<!--                    <th>Seats</th>-->
<!--                    <th>Seats Left</th>-->
<!--                    <th>Start Time</th>-->
<!--                    <th>End Time</th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!--                <tr v-for="event in events" :key="event.id">-->
<!--                    <td>{{ event.title }}</td>-->
<!--                    <td>{{ event.description }}</td>-->
<!--                    <td>{{ event.seats }}</td>-->
<!--                    <td>{{ event.seats_left }}</td>-->
<!--                    <td>{{ event.start_time }}</td>-->
<!--                    <td>{{ event.end_time }}</td>-->
<!--                </tr>-->
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->
<!--    </AuthenticatedLayout>-->
<!--</template>-->

<!--<script>-->
<!--import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';-->
<!--import { usePage } from '@inertiajs/vue3'-->

<!--export default {-->
<!--    components: {-->
<!--        AuthenticatedLayout-->
<!--    },-->
<!--    setup() {-->
<!--        const { events } = usePage().props-->

<!--        return {-->
<!--            events-->
<!--        }-->
<!--    }-->
<!--}-->
<!--</script>-->

<!--<div class="search-panel">-->
<!--<div class="row">-->
<!--    <div class="col-2 mt-3">-->
<!--        <div class="search-panel__filters">-->
<!--            <ais-refinement-list attribute="type" searchable-placeholder="Search types..." searchable />-->
<!--        </div>-->
<!--        <hr>-->
<!--        <div class="search-panel__filters">-->
<!--            <ais-refinement-list attribute="country" searchable-placeholder="Search countries..." searchable />-->
<!--        </div>-->
<!--    </div>-->

<!--    <div class="col-1">-->

<!--    </div>-->

<!--    <div class="col">-->
<!--        <div class="row">-->
<!--            <div class="search-panel__results">-->
<!--                <ais-search-box placeholder="Search events by name / type / location" class="searchbox" />-->

<!--                <ais-configure :hits-per-page.camel="12" />-->
<!--                <ais-hits :transform-items="transformItems">-->
<!--                    <div class="row" slot-scope="{ items, sendEvent }">-->
<!--                        <div class="col my-3" v-for="item in items" :key="item.objectID">-->
<!--                            <div class="card" style="width: 18rem;">-->
<!--                                <img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1769f8b6c08%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1769f8b6c08%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22107.1953125%22%20y%3D%2296.3%22%3E286x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">-->
<!--                                <div class="card-body">-->
<!--                                    <h5 class="card-title">{{ item.name }}</h5>-->
<!--                                    <p class="card-text">{{ item.description }}</p>-->
<!--                                </div>-->
<!--                                <ul class="list-group list-group-flush">-->
<!--                                    <li class="list-group-item">-->
<!--                                        {{ item.location }}-->
<!--                                    </li>-->
<!--                                    <li class="list-group-item">-->
<!--                                        Ending: {{ item.end_time }}-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                                <div class="card-body">-->
<!--                                    <a :href="'/event/' + item.id" class="btn btn-success">-->
<!--                                        Check in before-->
<!--                                        <br>-->
<!--                                    </a>-->
<!--                                    <p class="text-danger">The event is full!</p>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </ais-hits>-->
<!--            </div>-->
<!--        </div>-->

<!--        <div class="row justify-content-center">-->
<!--            <div class="pagination"><ais-pagination /></div>-->
<!--        </div>-->

<!--    </div>-->
<!--</div>-->

<!--</div>-->

<!--<template>-->
<!--    <AuthenticatedLayout>-->
<!--        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">-->
<!--            <div class="flex justify-between items-center mb-6">-->
<!--                <router-link :to="{ name: 'events.create' }" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">-->
<!--                    Create Event-->
<!--                </router-link>-->
<!--            </div>-->
<!--            <div class="overflow-hidden border-b border-gray-200 sm:rounded-lg">-->
<!--                <table class="min-w-full divide-y divide-gray-200">-->
<!--                    <thead class="bg-gray-50">-->
<!--                    <tr>-->
<!--                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
<!--                            Title-->
<!--                        </th>-->
<!--                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
<!--                            Description-->
<!--                        </th>-->
<!--                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
<!--                            Seats-->
<!--                        </th>-->
<!--                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
<!--                            Seats Left-->
<!--                        </th>-->
<!--                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
<!--                            Start Time-->
<!--                        </th>-->
<!--                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
<!--                            End Time-->
<!--                        </th>-->
<!--                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">-->
<!--                            Actions-->
<!--                        </th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody class="bg-white divide-y divide-gray-200">-->
<!--                    <tr v-for="event in events" :key="event.id">-->
<!--                        <td class="px-6 py-4 whitespace-nowrap">-->
<!--                            <div class="text-sm font-medium text-gray-900">{{ event.title }}</div>-->
<!--                        </td>-->
<!--                        <td class="px-6 py-4 whitespace-nowrap">-->
<!--                            <div class="text-sm text-gray-500">{{ event.description }}</div>-->
<!--                        </td>-->
<!--                        <td class="px-6 py-4 whitespace-nowrap">-->
<!--                            <div class="text-sm text-gray-900">{{ event.seats }}</div>-->
<!--                        </td>-->
<!--                        <td class="px-6 py-4 whitespace-nowrap">-->
<!--                            <div class="text-sm text-gray-900">{{ event.seats_left }}</div>-->
<!--                        </td>-->
<!--                        <td class="px-6 py-4 whitespace-nowrap">-->
<!--                            <div class="text-sm text-gray-500">{{ event.start_time }}</div>-->
<!--                        </td>-->
<!--                        <td class="px-6 py-4 whitespace-nowrap">-->
<!--                            <div class="text-sm text-gray-500">{{ event.end_time }}</div>-->
<!--                        </td>-->
<!--                        <td class="px-6 py-4 whitespace-nowrap text-center">-->
<!--                            <div class="flex justify-center">-->
<!--&lt;!&ndash;                                <button v-if=""></button>&ndash;&gt;-->
<!--                            </div>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--        </div>-->
<!--    </AuthenticatedLayout>-->
<!--</template>-->

<!--<script>-->
<!--import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';-->
<!--import { usePage } from '@inertiajs/vue3'-->

<!--export default {-->
<!--    components: {-->
<!--        AuthenticatedLayout-->
<!--    },-->
<!--    setup() {-->
<!--        const { events } = usePage().props-->

<!--        return {-->
<!--            events-->
<!--        }-->
<!--    }-->
<!--}-->
<!--</script>-->

<template>
    <Head title="Events" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Events</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="card" style="width: 18rem;">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">This is the events page!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';


export default {
    components: {
        AuthenticatedLayout,
        Head,
        usePage,
        Pagination,
    },
    props: {
        events: Object
    }
}
</script>

