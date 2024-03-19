$(function () {

  var chart = {
    chart: {
      type: "area",
      height: 280
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
        data: [45, 52, 38, 45, 19, 23, 2, 30, 29, 28, 29, 19, 41, 45, 52, 38, 45, 19, 23, 2, 30, 29, 28, 29, 19, 41, 45, 52, 38, 45, 19]
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
        "14 Jan",
        "15 Jan",
        "16 Jan",
        "17 Jan",
        "18 Jan",
        "19 Jan",
        "20 Jan",
        "21 Jan",
        "22 Jan",
        "23 Jan",
        "24 Jan",
        "25 Jan",
        "26 Jan",
        "27 Jan",
        "28 Jan",
        "29 Jan",
        "30 Jan",
        "31 Jan",
      ]
    },
    yaxis: {
      title: {
        text: "Price($)"
      }
    }
  };

  var chart = new ApexCharts(document.querySelector("#chart"), chart);
  chart.render();

  var chart2 = {
    chart: {
      type: "bar",
      height: 280
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
        data: [45, 52, 38, 45, 19, 23, 2, 30, 29, 28, 29, 19, 41, 45, 52, 38, 45, 19, 23, 2, 30, 29, 28, 29, 19, 41, 45, 52, 38, 45, 19]
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
        "14 Jan",
        "15 Jan",
        "16 Jan",
        "17 Jan",
        "18 Jan",
        "19 Jan",
        "20 Jan",
        "21 Jan",
        "22 Jan",
        "23 Jan",
        "24 Jan",
        "25 Jan",
        "26 Jan",
        "27 Jan",
        "28 Jan",
        "29 Jan",
        "30 Jan",
        "31 Jan",
      ],
    },
    yaxis: {
      title: {
        text: "Price($)"
      }
    }
  };

  var chart2 = new ApexCharts(document.querySelector("#chart2"), chart2);
  chart2.render();
})