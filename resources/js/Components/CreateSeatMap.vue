<template>
    <div class="my-8 p-4 bg-gray-50 rounded-lg shadow">
        <!-- Grid Settings -->
        <div class="flex items-center space-x-4 mb-6 text-black">
            <div class="flex flex-col">
                <label for="rows" class="font-medium mb-1">Rows</label>
                <input
                    type="number"
                    id="rows"
                    v-model.number="rows"
                    class="border border-gray-300 rounded-md p-2 text-gray-700 focus:ring focus:ring-blue-300 w-20"
                />
            </div>
            <div class="flex flex-col">
                <label for="columns" class="font-medium mb-1">Columns</label>
                <input
                    type="number"
                    id="columns"
                    v-model.number="columns"
                    class="border border-gray-300 rounded-md p-2 text-gray-700 focus:ring focus:ring-blue-300 w-20"
                />
            </div>
            <div class="flex flex-col">
                <label for="gridSize" class="font-medium mb-1">Grid Size (px)</label>
                <input
                    type="number"
                    id="gridSize"
                    v-model.number="gridSize"
                    class="border border-gray-300 rounded-md p-2 text-gray-700 focus:ring focus:ring-blue-300 w-20"
                />
            </div>
        </div>

        <!-- Canvas with zoom functionality -->
        <div
            class="canvas-container overflow-auto border-2 border-dashed border-gray-300 bg-gray-200"
            @wheel="handleZoom"
        >
            <div
                class="canvas relative"
                @mousedown="startAction"
                @mousemove="handleMouseMove"
                @mouseup="endAction"
                ref="canvas"
                :style="{
                    width: `${columns * gridSize}px`,
                    height: `${rows * gridSize}px`,
                    transform: `scale(${scale})`,
                    transformOrigin: 'top left',
                }"
            >
                <!-- Render grid -->
                <div
                    v-for="row in rows"
                    :key="'row-' + row"
                    class="grid-row"
                    :style="{ top: `${row * gridSize}px` }"
                >
                    <div
                        v-for="col in columns"
                        :key="'col-' + col"
                        class="grid-col"
                        :style="{
                            width: `${gridSize}px`,
                            height: `${gridSize}px`,
                            left: `${col * gridSize}px`,
                        }"
                    ></div>
                </div>

                <!-- Render items -->
                <div
                    v-for="item in items"
                    :key="item.id"
                    :class="[
        'item',
        'absolute',
        'cursor-pointer',
        item.type,
        { 'bg-red-500': item.booked, 'selected-item': selectedItems.includes(item) }
    ]"
                    :style="{ top: `${item.y}px`, left: `${item.x}px`, width: `${gridSize}px`, height: `${gridSize}px` }"
                    @mousedown.stop="startDrag(item, $event)"
                >
                    {{ item.label }}
                </div>


                <!-- Selection Area -->
                <div
                    v-if="selection.active"
                    class="absolute bg-blue-300 bg-opacity-50 border border-blue-500"
                    :style="{
                        top: `${selection.startY}px`,
                        left: `${selection.startX}px`,
                        width: `${selection.width}px`,
                        height: `${selection.height}px`,
                    }"
                ></div>
            </div>
        </div>

        <!-- Controls -->
        <div class="flex justify-between mt-4 items-center">
            <!-- Dropdown to select item type -->
            <div class="flex items-center space-x-4 text-black">
                <label for="itemType" class="font-medium">Generate:</label>
                <select
                    id="itemType"
                    v-model="selectedType"
                    class="border border-gray-300 rounded-md p-2 text-gray-700 focus:ring focus:ring-blue-300"
                >
                    <option value="chair">Chairs</option>
                    <option value="table">Tables</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-4">
                <button
                    type="button"
                    class="px-4 py-2 bg-green-600 text-white font-medium rounded-md shadow-sm hover:bg-green-700 focus:ring focus:ring-green-300"
                    @click="generateItems"
                >
                    Generate Items
                </button>
                <button
                    type="button"
                    class="px-4 py-2 bg-red-600 text-white font-medium rounded-md shadow-sm hover:bg-red-700 focus:ring focus:ring-red-300"
                    @click="deleteSelectedItems"
                >
                    Delete Selected
                </button>
            </div>
        </div>
    </div>
</template>

<script>
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
            gridSize: 50, // Default grid size in pixels
            rows: 12, // Default number of rows
            columns: 16, // Default number of columns
            selection: {
                active: false,
                startX: 0,
                startY: 0,
                width: 0,
                height: 0,
            },
            scale: 1, // Zoom level
            zoomStep: 0.1, // Increment for zooming
            minScale: 0.5, // Minimum zoom level
            maxScale: 2, // Maximum zoom level
            currentDragItem: null,
            offsetX: 0,
            offsetY: 0,
            selectedType: "chair", // Default to "chair"
        };
    },
    methods: {
        handleZoom(event) {
            event.preventDefault();
            if (event.deltaY < 0 && this.scale < this.maxScale) {
                this.scale += this.zoomStep;
            } else if (event.deltaY > 0 && this.scale > this.minScale) {
                this.scale -= this.zoomStep;
            }
        },
        startAction(event) {
            const rect = this.$refs.canvas.getBoundingClientRect();
            const clickX = (event.clientX - rect.left) / this.scale;
            const clickY = (event.clientY - rect.top) / this.scale;

            const clickedItem = this.items.find(
                (item) => clickX >= item.x && clickX < item.x + this.gridSize &&
                    clickY >= item.y && clickY < item.y + this.gridSize
            );

            if (clickedItem) {
                // Handle single or multi-selection
                if (event.ctrlKey || event.metaKey) {
                    // Toggle the clicked item in the selected items list
                    const isSelected = this.selectedItems.includes(clickedItem);
                    if (isSelected) {
                        this.selectedItems = this.selectedItems.filter((item) => item !== clickedItem);
                    } else {
                        this.selectedItems.push(clickedItem);
                    }
                } else {
                    // Single selection
                    this.selectedItems = [clickedItem];
                }
            } else {
                // Start area selection
                this.selection.active = true;
                this.selection.startX = Math.floor(clickX / this.gridSize) * this.gridSize;
                this.selection.startY = Math.floor(clickY / this.gridSize) * this.gridSize;
                this.selection.width = 0;
                this.selection.height = 0;
                this.selectedItems = []; // Clear selection
            }
        },
        handleMouseMove(event) {
            if (this.selection.active) {
                const rect = this.$refs.canvas.getBoundingClientRect();
                const currentX = (event.clientX - rect.left) / this.scale;
                const currentY = (event.clientY - rect.top) / this.scale;

                // Calculate raw width and height
                const rawWidth = currentX - this.selection.startX;
                const rawHeight = currentY - this.selection.startY;

                // Handle reverse selection horizontally
                if (rawWidth < 0) {
                    this.selection.width = Math.abs(rawWidth);
                    this.selection.startX = currentX;
                } else {
                    this.selection.width = rawWidth;
                }

                // Handle reverse selection vertically
                if (rawHeight < 0) {
                    this.selection.height = Math.abs(rawHeight);
                    this.selection.startY = currentY;
                } else {
                    this.selection.height = rawHeight;
                }

                // Normalize the width and height to ensure positive values
                this.selection.width = Math.abs(this.selection.width);
                this.selection.height = Math.abs(this.selection.height);
            } else if (this.currentDragItem) {
                // Move all selected items
                this.selectedOffsets.forEach(({ item, offsetX, offsetY }) => {
                    let x = (event.clientX - offsetX) / this.scale;
                    let y = (event.clientY - offsetY) / this.scale;

                    // Snap to grid
                    x = Math.round(x / this.gridSize) * this.gridSize;
                    y = Math.round(y / this.gridSize) * this.gridSize;

                    // Prevent going out of bounds
                    x = Math.max(0, Math.min(x, (this.columns - 1) * this.gridSize));
                    y = Math.max(0, Math.min(y, (this.rows - 1) * this.gridSize));

                    item.x = x;
                    item.y = y;
                });
            }
        },
        endAction() {
            if (this.selection.active) {
                // Normalize selection dimensions
                const endX = this.selection.startX + this.selection.width;
                const endY = this.selection.startY + this.selection.height;

                const normalizedStartX = Math.min(this.selection.startX, endX);
                const normalizedStartY = Math.min(this.selection.startY, endY);
                const normalizedWidth = Math.abs(this.selection.width);
                const normalizedHeight = Math.abs(this.selection.height);

                this.selection.startX = normalizedStartX;
                this.selection.startY = normalizedStartY;
                this.selection.width = normalizedWidth;
                this.selection.height = normalizedHeight;

                // Select items within the normalized rectangle
                this.selectedItems = this.items.filter((item) => {
                    return (
                        item.x >= this.selection.startX &&
                        item.x < this.selection.startX + this.selection.width &&
                        item.y >= this.selection.startY &&
                        item.y < this.selection.startY + this.selection.height
                    );
                });
            }

            this.selection.active = false;
            this.currentDragItem = null;
        },
        deleteSelectedItems() {
            this.items = this.items.filter((item) => !this.selectedItems.includes(item));
            this.selectedItems = [];
            this.emitLayout();
        },
        generateItems() {
            if (!this.selection.width || !this.selection.height) {
                alert("Please select an area first!");
                return;
            }

            const cols = Math.floor(this.selection.width / this.gridSize);
            const rows = Math.floor(this.selection.height / this.gridSize);

            for (let row = 0; row < rows; row++) {
                for (let col = 0; col < cols; col++) {
                    const x = this.selection.startX + col * this.gridSize;
                    const y = this.selection.startY + row * this.gridSize;

                    if (!this.items.some((item) => item.x === x && item.y === y)) {
                        this.items.push({
                            id: this.generateUniqueId(),
                            type: this.selectedType, // Use the selected type
                            label: this.selectedType.charAt(0).toUpperCase() + this.selectedType.slice(1),
                            booked: false,
                            x,
                            y,
                        });
                    }
                }
            }

            this.emitLayout();
        },
        startDrag(item, event) {
            if (!this.selectedItems.includes(item)) {
                // If the item is not already selected, clear all selections and select this one
                this.selectedItems = [item];
            }
            // Track the initial mouse position and offsets for selected items
            this.currentDragItem = item;
            this.offsetX = event.clientX - item.x;
            this.offsetY = event.clientY - item.y;
            this.selectedOffsets = this.selectedItems.map((selectedItem) => ({
                item: selectedItem,
                offsetX: event.clientX - selectedItem.x,
                offsetY: event.clientY - selectedItem.y,
            }));
        },
        generateUniqueId() {
            return Date.now() + Math.random().toString(36).substr(2, 9);
        },
        emitLayout() {
            this.$emit("update-layout", this.items);
        },
    },
    created() {
        this.items = this.initialItems.map((item) => ({...item}));
    },
};
</script>

<style scoped>
.canvas-container {
    position: relative;
    width: 100%;
    height: 700px;
}

.canvas {
    position: relative;
    display: block;
    user-select: none;
    overflow: hidden;
}

.grid-row,
.grid-col {
    position: absolute;
    pointer-events: none;
    border: 1px solid #e5e7eb; /* Light gray border */
}

.item {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    text-align: center;
    border: 1px solid #000;
    color: white;
}

.chair {
    background-color: #3b82f6; /* Blue */
}

.table {
    background-color: #f59e0b; /* Amber */
}

.selection {
    border: 1px dashed #38bdf8;
}

.selected-item {
    border: 2px solid #38bdf8; /* Highlight color for selected items */
    background-color: rgba(56, 189, 248, 0.2); /* Light blue overlay */
}
</style>
