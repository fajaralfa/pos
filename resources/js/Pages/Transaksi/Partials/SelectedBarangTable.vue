<script setup>
import { computed, watch } from 'vue';

const input = defineModel()

const emit = defineEmits(['tambahBarang', 'ubahBarang'])

const sumInput = computed(() => {
    let subtotal = 0
    let total = 0
    input.value.barang.forEach((item) => {
        subtotal += sumTotal(hargaDiskon(item.harga, item.diskon), item.qty)
    })

    total = subtotal - input.value.diskon + Number(input.value.ongkir)

    return { subtotal, total }
})

const potongan = (harga, diskon) => (harga / 100 * diskon)
const hargaDiskon = (harga, diskon) => harga - potongan(harga, diskon)
const sumTotal = (harga, qty) => harga * qty

</script>

<template>
    <table class="w-full table-fixed">
        <thead>
            <tr>
                <th rowspan="2" class="!p-0 w-32">
                    <button class="w-full bg-slate-300" @click="$emit('tambahBarang')">Tambah</button>
                </th>
                <th rowspan="2" class="w-10">No</th>
                <th rowspan="2">Kode</th>
                <th rowspan="2" class="w-60">Nama</th>
                <th rowspan="2" class="border py-1 w-20">QTY</th>
                <th rowspan="2" class="w-40">Harga Bandrol</th>
                <th colspan="2">Diskon</th>
                <th rowspan="2" class="w-40">Harga Diskon</th>
                <th rowspan="2" class="border py-1 w-40">Total</th>
            </tr>
            <tr>
                <th>(%)</th>
                <th>(Rp)</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <tr v-if="input.barang.length == 0" class="min-h-full">
                <th colspan="8" class="text-center text-2xl">Data Kosong!</th>
            </tr>
            <tr v-for="(item, index) in input.barang" :key="item.id">
                <td class="w-full !p-0">
                    <div class="flex bg-blue-300">
                        <button class="w-1/2 bg-blue-300" @click="$emit('ubahBarang', index)">Ubah</button>
                        <button @click="input.barang.splice(index, 1)" class="w-1/2 bg-red-300">Hapus</button>
                    </div>
                </td>
                <td>{{ index + 1 }}</td>
                <td>{{ item.kode }}</td>
                <td>{{ item.nama }}</td>
                <td class="!p-0">
                    <input v-model="item.qty" class="w-full border text-center">
                </td>
                <td>{{ item.harga }}</td>
                <td class="!p-0">
                    <input v-model="item.diskon" class="w-10 !p-0 border text-center">
                </td>
                <td>{{ potongan(item.harga, item.diskon) }}</td>
                <td>{{ hargaDiskon(item.harga, item.diskon) }}</td>
                <td>{{ sumTotal(hargaDiskon(item.harga, item.diskon), item.qty) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="8" rowspan="4"></th>
                <th>Sub Total</th>
                <th>{{ sumInput.subtotal }}</th>
            </tr>
            <tr>
                <th>Diskon</th>
                <th class="!p-0"><input v-model="input.diskon" class="w-full !p-0 border-none text-center bg-slate-300"></th>
            </tr>
            <tr>
                <th>Ongkir</th>
                <th class="!p-0"><input v-model="input.ongkir"></th>
            </tr>
            <tr>
                <th>Total Bayar</th>
                <th>{{ sumInput.total }}</th>
            </tr>
        </tfoot>
    </table>
</template>

<style scoped>
table tr * input {
    @apply w-full !p-0 border-none text-center bg-slate-300;
}
tr, td, th, td *, th *, th * {
    @apply h-full;
}
td *, th input, th button {
    @apply w-full;
}
table {
    @apply border-collapse;
}
thead tr, thead th, thead td, tbody tr, tbody td {
    @apply border border-black/30;
}
th, td {
    @apply px-2 py-1;
}
</style>