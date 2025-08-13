import { Route, Routes } from "react-router";
import Signup from "../src/components/Signup";
import { AuthProvider } from "./context/AuthContext";
import { ToastContainer } from "react-toastify";
import Home from "./components/Home";
import { TransactionProvider} from "./context/TransactionContext";
import TransactionList from "./components/TransactionList";
import AddTransaction from "./components/AddTransaction";
import AddCategory from "./components/AddCategory";

const App = () => {
  
  return (
    <>
      <AuthProvider>
        <TransactionProvider>
        <div id="container">
          <div className="container-box" id="bluebox">
            <ToastContainer position="top-right" autoClose={3000} />
            <Routes>
              <Route path="/signup" element={<Signup />} />
              <Route exact path="/" element={<Home />} />
              <Route path="/transactions" element={<TransactionList/>} />
              <Route path="/addtransaction" element={<AddTransaction />} />
              <Route path="/addcategory" element={<AddCategory />} />
            </Routes>
          </div>
        </div>
        </TransactionProvider>
      </AuthProvider>
    </>
  );
};

export default App;
