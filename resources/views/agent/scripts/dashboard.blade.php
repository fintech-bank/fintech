<script type="text/javascript">
    let messageOverlay = '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargements...</div>'

    let elements = {
        widgets: {
            cardUsers: document.querySelector('.cardAllUser'),
            cardVerifiedUsers: document.querySelector('.cardVerifiedUser'),
            cardDeposit: document.querySelector('.cardDeposit'),
            cardWithdraw: document.querySelector('.cardWithdraw'),
            cardAgency: document.querySelector('.cardAgency'),
            cardLoan: document.querySelector('.cardLoan'),
        },
        charts: {
            chartReport: document.querySelector('#chartReport')
        },
    }

    let blockElements = {
        blockCardUser: new KTBlockUI(elements.widgets.cardUsers, {message: messageOverlay}),
        blockCardVerifiedUser: new KTBlockUI(elements.widgets.cardVerifiedUsers, {message: messageOverlay}),
        blockChartReport: new KTBlockUI(elements.charts.chartReport, {message: messageOverlay}),
        blockCardDeposit: new KTBlockUI(elements.widgets.cardDeposit, {message: messageOverlay}),
        blockCardWithdraw: new KTBlockUI(elements.widgets.cardWithdraw, {message: messageOverlay}),
        blockCardAgency: new KTBlockUI(elements.widgets.cardAgency, {message: messageOverlay}),
        blockCardLoan: new KTBlockUI(elements.widgets.cardLoan, {message: messageOverlay}),
    }

    blockElements.blockCardUser.block()
    blockElements.blockCardVerifiedUser.block()
    blockElements.blockChartReport.block()
    blockElements.blockCardDeposit.block()
    blockElements.blockCardWithdraw.block()
    blockElements.blockCardAgency.block()
    blockElements.blockCardLoan.block()


    let cardUser = () => {
        $.ajax({
            url: '/api/customer',
            method: 'POST',
            data: {'call': 'countAllCustomer'},
            success: data => {
                blockElements.blockCardUser.release()
                elements.widgets.cardUsers.querySelector('.count').innerHTML = data
            },
            error: err => {
                console.error(err)
            }
        })
    }

    let cardUserVerified = () => {
        $.ajax({
            url: '/api/customer',
            method: 'POST',
            data: {'call': 'countAllVerifiedCustomer'},
            success: data => {
                blockElements.blockCardVerifiedUser.release()
                elements.widgets.cardVerifiedUsers.querySelector('.count').innerHTML = data
            },
            error: err => {
                console.error(err)
            }
        })
    }

    let initChartReport = () => {
        let height = parseInt(KTUtil.css(elements.charts.chartReport, 'height'));
        let labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        let borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        let baseColor = KTUtil.getCssVariableValue('--bs-primary');
        let secondaryColor = KTUtil.getCssVariableValue('--bs-warning');

        $.ajax({
            url: '/api/stats',
            success: data => {
                blockElements.blockChartReport.release()
                let options = {
                    series: [{
                        name: 'Total des dépots',
                        data: data.deposit
                    }, {
                        name: 'Total des retraits',
                        data: data.withdraw
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'bar',
                        height: height,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['30%'],
                            endingShape: 'rounded'
                        },
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec'],
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function (val) {
                                return new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'}).format(val)
                            }
                        }
                    },
                    colors: [baseColor, secondaryColor],
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                }
                let chart = new ApexCharts(elements.charts.chartReport, options);
                chart.render()
            }
        })
    }

    let initWidgetStat = () => {
        $.ajax({
            url: '/api/stats',
            success: data => {
                console.log(data)
                blockElements.blockCardDeposit.release()
                blockElements.blockCardWithdraw.release()
                blockElements.blockCardAgency.release()
                blockElements.blockCardLoan.release()

                elements.widgets.cardDeposit.querySelector('.amountAll').innerHTML = data.sumAllDeposit
                elements.widgets.cardDeposit.querySelector('.amountWait').innerHTML = data.sumAllDepositCharge

                elements.widgets.cardWithdraw.querySelector('.amountAll').innerHTML = data.sumAllWithdraw
                elements.widgets.cardWithdraw.querySelector('.amountWait').innerHTML = data.sumAllWithdrawCharge

                elements.widgets.cardAgency.querySelector('.amountAll').innerHTML = data.sumAllTransactionBalance
                elements.widgets.cardLoan.querySelector('.amountAll').innerHTML = data.dispoPret

                if(data.sumAllTransactionBalance <= 0) {
                    elements.widgets.cardAgency.classList.remove('bg-info')
                    elements.widgets.cardAgency.classList.add('bg-danger')
                } else {
                    elements.widgets.cardAgency.classList.remove('bg-info')
                    elements.widgets.cardAgency.classList.add('bg-success')
                }
            }
        })
    }

    cardUser()
    cardUserVerified()
    initChartReport()
    initWidgetStat()

</script>
