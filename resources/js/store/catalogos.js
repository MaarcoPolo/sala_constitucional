export default {
    state: {
        usuarios: [],
        tipoUsuarios: [],
        ponencias:[],
        juicios:[],
        consultaExp:[]
    },
    getters: {
        getUsuarios(state) {
            return state.usuarios
        },
        getTipoUsuarios(state){
            return state.tipoUsuarios
        },
        getPonencias(state) {
            return state.ponencias
        },
        getJuicios(state) {
            return state.juicios
        },
        getConsultaExp(state) {
            return state.consultaExp
        }
    },
    mutations: {
        setUsuarios(state, payload) {
            state.usuarios = payload
        },
        setTipoUsuarios(state, payload){
            state.tipoUsuarios = payload
        },
        setPonencias(state, payload) {
            state.ponencias = payload
        },
        setJuicios(state, payload) {
            state.juicios = payload
        },
        setConsultaExp(state, payload) {
            state.consultaExp = payload
        }
    }
}