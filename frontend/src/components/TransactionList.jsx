import { useTransaction } from "../context/TransactionContext";
import { useMemo, useState } from "react";
import { useRef } from "react";
import Doughnut from "../components/Doughnut";
import {
  filterCategoriesByType,
  getDoughnutData,
} from "../context/transactionUtils";

const TransactionList = () => {
  const { transactions } = useTransaction();
  const [expandedCategoryId, setExpandedCategoryId] = useState(null);
  const [isIncomeView, setIsIncomeView] = useState(false);
  const categoryRefs = useRef({});

  const filteredCategories = useMemo(() => {
    return filterCategoriesByType(transactions, isIncomeView);
  }, [transactions, isIncomeView]);

  const dataForDoughnut = useMemo(() => {
    return getDoughnutData({
      expandedCategoryId,
      filteredCategories,
      isIncomeView,
    });
  }, [expandedCategoryId, filteredCategories, isIncomeView]);

  const toggleCategory = (id) => {
    setExpandedCategoryId((prevId) => {
      const newId = prevId === id ? null : id;
      setTimeout(() => {
        const node = categoryRefs.current[newId];
        if (node) node.scrollIntoView({ behavior: "smooth", block: "start" });
      }, 100);
      return newId;
    });
  };

  return (
    <>
      <Doughnut
        key={`${isIncomeView} - ${expandedCategoryId ?? "default"}`}
        data={dataForDoughnut}
        month={new Date().toLocaleString("en-US", {
          month: "long",
          year: "numeric",
        })}
      />

      {filteredCategories.length > 0 ? (
        <div className="card-transaction">
          <div
            className={`expense button ${!isIncomeView ? "selected" : ""}`}
            onClick={() => setIsIncomeView(false)}
          >
            Expenses
          </div>
          <div
            className={`income button ${isIncomeView ? "selected" : ""}`}
            onClick={() => setIsIncomeView(true)}
          >
            Income
          </div>
        </div>
      ) : (
        ``
      )}

      <div className="trans-list">
        <div className="scroll-container">
          {filteredCategories.length > 0 ? (
            filteredCategories.map((category) => {
              const filteredTransactions = category.transactions.filter((tx) =>
                isIncomeView ? tx.amount > 0 : tx.amount < 0
              );
              return (
                <div
                  key={category.id}
                  className={`category-section ${
                    expandedCategoryId === category.id ? `expanded` : ``
                  }`}
                >
                  <div
                    id="categories-item"
                    onClick={() => toggleCategory(category.id)}
                    ref={(el) => (categoryRefs.current[category.id] = el)}
                    className={
                      expandedCategoryId === category.id ? "active" : ""
                    }
                  >
                    <img src="/assets/user.png" alt="user-icon" />
                    <div
                      className={`category-name ${
                        expandedCategoryId === category.id ? "highlight" : ""
                      }`}
                    >
                      {category.category}
                    </div>
                    <div className="trans">${category.total_amount}</div>
                  </div>
                  {expandedCategoryId === category.id &&
                    filteredTransactions.map((tx) => (
                      <div
                        key={tx.id}
                        id="categories-item"
                        className="category-transactions"
                      >
                        <div>{tx.text}</div>
                        <div>${tx.amount}</div>
                      </div>
                    ))}
                </div>
              );
            })
          ) : (
            <div className="no-data">No transactions found.</div>
          )}
        </div>
      </div>
    </>
  );
};

export default TransactionList;
