<template>
    <div class="wrapper" v-if="user">
        <div class="main-head">
            <div class="custom-page-header">
                <div class="separador">
                    <h1 class="title-head"><span>Estadística Integral</span><br>Jurisdisccional</h1>
                </div>
                <div class="logo">
                    <picture>
                        <img class="custom-image-header" loading="lazy" src="../../../public/img/logo_poder_judicial_gris.svg" alt="Logo Poder Judicial del Estado de Puebla">
                    </picture>
                </div>
                <div class="separador-mobile">
                    <h1 class="title-head"><span>Estadistica</span><br></h1>
                </div>
            </div>
            <div class="custom-navbar">
                <ul class="custom-ul-navbar m-0">
                    <li  v-if="user.user.cede_id != 1" :class="currentRoute == 'Home' ? 'custom-navbar-option-selected' : 'custom-navbar-option-unselected'" @click="irInicio()">Inicio</li>
                    <li v-if="user.user.tipo_usuario_id == 1 || user.user.tipo_usuario_id == 2 && user.user.cede_id != 7" :class="currentRoute == 'Usuarios' || currentRoute == 'Regiones' || currentRoute == 'Municipios' || currentRoute == 'Estado' 
                        || currentRoute == 'Distrito' || currentRoute == 'Areas' || currentRoute == 'SolicitudAperturada' || currentRoute == 'CJATipoUsuario' || currentRoute == 'CJARangoEdad' 
                        || currentRoute == 'CJAEscolaridad' || currentRoute == 'CJAOcupacion' || currentRoute == 'CJAConvenio' || currentRoute == 'CJACanalizacion' || currentRoute == 'CJARecpExp'
                        || currentRoute == 'CJAPlataforma' || currentRoute == 'ModalidadEscuela' || currentRoute == 'PonenteEscuela' || currentRoute == 'DirigidosEscuela' || currentRoute == 'ActividadesEscuela'
                        || currentRoute == 'PosgradosEscuela' || currentRoute == 'TipoConvenioEscuela' || currentRoute == 'AreaEscuela' || currentRoute == 'MateriasDirVinculacion' || currentRoute == 'JuzgadosDirVinculacion'
                        || currentRoute == 'JuiciosDirVinculacion' || currentRoute == 'InconformidadDireccionVinculacion' || currentRoute == 'ResolucionesDireccionVinculacion' 
                        ? 'custom-navbar-option-selected' : 'custom-navbar-option-unselected'" @mouseover="mouseOverCatalogos()" @mouseleave="mouseLeaveCatalogos()">
                        Catálogos
                        <div class="custom-dropdown-menu dropdown-menu-catalogos" v-if="bandCatalogos" >
                            <a class="custom-dropdown-item" :class="currentRoute == 'Usuarios' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irUsuarios()">Usuarios</a>
                            <a v-if="user.user.cede_id == 4 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'Regiones' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irRegiones()">Regiones</a>
                            <a v-if="user.user.cede_id == 4 || user.user.cede_id == 6 || user.user.cede_id == 5" class="custom-dropdown-item" :class="currentRoute == 'Municipios' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irMunicipios()">Municipios</a>
                            <a v-if="user.user.cede_id == 5 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'Estado' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irEstados()">Estados</a>
                            <a v-if="user.user.cede_id == 1 || user.user.cede_id == 6 || user.user.cede_id == 4" class="custom-dropdown-item" :class="currentRoute == 'Distrito' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irDistrito()"> <span v-if="user.user.cede_id == 1" span>Sedes</span> <span v-if="user.user.cede_id != 1" span>Distritos</span></a>
                            <a v-if="user.user.cede_id == 1 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'Areas' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irAreas()">Áreas</a>
                            <a v-if="user.user.cede_id == 6 || user.user.cede_id == 2" class="custom-dropdown-item" :class="currentRoute == 'Materia' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irMaterias()">Materias</a>
                            <a v-if="user.user.cede_id == 1 " class="custom-dropdown-item" :class="currentRoute == 'Servicios-CECOFAM' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irServicioCecofam()">Servicios</a>
                            <!-- <a v-if="user.user.cede_id == 2 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'SolicitudAperturada' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irSolicitudAperturada()">Solicitud Aperturada</a> -->
                            <a v-if="user.user.cede_id == 2 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'CJATipoUsuario' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irCJATipoUsuario()">Tipo Usuario</a>
                            <a v-if="user.user.cede_id == 2 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'CJARangoEdad' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irCJARangoEdad()">Rango Edad</a>
                            <a v-if="user.user.cede_id == 2 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'CJAEscolaridad' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irCJAEscolaridad()">Escolaridad</a>
                            <a v-if="user.user.cede_id == 2 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'CJAOcupacion' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irCJAOcupacion()">Ocupación</a>
                            <a v-if="user.user.cede_id == 2 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'CJAConvenio' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irCJAConvenio()">Convenio</a>
                            <a v-if="user.user.cede_id == 2 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'CJACanalizacion' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irCJACanalizacion()">Canalización</a>
                            <a v-if="user.user.cede_id == 2 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'CJARecpExp' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irCJARecpExp()">Recepción de Expediente</a>
                            <a v-if="user.user.cede_id == 2 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'CJAPlataforma' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irCJAPlataforma()">Plataforma</a>
                            <a v-if="user.user.cede_id == 3 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'ModalidadEscuela' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irModalidadEscuela()">Modalidad Escuela</a>
                            <a v-if="user.user.cede_id == 3 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'PonenteEscuela' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irPonenteEscuela()">Ponente Escuela</a>
                            <a v-if="user.user.cede_id == 3 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'DirigidosEscuela' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irDirigidosEscuela()">Dirigido a Escuela</a>
                            <a v-if="user.user.cede_id == 3 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'ActividadesEscuela' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irActividadesEscuela()">Actividades Escuela</a>
                            <a v-if="user.user.cede_id == 3 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'PosgradosEscuela' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irPosgradosEscuela()">Posgrados Escuela</a>
                            <a v-if="user.user.cede_id == 3 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'TipoConvenioEscuela' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irTipoConvenioEscuela()">Tipo convenio Escuela</a>
                            <a v-if="user.user.cede_id == 3 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'AreaEscuela' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irAreaEscuela()">Áreas Escuela</a>
                            <a v-if="user.user.cede_id == 3 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'ActividadesCJEscuela' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irActividadesCJ()">Actividades CJ Escuela</a>
                            <a v-if="user.user.cede_id == 4 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'MateriasDirVinculacion' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irMateriasDirVinculacion()">Materias Vinculación</a>
                            <a v-if="user.user.cede_id == 4 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'JuzgadosDirVinculacion' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irJuzgadosDirVinculacion()">Juzgados Vinculación</a>
                            <a v-if="user.user.cede_id == 4 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'JuiciosDirVinculacion' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irJuiciosDirVinculacion()">Juicios Vinculación</a>
                            <a v-if="user.user.cede_id == 4 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'InconformidadDireccionVinculacion' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irInconformidadDireccionVinculacion()">Inconformidad Vinculación</a>
                            <a v-if="user.user.cede_id == 4 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'ResolucionesDireccionVinculacion' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irResolucionesDireccionVinculacion()">Resoluciones Vinculación</a>
                            <!-- <a v-if="user.user.cede_id == 5 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'OficinasDefensoriaPublica' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irOficinasDefensoriaPublica()">Oficinas DF</a>
                            <a v-if="user.user.cede_id == 5 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'AsuntosDefensoriaPublica' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irAsuntosDefensoriaPublica()">Asuntos DF</a>
                            <a v-if="user.user.cede_id == 5 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'ModosFinalizaDefensoriaPublica' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irModosFinalizaDefensoriaPublica()">Modos DF</a> -->
                        </div>
                    </li>
                    <li  v-if="user.user.cede_id != 7" :class="currentRoute == 'Cecofam' || currentRoute == 'CentroJusticiaAlternativa' || currentRoute == 'EscuelaEstatalFormacionJudicial' || currentRoute == 'DireccionVinculacionAtencionCiudadana' || currentRoute == 'DefensoriaPublica' ? 'custom-navbar-option-selected' : 'custom-navbar-option-unselected'" @mouseover="mouseOverRegistro()" @mouseleave="mouseLeaveRegistro()">
                        Registro                       
                        <div class="custom-dropdown-menu dropdown-menu-catalogos" v-if="bandRegistro">
                            <a v-if="user.user.cede_id == 1 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'CECOFAM' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irCECOFAM()">CECOFAM</a>
                            <a v-if="user.user.cede_id == 2 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'CentroJusticiaAlternativa' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irCentroJ()">Centro de Justicia Alternativa</a>
                            <a v-if="user.user.cede_id == 3 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'EscuelaEstatalFormacionJudicial' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irEscuelaEstatal()">Escuela Estatal de Formación Judicial </a>                                                    
                            <a v-if="user.user.cede_id == 4 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'DireccionVinculacionAtencionCiudadana' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irDirVinculacion()">Dirección de Vinculación y Atención Ciudadana </a> 
                            <!-- <a v-if="user.user.cede_id == 5 || user.user.cede_id == 6" class="custom-dropdown-item" :class="currentRoute == 'DefensoriaPublica' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irDefensoriaPublica()">Defensoría Pública </a>                                                                                                        -->
                        </div>
                    </li>
                    <li :class="currentRoute == 'Consulta' || currentRoute == 'ConsultaCJA' || currentRoute == 'ConsultaEscuelaEstatal' || currentRoute == 'ConsultaDireccionVinculacion' || currentRoute == 'ConsultaDefensoriaPublica' ? 'custom-navbar-option-selected' : 'custom-navbar-option-unselected'" @mouseover="mouseOverConsulta()" @mouseleave="mouseLeaveConsulta()">
                        Consultar
                        <div class="custom-dropdown-menu dropdown-menu-catalogos" v-if="bandConsulta">
                            <a v-if="user.user.cede_id == 1 || user.user.cede_id == 6 || user.user.cede_id == 7" class="custom-dropdown-item" :class="currentRoute == 'consulta' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'"  @click="irConsulta()">CECOFAM</a>
                            <a v-if="user.user.cede_id == 2 || user.user.cede_id == 6 || user.user.cede_id == 7" class="custom-dropdown-item" :class="currentRoute == 'consultaCJA' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irConsultaCJA()">Centro de Justicia Alternativa</a>
                            <a v-if="user.user.cede_id == 3 || user.user.cede_id == 6 || user.user.cede_id == 7" class="custom-dropdown-item" :class="currentRoute == 'ConsultaEscuelaEstatal' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irConsultaEscuelaEstatal()">Escuela Estatal de Formación Judicial</a>
                            <a v-if="user.user.cede_id == 4 || user.user.cede_id == 6 || user.user.cede_id == 7" class="custom-dropdown-item" :class="currentRoute == 'ConsultaDireccionVinculacion' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irconsultaDireccionVinculacion()">Dirección de Vinculación y Atención Ciudadana</a>
                            <!-- <a v-if="user.user.cede_id == 5 || user.user.cede_id == 6 || user.user.cede_id == 7" class="custom-dropdown-item" :class="currentRoute == 'ConsultaDefensoriaPublica' ? 'custom-dropdown-item-selected' : 'custom-dropdown-item-unselected'" @click="irConsultaDefensoriaPublica()">Defensoría Pública</a> -->
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
            irRegiones() {
                this.$router.push('/regiones')
            },
            irMunicipios() {
                this.$router.push('/municipios')
            },
            irJueces() {
                this.$router.push('/jueces')
            },
            irRelevancias() {
                this.$router.push('/relevancias')
            },
            irMaterias() {
                this.$router.push('/materia')
            },
            irTipoAudiencias(){
                this.$router.push('/tipo-audiencias')
            },
            irAreas(){
                this.$router.push('/areas')
            },
            irConsulta(){
                this.$router.push('/consulta')
            }, 
            irCECOFAM() {
                this.$router.push('/cecofam')
            },
            irCentroJ() {
                this.$router.push('/CentroJusticiaAlternativa')
            },
            irEscuelaEstatal() {
                this.$router.push('/EscuelaEstatalFormacionJudicial')
            },
            irDirVinculacion() {
                this.$router.push('/DireccionVinculacionAtencionCiudadana')
            },
            irDefensoriaPublica() {
                this.$router.push('/DefensoriaPublica')
            },
            irSolicitudAperturada(){
                this.$router.push('/SolicitudAperturada')
            },
            irCJATipoUsuario() {
                this.$router.push('/CJATipoUsuario')
            },
            irCJARangoEdad(){
                this.$router.push('/CJARangoEdad')
            },
            irCJAEscolaridad(){
                this.$router.push('/CJAEscolaridad')
            },
            irCJAOcupacion(){
                this.$router.push('/CJAOcupacion')
            },
            irCJAConvenio(){
                this.$router.push('/CJAConvenio')
            },
            irCJACanalizacion(){
                this.$router.push('/CJACanalizacion')
            },
            irCJARecpExp(){
                this.$router.push('/CJARecpExp')
            },
            irDistrito(){
                this.$router.push('/Distrito')
            },  
            irEstados(){
                this.$router.push('/Estado')
            },
            irCJAPlataforma(){
                this.$router.push('/CJAPlataforma')
            },
            irConsultaCJA(){
                this.$router.push('/consultaCJA')
            }, 
            irModalidadEscuela(){
                this.$router.push('/ModalidadEscuela')
            },
            irPonenteEscuela(){
                this.$router.push('/PonenteEscuela')
            },
            irDirigidosEscuela(){
                this.$router.push('/DirigidosEscuela')
            },
            irActividadesEscuela(){
                this.$router.push('/ActividadesEscuela')
            },
            irPosgradosEscuela(){
                this.$router.push('/PosgradosEscuela')
            },
            irTipoConvenioEscuela(){
                this.$router.push('/TipoConvenioEscuela')
            },
            irAreaEscuela(){
                this.$router.push('/AreaEscuela')
            },
            irMateriasDirVinculacion(){
                this.$router.push('/MateriasDirVinculacion')
            },
            irJuzgadosDirVinculacion(){
                this.$router.push('/JuzgadosDirVinculacion')
            },
            irJuiciosDirVinculacion(){
                this.$router.push('/JuiciosDirVinculacion')
            },
            irInconformidadDireccionVinculacion(){
                this.$router.push('/InconformidadDireccionVinculacion')
            },
            irResolucionesDireccionVinculacion(){
                this.$router.push('/ResolucionesDireccionVinculacion')
            },
            // irOficinasDefensoriaPublica(){
            //     this.$router.push('/OficinasDefensoriaPublica')
            // },
            // irAsuntosDefensoriaPublica(){
            //     this.$router.push('/AsuntosDefensoriaPublica')
            // },
            // irModosFinalizaDefensoriaPublica(){
            //     this.$router.push('/ModosFinalizaDefensoriaPublica')
            // },
            irConsultaEscuelaEstatal(){
                this.$router.push('/ConsultaEscuelaEstatal')
            },
            irconsultaDireccionVinculacion(){
                this.$router.push('/ConsultaDireccionVinculacion')
            },
            // irConsultaDefensoriaPublica(){
            //     this.$router.push('/ConsultaDefensoriaPublica')
            // },
            irActividadesCJ(){
                this.$router.push('/ActividadesCJEscuela')
            },
            irServicioCecofam(){
                this.$router.push('/ServiciosCECOFAM')
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