import './bootstrap';
import { createApp } from 'vue';
import RegisterFormComponent from './components/RegisterFormComponent.vue';

const app = createApp({});

// Registra o componente globalmente
app.component('register-form-component', RegisterFormComponent);

app.mount('#app');