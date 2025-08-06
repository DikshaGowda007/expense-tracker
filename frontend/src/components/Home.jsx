import Header from "./Header";
import { useAuth } from "../context/AuthContext";

const Home = () => {
  const { user, navigate } = useAuth();

  return (
    <>
      <Header userName={user} navigate={navigate} />
    </>
  );
};

export default Home;
