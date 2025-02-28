<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <input v-model="email" type="email" placeholder="Email" required />
            <input v-model="password" type="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>
        <p v-if="message">{{ message }}</p>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const email = ref('');
const password = ref('');
const message = ref('');

const login = async () => {
    try {
        let response = await axios.post('/api/login', { email: email.value, password: password.value });
        localStorage.setItem('token', response.data.token);
        message.value = 'Login successful!';
    } catch (error) {
        message.value = 'Invalid credentials';
    }
};
</script>
