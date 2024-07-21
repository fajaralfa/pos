<script setup>
import Popup from '@/Components/Popup.vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { computed, ref, watch } from 'vue';
import axios from 'axios';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const showPopupModel = defineModel()

const props = defineProps({
    semuaCustomer: Array,
})

const emit = defineEmits(['customerSelected'])

const newCustomer = {
    kode: '',
    nama: '',
    telp: '',
}

const loading = ref(false)

const errors = ref({})

watch(errors, console.log)

async function postNewCustomer(customer) {
    loading.value = true
    try {
        const res = await axios.post(route('customer.store'), customer)
        showPopupModel.value = false
        emit('customerSelected', res.data)
    } catch (err) {
        errors.value = err.response.data.errors
    } finally {
        loading.value = false
    }
}

const queryNama = ref('')
const filteredCustomer = computed(() => {
    return props.semuaCustomer.filter((c) => {
        return c.nama.toLowerCase().includes(queryNama.value.toLowerCase())
    })
})

const showBuatCustomerBaru = ref(false)

</script>

<template>
    <Popup v-if="showPopupModel">
        <div class="relative bg-white p-2 md:p-10 space-y-5 h-full overflow-y-scroll">
            <button @click="showPopupModel = false"
                class="absolute top-0 right-0 px-2 py-1 bg-red-500 text-white font-bold">Close</button>

            <div>
                <SecondaryButton v-if="!showBuatCustomerBaru" @click="showBuatCustomerBaru = true">Buat Customer Baru
                </SecondaryButton>
            </div>
            <form @submit.prevent="postNewCustomer(newCustomer)" v-if="showBuatCustomerBaru">
                <div class="space-y-3">
                    <div>
                        <InputLabel value="Kode" />
                        <TextInput v-model="newCustomer.kode" name="kode" />
                        <InputError v-for="e in errors.kode" :message="e" />
                    </div>
                    <div>
                        <InputLabel value="Nama" :message="errors.nama" />
                        <TextInput v-model="newCustomer.nama" name="nama" />
                        <InputError v-for="e in errors.nama" :message="e" />
                    </div>
                    <div>
                        <InputLabel value="Telp" :message="errors.telp" />
                        <TextInput v-model="newCustomer.telp" name="telp" />
                        <InputError v-for="e in errors.telp" :message="e" />
                    </div>
                    <div>
                        <PrimaryButton class="space-x-3">
                            <svg v-if="loading" class="animate-spin h-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span class="transition-all">Buat Customer Baru</span>
                        </PrimaryButton>
                    </div>
                </div>
            </form>
            <TextInput v-model="queryNama" name="nama" placeholder="Cari Nama Customer" />
            <div class="overflow-x-auto text-sm md:text-base">
                <table>
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Telp</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in filteredCustomer" :key="customer.id">
                            <td>{{ customer.kode }}</td>
                            <td>{{ customer.nama }}</td>
                            <td>{{ customer.telp }}</td>
                            <td>
                                <PrimaryButton @click.prevent="() => $emit('customerSelected', customer)">Pilih
                                </PrimaryButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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