import axios from "axios";
import { APPROVE_DOCTOR_APPOINTMENT, CREATE_APPOINTMENT, DECLINE_DOCTOR_APPOINTMENT, GET_ALL_APPOINTMENTS, GET_ALL_DOCTORS_APPOINTMENTS, GET_ALL_PATIENTS_APPOINTMENTS, REPLY_TO_APPOINTMENT, UPDATE_APPOINTMENT, UPDATE_DOCTOR_APPOINTMENT, UPDATE_PATIENT_APPOINTMENT } from "../actions/appointments";
import { APPROVE_DOCTOR_APPOINTMENT_URL, CREATE_APPOINTMENT_URL, DECLINE_DOCTOR_APPOINTMENT_URL, GET_ALL_APPOINTMENTS_URL, GET_ALL_DOCTORS_APPOINTMENTS_URL, GET_ALL_PATIENTS_APPOINTMENTS_URL, REPLY_TO_APPOINTMENT_URL, UPDATE_APPOINTMENT_URL, UPDATE_DOCTOR_APPOINTMENT_URL, UPDATE_PATIENT_APPOINTMENT_URL } from "../variables";

const appointments = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        // RECEPTIONIST APPOINTMENTS
        [GET_ALL_PATIENTS_APPOINTMENTS]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_PATIENTS_APPOINTMENTS_URL,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [UPDATE_PATIENT_APPOINTMENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_PATIENT_APPOINTMENT_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        // PATIENTS APPOINTMENTS
        [GET_ALL_APPOINTMENTS]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_APPOINTMENTS_URL,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [CREATE_APPOINTMENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CREATE_APPOINTMENT_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [UPDATE_APPOINTMENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_APPOINTMENT_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        // DOCTORS APPOINTMENTS
        [GET_ALL_DOCTORS_APPOINTMENTS]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_DOCTORS_APPOINTMENTS_URL,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [UPDATE_DOCTOR_APPOINTMENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_DOCTOR_APPOINTMENT_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [APPROVE_DOCTOR_APPOINTMENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + APPROVE_DOCTOR_APPOINTMENT_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [DECLINE_DOCTOR_APPOINTMENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + DECLINE_DOCTOR_APPOINTMENT_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [REPLY_TO_APPOINTMENT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + REPLY_TO_APPOINTMENT_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        }
    }
}

export default appointments;