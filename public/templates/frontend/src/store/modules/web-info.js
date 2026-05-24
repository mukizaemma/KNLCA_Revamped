import axios from "axios";
import { GET_ALL_DASHBOARD_INFO_URL, GET_ALL_ROLES_URL, GET_ALL_WEB_INFO_URL } from "../variables";
import { GET_ALL_DASHBOARD_INFO, GET_ALL_ROLES, GET_ALL_WEB_INFO, UPDATE_WEB_INFO } from "../actions/web-info";

const webInfo = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        // WEB INFO
        [GET_ALL_WEB_INFO]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_WEB_INFO_URL,
            })
        },
        [UPDATE_WEB_INFO]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'PUT',
                url: rootState.apiBaseUrl + GET_ALL_WEB_INFO_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        // GENERAL
        [GET_ALL_ROLES]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_ROLES_URL,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [GET_ALL_DASHBOARD_INFO]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_DASHBOARD_INFO_URL,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        }
    }
};

export default webInfo;