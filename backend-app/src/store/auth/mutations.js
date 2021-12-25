import storageHelper from "src/helpers/storageHelper";

export function login(state, data) {
  storageHelper.setToken(data.token);
  state.TOKEN = data.token;
  state.isLoggedIn = true;
  state.user = data.user;
}

export function logout(state) {
  storageHelper.removeToken();
  state.TOKEN = '';
  state.isLoggedIn = false;
}

export function check(state, data) {
  state.user = data.user;
  state.isLoggedIn = true;
}


