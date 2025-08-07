import { createContext, useReducer } from "react";
import axiosRequest from "../components/axiosRequest";
import { API } from "../constants/apiRoutes";
import AppReducer from "../context/AppReducer";
import { useContext } from "react";

export const TransactionContext = createContext();

const initialState = {
  data: [],
  error: null,
};

export const TransactionProvider = ({ children }) => {
  const [state, dispatch] = useReducer(AppReducer, initialState);

  const getCategorySummary = async () => {
    const token = localStorage.getItem("token");

    if (!token) {
      console.error("Token not found. User is not authenticated.");
      return false;
    }

    try {
      const response = await axiosRequest(
        API.TRANSACTION.GET_CATEGORY_SUMMARY,
        {},
        "POST",
        {
          Authorization: `Bearer ${token}`,
        }
      );
      if (response?.status === "success") {
        dispatch({
          type: "CATEGORY_TRANSACTIONS",
          payload: response.message,
        });
        return true;
      } else {
        console.log(error)
        dispatch({
          type: "TRANSACTIONS_ERROR",
          payload: response?.message || "Failed to fetch category summary.",
        });
        return false;
      }
    } catch (error) {
      console.error("Error fetching category summary:", error);
      dispatch({
        type: "TRANSACTIONS_ERROR",
        payload: error?.message || "Request failed",
      });
      return false;
    }
  };

  return (
    <TransactionContext.Provider value={{ ...state, getCategorySummary }}>
      {children}
    </TransactionContext.Provider>
  );
};

export const useTransaction = () => {
  return useContext(TransactionContext);
};

export default TransactionContext;
