export default (state, action) => {
  switch (action.type) {
    case "CATEGORY_TRANSACTIONS":
      return {
        ...state,
        categories: Array.isArray(action.payload) ? action.payload : [],
      };
    case "GET_TOTAL_BALANCE":
      return {
        ...state,
        balance: action.payload,
      };
    case "TRANSACTIONS_ERROR":
      return {
        ...state,
        data: [],
        error: action.payload,
      };
    default:
      return state;
  }
};
