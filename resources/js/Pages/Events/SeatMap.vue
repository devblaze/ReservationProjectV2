<template>
    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="modal">
            <button @click="confirmReservation">Confirm Reservation</button>
        </div>
    </div>
</template>

<script>
import {ref, defineEmits} from 'vue';

export default {
    // Component logic here
    setup() {
        const selectedSeats = ref([]);
        const selectedSeatCount = ref(0);

        // Emit an event to confirm the reservation
        const emit = defineEmits();

        const confirmReservation = () => {
        // Emit an event with selected seats data
            emit('reserve', {
                seats: selectedSeats.value,
                seatCount: selectedSeatCount.value,
            });
        };

        // Seat selection logic here
        return {
            selectedSeats,
            selectedSeatCount,
            confirmReservation,
        };
    },
};
</script>
