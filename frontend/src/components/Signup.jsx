import { useAuth } from "../context/AuthContext";

const Signup = () => {
  const {
    signup,
    name,
    setName,
    email,
    setEmail,
    password,
    setPassword,
    isSignupView,
    setIsSignupView,
    login,
  } = useAuth();

  const handleSubmit = async (e) => {
    e.preventDefault();
    isSignupView ? await signup() : await login();
  };

  return (
    <>
      <div className="card-transaction">
        <div
          className={`button ${!isSignupView ? `selected loginView` : `none`}`}
          onClick={() => setIsSignupView(false)}
        >
          Login
        </div>
        <div
          className={`button ${isSignupView ? `selected SignupView` : `none`}`}
          onClick={() => setIsSignupView(true)}
        >
          Signup
        </div>
      </div>

      {!isSignupView && (
        <div className="form-container">
          <form action="#" onSubmit={handleSubmit}>
            <div className="input_box">
              <input
                type="email"
                required
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
              <label>Email Id</label>
            </div>
            <div className="input_box">
              <input
                type="text"
                required
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />
              <label>Password</label>
            </div>
            <button type="submit">{isSignupView ? "Signup" : "Login"}</button>
            <p className="signup_link">
              Don't have an account ?
              <span onClick={() => setIsSignupView(true)}>Signup</span>
            </p>
          </form>
        </div>
      )}

      {isSignupView && (
        <div className="form-container">
          <form onSubmit={handleSubmit}>
            <div className="input_box">
              <input
                type="text"
                name="name"
                value={name}
                onChange={(e) => setName(e.target.value)}
              />
              <label>Username</label>
            </div>

            <div className="input_box">
              <input
                type="password"
                name="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />
              <label>Password</label>
            </div>

            <div className="input_box">
              <input
                type="email"
                name="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
              <label>Email Id</label>
            </div>
            <button type="submit">{isSignupView ? "Signup" : "Login"}</button>
            <p className="signup_link">
              Already have an account? <span onClick={()=> setIsSignupView(false)}>Login</span>
            </p>
            <p className="contact_link">
              <a href="#" onClick={(e) => e.preventDefault()}>
                Resend OTP
              </a>
            </p>
          </form>
        </div>
      )}
    </>
  );
};

export default Signup;