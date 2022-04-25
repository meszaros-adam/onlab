import Vue from 'vue'
import vuex from 'vuex'

Vue.use(vuex)

export default new vuex.Store({
    state:{
        user: false,
    },
    getters: {
        getUser(state){
            return state.user
        }
    },
    mutations: {
        setUser(state, data){
            state.user = data
        }
    },
})