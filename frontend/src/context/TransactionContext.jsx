import { createContext, useReducer } from "react";
import axiosRequest from "../components/axiosRequest";
import { API } from "../constants/apiRoutes";
import AppReducer from "../context/AppReducer";
import { useContext } from "react";
import { toast } from "react-toastify";

export const TransactionContext = createContext();

const initialState = {
  categories: [],
  transactions: [],
  balance: { totalIncome: "0.00", totalExpense: "0.00" },
  error: null,
};

export const TransactionProvider = ({ children }) => {
  const [state, dispatch] = useReducer(AppReducer, initialState);

  const getCategorySummary = async () => {
    const token = localStorage.getItem("token");

    if (!token) {
      toast.error(
        response.message || "Token not found. User is not authenticated."
      );
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

      const categoryData = response.message;
      const totalBalance = calculateTotalBalance(response.message);
      const transactionData = response.message;
      if (response?.status === "success") {
        dispatch({
          type: "CATEGORY_TRANSACTIONS",
          payload: categoryData,
        });
        dispatch({
          type: "GET_TOTAL_BALANCE",
          payload: totalBalance,
        });
        dispatch({
          type: "TRANSACTION_LIST",
          payload: transactionData,
        })
        return true;
      } else {
        dispatch({
          type: "TRANSACTIONS_ERROR",
          payload: error.message || "Failed to fetch category summary.",
        });
        return false;
      }
    } catch (error) {
      console.error("Error fetching category summary:", error);
      dispatch({
        type: "TRANSACTIONS_ERROR",
        payload: error.message || "Request failed",
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

const calculateTotalBalance = (amountSummary) => {
  let totalIncome = 0;
  let totalExpense = 0;
  amountSummary.forEach((amount) => {
    const incomeTransactions = amount.transactions.filter(
      (tx) => tx.amount > 0
    );
    const expenseTransactions = amount.transactions.filter(
      (tx) => tx.amount < 0
    );

    totalIncome += incomeTransactions.reduce((sum, tx) => sum + tx.amount, 0);
    totalExpense += expenseTransactions.reduce((sum, tx) => sum + tx.amount, 0);
  });
  return {
    totalIncome: totalIncome.toFixed(2),
    totalExpense: totalExpense.toFixed(2),
  };
};

export const useTransaction = () => {
  return useContext(TransactionContext);
};

export default TransactionContext;
