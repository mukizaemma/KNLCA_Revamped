import axios from "axios";
import { CREATE_SUBSCRIBER, GET_ALL_SUBSCRIBERS } from "../actions/subscribers";
import { CREATE_SUBSCRIBER_URL, GET_ALL_SUBSCRIBERS_URL } from "../variables";

const subscribers = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        // SUBSCRIBERS
        [GET_ALL_SUBSCRIBERS]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_SUBSCRIBERS_URL,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [CREATE_SUBSCRIBER]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CREATE_SUBSCRIBER_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
    }
}

export default subscribers;