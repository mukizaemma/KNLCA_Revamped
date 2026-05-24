import axios from "axios";
import { CREATE_DEPARTMENT, DELETE_DEPARTMENT, GET_ALL_DEPARTMENTS, GET_A_DEPARTMENT, UPDATE_DEPARTMENT } from "../actions/departments";
import { CREATE_DEPARTMENT_URL, DELETE_DEPARTMENT_URL, GET_ALL_DEPARTMENTS_URL, GET_A_DEPARTMENT_URL, UPDATE_DEPARTMENT_URL } from "../variables";

const departments = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        // DEPARTMENTS
        [GET_ALL_DEPARTMENTS]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_DEPARTMENTS_URL
            })
        },
        [GET_A_DEPARTMENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_A_DEPARTMENT_URL + payload
            })
        },
        [CREATE_DEPARTMENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CREATE_DEPARTMENT_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [UPDATE_DEPARTMENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_DEPARTMENT_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [DELETE_DEPARTMENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'DELETE',
                url: rootState.apiBaseUrl + DELETE_DEPARTMENT_URL + payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
    }
}

export default departments;