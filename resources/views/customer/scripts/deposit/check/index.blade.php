<script type="text/javascript">
    let tables = {
        list_check_deposit: $("#list_check_deposit"),
        list_checks: $("#liste_checks")
    }
    let elements = {
        gauge: document.querySelector('#chart_gauge_deposit'),
        btnViewCheck: document.querySelectorAll('.viewCheck'),
        btnDeleteDeposit: document.querySelectorAll('.deleteDeposit'),
    }
    let modals = {
        modalViewCheck: document.querySelector('#viewCheck'),
    }
    let forms = {
        formCheckDeposit: $("#formCheckDeposit")
    }

    let blocks = {
        blockTableCheck: new KTBlockUI(document.querySelector("#liste_checks_content"), {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement de la liste des chèques...</div>',
        })
    }

    am5.ready(function () {
        let root = am5.Root.new('chart_gauge_deposit')

        let chart = root.container.children.push(am5radar.RadarChart.new(root, {
            panX: false,
            panY: false,
            startAngle: 160,
            endAngle: 380
        }));

        let axisRenderer = am5radar.AxisRendererCircular.new(root, {
            innerRadius: 0
        });

        axisRenderer.grid.template.setAll({
            stroke: root.interfaceColors.get("background"),
            visible: true,
            strokeOpacity: 0.8
        });

        let xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
            maxDeviation: 0,
            min: 0,
            max: {{ $customer->info->type == 'part' ? \App\Helper\CustomerDepositCheckHelper::$limit_deposit_month_part : \App\Helper\CustomerDepositCheckHelper::$limit_deposit_month_pro }},
            strictMinMax: true,
            renderer: axisRenderer
        }));

        let axisDataItem = xAxis.makeDataItem({});

        let clockHand = am5radar.ClockHand.new(root, {
            pinRadius: am5.percent(20),
            radius: am5.percent(100),
            bottomWidth: 40
        })

        let bullet = axisDataItem.set("bullet", am5xy.AxisBullet.new(root, {
            sprite: clockHand
        }));

        xAxis.createAxisRange(axisDataItem);

        let label = chart.radarContainer.children.push(am5.Label.new(root, {
            fill: am5.color(0x000000),
            centerX: am5.percent(50),
            textAlign: "center",
            centerY: am5.percent(-50),
            fontSize: "3em"
        }));

        axisDataItem.set("value", {{ \App\Helper\CustomerDepositCheckHelper::getAmountMonthDeposit($customer) }});

        bullet.get("sprite").on("rotation", function () {
            var value = axisDataItem.get("value");
            var text = Math.round(axisDataItem.get("value")).toString();
            var fill = am5.color(0x000000);
            xAxis.axisRanges.each(function (axisRange) {
                if (value >= axisRange.get("value") && value <= axisRange.get("endValue")) {
                    fill = axisRange.get("axisFill").get("fill");
                }
            })

            label.set("text", new Intl.NumberFormat('fr-FR', {
                style: 'currency',
                currency: 'eur'
            }).format(Math.round(value).toString()));

            clockHand.pin.animate({key: "fill", to: fill, duration: 500, easing: am5.ease.out(am5.ease.cubic)})
            clockHand.hand.animate({key: "fill", to: fill, duration: 500, easing: am5.ease.out(am5.ease.cubic)})
        });

        var bandsData = [{
            title: "Unsustainable",
            color: "#ee1f25",
            lowScore: {{ $customer->info->type == 'part' ? 8000 : 80000 }},
            highScore: {{ $customer->info->type == 'part' ? 10000 : 100000 }}
        }, {
            title: "Volatile",
            color: "#f04922",
            lowScore: {{ $customer->info->type == 'part' ? 6000 : 60000 }},
            highScore: {{ $customer->info->type == 'part' ? 8000 : 80000 }}
        }, {
            title: "Foundational",
            color: "#fdae19",
            lowScore: {{ $customer->info->type == 'part' ? 4000 : 40000 }},
            highScore: {{ $customer->info->type == 'part' ? 6000 : 60000 }}
        }, {
            title: "Developing",
            color: "#f3eb0c",
            lowScore: {{ $customer->info->type == 'part' ? 3000 : 30000 }},
            highScore: {{ $customer->info->type == 'part' ? 4000 : 40000 }}
        }, {
            title: "Maturing",
            color: "#b0d136",
            lowScore: {{ $customer->info->type == 'part' ? 2000 : 20000 }},
            highScore: {{ $customer->info->type == 'part' ? 3000 : 30000 }}
        }, {
            title: "Sustainable",
            color: "#54b947",
            lowScore: {{ $customer->info->type == 'part' ? 1000 : 10000 }},
            highScore: {{ $customer->info->type == 'part' ? 500 : 5000 }}
        }, {
            title: "High Performing",
            color: "#0f9747",
            lowScore: 0,
            highScore: {{ $customer->info->type == 'part' ? 500 : 5000 }}
        }];

        am5.array.each(bandsData, function (data) {
            var axisRange = xAxis.createAxisRange(xAxis.makeDataItem({}));

            axisRange.setAll({
                value: data.lowScore,
                endValue: data.highScore
            });

            axisRange.get("axisFill").setAll({
                visible: true,
                fill: am5.color(data.color),
                fillOpacity: 0.8
            });

            axisRange.get("label").setAll({
                text: data.title,
                inside: true,
                radius: 15,
                fontSize: "0.9em",
                fill: root.interfaceColors.get("background")
            });
        });

        chart.appear(1000, 100);
    })

    $('#kt_docs_repeater_basic').repeater({
        initEmpty: false,

        defaultValues: {
            'text-input': 'foo'
        },

        show: function (createElement) {
            $(this).slideDown(createElement);
        },

        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });

    tables.list_check_deposit.dataTable()

    if (elements.btnViewCheck) {
        elements.btnViewCheck.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                let id = e.target.dataset.deposit
                console.log(id)
                let modal = new bootstrap.Modal(modals.modalViewCheck)
                modal.show()

                modals.modalViewCheck.addEventListener('shown.bs.modal', e => {
                    console.log(id)
                    reloadTableCheck(id)
                })
            })
        })
    }
    if(elements.btnDeleteDeposit) {
        elements.btnDeleteDeposit.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                Swal.fire({
                    title: 'Tapez votre code SECURPASS',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Valider',
                    showLoaderOnConfirm: true,
                    preConfirm: (code) => {
                        btn.attr('data-kt-indicator', 'on')
                        $.ajax({
                            url: '/api/customer/verifSecure/' + code,
                            method: 'POST',
                            data: {'customer_id': {{ $customer->id }}},
                            success: data => {
                                console.log(data)
                                $.ajax({
                                    url: `/api/deposit/checks/${e.target.dataset.deposit}`,
                                    method: 'POST',
                                    data: dataset,
                                    success: data => {
                                        btn.removeAttr('data-kt-indicator')
                                        console.log(data)

                                        toastr.success(`La remise de Chèque ${data.reference} à été supprimer avec succès`, null, {
                                            "positionClass": "toastr-bottom-right",
                                        })

                                        setTimeout(() => {
                                            window.location.reload()
                                        }, 1000)
                                    },
                                    error: err => {
                                        btn.removeAttr('data-kt-indicator')
                                        const errors = err.responseJSON.errors

                                        Object.keys(errors).forEach(key => {
                                            toastr.error(errors[key][0], "Champs: " + key, {
                                                "positionClass": "toastr-bottom-right",
                                            })
                                        })
                                    }
                                })
                            },
                            error: err => {
                                btn.removeAttr('data-kt-indicator')
                                const errors = err.responseJSON.errors

                                Object.keys(errors).forEach(key => {
                                    toastr.error(errors[key], null, {
                                        "positionClass": "toastr-bottom-right",
                                    })
                                })
                            }
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading(),
                    backdrop: true
                }).then((result) => {
                    console.log(result)
                })
            })
        })
    }

    forms.formCheckDeposit.on('submit', e => {
        e.preventDefault()
        let form = forms.formCheckDeposit
        let url = form.attr('action')
        let dataset = form.serializeArray()
        let btn = form.find('.btn-bank')

        Swal.fire({
            title: 'Tapez votre code SECURPASS',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Valider',
            showLoaderOnConfirm: true,
            preConfirm: (code) => {
                btn.attr('data-kt-indicator', 'on')
                $.ajax({
                    url: '/api/customer/verifSecure/' + code,
                    method: 'POST',
                    data: {'customer_id': {{ $customer->id }}},
                    success: data => {
                        console.log(data)
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: dataset,
                            success: data => {
                                btn.removeAttr('data-kt-indicator')
                                console.log(data)

                                toastr.success(`La remise de Chèque ${data.reference} à été ajouté avec succès`, null, {
                                    "positionClass": "toastr-bottom-right",
                                })

                                setTimeout(() => {
                                    window.location.reload()
                                }, 1000)
                            },
                            error: err => {
                                btn.removeAttr('data-kt-indicator')
                                const errors = err.responseJSON.errors

                                Object.keys(errors).forEach(key => {
                                    toastr.error(errors[key][0], "Champs: " + key, {
                                        "positionClass": "toastr-bottom-right",
                                    })
                                })
                            }
                        })
                    },
                    error: err => {
                        btn.removeAttr('data-kt-indicator')
                        const errors = err.responseJSON.errors

                        Object.keys(errors).forEach(key => {
                            toastr.error(errors[key], null, {
                                "positionClass": "toastr-bottom-right",
                            })
                        })
                    }
                })
            },
            allowOutsideClick: () => !Swal.isLoading(),
            backdrop: true
        }).then((result) => {
            console.log(result)
        })
    })

    function reloadTableCheck(id) {
        blocks.blockTableCheck.block()

        $.ajax({
            url: `/api/deposit/checks/${id}/checks`,
            success: data => {
                //console.log(data)
                modals.modalViewCheck.querySelector("[data-content='title']").innerHTML = `Remise de chèque N°${data.deposit.reference}`
                let content = document.querySelector("#liste_checks").querySelector('#liste_checks_content');
                content.innerHTML = ``;
                data.lists.forEach(list => {
                    content.innerHTML += `
                                    <tr>
                                        <td>${list.number}</td>
                                        <td>${new Intl.NumberFormat('fr-FR', {
                        style: 'currency',
                        currency: 'eur'
                    }).format(list.amount)}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bolder">${list.name_deposit}</span>
                                                <span class="text-muted">${list.bank_deposit}</span>
                                            </div>
                                        </td>
                                        <td>${list.date_deposit_format}</td>
                                        <td>${list.is_verified_label}</td>
                                        <td></td>
                                    </tr>
                                `
                })
                tables.list_checks.DataTable()
                blocks.blockTableCheck.release()
            }
        })
    }
</script>
