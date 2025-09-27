<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" v-model="client.name">
                <div v-if="errors.name" class="text-red-600 text-sm">{{ errors.name[0] }}</div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" v-model="client.email">
                <div v-if="errors.email" class="text-red-600 text-sm">{{ errors.email[0] }}</div>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" class="form-control" v-model="client.phone">
                <div v-if="errors.phone" class="text-red-600 text-sm">{{ errors.phone[0] }}</div>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" class="form-control" v-model="client.address">
                <div v-if="errors.address" class="text-red-600 text-sm">{{ errors.address[0] }}</div>
            </div>

            <div class="flex">
                <div class="form-group flex-1">
                    <label for="city">City</label>
                    <input type="text" id="city" class="form-control" v-model="client.city">
                    <div v-if="errors.city" class="text-red-600 text-sm">{{ errors.city[0] }}</div>
                </div>
                <div class="form-group flex-1">
                    <label for="postcode">Postcode</label>
                    <input type="text" id="postcode" class="form-control" v-model="client.postcode">
                    <div v-if="errors.postcode" class="text-red-600 text-sm">{{ errors.postcode[0] }}</div>
                </div>
            </div>

            <div class="text-right">
                <a href="/clients" class="btn btn-default">Cancel</a>
                <button @click="storeClient" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientForm',

    data() {
        return {
            client: {
                name: '',
                email: '',
                phone: '',
                address: '',
                city: '',
                postcode: '',
            },
            errors: {}
        }
    },

    methods: {
        async storeClient() {
            this.errors = {};
            try {
                const response = await axios.post('/clients', this.client);
                window.location.href = response.data.url;
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
            }
        }
    }
}
</script>
