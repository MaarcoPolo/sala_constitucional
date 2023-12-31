import { createWebHistory, createRouter } from "vue-router";
import store from './store'
import Login from './pages/Login.vue'
import Home from './pages/Home.vue'
import Usuarios from './pages/catalogos/Usuarios.vue'
import TipoUsuarios from './pages/catalogos/TipoUsuarios.vue'
import Ponencias from './pages/catalogos/Ponencias.vue'
import Juicios from './pages/catalogos/Juicios.vue'
import RegistroExpediente from './pages/RegistroExpediente.vue'
import ConsultaExp from './pages/ConsultaExp.vue'


const routes = [
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/usuarios',
        name: 'Usuarios',
        component: Usuarios,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/tipo-usuario',
        name: 'TipoUsuarios',
        component: TipoUsuarios,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/ponencias',
        name: 'Ponencias',
        component: Ponencias,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/juicios',
        name: 'Juicios',
        component: Juicios,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/registro-expediente',
        name: 'RegistroExpediente',
        component: RegistroExpediente,
        meta: {
            requiresAuth: true
        }
    }, 
    {
        path: '/consulta-expediente',
        name: 'ConsultaExp',
        component: ConsultaExp,
        meta: {
            requiresAuth: true
        }
    },   
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
    const currentUser = store.state.user

    if (requiresAuth && !currentUser) {
        next('/login')
    } else if (to.path == '/login' && currentUser) {
        next('/')
    } else {
        next()
    }
})

export default router