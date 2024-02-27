import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../vue-views/HomeView.vue";
import AboutView from "../vue-views/AboutView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "home",
            component: HomeView,
        },
        {
            path: "/about",
            name: "about",
            component: AboutView,
        },
    ],
});

export default router;
