let cicChart = null;
let icChart = null;
jQuery(function($) {
    resetCalculator("calculator-loan");
    resetCalculator("calculator-how-invest");
    resetCalculator("calculator-compound-interest");
    if (checkCalculatorValues()) {
        recountLoanCalculator();
        recountFinancialIndependenceCalculator();
        recountCompoundInterestCalculator();
        recountRentCalculator()
    }

    $('body').on('click', '.calculator-loan .calculate', function(k, v) {
        if (checkCalculatorValues()) {
            recountLoanCalculator();
            k.preventDefault();
        }
    }).on('click', '.calculator-how-invest .calculate', function(k, v) {
        if (checkCalculatorValues()) {
            recountFinancialIndependenceCalculator();
            k.preventDefault();
        }
    }).on('click', '.calculator-compound-interest .calculate', function(k, v) {
        if (checkCalculatorValues()) {
            recountCompoundInterestCalculator();
            k.preventDefault();
        }
    }).on('click', '.calculator-rent .calculate', function(k, v) {
        if (checkCalculatorValues()) {
            recountRentCalculator();
            k.preventDefault();
        }
    }).on('click', '.calculator .clear', function(k, v) {
        const calculator = $(this).closest('.calculator');
        $.each($('input', calculator), function(k, input) {
            $(input).val('');
        });
        if (checkCalculatorValues()) {
            recountLoanCalculator();
            recountFinancialIndependenceCalculator();
            recountCompoundInterestCalculator();
            recountRentCalculator();
        }
        k.preventDefault();
    });
    function checkCalculatorValues() {
        let valid = true;
        $('.calculator-error-message').remove();
        $('.calculator-error-info').hide();
        $.each($('.calculator input'), function(k, input) {
            let value = $(input).val();
            let min = Number.parseInt($(input).attr('min'));
            if (('' === value) || (min > Number.parseInt(value))) {
                valid = false;
                let error = $(input).data('error');
                if (undefined !== error) {
                    $(input).after('<span class="calculator-error-message">' + error + '</span>')
                }
            }
        });
        if (!valid) {
            $('.calculator-error-info').show();
            $('.calculator-result-row, .calculator-results canvas').hide()
        } else {
            $('.calculator-result-row, .calculator-results canvas').show()
        }
        return valid
    }
    function recountLoanCalculator() {
        if ($('.calculator-loan').length > 0) {
            const startInvestment = Number.parseInt($('input[name=start-investment]').val());
            const annualInterestRate = Number.parseFloat($('input[name=annual-interest-rate]').val()) / 100;
            const investmentYears = Number.parseInt($('input[name=investment-years]').val());

            let instalmentTotal = investmentYears * 12;
            let left = startInvestment;
            let interestTotal = 0;
            let monthlyInterestRate = annualInterestRate / 12;
            let monthlyPayment = startInvestment * monthlyInterestRate * (Math.pow(1 + monthlyInterestRate, instalmentTotal)) / (Math.pow(1 + monthlyInterestRate, instalmentTotal) - 1);
            for (let i = 1; i <= investmentYears; i += 1) {
                for(let j = 1; j <= 12; j += 1){
                    let interest = left * monthlyInterestRate;
                    interestTotal += interest;
                    left -= monthlyPayment - interest;
                }
                
                console.log(i + ".\t" + left.toFixed(2) + " Kč\t" + interestTotal.toFixed(2) + " Kč" + ".\t" + annualInterestRate);
            }

            const resultInvestedValue = $('.calculator-result-row-value[data-result=investedValue]');
            const resultReceivedInterest = $('.calculator-result-row-value[data-result=receivedInterest]');
            resultInvestedValue.html(numberWithSpaces(Math.ceil(monthlyPayment)) + ' ' + resultInvestedValue.data('suffix'));
            resultReceivedInterest.html(numberWithSpaces(Math.ceil(interestTotal)) + ' ' + resultReceivedInterest.data('suffix'));
            redrawIcChart(investmentYears, startInvestment, annualInterestRate)
        }
    }
    function recountFinancialIndependenceCalculator() {
        if ($('.calculator-how-invest').length > 0) {
            const startInvestment = Number.parseInt($('input[name=start-investment]').val());
            const goalInvestment = Number.parseInt($('input[name=goal-investment]').val());
            const annualInterestRate = Number.parseFloat($('input[name=annual-interest-rate]').val()) / 100;
            const investmentYears = Number.parseInt($('input[name=investment-years]').val());

            var months = investmentYears * 12;
            var monthlyReturn = Math.pow(1 + annualInterestRate, 1/12) -1;
            var monthlyContribution = (goalInvestment - startInvestment * Math.pow(1 + monthlyReturn, months)) / ((Math.pow(1 + monthlyReturn, months) - 1) / monthlyReturn);
            console.log("mesicne: " + monthlyContribution + ".\t" + investmentYears + ".\t" + goalInvestment + ".\t" + startInvestment + ".\t" + annualInterestRate);
            var totalInvested = startInvestment + monthlyContribution * months;
            var totalReturn = goalInvestment - totalInvested;
            console.log("investováno : " + numberWithSpaces(totalInvested) + "  zhodnoceno : " + numberWithSpaces(totalReturn));

            const resultInvestedValue = $('.calculator-result-row-value[data-result=investedValue]');
            const resultReceivedInterest = $('.calculator-result-row-value[data-result=receivedInterest]');
            const resultFinalValue = $('.calculator-result-row-value[data-result=finalValue]');
            resultInvestedValue.html(numberWithSpaces(Math.ceil(totalInvested)) + ' ' + resultInvestedValue.data('suffix'));
            resultReceivedInterest.html(numberWithSpaces(Math.ceil(totalReturn)) + ' ' + resultReceivedInterest.data('suffix'));
            resultFinalValue.html(numberWithSpaces(Math.ceil(monthlyContribution)) + ' ' + resultFinalValue.data('suffix'));
            redrawFicChart(investmentYears, goalInvestment, startInvestment, annualInterestRate);
            console.log(startInvestment, goalInvestment);
        }
    }
    function recountCompoundInterestCalculator(e) {
        if ($('.calculator-compound-interest').length > 0) {
            const startInvestment = Number.parseInt($('input[name=start-investment]').val());
            const monthlyInvestment = Number.parseInt($('input[name=monthly-investment]').val());
            const annualInterestRate = Number.parseFloat($('input[name=annual-interest-rate]').val()) / 100;
            const investmentYears = Number.parseInt($('input[name=investment-years]').val());
            const rate = annualInterestRate / 12;
            const pow = Math.pow(1 + rate, investmentYears * 12);
            const pmt = -1 * monthlyInvestment;
            const pv = -1 * startInvestment;
            const finalValue = (pmt * (1 - pow) / rate) - pv * pow;
            const investedValue = startInvestment + (monthlyInvestment * investmentYears * 12);
            const receivedInterest = finalValue - investedValue;
            const resultInvestedValue = $('.calculator-result-row-value[data-result=investedValue]');
            const resultReceivedInterest = $('.calculator-result-row-value[data-result=receivedInterest]');
            const resultFinalValue = $('.calculator-result-row-value[data-result=finalValue]');
            resultInvestedValue.html(numberWithSpaces(Math.ceil(startInvestment)) + ' ' + resultInvestedValue.data('suffix'));
            resultReceivedInterest.html(numberWithSpaces(Math.ceil(receivedInterest)) + ' ' + resultReceivedInterest.data('suffix'));
            resultFinalValue.html(numberWithSpaces(Math.ceil(finalValue)) + ' ' + resultFinalValue.data('suffix'));
            redrawCicChart(investmentYears, monthlyInvestment, startInvestment, rate)
        }
    }
    function recountRentCalculator() {
        if ($('.calculator-rent').length > 0) {
            const startInvestment = Number.parseInt($('input[name=start-investment]').val());
            const renta = Number.parseInt($('input[name=goal-investment]').val());
            const annualInterestRate = Number.parseFloat($('input[name=annual-interest-rate]').val()) / 100;
            var monthlyInterestRate = annualInterestRate / 12;
            var numberOfPayments = Math.log(renta / (renta - startInvestment * monthlyInterestRate)) / Math.log(1 + monthlyInterestRate);
            var totalInterest = 0;
            var left = startInvestment;
            for (var i = 0; i < numberOfPayments; i++) {
              var interest = left * monthlyInterestRate;
              totalInterest += interest;
              left -= renta - interest;
            }


            var years = Math.floor(numberOfPayments / 12);
            var months = Math.round(numberOfPayments % 12);

            const resultInvestedValue = $('.calculator-result-row-value[data-result=investedValue]');
            const resultReceivedInterest = $('.calculator-result-row-value[data-result=receivedInterest]');
            const resultFinalValue = $('.calculator-result-row-value[data-result=finalValue]');
            resultFinalValue.html(numberWithSpaces(years) + ' Let ' + months + " měsíců");
            resultInvestedValue.html(numberWithSpaces(Math.ceil(totalInterest)) + ' ' + resultInvestedValue.data('suffix'));
            resultReceivedInterest.html(numberWithSpaces(Math.ceil(startInvestment)) + ' ' + resultReceivedInterest.data('suffix'));
            redrawRentChart(renta, startInvestment, annualInterestRate);
        }
    }
    function redrawCicChart(investmentYears, monthlyInvestment, startInvestment, rate) {
        let finalValues = [];
        let investedValues = [];
        let years = [];
        const pmt = -1 * monthlyInvestment;
        const pv = -1 * startInvestment;
        for (let i = 1; i <= investmentYears; i += 1) {
            let pow = Math.pow(1 + rate, i * 12);
            let investedValue = monthlyInvestment * (i * 12) + startInvestment;
            investedValues.push(investedValue);
            finalValues.push(((pmt * (1 - pow) / rate) - pv * pow) - investedValue);
            years.push(i)
        }
        let ctx = document.getElementById('cicChart').getContext('2d');
        if (null === cicChart) {
            cicChart = new Chart(ctx,{
                type: 'bar',
                data: {
                    labels: years,
                    datasets: [{
                        label: 'Investovaná částka',
                        data: investedValues,
                        backgroundColor: '#353535'
                    }, {
                        label: 'Obdržený úrok',
                        data: finalValues,
                        backgroundColor: '#A3A3A3',
                        font: {
                            weight: 'bold'
                        },
                        pointLabels: {
                            fontSize: 18
                        }
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: false
                        },
                        legend: {
                            labels: {
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    let value = Math.round(tooltipItem.raw);
                                    if (value >= 1000) {
                                        return tooltipItem.dataset.label + ": " + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' Kč'
                                    } else {
                                        return tooltipItem.dataset.label + ": " + value + ' Kč'
                                    }
                                },
                                title: function(tooltipItem, data) {
                                    return "Počet let: " + tooltipItem[0].label
                                }
                            }
                        }
                    },
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                            title: {
                                display: true,
                                text: 'Počet let',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        y: {
                            stacked: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    if (parseInt(value) >= 1000) {
                                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' Kč'
                                    } else {
                                        return value + ' Kč'
                                    }
                                }
                            }
                        }
                    }
                }
            })
        } else {
            cicChart.data.labels = years;
            cicChart.data.datasets[0].data = investedValues;
            cicChart.data.datasets[1].data = finalValues;
            cicChart.update()
        }
    }
    function redrawIcChart(investmentYears, startInvestment, rate)  {
        let finalValues = [];
        let investedValues = [];
        let years = [];
        let fortnie = rate;
        let instalmentTotal = investmentYears * 12;
        let left = startInvestment;
        let interestTotal = 0;
        let monthlyInterestRate = rate / 12;
        let monthlyPayment = startInvestment * monthlyInterestRate * (Math.pow(1 + monthlyInterestRate, instalmentTotal)) / (Math.pow(1 + monthlyInterestRate, instalmentTotal) - 1);
        for (let i = 1; i <= investmentYears; i += 1) {
            for(let j = 1; j <= 12; j += 1){
                let interest = left * monthlyInterestRate;
                interestTotal += interest;
                left -= monthlyPayment - interest;
            }
            investedValues.push(left);
            finalValues.push(interestTotal);
            years.push(i)
            console.log(i + ".\t" + left.toFixed(2) + " Kč\t" + interestTotal.toFixed(2) + " Kč" + ".\t" + fortnie);
        }
        let ctx = document.getElementById('icChart').getContext('2d');
        if (null === icChart) {
            icChart = new Chart(ctx,{
                type: 'bar',
                data: {
                    labels: years,
                    datasets: [{
                        label: 'Zůstatek hypoteční splátky',
                        data: investedValues,
                        backgroundColor: '#353535'
                    }, {
                        label: 'Úrok celkem',
                        data: finalValues,
                        backgroundColor: '#A3A3A3',
                        font: {
                            weight: 'bold'
                        },
                        pointLabels: {
                            fontSize: 18
                        }
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: false
                        },
                        legend: {
                            labels: {
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    let value = Math.round(tooltipItem.raw);
                                    if (value >= 1000) {
                                        return tooltipItem.dataset.label + ": " + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' Kč'
                                    } else {
                                        return tooltipItem.dataset.label + ": " + value + ' Kč'
                                    }
                                },
                                title: function(tooltipItem, data) {
                                    return "Počet let: " + tooltipItem[0].label
                                }
                            }
                        }
                    },
                    responsive: true,
                    
                }
            })
        } else {
            icChart.data.labels = years;
            icChart.data.datasets[0].data = investedValues;
            icChart.data.datasets[1].data = finalValues;
            icChart.update()
        }
    }

    function redrawFicChart(investmentYears, goalInvestment, startInvestment, annualInterestRate){
        var months = investmentYears * 12;
        var monthlyReturn = Math.pow(1 + annualInterestRate, 1/12) -1;
        var monthlyContribution = (goalInvestment - startInvestment * Math.pow(1 + monthlyReturn, months)) / ((Math.pow(1 + monthlyReturn, months) - 1) / monthlyReturn);
        console.log("mesicne: " + monthlyContribution + ".\t" + investmentYears + ".\t" + goalInvestment + ".\t" + startInvestment + ".\t" + annualInterestRate);
        var totalInvested = startInvestment + monthlyContribution * months;
        var totalReturn = goalInvestment - totalInvested;
        console.log("investováno : " + numberWithSpaces(totalInvested) + "  zhodnoceno : " + numberWithSpaces(totalReturn));

        let ctx = document.getElementById('ficChart').getContext('2d');
        if (null === icChart) {
            icChart = new Chart(ctx, {
                type: "pie",
                data: {
                  labels: ["Zhodnocení", "Investováno"],
                  datasets: [
                    {
                      data: [totalReturn, totalInvested],
                      backgroundColor: ["#353535", "#A3A3A3"],
                      borderWidth: 5,
                    },
                  ],
                },
              });
        } else {
            icChart.data.datasets[0].data = [totalReturn, totalInvested];
            icChart.update()
        }
    }
    function redrawRentChart(renta, startInvestment, annualInterestRate){
            var monthlyInterestRate = annualInterestRate / 12;
            var numberOfPayments = Math.log(renta / (renta - startInvestment * monthlyInterestRate)) / Math.log(1 + monthlyInterestRate);
            var totalInterest = 0;
            var left = startInvestment;
            for (var i = 0; i < numberOfPayments; i++) {
              var interest = left * monthlyInterestRate;
              totalInterest += interest;
              left -= renta - interest;
            }
        let ctx = document.getElementById('ficChart').getContext('2d');
        if (null === icChart) {
            icChart = new Chart(ctx, {
                type: "pie",
                data: {
                  labels: ["Zhodnocení", "Investováno"],
                  datasets: [
                    {
                      data: [totalInterest, startInvestment],
                      backgroundColor: ["#353535", "#A3A3A3"],
                      borderWidth: 5,
                    },
                  ],
                },
              });
        } else {
            icChart.data.datasets[0].data = [totalInterest, startInvestment];
            icChart.update()
        }
    }
    function numberWithSpaces(x) {
        let parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        return parts.join(".")
    }
    function resetCalculator(id) {
        let calculator = document.getElementById(id);
        if (null !== calculator) {
            calculator.reset()
        }
    }


    //SLIDERY
    var slider = document.getElementById("slider-start-investment");
    var output = document.getElementById("start-investment");
    output.value = slider.value;

    slider.oninput = function(){
        output.value = this.value;
        recountRentCalculator();
        recountFinancialIndependenceCalculator();
    }

    output.oninput = function(){
        slider.value = this.value;
    }
    var slider2 = document.getElementById("slider-goal-investment");
    var output2 = document.getElementById("goal-investment");
    output2.value = slider2.value;

    slider2.oninput = function(){
        output2.value = this.value;
        recountRentCalculator();
        recountFinancialIndependenceCalculator();
    }

    output2.oninput = function(){
        slider2.value = this.value;
    }

    
});

