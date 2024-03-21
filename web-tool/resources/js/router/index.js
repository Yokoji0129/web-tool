import { createRouter, createWebHistory } from "vue-router";
import LoginView from "../vue-views/LoginView.vue";
import NewAccountView from "../vue-views/NewAccountView.vue";
import AccountNameView from "../vue-views/AccountNameView.vue";
import DiarybooksListView from "../vue-views/DiarybooksListView.vue";
import DiaryView from "../vue-views/DiaryView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "login",
            component: LoginView,
        },
        {
            path: "/newAccount",
            name: "newAccount",
            component: NewAccountView,
        },
        {
            path: "/accountName",
            name: "accountName",
            component: AccountNameView,
        },
        {
            path: "/diaryBooksList",
            name: "diaryBooksList",
            component: DiarybooksListView,
        },
        {
            path: "/diary",
            name: "diary",
            component: DiaryView,
        },
    ],
});

export default router;