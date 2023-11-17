<template>
    <div class="my-8 p-4 bg-gray-50 rounded-lg shadow">
        <div class="canvas relative border-2 border-dashed border-gray-300 h-96 mb-4 bg-gray-200"
             @mousemove="handleMouseMove" @mouseup="endDrag">
            <div
                v-for="item in items"
                :key="item.id"
                :class="['item', 'absolute', 'cursor-move', 'select-none', item.type, { 'bg-red-500': item.booked }]"
                :style="{ top: `${item.y}px`, left: `${item.x}px` }"
                @mousedown="startDrag(item, $event)"
            >
                {{ item.label }}
            </div>
        </div>
        <div class="flex justify-between">
            <button class="btn bg-blue-500 hover:bg-blue-600 text-white" @click="addItem('chair')">Add Chair</button>
            <button class="btn bg-blue-500 hover:bg-blue-600 text-white" @click="addItem('table')">Add Table</button>
            <button class="btn bg-blue-600 hover:bg-blue-700 text-white" @click="saveLayout">Save Layout</button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            items: [],
            layout: Array.from({length: 100}, () => []), // 10 rows for example
            rows: 100, // Number of rows in the map
            currentDragItem: null,
            offsetX: 0,
            offsetY: 0,
        };
    },
    methods: {
        startDrag(item, event) {
            this.currentDragItem = item;
            this.offsetX = event.clientX - item.x;
            this.offsetY = event.clientY - item.y;
            event.preventDefault();
        },
        handleMouseMove(event) {
            if (this.currentDragItem) {
                this.currentDragItem.x = event.clientX - this.offsetX;
                this.currentDragItem.y = event.clientY - this.offsetY;
            }
        },
        endDrag() {
            if (this.currentDragItem) {
                this.currentDragItem = null;
            }
        },
        addItem(type) {
            const newItem = {
                id: this.generateUniqueId(),
                type: type,
                label: type.charAt(0).toUpperCase() + type.slice(1),
                booked: false,
                x: 50,
                y: 50,
                icon: type === 'chair' ? '🪑' : '🛏️', // Emoji icons for chair and table
            };
            this.items.push(newItem);
        },
        generateUniqueId() {
            return Date.now() + Math.random().toString(36).substr(2, 9);
        },
        saveLayout() {
            // Here you would send the layout to your backend to be saved
            // Replace with an actual API call to your Laravel backend
            console.log('Layout saved!');
            axios.post('/save-layout', {layout: this.layout})
                .then(response => {
                    // Handle success
                    console.log('Layout saved', response);
                })
                .catch(error => {
                    // Handle error
                    console.error('Error saving layout', error);
                });
        },
        emitLayout() {
            this.$emit('update-layout', this.layout);
        }
    },
};
</script>

<style scoped>
.btn {
    padding: 0.5rem 1.5rem;
    border: none;
    border-radius: 0.375rem; /* rounded-md */
    cursor: pointer;
    transition: background-color 150ms ease-in-out;
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
    background-color: #3f3f46;
    /*
    background-image: url('https://png.pngtree.com/png-vector/20190411/ourmid/pngtree-vector-chair-icon-png-image_927127.jpg')
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    */
}

.table {
    background-color: #9a3412;
}
</style>
