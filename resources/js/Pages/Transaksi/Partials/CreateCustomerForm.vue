<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
</script>

<template>
    <form @submit.prevent="postNewCustomer(newCustomer)">
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
                <PrimaryButton>Buat Customer Baru</PrimaryButton>
            </div>
        </div>
    </form>
</template>