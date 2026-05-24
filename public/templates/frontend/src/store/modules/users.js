import axios from "axios";
import { CHANGE_PASSWORD, CREATE_ADMIN, CREATE_DOCTOR, CREATE_PATIENT, DELETE_USER, GET_ALL_ADMINS, GET_ALL_DOCTORS, GET_A_DOCTOR, UPDATE_ADMIN, UPDATE_DOCTOR, UPDATE_PATIENT, USER_LOGIN, USER_LOGOUT } from "../actions/users";
import { CHANGE_PASSWORD_URL, CREATE_ADMIN_URL, CREATE_DOCTOR_URL, CREATE_PATIENT_URL, DELETE_USER_URL, GET_ALL_ADMINS_URL, GET_ALL_DOCTORS_URL, GET_A_DOCTOR_URL, UPDATE_ADMIN_URL, UPDATE_DOCTOR_URL, UPDATE_PATIENT_URL, USER_LOGIN_URL, USER_LOGOUT_URL } from "../variables";

const users = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        // ALL USERS
        [USER_LOGIN]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + USER_LOGIN_URL,
                data: payload
            })
        },
        [USER_LOGOUT]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + USER_LOGOUT_URL,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [DELETE_USER]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'DELETE',
                url: rootState.apiBaseUrl + DELETE_USER_URL + payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [CHANGE_PASSWORD]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CHANGE_PASSWORD_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        // ADMINS
        [GET_ALL_ADMINS]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_ADMINS_URL,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [CREATE_ADMIN]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CREATE_ADMIN_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [UPDATE_ADMIN]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_ADMIN_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        // PATIENTS
        [CREATE_PATIENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CREATE_PATIENT_URL,
                data: payload
            })
        },
        [UPDATE_PATIENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_PATIENT_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        // DOCTORS
        [GET_ALL_DOCTORS]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_DOCTORS_URL
            })
        },
        [GET_A_DOCTOR]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_A_DOCTOR_URL + payload
            })
        },
        [CREATE_DOCTOR]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CREATE_DOCTOR_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [UPDATE_DOCTOR]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_DOCTOR_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        }
    }
}

export default users;