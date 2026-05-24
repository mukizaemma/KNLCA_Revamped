import axios from "axios";
import { CREATE_UPDATE, DELETE_UPDATE, GET_ALL_UPDATES, UPDATE_UPDATE } from "../actions/updates";
import { CREATE_UPDATE_URL, DELETE_UPDATE_URL, GET_ALL_UPDATES_URL, GET_AN_UPDATE_URL, UPDATE_UPDATE_URL } from "../variables";
import { GET_AN_UPDATE } from "../actions/partners";

const updates = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        // UPDATES
        [GET_ALL_UPDATES]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_UPDATES_URL
            })
        },
        [GET_AN_UPDATE]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_AN_UPDATE_URL + payload
            })
        },
        [CREATE_UPDATE]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CREATE_UPDATE_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [UPDATE_UPDATE]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_UPDATE_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [DELETE_UPDATE]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'DELETE',
                url: rootState.apiBaseUrl + DELETE_UPDATE_URL + payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
    }
}

export default updates;