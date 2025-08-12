import { Link } from "react-router-dom"

const AddTransactionBtn = ({user}) => {
  return (
  <>
  <div className="add-btn">
    <Link to={`${user ? `/addtransaction` : `/signup`}`} >
    <img src="../assets/plus.png" alt="add-transaction" />
    </Link>
  </div>
  </>
  )
}

export default AddTransactionBtn