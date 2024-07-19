<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TransaksiTable from './Partials/TransaksiTable.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link, router } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
    semuaTransaksi: Array,
    grandTotal: Object,
})

const formQuery = ref({
    q: ''
})

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Transaksi</h2>
        </template>

        <div class="w-full flex px-10 py-5 justify-between">
            <Link :href="route('transaksi.create')" as="button">
            <PrimaryButton>Transaksi Baru</PrimaryButton>
            </Link>
            <form @submit.prevent="router.get(route('transaksi.index'), formQuery)" class="flex items-stretch">
                <TextInput v-model="formQuery.q" placeholder="Nama Pembeli" />
                <SecondaryButton type="submit">Cari</SecondaryButton>
            </form>
        </div>

        <TransaksiTable :semuaTransaksi :grandTotal />
    </AuthenticatedLayout>
</template>
