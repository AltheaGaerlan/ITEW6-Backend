import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

import LoginPage from './pages/LoginPage.vue';
import DashboardPage from './pages/DashboardPage.vue';
import StudentsPage from './pages/StudentsPage.vue';
import ViolationsPage from './pages/ViolationsPage.vue';
import EventsPage from './pages/EventsPage.vue';
import ReportsPage from './pages/ReportsPage.vue';
import SettingsPage from './pages/SettingsPage.vue';
import ProfilePage from './pages/ProfilePage.vue';
import UsersPage from './pages/UsersPage.vue';

import { getStoredUser, isAdminUser } from './utils/auth';
import globalState from './store/globalState';

const routes = [
    {
        path: '/',
        name: 'Login',
        component: LoginPage
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: DashboardPage,
        meta: { requiresAuth: true }
    },
    {
        path: '/students',
        name: 'Students',
        component: StudentsPage,
        meta: { requiresAuth: true }
    },
    {
        path: '/violations',
        name: 'Violations',
        component: ViolationsPage,
        meta: { requiresAuth: true }
    },
    {
        path: '/events',
        name: 'Events',
        component: EventsPage,
        meta: { requiresAuth: true }
    },
    {
        path: '/reports',
        name: 'Reports',
        component: ReportsPage,
        meta: { requiresAuth: true, requiresAdmin: true }
    },
    {
        path: '/users',
        name: 'Users',
        component: UsersPage,
        meta: { requiresAuth: true, requiresAdmin: true }
    },
    {
        path: '/settings',
        name: 'Settings',
        component: SettingsPage,
        meta: { requiresAuth: true }
    },
    {
        path: '/profile',
        name: 'Profile',
        component: ProfilePage,
        meta: { requiresAuth: true }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const user = globalState.state.user || getStoredUser();

    if (to.meta.requiresAuth && !user) {
        next('/');
        return;
    }

    if (to.path === '/' && user) {
        next('/dashboard');
        return;
    }

    if (to.meta.requiresAdmin && !isAdminUser(user)) {
        next('/dashboard');
        return;
    }

    next();
});

const app = createApp({
    template: '<router-view />'
});

app.use(router);
app.mount('#app');