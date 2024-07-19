<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Popup from '@/Components/Popup.vue'

defineProps({
    semuaBarang: Array,
})

const showPopupModel = defineModel()

const emit = defineEmits(['barangSelected'])

function emitBarang(barang) {
    barang.qty = 1
    barang.diskon = 0
    emit('barangSelected', barang)
}

</script>

<template>
    <Popup v-if="showPopupModel">
        <div class="relative bg-white p-10">
            <button @click="showPopupModel = false" class="absolute top-0 right-0 px-2 py-1 bg-red-500 text-white font-bold">Close</button>
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in semuaBarang" :key="item.id">
                        <td>{{ item.kode }}</td>
                        <td>{{ item.nama }}</td>
                        <td>{{ item.harga }}</td>
                        <td>
                            <SecondaryButton
                                @click.prevent="emitBarang(item)"
                                >Select</SecondaryButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Popup>
</template>

<style scoped>
table tr * input {
    @apply w-full p-0 border-none text-center bg-slate-300;
}
tr, td, th, td *, th * {
    @apply h-full;
}
td *, th * {
    @apply w-full;
}
table {
    @apply border-collapse;
}
tr, th, td {
    @apply border border-black/30;
}
th, td {
    @apply px-2 py-1;
}
</style>