import { Route, Routes } from "react-router";
import Signup from "../src/components/Signup";
import { AuthProvider } from "./context/AuthContext";
import { ToastContainer } from "react-toastify";
import Home from "./components/Home";

const App = () => {
  return (
    <>
      <AuthProvider>
        <div id="container">
          <div className="container-box" id="bluebox">
            <ToastContainer position="top-right" autoClose={3000} />
            <Routes>
              <Route path="/signup" element={<Signup />} />
              <Route exact path="/" element={<Home />} />
            </Routes>
          </div>
        </div>
      </AuthProvider>
    </>
  );
};

export default App;
