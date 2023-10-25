<template>
    <v-container fluid="fluid">
        <v-card variant="elevated">
            <div class="row justify-content-center mt-12">
                <div class="card-titulo-page mt-2">
                    <img class="icono-page" src="../../../public/icons/alta_expediente.png" alt="">
                    <p>Alta de Expediente</p>
                </div>
            </div>
            <div class="container mt-16">
                <div class="row justify-content-between mt-8">
                    <div class="col-md-4 col-12">
                    <v-text-field
                        v-model="dato.expediente"
                        label="Expediente"
                        placeholder="Expediente"
                        variant="solo-filled"
                        disabled
                    ></v-text-field>
                    </div>
                    <div class="col-md-4 col-12">
                        <v-text-field
                        v-model="dato.ayo"
                        label="Año"
                        placeholder="Año"
                        variant="solo-filled"
                        disabled
                        ></v-text-field>
                    </div>
                    <div class="col-md-4 col-12">
                        <v-text-field
                            v-model="dato.fecha"
                            label="Fecha"
                            placeholder="Fecha"
                            variant="solo-filled"
                            type="date"
                            disabled
                        ></v-text-field>
                    </div>
                </div>
                <div class="row justify-content-between mt-8">
                    <div class="col-md-6 col-12">
                    <v-text-field
                        v-model="dato.actor"
                        label="Actor"
                        placeholder="Actor"
                        variant="solo-filled"
                        clearable
                        ></v-text-field>
                    </div>
                    <div class="col-md-6 col-12">
                        <v-text-field
                        v-model="dato.demandado"
                        label="Demandado"
                        placeholder="Demandado"
                        variant="solo-filled"
                        clearable
                        ></v-text-field>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-12">
                    <v-autocomplete
                        variant="outlined"
                        label="Juicio para asignar"
                        :items="juicios"
                        item-title="nombre"
                        item-value="id"
                        v-model="dato.juicio_id"
                    ></v-autocomplete>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-12">
                        <v-file-input
                        v-model="dato.archivo"
                        show-size
                        label="Archivo"
                        variant="outlined"
                        accept="application/pdf">
                        </v-file-input>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between  mb-4 mt-7">
                <div class="col-md-3"></div>
                <div class="col-md-2 mt-6 mb-4">
                    <v-btn
                    class="custom-button mr-2"
                    color="#c4f45d"
                    @click="guardarNuevoRegistro()"
                    >
                    Guardar
                    </v-btn>
                </div>
                <div class="col-md-2"></div>
            </div>
        </v-card>
    </v-container>
</template>
<script>
    import { defineComponent } from "vue";
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals";

    export default defineComponent({
        name: 'RegistroExpediente',
        data () {
            return {      
                dato: {
                    expediente: '',
                    ayo: '',
                    fecha: '',
                    actor:'',
                    demandado:'',
                    archivo:'',
                    juicio_id: null,
                    // ponencia_id:null
                },
            }
        },
        created() {
        this.getDatos()
        this.getJuicios()        
        },
        computed: {
            juicios() {
                    return this.$store.getters.getJuicios
            }
        },
        watch: {
        },
        methods: {          
            async getDatos(){
                this.loading = true
                try {
                    let response = await axios.get('/api/datos')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.dato.expediente = response.data.expediente
                            this.dato.ayo = response.data.ayo
                            this.dato.fecha = response.data.fecha
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener los datos iniciales')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener los datos iniciales')
                }
                this.loading = false
            },
            async guardarNuevoRegistro() {
                console.log(this.dato)

                Swal.fire({
                    title: '¿Guardar nuevo registro?',
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
                                let response = await axios.post('/api/registro-expediente', this.dato,{
                                    headers: {
                                        'Content-Type': 'multipart/form-data',
                                    }
                            })
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar el registro.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (result.value.status === 200) {
                            if (result.value.data.status === "ok") {
                                successSweetAlert(result.value.data.message)
                                this.loading = false
                                this.LimpiarFormulario()
                                this.getDatos()
                            }else {
                                errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error al guardar el registro.')
                        }
                    }
                })
            },
            LimpiarFormulario(){
                this.dato.id = ''
                this.dato.juicio_id = ''
                this.dato.expediente= ''
                this.dato.ayo = ''
                this.dato.fecha = ''
                this.dato.actor = ''
                this.dato.demandado = ''
                this.dato.archivo = ''
            },
            async getJuicios() {
                try {
                    let response = await axios.get('/api/juicios')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setJuicios', response.data.juicios)
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener los juicios')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener los juicios')
                }
            },
        }
    })
</script>