import { defineStore } from 'pinia';
export const useAuthStore = defineStore('auth', {
  state: () => ({
    tokenPartie: null,
    tokenUser: null,
    idPartie: null
  }),
  getters: {
    isAuthenticated: (state) => !!state.tokenUser,
    isPartieActive: (state) => !!(state.tokenPartie && state.idPartie)
  },
  actions: {
    setTokenPartie(partieToken) {
      this.tokenPartie = partieToken;
    },
    setTokenUser(userToken) {
      this.tokenUser = userToken;
    },
    setIdPartie(idPartie) {
      this.idPartie = idPartie;
    },
    logout() {
      this.tokenPartie = null;
      this.tokenUser = null;
      this.idPartie = null;
    },
    quitPartie() {
      this.tokenPartie = null;
      this.idPartie = null;
    },
    updateAuth(data) {
      if (data.tokenUser !== undefined) {
        this.tokenUser = data.tokenUser;
      }
      if (data.tokenPartie !== undefined) {
        this.tokenPartie = data.tokenPartie;
      }
      if (data.idPartie !== undefined) {
        this.idPartie = data.idPartie;
      }
    }
  },
  persist: true,
});
