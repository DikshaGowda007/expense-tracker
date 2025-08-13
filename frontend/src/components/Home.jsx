import Header from "./Header";
import { useAuth } from "../context/AuthContext";
import CategoriesList from "./CategoriesList";
import { useEffect } from "react";
import { useTransaction } from "../context/TransactionContext";
import BalanceCard from "../components/BalanceCard";
import AddTransactionBtn from "./AddTransactionBtn";

const Home = () => {
  const { user, navigate, logout } = useAuth();
  const { balance, categories, getCategorySummary } = useTransaction();

  useEffect(() => {
    getCategorySummary();
  }, [user]);

  const handleClick = () => {
    navigate("/transactions");
  };

  return (
    <>
      <Header userName={user} logout={logout} />
      <BalanceCard onClick={handleClick} balance={balance} />
      <CategoriesList categorySummary={categories} />
      <AddTransactionBtn user={user} />
    </>
  );
};

export default Home;
