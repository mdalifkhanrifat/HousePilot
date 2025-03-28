import axios from 'axios';

// Ensure Axios is available globally
window.axios = axios;

// Set default headers for AJAX requests
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Set base URL for API requests
window.axios.defaults.baseURL = 'http://localhost:8000/api';

// Enable credentials for cross-origin requests (for Laravel Sanctum)
window.axios.defaults.withCredentials = true;

// Set default headers for JSON requests
window.axios.defaults.headers.common['Accept'] = 'application/json';
