import { useState } from "react";
import { useTransaction } from "../context/TransactionContext";
import { Link } from "react-router-dom";

const AddCategory = () => {
  const { addCategory, navigate } = useTransaction();
  const [type, setType] = useState("");
  const [category, setCategory] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    await addCategory({ type, category }, navigate);
  };

  return (
    <>
      <div className="transaction-container">
        <Link to="/">
          <img src="../../assets/cross.png" alt="" />
        </Link>
        <div className="form-container">
          <h3>Add Category</h3>
          <form action="#" onSubmit={handleSubmit}>
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
                value={type}
                onChange={(e) => setType(e.target.value)}
              />
              <label>Type</label>
            </div>
            <button type="submit">Save</button>
          </form>
        </div>
      </div>
    </>
  );
};

export default AddCategory;
