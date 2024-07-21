<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router, Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';

defineProps({
    semuaBarang: {
        type: Array,
    },
    errors: Object,
})

const title = "Daftar Barang"

function confirmDelete(id) {
    if (confirm('Hapus data ini?')) {
        router.delete(route('barang.destroy', id))
    }
}
</script>

<template>
    <Head :title />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}</h2>
        </template>
        <InputError :message="errors.barang" />
        <Link :href="route('barang.create')" as="button" class="px-10 py-5">
        <PrimaryButton>Tambah Barang</PrimaryButton>
        </Link>
        <div class="flex justify-center text-sm md:text-base">
            <table class="border-collapse table-fixed">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in semuaBarang">
                        <td>{{ item.kode }}</td>
                        <td>{{ item.nama }}</td>
                        <td>{{ item.harga }}</td>
                        <td class="flex !p-0 w-12">
                            <Link :href="route('barang.edit', item.id)" as="button" class="bg-slate-300 flex-1">^</Link>
                            <button @click="confirmDelete(item.id)" class="bg-red-500 text-white flex-1">x</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
table tr * input {
    @apply w-full p-0 border-none text-center bg-slate-300;
}
tr, td, th, td *, th * {
    @apply h-full;
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