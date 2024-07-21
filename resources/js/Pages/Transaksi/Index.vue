<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TransaksiTable from './Partials/TransaksiTable.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link, router, Head } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
    semuaTransaksi: Array,
    grandTotal: Object,
})

const title = "Daftar Transaksi"

const search = ref({
    nama: ''
})

</script>

<template>
    <Head :title />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}</h2>
        </template>

        <div class="w-full px-3 md:px-10 py-5 md:flex justify-between space-y-4">
            <Link :href="route('transaksi.create')" as="button">
            <PrimaryButton>Transaksi Baru</PrimaryButton>
            </Link>
            <form @submit.prevent="router.get(route('transaksi.index'), search)" class="flex items-stretch">
                <TextInput v-model="search.nama" placeholder="Nama Pembeli" />
                <SecondaryButton type="submit">Cari</SecondaryButton>
            </form>
        </div>

        <TransaksiTable :semuaTransaksi :grandTotal />
    </AuthenticatedLayout>
</template>
