import { createContext, useContext, useEffect, useState } from "react";
import { toast } from "react-toastify";
import { API } from "../constants/apiRoutes";
import axiosRequest from "../components/axiosRequest";
import { useNavigate } from "react-router-dom";

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [responseStatus, setResponseStatus] = useState(null);
  const [responseMessage, setResponseMessage] = useState(null);
  const [token, setToken] = useState(null); // To store token
  const [isSignupView, setIsSignupView] = useState(false);
  const [user, setUser] = useState(null);
  const [isOtpSent, setIsOtpSent] = useState(false);
  const [userId, setUserId] = useState(null);
  const [otp, setOtp] = useState();

  useEffect(() => {
    const storedUser = localStorage.getItem("user");
    const storedToken = localStorage.getItem("token");

    if (storedUser && storedUser !== "undefined" && storedToken) {
      try {
        setUser(storedUser);
        setToken(storedToken);
      } catch (error) {
        console.error("Error parsing stored user:", error);
        localStorage.removeItem("user");
      }
    }
  }, []);

  const navigate = useNavigate();

  const signup = async () => {
    if (!isOtpSent) {
      let data = JSON.stringify({ name, email, password });
      try {
        const response = await axiosRequest(`${API.AUTH.SIGNUP}`, data, "POST");
        if (response.status === "otp_sent") {
          setIsOtpSent(true);
          setUserId(response.user_id);
        }
        
        setResponseStatus(JSON.stringify(response.status));
        setResponseMessage(JSON.stringify(response.message));
        (response.status === "success" || response.status === 'otp_sent')
          ? toast.success(response.message || "Signup successful!")
          : toast.error(response.message || "Signup failed.");
      } catch (error) {
        console.log(error);
        toast.error("An unexpected error occurred.");
      }
    } else if (isOtpSent) {
      let data = JSON.stringify({ user_id: userId, otp });
      try {
        const response = await axiosRequest(
          `${API.AUTH.VERIFY_OTP}`,
          data,
          "POST"
        );

        if (response.status === "SUCCESS" || response.status === "success") {
          toast.success(response.message || "Verification successful!");
          setIsSignupView(false);
          setIsOtpSent(false);
          setOtp("");
        } else {
          toast.error(response.message || "Verification failed.");
        }

        setResponseStatus(JSON.stringify(response.status));
        setResponseMessage(JSON.stringify(response.message));
      } catch (error) {
        console.error("Error during OTP verification:", error);
        toast.error("An unexpected error occurred.");
      }
    }
  };

  const login = async () => {
    const data = JSON.stringify({ email, password });

    try {
      const response = await axiosRequest(`${API.AUTH.LOGIN}`, data, "POST");
      setResponseStatus(JSON.stringify(response.status));
      setResponseMessage(JSON.stringify(response.message));
      response.status === "success"
        ? (() => {
            const name = response.message.match(/Welcome (.+)/)[1];
            setUser(name);
            setToken(response.token);
            localStorage.setItem("user", name);
            localStorage.setItem("token", response.token);
            toast.success(response.message || "Login successful!");
            navigate("/");
          })()
        : toast.error(response.message || "Login failed.");
    } catch (error) {
      console.error(error);
      toast.error("An unexpected error occurred.");
    }
  };

  const logout = async () => {
    try {
      const response = await axiosRequest(`${API.AUTH.LOGOUT}`, {}, "POST");
      localStorage.removeItem("user");
      localStorage.removeItem("token");
      setUser(null);
      setToken(null);
      navigate("/signup");
    } catch (error) {
      console.log(error);
      user || token
        ? toast.error("Logout failed")
        : toast.success("Logged out successfully!");
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
        token,
        isSignupView,
        setIsSignupView,
        user,
        login,
        navigate,
        logout,
        isOtpSent,
        otp,
        setOtp,
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
