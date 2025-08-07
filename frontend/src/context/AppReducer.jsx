export default (state, action) => {
  switch (action.type) {
    case "CATEGORY_TRANSACTIONS":
      return {
        ...state,
        data: Array.isArray(action.payload) ? action.payload : [],
      };
    case "TRANSACTIONS_ERROR":
      return {
        ...state,
        error: action.payload,
      };
    default:
      return state;
  }
};
