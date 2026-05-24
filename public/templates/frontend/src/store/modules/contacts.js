import axios from "axios";
import { CREATE_CONTACT, DELETE_CONTACT, GET_ALL_CONTACTS, REPLY_CONATCT, REPLY_CONTACT } from "../actions/contacts";
import { CREATE_CONTACT_URL, DELETE_CONTACT_URL, GET_ALL_CONTACTS_URL, REPLY_CONATCT_URL, REPLY_CONTACT_URL } from "../variables";

const contacts = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        // CONTACTS
        [GET_ALL_CONTACTS]: ({ rootGetters, rootState }) => {
            return axios({
                method: 'GET',
                url: rootState.apiBaseUrl + GET_ALL_CONTACTS_URL,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [CREATE_CONTACT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + CREATE_CONTACT_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [DELETE_CONTACT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'DELETE',
                url: rootState.apiBaseUrl + DELETE_CONTACT_URL + payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        },
        [REPLY_CONTACT]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + REPLY_CONTACT_URL,
                data: payload,
                headers: {
                    Authorization: `Bearer ${ rootGetters.get_access_token }`
                }
            })
        }
    }
}

export default contacts;