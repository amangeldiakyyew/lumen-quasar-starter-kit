import storageHelper from "src/helpers/storageHelper";

export function login(state, res) {
  storageHelper.setToken(res.data.token);
  state.token = res.data.token;
  state.authenticated = true;
  state.user = res.data.user;
}


export function logout(state, res) {
  storageHelper.removeToken();
  state.token = '';
  state.user = {};
  state.authenticated = false;
}

export function check(state, res) {
  state.user = res.data.user;
  state.authenticated = true;
}

export function setAuth(state, auth) {
  state.authenticated = auth;
}

export function setUser(state, user) {
  state.user = user;
}
