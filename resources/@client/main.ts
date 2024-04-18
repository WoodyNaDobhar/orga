import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import "./assets/css/app.css";
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs';

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(LaravelPermissionToVueJS);

app.mount("#app");
