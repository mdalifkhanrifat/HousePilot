<template>
    <div class="login-container">
        <h2>Login</h2>
        <form @submit.prevent="handleLogin">
            <input v-model="email" type="email" placeholder="Email" required />
            <input v-model="password" type="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>
        <p v-if="errorMessage">{{ errorMessage }}</p>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
const authStore = useAuthStore();

const email = ref('');
const password = ref('');
const errorMessage = ref('');

const handleLogin = async () => {
    try {
        await authStore.login(email.value, password.value);
    } catch (error) {
        errorMessage.value = 'Invalid credentials';
    }
};
</script>

<style scoped>
.login-container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background: #f9f9f9;
}
</style>