export const storageHelper = {
  keyName: '_user_token_',
  get(key) {
    return localStorage.getItem(key);
  },
  set(key, value) {
    return localStorage.setItem(key, value);
  },
  getToken() {
    return this.get(this.keyName);
  },
  setToken(token) {
    return this.set(this.keyName, token);
  },
  hasToken() {
    return !!this.get(this.keyName);
  },
  removeToken() {
    return localStorage.removeItem(this.keyName);
  }
};

export default storageHelper;
