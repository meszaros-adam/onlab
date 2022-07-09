import Vue from 'vue'
import vuex from 'vuex'

Vue.use(vuex)

export default new vuex.Store({
    state: {
        user: false,
        deleteModalObj: {
            showDeleteModal: false,
            deleteUrl: '',
            data: null,
            deletingIndex: -1,
            isDeleted: false,
            msg: '',
            successMsg: '',
        },
        tagFilter: null,
        searchEvent: null,
    },
    getters: {
        getUser(state) {
            return state.user
        },
        getDeleteModalObj(state) {
            return state.deleteModalObj
        },
        getTagFilter(state){
            return state.tagFilter
        },
        getSearchEvent(state){
            return state.searchEvent
        },
    },
    mutations: {
        setUser(state, data) {
            state.user = data
        },
        registrating(state, registration) {
            state.user.registrations.push(registration)
        },
        setDeleteModalObj(state, data){
            state.deleteModalObj = data
        },
        setTagFilter(state, data){
            state.tagFilter = data
        },
        setSearchEvent(state, data){
            state.searchEvent = data
        }
    },
})