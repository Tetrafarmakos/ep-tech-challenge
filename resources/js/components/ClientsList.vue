<template>
    <div>
        <h1>
            Clients
            <a href="/clients/create" class="float-right btn btn-primary">+ New Client</a>
        </h1>

        <div v-if="notice" class="alert alert-success" role="status" aria-live="polite">{{ notice }}</div>
        <div v-if="error" class="alert alert-danger" role="alert">{{ error }}</div>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Number of Bookings</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in list" :key="client.id">
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.bookings_count }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" :href="`/clients/${client.id}`">View</a>
                        <button class="btn btn-danger btn-sm" @click="deleteClient(client)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientsList',

    props: ['clients'],

    data: function () {
        return {
            list: [],
            notice: null,
            error: null
        };
    },

    created() {
        this.list = [...this.clients];
    },

    watch: {
        clients: {
            immediate: true,
            handler(next) {
                this.list = [...next];
            }
        }
    },

    methods: {
        async deleteClient(client) {
            this.error = null;

            if (!window.confirm(`Delete ${client.name}?`)) return;

            try {
                await axios.delete(`/clients/${client.id}`);
                this.list = this.list.filter(c => c.id !== client.id);
                this.notice = `Deleted ${client.name}`;
                setTimeout(() => (this.notice = null), 3000);
            } catch (e) {
                this.error = 'Failed to delete client. Please try again.';
            }
        }
    }
}
</script>
