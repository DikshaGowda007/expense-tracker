import { useTransaction } from "../context/TransactionContext";
import { useMemo, useState } from "react";
import { useRef } from "react";
import Doughnut from "../components/Doughnut";

const TransactionList = () => {
  const [expandedCategoryId, setExpandedCategoryId] = useState(null);
  const { transactions } = useTransaction();
  const [isIncomeView, setIsIncomeView] = useState(false);
  const categoryRefs = useRef({});

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

  const filteredCategories = useMemo(() => {
    return transactions.filter((category) =>
      isIncomeView ? category.type === "1" : category.type === "2"
    );
  }, [transactions, isIncomeView]);

  const dataForDoughnut = useMemo(() => {
    if (expandedCategoryId) {
      const category = filteredCategories.find(
        (cat) => cat.id === expandedCategoryId
      );
      if (!category) return { labels: [], values: [] };

      const filteredTransactions = category.transactions.filter((tx) =>
        isIncomeView ? tx.amount > 0 : tx.amount < 0
      );

      return {
        labels: filteredTransactions.map((tx) => tx.text),
        values: filteredTransactions.map((tx) => Math.abs(tx.amount)),
      };
    }

    // Show category totals by default
    return {
      labels: filteredCategories.map((category) => category.category),
      values: filteredCategories.map((category) =>
        Math.abs(category.total_amount)
      ),
    };
  }, [expandedCategoryId, filteredCategories, isIncomeView]);

  return (
    <>
      <Doughnut
        data={dataForDoughnut}
        month={new Date().toLocaleString("en-US", {
          month: "long",
          year: "numeric",
        })}
        // total={isIncomeView ? `income` : `expense` }
      />
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
