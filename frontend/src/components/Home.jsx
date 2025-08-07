import Header from "./Header";
import { useAuth } from "../context/AuthContext";
import CategoriesList from "./CategoriesList";
import { useEffect } from "react";
import { useTransaction } from "../context/TransactionContext";
import BalanceCard from "../components/BalanceCard";

const Home = () => {
  const { user, navigate } = useAuth();
  const { balance, categories, getCategorySummary } = useTransaction();

  useEffect(() => {
    getCategorySummary();
  }, []);

  const handleClick = () => {
    navigate("/transactions");
  };

  return (
    <>
      <Header userName={user} navigate={navigate} />
      <BalanceCard onClick={handleClick} balance={balance} />
      <CategoriesList categorySummary={categories} />
    </>
  );
};

export default Home;
