import axios from "axios";
import { UPLOAD_FILE_URL } from "../variables";
import { UPLOAD_FILE } from "../actions/files";

const files = {
    state: {},
    getters: {},
    mutations: {},
    actions: {
        // FILES
        [UPLOAD_FILE]: ({ rootGetters, rootState }, payload) => {
            return axios({
                method: 'POST',
                url: rootState.apiBaseUrl + UPLOAD_FILE_URL,
                data: payload,
                headers: {
                    'Authorization': `Bearer ${ rootGetters.get_access_token }`,
                    'Content-Type': 'multipart/form-data'
                }
            })
        }
    }
};

export default files;