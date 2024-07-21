<script setup>
defineProps({
    semuaTransaksi: Array,
    grandTotal: Object,
})

let count = 1
</script>

<template>
    <div class="px-2 md:px-10 overflow-auto text-sm md:text-base">
        <table class="md:w-full table-fixed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Transaksi</th>
                    <th>Tanggal</th>
                    <th>Nama Customer</th>
                    <th>Jumlah Barang</th>
                    <th>Sub Total</th>
                    <th>Diskon</th>
                    <th>Ongkir</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in semuaTransaksi">
                    <td>{{ count++ }}</td>
                    <td>{{ item.kode }}</td>
                    <td>{{ item.tgl }}</td>
                    <td>{{ item.customer?.nama ?? item.namaCustomer }}</td>
                    <td>{{ item.jumlah_barang }}</td>
                    <td>{{ item.subtotal }}</td>
                    <td>{{ item.diskon }}</td>
                    <td>{{ item.ongkir }}</td>
                    <td>{{ item.total_bayar }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="4" class="text-center">Grand Total</td>
                    <td>{{ grandTotal['grandTotal'] }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
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