import axios from "axios";
import { GET_GALLERY, ADD_TO_GALLERY, UPDATE_GALLERY, DELETE_GALLERY } from "../actions/gallery";
import { GET_GALLERY_URL, ADD_TO_GALLERY_URL, UPDATE_GALLERY_URL, DELETE_GALLERY_URL } from "../variables";

const gallery = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        [GET_GALLERY]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_GALLERY_URL
            })
        },
        [ADD_TO_GALLERY]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + ADD_TO_GALLERY_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [UPDATE_GALLERY]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_GALLERY_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [DELETE_GALLERY]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'DELETE',
                url: rootState.apiBaseUrl + DELETE_GALLERY_URL + payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
    }
}

export default gallery;