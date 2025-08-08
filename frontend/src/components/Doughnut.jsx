import { Link } from "react-router-dom";
import { Chart, ArcElement, Tooltip, Legend } from "chart.js";
import { Doughnut as D } from "react-chartjs-2";
import { useMemo } from "react";

Chart.register(ArcElement, Tooltip, Legend);

// Generate distinct colors (spread out hues evenly)
const generateDistinctColors = (count) => {
  const colors = [];
  const hueStep = 360 / count;
  for (let i = 0; i < count; i++) {
    const hue = Math.floor(i * hueStep);
    colors.push(`hsl(${hue}, 70%, 75%)`);
  }
  return colors;
};

const Doughnut = ({ data, month, total }) => {
  // Memoize colors so they don't change on each render
  const backgroundColors = useMemo(
    () => generateDistinctColors(data.values.length),
    [data.values.length]
  );

  const hoverColors = useMemo(
    () => generateDistinctColors(Math.min(3, data.values.length)),
    [data.values.length]
  );
  const Doughnutdata = {
    labels: data.labels,
    datasets: [
      {
        data: data.values,
        // backgroundColor: [
        //   "#FF6384",
        //   "#36A2EB",
        //   "#FFCE56",
        //   "#4BC0C0",
        //   "#9966FF",
        //   "#FF9F40",
        // ],
        // hoverBackgroundColor: ["#FF85A1", "#50B4F7", "#FFD768"],
        backgroundColor: backgroundColors,
        hoverBackgroundColor: hoverColors,
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
