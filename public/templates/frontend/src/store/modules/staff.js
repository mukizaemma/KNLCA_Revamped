import axios from 'axios';
import { ADD_TO_STAFF, DELETE_STAFF, GET_ALL_STAFF, UPDATE_STAFF } from '../actions/staff';
import { ADD_TO_STAFF_URL, DELETE_STAFF_URL, GET_ALL_STAFF_URL, UPDATE_STAFF_URL } from '../variables';

const staff = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        [GET_ALL_STAFF]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_STAFF_URL,
            })
        },
        [ADD_TO_STAFF]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + ADD_TO_STAFF_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [UPDATE_STAFF]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_STAFF_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [DELETE_STAFF]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'DELETE',
                url: rootState.apiBaseUrl + DELETE_STAFF_URL + payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
    }
}

export default staff;