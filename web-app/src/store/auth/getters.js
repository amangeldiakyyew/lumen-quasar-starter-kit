import storageHelper from "src/helpers/storageHelper";

export function hasToken(){
  return storageHelper.hasToken();
}

export function getToken(){
  return storageHelper.getToken();
}
