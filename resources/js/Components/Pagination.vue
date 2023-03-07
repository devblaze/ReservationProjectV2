<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item" :class="{ disabled: currentPage <= 1 }">
                <a class="page-link" href="#" @click.prevent="paginate(currentPage - 1)">Previous</a>
            </li>
            <li v-for="pageNumber in totalPages" :key="pageNumber" class="page-item" :class="{ active: pageNumber === currentPage }">
                <a class="page-link" href="#" @click.prevent="paginate(pageNumber)">{{ pageNumber }}</a>
            </li>
            <li class="page-item" :class="{ disabled: currentPage >= totalPages }">
                <a class="page-link" href="#" @click.prevent="paginate(currentPage + 1)">Next</a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true,
        },
        totalPages: {
            type: Number,
            required: true,
        },
        onPaginate: {
            type: Function,
            required: true,
        },
    },
    methods: {
        paginate(pageNumber) {
            if (pageNumber > 0 && pageNumber <= this.totalPages) {
                this.onPaginate(pageNumber);
            }
        },
    },
};
</script>
