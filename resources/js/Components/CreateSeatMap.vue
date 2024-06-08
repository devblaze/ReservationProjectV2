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
            <button type="button" class="btn bg-blue-500 hover:bg-blue-600 text-white" @click="addItem('chair')">Add Chair</button>
            <button type="button" class="btn bg-blue-500 hover:bg-blue-600 text-white" @click="addItem('table')">Add Table</button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: {
        initialItems: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            items: [],
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
            this.emitLayout();
        },
        addItem(type) {
            const newItem = {
                id: this.generateUniqueId(),
                type: type,
                label: type.charAt(0).toUpperCase() + type.slice(1),
                booked: false,
                x: 50,
                y: 50,
            };
            this.items.push(newItem);
            this.emitLayout();
        },
        generateUniqueId() {
            return Date.now() + Math.random().toString(36).substr(2, 9);
        },
        emitLayout() {
            this.$emit('update-layout', this.items);
        },
    },
    created() {
        this.items = this.initialItems.map(item => ({ ...item }));
    },
};
</script>

<style scoped>
.btn {
    padding: 0.5rem 1.5rem;
    border: none;
    border-radius: 0.375rem;
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
}

.table {
    background-color: #9a3412;
}
</style>
