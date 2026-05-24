import axios from "axios";
import { CREATE_PARTNER, DELETE_PARTNER, GET_ALL_PARTNERS, UPDATE_PARTNER } from "../actions/partners";
import { CREATE_PARTNER_URL, DELETE_PARTNER_URL, GET_ALL_PARTNERS_URL, UPDATE_PARTNER_URL } from "../variables";

const partners = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        // PARTNERS
        [GET_ALL_PARTNERS]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_PARTNERS_URL
            })
        },
        [CREATE_PARTNER]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CREATE_PARTNER_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [UPDATE_PARTNER]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_PARTNER_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [DELETE_PARTNER]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'DELETE',
                url: rootState.apiBaseUrl + DELETE_PARTNER_URL + payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
    }
};

export default partners;