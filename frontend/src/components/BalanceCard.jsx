const BalanceCard = ({ balance }) => {
  return (
    <>
      <div className="box" id="card">
        <div className="card card1"></div>
        <div className="card card2">
          <div className="balance-card">
            My Balance
            <h2>
              ${" "}
              {(
                parseFloat(balance.totalIncome) +
                parseFloat(balance.totalExpense)
              ).toFixed(2)}
            </h2>
            <div className="income-expense">
              <div>
                Profit
                <h3>$ {balance.totalIncome}</h3>
              </div>
              <div>
                Spend
                <h3>$ {balance.totalExpense}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default BalanceCard;
