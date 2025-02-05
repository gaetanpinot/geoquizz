import axios from 'axios';

export default {
  install(Vue, { baseURL }) {
    Vue.config.globalProperties.$api = axios.create({
      baseURL,
      headers: {
        'Content-Type': 'application/json'
      },
    });
  },
};
