<template>
    <v-container fluid="fluid">
        <v-card variant="outlined">
            <v-card-title class="text-h3 text-center mt-10">Alta de Expediente</v-card-title>
            <v-row justify="center" class="mt-5">
                <v-col cols="10" sm="5" md="5">
                    <v-autocomplete
                        variant="solo-filled"
                        label="Juicio para asignar"
                        :items="juicios"
                        item-title="nombre"
                        item-value="id"
                        v-model="dato.juicio_id"
                    ></v-autocomplete>
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="12" sm="4" md="2">
                    <v-text-field
                        v-model="dato.expediente"
                        label="Expediente"
                        placeholder="Expediente"
                        variant="solo-filled"
                        clearable
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="2">
                    <v-text-field
                        v-model="dato.ayo"
                        label="Año"
                        placeholder="Año"
                        variant="solo-filled"
                        clearable
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="2">
                    <v-text-field
                        v-model="dato.fecha"
                        label="Fecha"
                        placeholder="Fecha"
                        variant="solo-filled"
                        clearable
                        type="date"
                        disabled
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        v-model="dato.actor"
                        label="Actor"
                        placeholder="Actor"
                        variant="solo-filled"
                        clearable
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        v-model="dato.demandado"
                        label="Demandado"
                        placeholder="Demandado"
                        variant="solo-filled"
                        clearable
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="12" sm="6" md="4">
                    <v-file-input
                    v-model="dato.archivo"
                    show-size
                    label="Archivo"
                    variant="solo-filled"
                    accept="application/pdf">
                    </v-file-input>
                </v-col>
            </v-row>
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
                    juicio_id:''
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
                                let response = await axios.post('/api/registro-expediente', this.dato,)
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
                                this.getNumerosConsecutivos()
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