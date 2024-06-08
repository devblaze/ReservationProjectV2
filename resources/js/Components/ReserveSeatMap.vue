<template>
    <div class="my-8 p-4 bg-gray-50 rounded-lg shadow">
        <div class="canvas relative border-2 border-dashed border-gray-300 h-96 mb-4 bg-gray-200">
            <div
                v-for="item in layout"
                :key="item.id"
                :class="['item', 'absolute', 'select-none',
                item.type, {
                    'bg-red-500': item.booked,
                    'bg-gray-500': item.selected && !item.booked,
                    'bg-orange-800': item.type === 'table' && !item.selected && !item.booked,
                    'bg-green-800': item.type === 'chair' && !item.selected && !item.booked,
                }]"
                :style="{ top: `${item.y}px`, left: `${item.x}px` }"
                @click="toggleSelection(item)"
            >
                {{ item.label }}
            </div>
        </div>
        <div class="flex flex-wrap">
            <div class="flex items-center" v-for="(item, index) in selectedItems" :key="index">
                <div
                    :class="['item', item.type, { 'bg-red-500': item.booked, 'bg-gray-500': item.selected && !item.booked }]">
                    {{ item.label }}
                </div>
                <!--                <button type="button"-->
                <!--                        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"-->
                <!--                        @click="unselectItem(index)">-->
                <!--                    Remove-->
                <!--                </button>-->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        initialItems: {
            Array,
            default: () => [],
        },
    },
    data() {
        return {
            items: [],
            layout: Array.from({length: 100}, () => []), // 10 rows for example
            rows: 100, // Number of rows in the map
            currentDragItem: null,
            offsetX: 0,
            offsetY: 0,
            selectedItems: [],
        };
    },
    methods: {
        toggleSelection(item) {
            if (item.selected) {
                this.unselectItem(this.selectedItems.indexOf(item));
            } else if (!item.booked) {
                this.selectItem(item);
            }
        },
        unselectItem(index) {
            const item = this.selectedItems[index];
            if (item) {
                item.selected = false;
                this.selectedItems.splice(index, 1);
            }
        },
        selectItem(item) {
            item.selected = true;
            this.selectedItems.push(item);
            this.emitSelectedSeats();
        },
        emitSelectedSeats() {
            this.$emit('selected-seats', this.selectedItems);
        },
    },
    created() {
        this.layout = JSON.parse(this.initialItems);
    }
};
</script>

<style scoped>
.item {
    padding: 5px;
    border: 1px solid #000;
    margin: 2px;
    display: inline-block;
    cursor: pointer;
}
</style>
