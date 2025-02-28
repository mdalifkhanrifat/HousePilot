<template>
    <div>
        <h2>Register</h2>
        <form @submit.prevent="register">
            <input v-model="name" type="text" placeholder="Name" required />
            <input v-model="email" type="email" placeholder="Email" required />
            <input v-model="password" type="password" placeholder="Password" required />
            <button type="submit">Register</button>
        </form>
        <p v-if="message">{{ message }}</p>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const name = ref('');
const email = ref('');
const password = ref('');
const message = ref('');

const register = async () => {
    try {
        await axios.post('/api/register', { name: name.value, email: email.value, password: password.value });
        message.value = 'Registration successful! You can now login.';
    } catch (error) {
        message.value = 'Error: ' + error.response.data.message;
    }
};
</script>