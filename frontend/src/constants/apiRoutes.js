const BASE_URL = "http://127.0.0.1:8000"
export const API = {
  AUTH: {
    LOGIN: `${BASE_URL}/api/auth/login`,
    SIGNUP: `${BASE_URL}/api/auth/signup`,
  },
  TRANSACTION: {
    ADD: `${BASE_URL}/api/transaction/add`,
    GET_CATEGORY_SUMMARY: `${BASE_URL}/api/transaction/category-summary`,
  },
};