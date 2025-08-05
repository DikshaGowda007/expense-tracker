import { useAuth } from "../context/AuthContext";

const Signup = () => {
  const { signup, name, setName, email, setEmail, password, setPassword } =
    useAuth();

  const handleSubmit = async (e) => {
    e.preventDefault();
    await signup();
  };

  return (
    <div className="form-container">
      <form onSubmit={handleSubmit}>
        <div className="input_box">
          <input
            type="text"
            name="name"
            required
            value={name}
            onChange={(e) => setName(e.target.value)}
          />
          <label>Username</label>
        </div>

        <div className="input_box">
          <input
            type="password"
            name="password"
            required
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
          <label>Password</label>
        </div>

        <div className="input_box">
          <input
            type="email"
            name="email"
            required
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
          <label>Email Id</label>
        </div>
        <button type="submit">Submit</button>
        <p className="signup_link">
          Already have an account? <span>Login</span>
        </p>
        <p className="contact_link">
          <a href="#" onClick={(e) => e.preventDefault()}>
            Resend OTP
          </a>
        </p>
      </form>
    </div>
  );
};

export default Signup;