<template>
    <div class="container" >
        <div  v-if="user.user.cede_id == 6 || user.user.cede_id == 7" class="row justify-content-center align-items-center contenedor-imagen">
            <div class="row justify-content-center">
                <div class="col-md-6 col-12">
                    <a @click="irCECOFAM()">
                        <span class="titulo_centro">CENTRO DE CONVIVENCIA</span><br>
                        <span class="titulo_centro" style="letter-spacing: .25rem;">FAMILIAR  SUPERVISADA</span><br>
                        <span class="subtitulo">&nbsp;CONSEJO DE LA JUDICATURA</span><br>
                        <span class="subtitulo2">PODER JUDICIAL DEL ESTADO DE PUEBLA</span>
                    </a>                            
                </div>
                <div class="col-md-6 col-12">
                    <a @click="irCentroJ()">
                        <span class="titulo_centro ml-6" >CENTRO DE JUSTICIA</span><br>
                        <span class="titulo_centro ml-15" style="letter-spacing: .25rem;">ALTERNATIVA</span><br>
                        <span class="subtitulo">&nbsp;CONSEJO DE LA JUDICATURA</span><br>
                        <span class="subtitulo2">PODER JUDICIAL DEL ESTADO DE PUEBLA</span>
                    </a>                             
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-12">
                    <a @click="irEscuelaEstatal()">
                        <span class="titulo_centro ml-7">ESCUELA ESTATAL DE</span><br>
                        <span class="titulo_centro ml-4" style="letter-spacing: .25rem;">FORMACIÓN JUDICIAL</span><br>
                        <span class="subtitulo">&nbsp;CONSEJO DE LA JUDICATURA</span><br>
                        <span class="subtitulo2">PODER JUDICIAL DEL ESTADO DE PUEBLA</span>
                    </a>
                </div>
                <div class="col-md-6 col-12">
                    <a @click="irDirVinculacion()">
                        <span class="titulo_direccion ml-2">DIRECCIÓN DE VINCULACIÓN</span><br>
                        <span class="titulo_direccion ml-5" style="letter-spacing: .25rem;">Y ATENCION CIUDADANA</span><br>
                        <span class="subtitulo">&nbsp;CONSEJO DE LA JUDICATURA</span><br>
                        <span class="subtitulo2">PODER JUDICIAL DEL ESTADO DE PUEBLA</span>
                    </a>                       
                </div>
            </div>
        </div>
        <div v-if="user.user.cede_id == 1" class="row justify-content-center">
            <div  class="col-4 row justify-content-center align-items-center contenedor-imagen">
                <a @click="irCECOFAM()">
                    <span class="titulo_centro">CENTRO DE CONVIVENCIA</span><br>
                    <span class="titulo_centro" style="letter-spacing: .25rem;">FAMILIAR  SUPERVISADA</span><br>
                    <span class="subtitulo">&nbsp;CONSEJO DE LA JUDICATURA</span><br>
                    <span class="subtitulo2">PODER JUDICIAL DEL ESTADO DE PUEBLA</span>
                </a> 
            </div>
        </div>
        <div v-if="user.user.cede_id == 2" class="row justify-content-center">
            <div  class="col-4 row justify-content-center align-items-center contenedor-imagen">
                <a @click="irCentroJ()">
                    <span class="titulo_centro ml-6" >CENTRO DE JUSTICIA</span><br>
                    <span class="titulo_centro ml-15" style="letter-spacing: .25rem;">ALTERNATIVA</span><br>
                    <span class="subtitulo">&nbsp;CONSEJO DE LA JUDICATURA</span><br>
                    <span class="subtitulo2">PODER JUDICIAL DEL ESTADO DE PUEBLA</span>
                </a> 
            </div>
        </div>
        <div v-if="user.user.cede_id == 3" class="row justify-content-center">
            <div  class="col-4 row justify-content-center align-items-center contenedor-imagen">
                <a @click="irEscuelaEstatal()">
                    <span class="titulo_centro ml-7">ESCUELA ESTATAL DE</span><br>
                    <span class="titulo_centro ml-4" style="letter-spacing: .25rem;">FORMACIÓN JUDICIAL</span><br>
                    <span class="subtitulo">&nbsp;CONSEJO DE LA JUDICATURA</span><br>
                    <span class="subtitulo2">PODER JUDICIAL DEL ESTADO DE PUEBLA</span>
                </a> 
            </div>
        </div>
        <div v-if="user.user.cede_id == 4" class="row justify-content-center">
            <div  class="col-4 row justify-content-center align-items-center contenedor-imagen">
                <a @click="irDirVinculacion()">
                    <span class="titulo_direccion ml-2">DIRECCIÓN DE VINCULACIÓN</span><br>
                    <span class="titulo_direccion ml-5" style="letter-spacing: .25rem;">Y ATENCION CIUDADANA</span><br>
                    <span class="subtitulo">&nbsp;CONSEJO DE LA JUDICATURA</span><br>
                    <span class="subtitulo2">PODER JUDICIAL DEL ESTADO DE PUEBLA</span>
                </a>                    
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from "vue";    
    import router from '../router';

    export default defineComponent({
        name: 'home',
        data () {
            return {
            
            }
        },
    
        created() {
            const userInfo = localStorage.getItem('user')
            if (userInfo) {
                const userData = JSON.parse(userInfo)
                this.$store.commit('setUserData', userData)
                if(this.user.user.cede_id === 1){
                    router.push({name: 'Consulta'}) 
                }
               
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
            }
        },
        watch: {
        },
        methods: {
            logout() {
                this.$store.dispatch('logout')
            },
            async getAgenda() {
                try {
                    let response = await axios.get('/api/agenda')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.calendarOptions.events = response.data.eventos
                            this.eventos_dia_aux = response.data.eventos
                            this.$store.commit('setEventosMostrar', response.data.eventos_dia)
                            this.eventos_dia_mostrar = response.data.eventos
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener los eventos del calendario.')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener los eventos del calendario.')
                }
            },
            irCECOFAM() {
                this.$router.push('/consulta')
            },
            irCentroJ() {
                this.$router.push('/consultaCJA')
            },
            irEscuelaEstatal() {
                this.$router.push('/ConsultaEscuelaEstatal')
            },
            irDirVinculacion() {
                this.$router.push('/ConsultaDireccionVinculacion')
            },
            // irDefensoriaPublica(){
            //     this.$router.push('/ConsultaDefensoriaPublica')
            // },            
           
        }
    })
</script>