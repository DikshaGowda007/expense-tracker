import Header from "./Header";
import { useAuth } from "../context/AuthContext";
import CategoriesList from "./CategoriesList";
import { useEffect } from "react";
import { useTransaction } from "../context/TransactionContext";

const Home = () => {
  const { user, navigate } = useAuth();
  const { data, getCategorySummary } = useTransaction();

  useEffect(() => {
    getCategorySummary();
  }, []);

  return (
    <>
      <Header userName={user} navigate={navigate} />
      <CategoriesList categorySummary={data} />
    </>
  );
};

export default Home;
