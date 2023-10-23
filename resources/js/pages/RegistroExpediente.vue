<template>
    <v-container fluid="fluid">
        <v-card variant="elevated">
            <v-card-title class="text-h3 text-center mt-10">Alta de Expediente</v-card-title>
        <v-row justify="center" class="mt-5">
            <v-col cols="4" sm="2" md="2">
            <v-checkbox
                label="Acción de Tutela"
                color="primary"
            ></v-checkbox>
            </v-col>
            <v-col
            cols="4" sm="2" md="2">
            <v-checkbox
                label="Acciones de Inconstitucionalidad"
                color="primary"
            ></v-checkbox>
            </v-col>
            <v-col cols="4" sm="2" md="2">
            <v-checkbox
                label="Controversias Competenciales"
                color="primary"
            ></v-checkbox>
            </v-col>
            <v-col cols="4" sm="2" md="2">
            <v-checkbox
                label="Acción por Omisión Legislativa"
                color="primary"
            ></v-checkbox>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="4" sm="2" md="2">
            <v-checkbox
                label="Consulta interpretación de la Ley Orgánica del Poder Judicial del Estado de Puebla"
                color="primary"
            ></v-checkbox>
            </v-col>
            <v-col cols="4" sm="2" md="2">
            <v-checkbox
                label="Recurso de Revocación"
                color="primary"
            ></v-checkbox>
            </v-col>
            <v-col cols="4" sm="2" md="2">
            <v-checkbox
                label="Recurso de Revisión"
                color="primary"
            ></v-checkbox>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12" sm="4" md="2">
                <v-text-field
                    label="Expediente"
                    placeholder="Expediente"
                    variant="outlined"
                    clearable
                ></v-text-field>
            </v-col>
            <v-col cols="12" sm="4" md="2">
                <v-text-field
                    label="Año"
                    placeholder="Año"
                    variant="outlined"
                    clearable
                ></v-text-field>
            </v-col>
            <v-col cols="12" sm="4" md="2">
                <v-text-field
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
                    label="Actor"
                    placeholder="Actor"
                    variant="outlined"
                    clearable
                ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-text-field
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