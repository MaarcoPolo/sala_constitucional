<template>
    <div class="container-fluid">
        <div class="row justify-content-center mt-12">
            <div class="card-titulo-page mt-2">
                <img class="icono-page" src="../../../../public/icons/ventanilla.png" alt="">
                <p>Tipo de usuarios</p>
            </div>
        </div>
        <div class="container mt-16">
            <!-- INICIO BOTON NUEVO Y BUSCADOR -->
            <div class="row justify-content-between mt-8">
                <div class="col-md-3 col-12">
                    <v-btn
                        class="custom-button"
                        block
                        color="#c4f45d"
                        @click="abrirModalNuevotipoUsuario()"
                        >
                        Nuevo tipo de usuario
                    </v-btn>
                </div>
                <div class="col-md-5 col-12"></div>
                <div class="col-md-4 col-12">
                    <div class="principal-div-custom-select">
                        <div class="first-div-custom-select">
                            <img src="../../../../public/icons/buscar.png" alt="">
                        </div>
                        <div class="second-div-custom-select">
                            <input v-model="buscar" placeholder="Buscar..." type="search" autocomplete="off" class="form-control custom-input">
                        </div>
                    </div>
                </div>
            </div>
            <!--INICIO DE LA TABLA TIPO DE USUARIOS-->
            <div class="my-2 mb-12 py-6">
                <div class="">
                    <div class="row justify-content-between">
                        <table class="table custom-border-table">
                            <thead class="headers-table">
                                <tr>
                                    <th class="custom-title-table">No.</th>
                                    <th class="custom-title-table">Nombre</th>
                                    <th class="custom-title-table">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="loading">
                                    <th colspan="5">
                                        <p class="text-center text-loading-data-table">Cargando datos...</p>
                                        <div class="linear-activity">
                                            <div class="indeterminate"></div>
                                        </div>
                                    </th>
                                </tr>
                                <tr v-else v-for="tipoUsuario in datosPaginados" :key="tipoUsuario.id">
                                    <td class="custom-data-table">
                                        {{tipoUsuario.numero_registro}}
                                    </td>
                                    <td class="custom-data-table text-uppercase">
                                        {{tipoUsuario.nombre}}
                                    </td>
                                    <td>
                                        <div class="text-center row justify-content-center">
                                            <div>
                                                <v-icon
                                                    @click="abrirModalEditartipoUsuario(tipoUsuario)"
                                                    class="mr-1"
                                                    >
                                                    mdi-text-box-edit-outline
                                                </v-icon>

                                                <v-tooltip
                                                    activator="parent"
                                                    location="bottom"
                                                    >
                                                    <span style="font-size: 15px;">Editar tipo de usuario</span>
                                                </v-tooltip>
                                            </div>
                                            <div>
                                                <v-icon
                                                    @click="eliminartipoUsuario(tipoUsuario)"
                                                    class="ml-1"
                                                    >
                                                    mdi-trash-can
                                                </v-icon>

                                                <v-tooltip
                                                    activator="parent"
                                                    location="bottom"
                                                    >
                                                    <span style="font-size: 15px;">Eliminar tipo de usuario</span>
                                                </v-tooltip>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <template v-if="tipoUsuarios && tipoUsuarios.length > 0">
                            <div class="row justify-content-between container">
                                <div>
                                    <p class="custom-text-show-results mt-2">
                                        Mostrando
                                        <span>{{from}}</span>
                                        -
                                        <span>{{to}}</span>
                                        de
                                        <span>{{tipoUsuarios.length}}</span>
                                        resultados
                                    </p>
                                </div>
                                <div>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination pagination-lg justify-content-center">
                                            <li class="page-item cursor-paginator" @click="getFirstPage()">
                                                <a class="page-link" aria-label="Previous">
                                                    <span aria-hidden="true">&lt;&lt;</span>
                                                    <span class="sr-only">First</span>
                                                </a>
                                            </li>
                                            <li class="page-item cursor-paginator" @click="getPreviousPage()">
                                                <a class="page-link" aria-label="Previous">
                                                    <span aria-hidden="true">&lt;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <li v-for="pagina in pages" @click="getDataPagina(pagina), setCurrentPage(pagina)" :key="pagina" class="page-item cursor-paginator" :class="isActive(pagina)">
                                                <a class="page-link">
                                                    {{pagina}}
                                                </a>
                                            </li>
                                            <li class="page-item cursor-paginator" @click="getNextPage()">
                                                <a class="page-link" aria-label="Next">
                                                    <span aria-hidden="true">&gt;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                            <li class="page-item cursor-paginator" @click="getLastPage()">
                                                <a class="page-link" aria-label="Next">
                                                    <span aria-hidden="true">&gt;&gt;</span>
                                                    <span class="sr-only">Last</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </template>
                        <template v-else-if="!loading">
                            <div class="text-center">
                                <p class="no-data-text">No hay tipo de usuarios disponibles</p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <v-dialog v-model="dialogNuevotipoUsuario" max-width="100rem" persistent>
                <v-card>
                    <v-card-title class="text-center">
                        <h3 class="mt-5 custom-dialog-title">Nuevo tipo de usuario</h3>
                    </v-card-title>
                    <v-card-text>
                        <div class="text-center my-3 custom-border">
                            <div class="custom-subtitle">
                                <p>Datos</p>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_nombre">Nombre:</label>
                                    <input id="input_nombre" type="text" class="form-control" v-model="v$.tipoUsuario.nombre.$model">
                                    <p class="text-validation-red" v-if="v$.tipoUsuario.nombre.$error">*Campo obligatorio</p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-md-2"></div>
                            <div class="col-md-2 mt-6 mb-4">
                                <v-btn
                                class="custom-button mr-2"
                                color="#c4f45d"
                                @click="guardarNuevotipoUsuario()"
                                >
                                Guardar
                                </v-btn>
                            </div>
                            <div class="col-md-2 mt-6">
                                <v-btn
                                class="custom-button ml-2"
                                color="#6a73a0"
                                @click="cerrarModalNuevotipoUsuario()"
                                >
                                Cancelar
                            </v-btn>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <!-- INICIO MODAL PARA EDITAR DATOS DE LA TIPO DE USUARIOS -->
            <v-dialog v-model="dialogEditartipoUsuario" max-width="100rem" persistent>
                <v-card>
                    <v-card-title class="text-center">
                        <h3 class="mt-2 custom-dialog-title">Editar tipo de usuario</h3>
                    </v-card-title>
                    <v-card-text>
                        <div class="text-center my-8 custom-border">
                            <div class="custom-subtitle">
                                <p>Datos</p>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_nombre">Nombre:</label>
                                    <input id="input_nombre" type="text" class="form-control" v-model="v$.tipoUsuario.nombre.$model">
                                    <p class="text-validation-red" v-if="v$.tipoUsuario.nombre.$error">*Campo obligatorio</p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between  mb-4 mt-6">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                            <v-btn
                                class="custom-button mr-2"
                                color="#c4f45d"
                                @click="guardarCambiosEditartipoUsuario()"
                                >
                                Guardar
                            </v-btn>
                            </div>
                            <div class="col-md-3">
                            <v-btn
                                class="custom-button ml-2"
                                color="#6a73a0"
                                @click="cerrarModalNuevotipoUsuario()"
                                >
                                Cancelar
                            </v-btn>
                        </div>
                        <div class="col-md-1"></div>
                        </div>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { errorSweetAlert, successSweetAlert, warningSweetAlert } from "../../helpers/sweetAlertGlobals"
    import useValidate from '@vuelidate/core'
    import { required } from '@vuelidate/validators'

    export default defineComponent({
        name: 'TipoUsuarios',
        data () {
            return { 
                showNav: false,
                dialogNuevotipoUsuario: false,
                dialogEditartipoUsuario: false,
                tipoUsuario: {
                    id: null,
                    nombre: ''
                },               
                loading: false,
                elementosPorPagina: 10,
                paginaActual: 1,
                datosPaginados: [],
                mostrar: false,
                from: '',
                to: '',
                numShown: 5,
                current: 1,
                buscar: '',
            }
        },
        setup() {
            return {
                v$: useValidate()
            }
        },
        validations() {
                return {
                    tipoUsuario: {
                        nombre: {
                            required
                        }
                    }
                }
        },
        created() {
            this.getTipoUsuarios()
        },
        computed: {
        pages() {
            const numShown = Math.min(this.numShown, this.totalPaginas())
            let first = this.current - Math.floor(numShown / 2)
            first = Math.max(first, 1)
            first = Math.min(first, this.totalPaginas() - numShown + 1)
            return [...Array(numShown)].map((k, i) => i + first)
            },
            tipoUsuarios() {
                    return this.$store.getters.getTipoUsuarios
            },
        },
        watch: {
            buscar: function () {
                if (!this.buscar.length == 0) {
                    this.datosPaginados = this.tipoUsuarios.filter(item => {
                        return item.nombre.toLowerCase().includes(this.buscar.toLowerCase())
                    })
                } else {
                    this.getDataPagina(1)
                }
            },
            mostrar: function () {
                if (this.mostrar) {
                    this.getDataPagina(1)
                }
            }
        },
        methods: {
        logout() {
                this.$store.dispatch('logout')
            },
            totalPaginas() {
                return Math.ceil(this.tipoUsuarios.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.tipoUsuarios[index]) {
                        this.datosPaginados.push(this.tipoUsuarios[index])
                    }
                }
                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.tipoUsuarios.length
                }
            },
            getFirstPage() {
                this.paginaActual = 1
                this.setCurrentPage(this.paginaActual)
                this.getDataPagina(this.paginaActual)
            },
            getPreviousPage() {
                if (this.paginaActual > 1) {
                    this.paginaActual--
                }
                this.setCurrentPage(this.paginaActual)
                this.getDataPagina(this.paginaActual)
            },
            getNextPage() {
                if (this.paginaActual < this.totalPaginas()) {
                    this.paginaActual++
                }
                this.setCurrentPage(this.paginaActual)
                this.getDataPagina(this.paginaActual)
            },
            getLastPage() {
                this.paginaActual = this.totalPaginas()
                this.setCurrentPage(this.paginaActual)
                this.getDataPagina(this.paginaActual)
            },
            isActive (noPagina) {
                return noPagina == this.paginaActual ? 'active' : ''
            },
            setCurrentPage(pagina) {
                this.current = pagina
            },
            abrirModalNuevotipoUsuario(){
                this.dialogNuevotipoUsuario = true
            },
            async getTipoUsuarios() {
                this.loading = true
                try {                   
                    let response = await axios.get('/api/tipoUsuarios', this.tipoUsuario)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setTipoUsuarios', response.data.tipoUsuarios)
                            this.mostrar = true
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener los tipos de usuarios')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener los tipos de usuarios')
                }
                this.loading = false
            },
            cerrarModalNuevotipoUsuario(){
                this.dialogNuevotipoUsuario = false
                this.dialogEditartipoUsuario = false
                this.tipoUsuario.nombre =''
            },
            abrirModalEditartipoUsuario(tipoUsuario){
                this.dialogEditartipoUsuario=true 
                this.tipoUsuario.id = tipoUsuario.id
                this.tipoUsuario.nombre = tipoUsuario.nombre
            },
            async guardarNuevotipoUsuario() {
                const isFormCorrect = await this.v$.tipoUsuario.$validate()              
                if (!isFormCorrect) return
                Swal.fire({
                    title: '¿Guardar nuevo tipo de usuario?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085D6',
                    cancelButtonColor: '#D33',
                    confirmButtonText: 'Si, guardar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        try {
                                this.loading = true
                                let response = await axios.post('/api/tipoUsuarios/nuevo-tipo-usuario', this.tipoUsuario)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar el tipo de usuario.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setTipoUsuarios', result.value.data.tipoUsuarios)
                                    this.loading = false
                                    this.cerrarModalNuevotipoUsuario()
                                    this.getDataPagina(1)
                                } else if(result.value.data.status==="exists"){
                                    warningSweetAlert(result.value.data.message)
                                    this.loading = false
                                }else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al guardar el tipo de usuario')
                            }
                        }
                    })
            },
            async guardarCambiosEditartipoUsuario() {
                const isFormCorrect = await this.v$.tipoUsuario.$validate()              
                if (!isFormCorrect) return
                    Swal.fire({
                        title: '¿Guardar cambios?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085D6',
                        cancelButtonColor: '#D33',
                        confirmButtonText: 'Si, guardar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: async () => {
                            try {

                                let response = await axios.post('/api/tipoUsuarios/actualizar-tipo-usuario', this.tipoUsuario)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al actualizar los datos del tipo de usuario')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setTipoUsuarios', result.value.data.tipoUsuarios)
                                    this.cerrarModalNuevotipoUsuario()
                                    this.getDataPagina(1)
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al actualizar los datos del tipo de usuario')
                            }
                        }
                    })
            },
            async eliminartipoUsuario(tipoUsuario) {
                Swal.fire({
                title: '¿Eliminar tipo de usuario?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085D6',
                cancelButtonColor: '#D33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        
                        let response = await axios.post('/api/tipoUsuarios/eliminar-tipo-usuario', tipoUsuario)
                        return response
                    } catch (error) {
                        errorSweetAlert('Ocurrió un error al eliminar este tipo de usuario.')
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    if (result.value.status === 200) {
                        if (result.value.data.status === "ok") {
                            successSweetAlert(result.value.data.message)
                            this.$store.commit('setTipoUsuarios', result.value.data.tipoUsuarios)
                            this.getDataPagina(1)
                        } else {
                            errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al eliminar este tipo de usuario.')
                    }
                }
            })
            },
        }
    })
</script>