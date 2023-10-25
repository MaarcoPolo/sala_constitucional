<template>
    <div class="wrapper" v-if="user">
        <div class="main-head">
            <div class="custom-page-header">
                <div class="separador">
                    <h1 class="title-head"><span>Sala Constitucional</span></h1>
                </div>
                <div class="logo">
                    <picture>
                        <img class="custom-image-header" loading="lazy" src="../../../public/img/logo_poder_judicial_gris.svg" alt="Logo Poder Judicial del Estado de Puebla">
                    </picture>
                </div>
                <div class="separador-mobile">
                    <h1 class="title-head"><span>Pagina Principal</span><br></h1>
                </div>
            </div>
            <div class="custom-navbar">
                <ul class="custom-ul-navbar m-0">
                    <li :class="currentRoute == 'Home' ? 'custom-navbar-option-selected' : 'custom-navbar-option-unselected'" @click="irInicio()">Inicio</li>
                    <li :class="currentRoute == 'RegistroExpediente' ? 'custom-navbar-option-selected' : 'custom-navbar-option-unselected'" @mouseover="mouseOverRegistro()" @mouseleave="mouseLeaveRegistro()">
                        Registro
                        <div class="custom-dropdown-menu dropdown-menu-catalogos" v-if="bandRegistro" >
                            <a class="custom-dropdown-item" :class="currentRoute == 'RegistroExpediente' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irRegistroExpediente()">Registro de expediente</a>
                        </div>
                    </li>
                    <li :class="currentRoute == 'Consulta' ? 'custom-navbar-option-selected' : 'custom-navbar-option-unselected'" @mouseover="mouseOverConsulta()" @mouseleave="mouseLeaveConsulta()">
                        Consultar
                        <div class="custom-dropdown-menu dropdown-menu-catalogos" v-if="bandConsulta" >
                            <a class="custom-dropdown-item" :class="currentRoute == 'ConsultaExp' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irConsultaExp()">Consulta de expediente</a>
                        </div>
                    </li>
                    <li :class="currentRoute == 'Usuarios' || currentRoute == 'Ponencias' || currentRoute == 'TipoUsuarios' || currentRoute == 'Juicios' ? 'custom-navbar-option-selected' : 'custom-navbar-option-unselected'" @mouseover="mouseOverCatalogos()" @mouseleave="mouseLeaveCatalogos()">
                        Catálogos
                        <div class="custom-dropdown-menu dropdown-menu-catalogos" v-if="bandCatalogos" >
                            <a class="custom-dropdown-item" :class="currentRoute == 'Usuarios' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irUsuarios()">Usuarios</a>
                            <a class="custom-dropdown-item" :class="currentRoute == 'TipoUsuarios' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irTipoUsuarios()">Tipo Usuarios</a>
                            <a class="custom-dropdown-item" :class="currentRoute == 'Ponencias' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irPonencias()">Ponencias</a>
                            <a class="custom-dropdown-item" :class="currentRoute == 'Juicios' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irJuicios()">Juicios</a>
                        </div>
                    </li>
                    <li @click="logout()">Cerrar Sesión</li>
                </ul>           
            </div>
        </div>
        <div class="content">
            <router-view></router-view>
        </div>
        <footer class="footer">
            <div class="footer-first-line"></div>
            <div class="footer-content">
                <p>&#169; 2023 Poder Judicial del Estado de Puebla</p>
            </div>
        </footer>
    </div>
    <div v-else>
        <router-view></router-view>
    </div>
</template>

<script>
    import { defineComponent } from "vue";

    export default defineComponent({
        name: 'app',
        data() {
            return {
                bandCatalogos: false,
                bandAcceso: false,
                bandRegistro: false,
                bandConsulta:false,
            }
        },
        created() {
            const userInfo = localStorage.getItem('user')
            if (userInfo) {
                const userData = JSON.parse(userInfo)
                this.$store.commit('setUserData', userData)
            }
            axios.interceptors.response.use(
                response => response,
                error => {
                    if (error.response.status === 401) {
                        this.$store.dispatch('logout')
                    }
                    return Promise.reject(error)
                }
            )
        },
        computed: {
            user() {
                return this.$store.getters.user
            },
            currentRoute() {
                return this.$route.name
            }
        },
        methods: {
            logout() {
                this.$store.dispatch('logout')
            },
            irInicio() {
                this.$router.push('/')
            },
            irUsuarios() {
                this.$router.push('/usuarios')
            },
            irPonencias() {
                this.$router.push('/ponencias')
            },
            irTipoUsuarios() {
                this.$router.push('/tipo-usuario')
            },
            irJuicios() {
                this.$router.push('/juicios')
            },
            irRegistroExpediente(){
                this.$router.push('/registro-expediente')
            },
            irConsultaExp(){
                this.$router.push('/consulta-expediente')
            },
            mouseOverCatalogos() {
                this.bandCatalogos = true
            },
            mouseLeaveCatalogos() {
                this.bandCatalogos = false
            },
            mouseOverAcceso() {
                this.bandAcceso = true
            },
            mouseLeaveAcceso() {
                this.bandAcceso = false
            },
            mouseOverRegistro() {
                this.bandRegistro = true
            },
            mouseLeaveRegistro() {
                this.bandRegistro = false
            },
            mouseOverConsulta() {
                this.bandConsulta = true
            },
            mouseLeaveConsulta() {
                this.bandConsulta = false
            },
        }
    })
</script>