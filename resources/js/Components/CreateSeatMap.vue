<template>
    <div id="seat-map-creator">
        <draggable class="drag-area" :v-model="items" group="items"
                   @start="drag=true"
                   @end="drag=false"
                   item-key="id">
            <div
                v-for="(item, index) in items"
                :key="index"
                :class="['item', item.type, { booked: item.booked }]"
                @click="toggleBooked(index)"
            >
                {{ item.label }}
            </div>
        </draggable>
        <div class="drop-area" v-for="row in rows" :key="row">
            <draggable class="row" :list="layout[row]" group="items" @change="updateLayout">
                <div
                    v-for="(seat, index) in layout[row]"
                    :key="index"
                    :class="['seat', seat.type, { booked: seat.booked }]"
                >
                    {{ seat.label }}
                </div>
            </draggable>
        </div>
        <button @click="saveLayout">Save Layout</button>
    </div>
</template>

<!--<template>-->
<!--    <div>-->
<!--        <draggable-->
<!--            v-model="items"-->
<!--            group="items"-->
<!--            @start="drag=true"-->
<!--            @end="drag=false"-->
<!--            item-key="id">-->
<!--            <template #item="{element}">-->
<!--                <div>{{element.label}}</div>-->
<!--            </template>-->
<!--        </draggable>-->
<!--    </div>-->
<!--</template>-->

<script>
import draggable from 'vuedraggable'

export default {
    components: {
        draggable,
    },
    data() {
        return {
            items: [
                { id: 1, type: 'chair', label: 'Chair', booked: false },
                { id: 2, type: 'table', label: 'Table', booked: false },
                // Add other furniture types as needed
            ],
            layout: Array.from({ length: 10 }, () => []), // 10 rows for example
            rows: 10, // Number of rows in the map
        };
    },
    methods: {
        toggleBooked(index) {
            this.items[index].booked = !this.items[index].booked;
        },
        updateLayout() {
            // Handle layout update
            // This will be triggered when items are moved around
        },
        saveLayout() {
            // Here you would send the layout to your backend to be saved
            // Replace with an actual API call to your Laravel backend
            axios.post('/save-layout', { layout: this.layout })
                .then(response => {
                    // Handle success
                    console.log('Layout saved', response);
                })
                .catch(error => {
                    // Handle error
                    console.error('Error saving layout', error);
                });
        },
    },
};
</script>

<style scoped>
.drag-area,
.drop-area {
    border: 1px solid #ccc;
    min-height: 50px;
    margin-bottom: 10px;
}

.item,
.seat {
    padding: 5px;
    border: 1px solid #000;
    margin: 2px;
    display: inline-block;
    cursor: pointer;
}

.chair {
    background-color: #a2b9bc;
}

.table {
    background-color: #b2ad7f;
}

.booked {
    background-color: #ff6b6b;
}
</style>
