<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    kode: '',
    nama: '',
    harga: '',
})

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Barang Baru</h2>
        </template>
        <div class="flex justify-center p-10">
            <form @submit.prevent="form.post(route('barang.store'))" class="w-[30rem] space-y-5">
                <div>
                    <InputLabel value="Kode Barang" />
                    <TextInput id="kode" v-model="form.kode" class="mt-1 block w-3/4" placeholder="BR101" />
                </div>
                <div>
                    <InputLabel value="Nama" />
                    <TextInput id="nama" v-model="form.nama" class="mt-1 block w-3/4" placeholder="Something" />
                </div>
                <div>
                    <InputLabel value="Harga" />
                    <TextInput id="harga" v-model="form.harga" class="mt-1 block w-3/4" placeholder="Rp. 000000" />
                </div>
                <div class="space-x-10">
                    <PrimaryButton type="submit">Simpan</PrimaryButton>
                    <Link :href="route('barang.index')"><SecondaryButton type="button">Kembali</SecondaryButton></Link>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>