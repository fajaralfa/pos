<script setup>
import SelectBarangPopup from './SelectBarangPopup.vue';

defineProps({
    semuaBarang: Array,
})

const showPopupModel = defineModel()

const emit = defineEmits(['barangSelected'])

function emitBarang(barang) {
    emit('barangSelected', barang)
}

</script>

<template>
    <SelectBarangPopup :semuaBarang v-model="showPopupModel" @barangSelected="emitBarang" />
</template>