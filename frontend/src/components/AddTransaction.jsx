import { useState } from "react";
import { Link } from "react-router-dom";
import { useTransaction } from "../context/TransactionContext";

const AddTransaction = () => {
  const {
    addTransaction,
    navigate,
  } = useTransaction();

  const [amount, setAmount] = useState(0);
  const [text, setText] = useState("");
  const [category, setCategory] = useState("");
  const [note, setNote] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    await addTransaction(
      { amount: parseFloat(amount), text, category, note },
      navigate
    );
  };

  return (
    <>
      <div className="transaction-container">
        <Link to="/">
          <img src="../../assets/cross.png" alt="" />
        </Link>
        <div className="form-container">
          <h3>Add Expenses</h3>
          <form action="#" onSubmit={handleSubmit}>
            <div className="input_box">
              <input
                type="number"
                value={amount}
                onChange={(e) => setAmount(e.target.value)}
              />
              <label>Amount</label>
            </div>
            <div className="input_box">
              <input
                type="text"
                value={text}
                onChange={(e) => setText(e.target.value)}
              />
              <label>Text</label>
            </div>
            <div className="input_box">
              <input
                type="text"
                value={category}
                onChange={(e) => setCategory(e.target.value)}
              />
              <label>Category</label>
            </div>
            <div className="input_box">
              <input
                type="text"
                value={note}
                onChange={(e) => setNote(e.target.value)}
              />
              <label>Note</label>
            </div>
            <button type="submit">Save</button>
          </form>
        </div>
      </div>
    </>
  );
};

export default AddTransaction;
