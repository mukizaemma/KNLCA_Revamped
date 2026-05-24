import axios from 'axios';
import { CREATE_SUGGESTION, GET_ALL_SUGGESTIONS } from '../actions/suggestions';
import { CREATE_SUGGESTION_URL, GET_ALL_SUGGESTIONS_URL } from '../variables';

const suggestions = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        [GET_ALL_SUGGESTIONS]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_SUGGESTIONS_URL,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [CREATE_SUGGESTION]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CREATE_SUGGESTION_URL,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                },
                data: payload
            })
        }
    }
}

export default suggestions;