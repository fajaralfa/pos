<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Head } from '@inertiajs/vue3'

const props = defineProps({
    barang: Object,
})

const title = "Edit Barang"

const form = useForm(props.barang)

</script>

<template>
    <Head :title />
    
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}</h2>
        </template>
        <div class="flex justify-center p-10">
            <form @submit.prevent="form.put(route('barang.update', barang.id))" class="w-[30rem] space-y-5">
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
                    <TextInput id="harga" v-model="form.harga" type="number" class="mt-1 block w-3/4"
                        placeholder="Rp. 000000" />
                </div>
                <div>
                    <PrimaryButton type="submit">Simpan Perubahan</PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>