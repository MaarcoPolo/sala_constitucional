<template>
    <div class="container-fluid">
        <div class="row justify-content-center mt-12">
            <div class="card-titulo-page mt-2">
                <img class="icono-page" src="../../../public/icons/estadistica.png" alt="">
                <p>Consulta de expedientes de Sala Constitucional</p>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center mt-8">
                <div class="col-md-4 col-12 principal-div-custom-select mt-4">
                    <div class="first-div-custom-select">
                        <img src="../../../public/icons/calendar.png" alt="">
                    </div>
                    <div class="second-div-custom-select">
                        <input v-model="consulta.fecha_inicio" placeholder="SELECCIONE LA FECHA INICIAL" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control minimal custom-input">                        
                    </div>
                </div>
                <div class="col-md-4 col-12 principal-div-custom-select mt-4">
                    <div class="first-div-custom-select">
                        <img src="../../../public/icons/calendar.png" alt="">
                    </div>
                    <div class="second-div-custom-select">   
                        <input v-model="consulta.fecha_fin" placeholder="SELECCIONE LA FECHA FINAL"  onfocus="(this.type='date')" onblur="(this.type='text')"  class="form-control minimal custom-input">                        
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-6">
                <div class="col-md-7 col-12"></div>
                <div class="row justify-content-center">
                        <div class="col-md-6 col-12">
                                <!-- <v-btn
                                    :loading="loading2"
                                    class="custom-button"
                                    block
                                    color="#c4f45d"
                                    @click="exportarReporteDVAC()" 
                                    >
                                    Exportar a Excel
                                </v-btn> -->
                        </div>
                        <div class="col-md-10 col-12 div-custom-button-filter-normal">
                            <v-btn
                                class="custom-button"
                                block
                                color="#c4f45d"
                                @click="obtenerInfo()"
                                >
                                Consultar
                            </v-btn>
                        </div>
                </div>
            </div>
        </div>
            <!-- INICIO BOTON NUEVO Y BUSCADOR -->
        </div>
            <div class="container mt-4">
                <div class="row justify-content-between mt-8">
                <div class="col-md-3 col-12"></div>
                <div class="col-md-5 col-12"></div>
                <div class="col-md-4 col-12">
                    <div class="principal-div-custom-select">
                        <div class="first-div-custom-select">
                            <img src="../../../public/icons/buscar.png" alt="">
                        </div>
                        <div class="second-div-custom-select">
                            <input v-model="buscar" placeholder="Buscar..." type="search" autocomplete="off" class="form-control custom-input">
                        </div>
                    </div>
                </div>
            </div>
                <div class="mt-6">
                    <div class="row justify-content-center">
                        <table class="table custom-border-table">
                            <thead class="headers-table">
                                <tr>
                                    <th class="custom-title-table text-uppercase">Exp.</th>
                                    <th class="custom-title-table text-uppercase">Año</th>
                                    <th class="custom-title-table text-uppercase">Fecha</th>
                                    <th class="custom-title-table text-uppercase">Actor</th>
                                    <th class="custom-title-table text-uppercase">Demandado</th>
                                    <th class="custom-title-table text-uppercase">Juicio</th>
                                    <th class="custom-title-table text-uppercase">Ponencia</th>
                                    <!-- <th class="custom-title-table text-uppercase">Acciones</th> -->
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
                                <tr v-else v-for="consultaExp in datosPaginados" :key="consultaExp.id">
                                    <td class="custom-data-table text-uppercase text-center">{{consultaExp.expediente}}</td> 
                                    <td class="custom-data-table text-uppercase text-center">{{consultaExp.ayo}}</td> 
                                    <td class="custom-data-table text-uppercase text-center">{{consultaExp.fecha}}</td> 
                                    <td class="custom-data-table text-uppercase text-center">{{consultaExp.actor}}</td> 
                                    <td class="custom-data-table text-uppercase text-center">{{consultaExp.demandado}}</td>                                    
                                    <td class="custom-data-table text-uppercase text-center">{{consultaExp.juicio}}</td> 
                                    <td class="custom-data-table text-uppercase text-center">{{consultaExp.ponencia}}</td> 
                                    <!-- <td class="custom-data-table">
                                        <div class="text-center row justify-content-center">
                                            <div>
                                                <v-icon
                                                    @click="abrirModalEditarRegistro(consultaExp)"
                                                    class="mr-1"
                                                    >
                                                    mdi-text-box-edit-outline
                                                </v-icon>

                                                <v-tooltip
                                                    activator="parent"
                                                    location="bottom"
                                                    >
                                                    <span style="font-size: 15px;">Editar Registro</span>
                                                </v-tooltip>
                                            </div>
                                        </div>
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <template v-if="consultaExp && consultaExp.length > 0">
                            <div class="row justify-content-between container">
                                <div>
                                    <p class="custom-text-show-results mt-2">
                                        Mostrando
                                        <span>{{from}}</span>
                                        -
                                        <span>{{to}}</span>
                                        de
                                        <span>{{consultaExp.length}}</span>
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
                                <p class="no-data-text">No hay registros disponibles</p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <!-------MODAL EDITAR REGISTO------>
        <!-- <v-dialog v-model="dialogEditarRegistro" max-width="100rem" persistent>
            <v-card>
                <v-card-title class="text-center mt-7">
                    <h3 class="mt-2 custom-dialog-title">Editar Registro</h3>
                </v-card-title>
                <v-card-text>
                    <div class="row justify-content-between">
                        <div class="col-md-4 col-12">
                            <div class="div-custom-input-form2">
                                <label><strong>Fecha:</strong></label>
                                <input type="date" class="form-control" v-model="registro.fecha">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="div-custom-input-form2">
                                <label><strong>Número de Expediente:</strong></label>
                                <input type="text" class="form-control" v-model="registro.num_expediente">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                                <label><strong>Materia:</strong></label>
                                <v-autocomplete 
                                v-model="registro.materia_id"
                                :items="materiasdirvinculacion"
                                item-title="nombre"
                                item-value="id"
                                variant="outlined"
                                density="compact"
                                background-color="#f6f6f6">
                                </v-autocomplete>
                        </div>
                    </div> 
                    <div class="row justify-content-between">
                        <div class="col-md-6 col-12">
                                <label><strong>Juzgado:</strong></label>
                                <v-autocomplete 
                                v-model="registro.juzgado_id"
                                :items="juzgadosdirvinculacion"
                                item-title="nombre"
                                item-value="id"
                                variant="outlined"
                                density="compact">
                                </v-autocomplete>
                        
                        </div>
                        <div class="col-md-6 col-12">
                                <label><strong>Tipo de Juicio:</strong></label>
                                <v-autocomplete  
                                v-model="registro.juicio_id"
                                :items="juiciosdirvinculacion"
                                item-title="nombre"
                                item-value="id"
                                variant="outlined"
                                density="compact">
                                </v-autocomplete>
                        </div>
                    </div> 
                    <div class="row justify-content-between">
                        <div class="col-md-4 col-12">
                            <label><strong>Región Judicial:</strong></label>
                            <v-autocomplete  
                                v-model="registro.region_id"
                                :items="regiones"
                                item-title="nombre"
                                item-value="id"
                                variant="outlined"
                                density="compact">
                            </v-autocomplete>
                        </div>
                        <div class="col-md-4 col-12">
                                <label><strong>Distrito Judicial:</strong></label>
                                <v-autocomplete 
                                    v-model="registro.distrito_id"
                                    :items="distrito"
                                    item-title="nombre"
                                    item-value="id"
                                    variant="outlined"
                                    density="compact">
                                </v-autocomplete>
                        </div>
                        <div class="col-md-4 col-12">
                                <label><strong>Municipio:</strong></label>
                                <v-autocomplete 
                                    v-model="registro.municipio_id"
                                    :items="municipio"
                                    item-title="nombre"
                                    item-value="id"
                                    variant="outlined"
                                    density="compact">
                                </v-autocomplete>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-md-4 col-12">
                            <div class="div-custom-input-form2">
                                <label><strong>Género:</strong></label>
                                <select class="form-control minimal custom-select2 text-uppercase" v-model="registro.genero">
                                    <option value="hombre">HOMBRE</option>
                                    <option value="mujer">MUJER</option>
                                </select>
                            </div>
                        </div>                
                        <div class="col-md-4 col-12">
                            <div class="div-custom-input-form2">
                                <label><strong>Tipo de inconformidad:</strong></label>
                                <select class="form-control minimal custom-select2 text-uppercase" v-model="registro.inconformidad_id">
                                    <option  v-for="item in inconformidades" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="div-custom-input-form2">
                                <label><strong>Tiempo de resolución:</strong></label>
                                <select class="form-control minimal custom-select2 text-uppercase" v-model="registro.resolucion_id">
                                    <option  v-for="item in resoluciones" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="row justify-content-between">
                        <div class="div-custom-input-form col-12">
                            <label>Descripción de la inconformidad:</label>
                            <textarea rows="4" cols="50" v-model="registro.descripcion_inconformidad"></textarea>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="div-custom-input-form col-12">
                            <label>Solución definitiva de la inconformidad:</label>
                            <textarea rows="4" cols="50" v-model="registro.solucion_definitiva_inconformidad"></textarea>
                        </div>
                    </div>
                    <div class="row justify-content-between pa-5">
                        <div class="col-md-1 col-10"></div>
                        <div class="col-md-3 col-8">
                            <v-btn
                                class="custom-button mr-2"
                                color="#c4f45d"
                                @click="guardarCambiosEditarRegistro()"
                                >
                                Guardar
                            </v-btn>
                        </div>
                        <div class="col-md-3 col-8">
                            
                            <v-btn
                                class="custom-button ml-2"
                                color="#6a73a0"
                                @click="cerrarModalEditarRegistro()"
                                >
                                Cancelar
                            </v-btn>
                        </div>
                        <div class="col-md-1 col-10"></div>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog> -->
        <!------FIN MODAL EDITAR REGISTRO--->    
</template>

<script>
    import { defineComponent } from 'vue';
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"
  
    export default defineComponent({
        name: 'ConsultaDireccionVinculacion',
        data () {
            return { 
                dialogEditarRegistro: false,
                consulta:{
                    fecha_inicio:'',
                    fecha_fin:''
                },
                showNav: false,  
                loading: false,
                loading2: false,
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
        
        created() {

        },
        computed: {
            pages() {
                const numShown = Math.min(this.numShown, this.totalPaginas())
                let first = this.current - Math.floor(numShown / 2)
                first = Math.max(first, 1)
                first = Math.min(first, this.totalPaginas() - numShown + 1)
                return [...Array(numShown)].map((k, i) => i + first)
            },
            consultaExp(){
                    return this.$store.getters.getConsultaExp
            },
        },
        watch: {
            buscar: function () {
                if (!this.buscar.length == 0) {
                    this.datosPaginados = this.consultaExp.filter(item => {
                        return item.expediente.toLowerCase().includes(this.buscar.toLowerCase())  
                        || item.ayo.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.fecha.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.nombre_materia.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.nombre_juzgado.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.genero.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.num_expediente.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.nombre_juicio.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.nombre_inconformidad.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.nombre_resolucion.toLowerCase().includes(this.buscar.toLowerCase())
                    })
                } else {
                    this.getDataPagina(1)
                }
            },
            mostrar: function () {
                if (this.mostrar) {
                    this.getDataPagina(1)
                }
            },
        },
        methods: {
        logout() {
                this.$store.dispatch('logout')
            },
            totalPaginas() {
                return Math.ceil(this.consultaExp.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.consultaExp[index]) {
                        this.datosPaginados.push(this.consultaExp[index])
                    }
                }
                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.consultaExp.length
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
            async obtenerInfo() {              
                try {
                                            
                    let response = await axios.post('/api/expedientes-consulta', this.consulta)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setConsultaExp', response.data.consultaExp)
                            this.getDataPagina(1)
                            this.mostrar = true 
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    }  
                } catch (error) {
                }
            },
        }
    })
</script>