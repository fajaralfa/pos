<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { router } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectCustomerPopup from './Partials/SelectCustomerPopup.vue';
import SelectBarangPopup from './Partials/SelectBarangPopup.vue';
import ChangeBarangPopup from './Partials/ChangeBarangPopup.vue';
import SelectedBarangTable from './Partials/SelectedBarangTable.vue';
import { ref } from 'vue';
import InputError from '@/Components/InputError.vue';
import { useTransaksiStore } from '@/Stores/Transaksi';

const props = defineProps({
    semuaCustomer: Array,
    semuaBarang: Array,
    errors: Object,
})

const selectCustomerPopup = ref(false)
const selectBarangPopup = ref(false)
const changeBarangPopup = ref(false)
const ubahBarangIndex = ref(null)

const transaksi = useTransaksiStore()

function submit() {
    router.post(route('transaksi.store'), transaksi.requestPayload)
}

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transaksi Baru</h2>
        </template>
        <div id="form" class="px-16 py-5 space-y-10">
            <div class="w-96 space-y-5">
                <div>
                    <div class="flex justify-between items-center">
                        <InputLabel value="Tanggal" />
                        <TextInput type="date" v-model="transaksi.tgl" />
                    </div>
                    <InputError :message="errors.tgl" />
                </div>
                <div class="w-full space-y-3">
                    <div class="font-bold">Customer</div>
                    <SecondaryButton @click="selectCustomerPopup = true">Pilih Customer</SecondaryButton>
                    <InputError :message="errors.customer_id" />
                    <SelectCustomerPopup v-model="selectCustomerPopup" :semuaCustomer="semuaCustomer"
                        @customerSelected="c => { transaksi.customer = c; selectCustomerPopup = false }" />
                    <div v-if="transaksi.customerIsSelected"class="w-full">
                        <div class="flex justify-between items-center">
                            <InputLabel value="Kode" />
                            <TextInput v-model="transaksi.customer.kode" disabled />
                        </div>
                        <div class="flex justify-between items-center">
                            <InputLabel value="Nama" />
                            <TextInput v-model="transaksi.customer.nama" disabled />
                        </div>
                        <div class="flex justify-between items-center">
                            <InputLabel value="Telp" />
                            <TextInput v-model="transaksi.customer.telp" disabled />
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full">
                <SelectBarangPopup
                    v-model="selectBarangPopup"
                    :semuaBarang="semuaBarang"
                    @barangSelected="barang => { transaksi.pushBarang(barang); selectBarangPopup = false }" />
                <ChangeBarangPopup
                    v-model="changeBarangPopup"
                    :semuaBarang="semuaBarang"
                    @barangSelected="barang => { transaksi.replaceBarang(ubahBarangIndex, barang); changeBarangPopup = false }" />

                <InputError :message="errors.barang" />
                <SelectedBarangTable
                    @tambahBarang="selectBarangPopup = true"
                    @ubahBarang="index => { changeBarangPopup = true; ubahBarangIndex = index }" />
            </div>
            <div class="flex justify-center gap-16 py-10">
                <PrimaryButton type="submit" @click="submit">Simpan</PrimaryButton>
                <SecondaryButton @click.prevent="router.get(route('transaksi.index'))">Batal</SecondaryButton>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
