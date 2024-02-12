const context = document.getElementById("data-set").getContext("2d");
let line = new Chart(context, {});
//Values from the form
const initialAmount = document.getElementById("start-investment");
const years = document.getElementById("monthly-investment");
const rates = document.getElementById("interest-rate");
const compound = document.getElementById("investment-years");

//The calculate button
const button = document.querySelector(".input-group button");
//Attach an event listener
button.addEventListener("click", calculateGrowth);

const data = [];
const labels = [];

function calculateGrowth(e) {
    e.preventDefault();
    data.length = 0;
    labels.length = 0;
    let growth = 0;
    try {
        const initial = parseInt(initialAmount.value);
        const period = parseInt(years.value);
        const interest = parseInt(rates.value);
        const comp = parseInt(compound.value);

        for(let i = 1; i <= period; i++) {
            const final = initial * Math.pow(1 + ((interest / 100) / comp), comp * i);
            data.push(toDecimal(final, 2));
            labels.push(i + " let");
            growth = toDecimal(final, 2);
        }
        //
        drawGraph();
    } catch (error) {
        console.error(error);
    }
}

function drawGraph() {
    line.destroy();
    line = new Chart(context, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: "Zhodnocení",
                data,
                fill: true,
                backgroundColor: "rgba(163,163,163)",
                borderWidth: 3
            }]
        }
    });
}

function toDecimal(value, decimals) {
    return +value.toFixed(decimals);
}