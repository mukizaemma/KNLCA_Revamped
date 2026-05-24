import axios from "axios";
import { CREATE_SERVICE, DELETE_SERVICE, GET_ALL_SERVICES, UPDATE_SERVICE } from "../actions/services";
import { CREATE_SERVICE_URL, DELETE_SERVICE_URL, GET_ALL_SERVICES_URL, UPDATE_SERVICE_URL } from "../variables";

const services = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        // SERVICES
        [GET_ALL_SERVICES]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_SERVICES_URL
            })
        },
        [CREATE_SERVICE]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CREATE_SERVICE_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [UPDATE_SERVICE]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_SERVICE_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [DELETE_SERVICE]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'DELETE',
                url: rootState.apiBaseUrl + DELETE_SERVICE_URL + payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
    }
}

export default services;