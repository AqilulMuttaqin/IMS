$(function () {

  var chart = {
    chart: {
      type: "area",
      height: 230
    },
    colors: ["#00BAEC"],
    stroke: {
      width: 3,
      curve: "straight"
    },
    dataLabels: {
      enabled: false

    },
    fill: {
      gradient: {
        enabled: true,
        opacityFrom: 0.55,
        opacityTo: 0
      }
    },
    markers: {
      size: 5,
      colors: ["#fff"],
      strokeColor: "#00BAEC",
      strokeWidth: 3
    },
    series: [
      {
        name: "Series 1",
        data: [45, 52, 38, 45, 19, 23, 2, 30, 29, 28, 29, 19, 41]
      }
    ],
    xaxis: {
      categories: [
        "01 Jan",
        "02 Jan",
        "03 Jan",
        "04 Jan",
        "05 Jan",
        "06 Jan",
        "07 Jan",
        "08 Jan",
        "09 Jan",
        "10 Jan",
        "11 Jan",
        "12 Jan",
        "13 Jan",
      ],
    }
  };

  var chart = new ApexCharts(document.querySelector("#chart"), chart);
  chart.render();
})