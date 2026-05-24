import axios from "axios";
import { CREATE_SLIDE, DELETE_SLIDE, GET_ALL_SLIDES, UPDATE_SLIDE } from "../actions/slides";
import { CREATE_SLIDE_URL, DELETE_SLIDE_URL, GET_ALL_SLIDES_URL, UPDATE_SLIDE_URL } from "../variables";

const slides = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        // SLIDES
        [GET_ALL_SLIDES]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_SLIDES_URL
            })
        },
        [CREATE_SLIDE]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CREATE_SLIDE_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [UPDATE_SLIDE]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + UPDATE_SLIDE_URL + payload.id,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [DELETE_SLIDE]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'DELETE',
                url: rootState.apiBaseUrl + DELETE_SLIDE_URL + payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
    }
}

export default slides;