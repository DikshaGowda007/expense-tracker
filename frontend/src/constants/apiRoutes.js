const BASE_URL = import.meta.env.VITE_API_URL;
console.log(BASE_URL);
export const API = {
  AUTH: {
    LOGIN: `${BASE_URL}/api/auth/login`,
    SIGNUP: `${BASE_URL}/api/auth/signup`,
    VERIFY_OTP: `${BASE_URL}/api/auth/verifyOtp`,
    LOGOUT: `${BASE_URL}/api/auth/logout`,
  },
  CATEGORY: {
    ADD: `${BASE_URL}/api/category/add`,
  },
  TRANSACTION: {
    ADD: `${BASE_URL}/api/transaction/add`,
    GET_CATEGORY_SUMMARY: `${BASE_URL}/api/transaction/category-summary`,
  },
  CSRF: `/sanctum/csrf-cookie`,
};