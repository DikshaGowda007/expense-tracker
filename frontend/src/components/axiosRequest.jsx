import axios from "axios";

const axiosRequest = async (url, params = {}, method = "GET", headers = {}) => {
  console.log('url')
  console.log(url)
  try {
    // Setup axios configuration
    const config = {
      method: method,
      maxBodyLength: Infinity,
      url: url,
      headers: {
        "Content-Type": "application/json",
        ...headers,
      },
      data: method === "POST" || method === "PUT" ? params : null,
      params: method === "GET" ? params : null,
      withCredentials: true,
    };
    const response = await axios(config);
    console.log(config)
    console.log(response)
    return response.data;
  } catch (error) {
    if (error.response) {
      console.log("Response Error:", error.response.data);
    } else if (error.request) {
      console.log("Request Error:", error.request);
    } else {
      console.log("Unknown Error:", error.message);
    }
    throw error;
  }
};
export default axiosRequest;
