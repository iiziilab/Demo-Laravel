import {createStore} from 'vuex'
import axios from "axios";
import { reactive, inject, ref, onMounted } from "vue";
export default createStore({
    state:{
        userSubjects:[]
    },
    mutations:{
        setUserSubjects(state,payload){
            state.userSubjects = payload
        }
    },
    actions:{
        updateUserSubjects(context,payload){
            context.commit('setUserSubjects',payload)
        }
    },
    getters:{
        subjects(){
            return state.userSubjects
        }
    }
})