import { Link } from "react-router-dom";
import { Chart, ArcElement, Tooltip, Legend } from "chart.js";
import { Doughnut as D } from "react-chartjs-2";

Chart.register(ArcElement, Tooltip, Legend);

const Doughnut = ({ data, month, total }) => {
  const Doughnutdata = {
    labels: data.labels,
    datasets: [
      {
        data: data.values,
        backgroundColor: [
          "#FF6384",
          "#36A2EB",
          "#FFCE56",
          "#4BC0C0",
          "#9966FF",
          "#FF9F40",
        ],
        hoverBackgroundColor: ["#FF85A1", "#50B4F7", "#FFD768"],
        border: [0],
        borderColor: "#302D43", // White border color between slices
        borderWidth: 5, // Thicker borders,
        borderRadius: 10,
        opacity: 0.1,
      },
    ],
  };

  const options = {
    plugins: {
      legend: {
        display: false,
      },
    },
    responsive: true,
    maintainAspectRatio: false,
    cutout: 30,
  };
  return (
    <>
      <div className="pie-chart">
        <div className="info">
          <Link to="/">
            <img src="/assets/back.png" alt="user-icon" />
          </Link>
          <h2>{month}</h2>
          <span>{total}</span>
        </div>
        <D data={Doughnutdata} options={options} />
      </div>
    </>
  );
};

export default Doughnut;
