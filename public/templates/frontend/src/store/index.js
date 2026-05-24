import { createStore } from 'vuex'
import users from './modules/users';
import appointments from './modules/appointments';
import contacts from './modules/contacts';
import suggestions from './modules/suggestions';
import departments from './modules/departments';
import files from './modules/files';
import partners from './modules/partners';
import gallery from './modules/gallery';
import staff from './modules/staff';
import services from './modules/services';
import slides from './modules/slides';
import subscribers from './modules/subscribers';
import updates from './modules/updates';
import webInfo from './modules/web-info';

export default createStore({
  state: {
    apiBaseUrl: '',
    apiUploadUrl: '',
    webInfo: {},
    authmodal: false,
    suggestionbox: false,
  },
  getters: {
    get_access_token(state){
      if(localStorage.getItem('user_token')){
        let user = localStorage.getItem('user_token');
        return user;
      }
      return 'No token';
    }
  },
  mutations: {
    setApiBaseUrl(state, payload) {
      state.apiBaseUrl = payload
    },
    setApiUploadUrl(state, payload) {
      state.apiUploadUrl = payload
    }
  },
  actions: {
    initializeApiBaseUrl({ commit }) {
      if (process.env.NODE_ENV === 'development') {
        commit('setApiBaseUrl', 'http://127.0.0.1:8000/api/');
        commit('setApiUploadUrl', 'http://127.0.0.1:8000/files/images/');
      } else if (process.env.NODE_ENV === 'production') {
        commit('setApiBaseUrl', 'https://dmcapi.iremetech.com/api/');
        commit('setApiUploadUrl', 'https://dmcapi.iremetech.com/files/images/');
      }
    }
  },
  modules: {
    users,
    appointments,
    contacts,
    departments,
    files,
    partners,
    gallery,
    staff,
    services,
    slides,
    subscribers,
    updates,
    webInfo,
    suggestions
  }
})
