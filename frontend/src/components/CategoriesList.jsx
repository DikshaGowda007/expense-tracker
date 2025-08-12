import { useEffect, useRef } from "react";
import { Link } from "react-router";

const CategoriesList = ({ categorySummary }) => {
  const lastTransactionRef = useRef(null);

  useEffect(() => {
    if (lastTransactionRef.current) {
      lastTransactionRef.current.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
    }
  }, []);

  return (
    <>
      <div className="box" id="categories">
        <div className="transaction-container">
          <h3>Transactions</h3>
          <Link to="/transactions" >See All</Link>
        </div>
        <div className="scroll-container">
          {Array.isArray(categorySummary) && categorySummary.length > 0 ? (
            categorySummary.map((category, index) => (
              <div
                id="categories-item"
                key={index}
                ref={
                  index === categorySummary.length - 1
                    ? lastTransactionRef
                    : null
                }
              >
                <img src="/assets/user.png" alt="user-icon" />
                {category.category}
                <div className="trans">${category.total_amount}</div>
              </div>
            ))
          ) : (
            <div className="no-data">No transactions found.</div>
          )}
        </div>
      </div>
    </>
  );
};

export default CategoriesList;
