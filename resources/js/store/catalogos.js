export default {
    state: {
        usuarios: [],
        tipoUsuarios: [],
        ponencias:[]

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
        }
    }
}