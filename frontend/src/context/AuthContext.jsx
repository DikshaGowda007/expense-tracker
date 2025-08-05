import { createContext, useContext, useState } from "react";
import { toast } from "react-toastify";
import { API } from "../constants/apiRoutes";
import axiosRequest from "../components/axiosRequest";

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [responseStatus, setResponseStatus] = useState(null);
  const [responseMessage, setResponseMessage] = useState(null);

  const signup = async () => {
    let data = JSON.stringify({ name, email, password });
    try {
      const response = await axiosRequest(`${API.AUTH.SIGNUP}`, data, "POST");

      setResponseStatus(JSON.stringify(response.status));
      setResponseMessage(JSON.stringify(response.message));
      response.status === "success"
        ? toast.success(response.message || "Signup successful!")
        : toast.error(response.message || "Signup failed.");
    } catch (error) {
      console.log(error);
    }
  };

  return (
    <AuthContext.Provider
      value={{
        signup,
        email,
        setEmail,
        password,
        setPassword,
        name,
        setName,
        responseStatus,
        responseMessage,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
};
export const useAuth = () => {
  return useContext(AuthContext);
};

export default AuthContext;
