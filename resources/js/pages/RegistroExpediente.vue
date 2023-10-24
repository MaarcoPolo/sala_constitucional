<template>
    <v-container fluid="fluid">
        <v-card variant="elevated">
            <v-card-title class="text-h3 text-center mt-10">Alta de Expediente</v-card-title>
            <v-row justify="center" class="mt-5">
                <v-col cols="10" sm="5" md="5">
                    <v-autocomplete
                        variant="outlined"
                        label="Juicio para asignar"
                        :items="['Acción de Tutela', 'Acciones de Inconstitucionalidad', 'Controversias Competenciales', 'Acción por Omisión Legislativa', 'Consulta interpretación de la Ley Orgánica del Poder Judicial del Estado de Puebla', 'Recurso de Revocación','Recurso de Revisión']"
                    ></v-autocomplete>
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="12" sm="4" md="2">
                    <v-text-field
                        v-model="dato.expediente"
                        label="Expediente"
                        placeholder="Expediente"
                        variant="outlined"
                        clearable
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="2">
                    <v-text-field
                        v-model="dato.ayo"
                        label="Año"
                        placeholder="Año"
                        variant="outlined"
                        clearable
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="2">
                    <v-text-field
                        v-model="dato.fecha"
                        label="Fecha"
                        placeholder="Fecha"
                        variant="outlined"
                        clearable
                        type="date"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        v-model="dato.actor"
                        label="Actor"
                        placeholder="Actor"
                        variant="outlined"
                        clearable
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        v-model="dato.demandado"
                        label="Demandado"
                        placeholder="Demandado"
                        variant="outlined"
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
                    variant="outlined"
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
                    archivo:''
                },
            }
        },
        created() {
        this.getDatos()
        
        },
        computed: {
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
                                let response = await axios.post('/api/EscuelaEstatal-registro/guardar', this.registro,)
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
                
            },
        }
    })
</script>