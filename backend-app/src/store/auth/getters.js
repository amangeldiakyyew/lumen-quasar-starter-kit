import storageHelper from "src/helpers/storageHelper";

export function hasToken(){
  return storageHelper.hasToken();
}

export function isLoggedIn(state){
  return state.isLoggedIn;
}

export function getAuthenticatedAdmin(state){
  return state.admin;
}

export function getToken(){
  return storageHelper.getToken();
}
