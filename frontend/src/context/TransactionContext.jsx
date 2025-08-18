import { createContext, useReducer } from "react";
import axiosRequest from "../components/axiosRequest";
import { API } from "../constants/apiRoutes";
import AppReducer from "../context/AppReducer";
import { useContext } from "react";
import { toast } from "react-toastify";
import { useNavigate } from "react-router";

export const TransactionContext = createContext();

const initialState = {
  categories: [],
  transactions: [],
  balance: { totalIncome: "0.00", totalExpense: "0.00" },
  error: null,
};

export const TransactionProvider = ({ children }) => {
  const [state, dispatch] = useReducer(AppReducer, initialState);
  const navigate = useNavigate();

  const getTransactionById = async () => {
    const token = localStorage.getItem("token");
    if (!token) {
      console.error("Token not found. User is not authenticated.");
      return false;
    }
    try {
      const response = await axiosRequest(`${API.TRANSACTION.GET}`, {}, "GET", {
        Authorization: `Bearer ${token}`,
      });

      dispatch({
        type:
          response?.status === "success"
            ? "GET_TRANSACTIONS"
            : "TRANSACTIONS_ERROR",
      });
      return true;
    } catch (error) {
      console.error("Error fetching transactions:", error);
      dispatch({
        type: "TRANSACTIONS_ERROR",
        payload: error?.message || "Request failed",
      });
      return false;
    }
  };

  const getCategorySummary = async () => {
    const token = localStorage.getItem("token");

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
      totalExpense += expenseTransactions.reduce(
        (sum, tx) => sum + tx.amount,
        0
      );
    });
    return {
      totalIncome: totalIncome.toFixed(2),
      totalExpense: totalExpense.toFixed(2),
    };
  };

  const addTransaction = async ({ amount, text, category, note }, navigate) => {
    const token = localStorage.getItem("token");
    let matchedCategory = null;
    if (category) {
      matchedCategory = state.categories.find(
        (cat) => cat.category.toLowerCase() === category.trim().toLowerCase()
      );
      if (!matchedCategory) {
        toast.error("Category not found.");
        return false;
      }
    }

    const data = JSON.stringify({
      amount,
      text,
      category: matchedCategory?.id,
      note,
    });
    try {
      const response = await axiosRequest(
        `${API.TRANSACTION.ADD}`,
        data,
        "POST",
        {
          Authorization: `Bearer ${token}`,
        }
      );
      response.status === "success"
        ? (toast.success("Transaction added successfully!"), navigate("/"))
        : toast.error(response.message);
    } catch (error) {
      console.error("Error fetching category summary:", error);

      toast.error("Some Error occurder");

      dispatch({
        type: "TRANSACTIONS_ERROR",
        payload: error.message || "Request failed",
      });
    }
  };

  const addCategory = async ({ type, category }) => {
    const token = localStorage.getItem("token");
    const data = JSON.stringify({
      type,
      category,
    });

    try {
      const response = await axiosRequest(`${API.CATEGORY.ADD}`, data, "POST", {
        Authorization: `Bearer ${token}`,
      });
      response.status === "success"
        ? (toast.success(response.message), navigate("/"))
        : toast.error(response.message);
    } catch (error) {
      console.log(error);
      toast.error("Some Error occured");
      dispatch({
        type: "CATEGORIES_ERROR",
        payload: error.message || "Request failed",
      });
    }
  };

  return (
    <TransactionContext.Provider
      value={{
        ...state,
        getCategorySummary,
        addTransaction,
        navigate,
        addCategory,
      }}
    >
      {children}
    </TransactionContext.Provider>
  );
};

export const useTransaction = () => {
  return useContext(TransactionContext);
};

export default TransactionContext;
