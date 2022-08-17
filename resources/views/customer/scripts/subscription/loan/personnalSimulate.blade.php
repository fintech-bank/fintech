<script type="text/javascript">
    let tables = {}
    let elements = {
        slider_mensuality: document.querySelector("#slider_mensuality"),
        slider_duration: document.querySelector("#slider_duration"),
        input_amount: document.querySelector("[name='amount']"),
        input_duration: document.querySelector("[name='duration']"),
        contents: {
            amount_loan: document.querySelector('[data-content="amount_loan"]'),
            mensuality_duration_text: document.querySelector('[data-content="mensuality_duration_text"]'),
            mensuality: document.querySelector('[data-content="mensuality"]'),
            mensuality_duration: document.querySelector('[data-content="mensuality_duration"]'),
            taeg: document.querySelector('[data-content="taeg"]'),
            amount_du: document.querySelector('[data-content="amount_du"]'),
        },
        btnSubmit: document.querySelector('#btnSubmit')
    }
    let modals = {}
    let forms = {}
    let blocks = {
        block_resultat: document.querySelector('#block_resultat')
    }

    let updateResult = (duration) => {
        if(duration) {
            $.ajax({
                url: '/api/pret/simulate/personnal',
                method: 'POST',
                data: {'amount': elements.input_amount.value, 'duration': duration},
                success: data => {
                    elements.contents.amount_loan.innerHTML = data.amount_loan
                    elements.contents.mensuality_duration_text.innerHTML = data.mensuality_duration_text
                    elements.contents.mensuality.innerHTML = new Intl.NumberFormat('fr', {style: 'currency', currency: 'EUR'}).format(data.mensuality)
                    elements.contents.mensuality_duration.innerHTML = data.mensuality_duration
                    elements.contents.taeg.innerHTML = data.taeg
                    elements.contents.amount_du.innerHTML = data.amount_du

                    elements.btnSubmit.classList.remove('d-none')
                }
            })
        } else {
            $.ajax({
                url: '/api/pret/simulate/personnal',
                method: 'POST',
                data: {'amount': elements.input_amount.value},
                success: data => {
                    console.log(data)
                }
            })
        }
    }

    elements.btnSubmit.classList.add('d-none')

    elements.input_amount.addEventListener('blur', e => {
        e.preventDefault()

        $.ajax({
            url: '/api/pret/simulate/personnal',
            method: 'POST',
            data: {'amount': e.target.value},
            success: data => {
                noUiSlider.create(elements.slider_duration, {
                    start: 0,
                    connect: true,
                    range: {
                        "min": 12,
                        "max": {{ $loan_plan->duration }}
                    },
                    pips: {
                        mode: "values",
                        values: [12, {{ $loan_plan->duration }}],
                        density: 4
                    },
                    step: 12
                });

                elements.contents.amount_loan.innerHTML = data.amount_loan
                elements.contents.mensuality_duration_text.innerHTML = data.mensuality_duration_text
                elements.contents.mensuality.innerHTML = new Intl.NumberFormat('fr', {style: 'currency', currency: 'EUR'}).format(data.mensuality)
                elements.contents.mensuality_duration.innerHTML = data.mensuality_duration
                elements.contents.taeg.innerHTML = data.taeg
                elements.contents.amount_du.innerHTML = data.amount_du
                elements.input_duration.value = 12+' mois'

                elements.slider_duration.noUiSlider.on('update', (values, handle) => {
                    elements.input_duration.value = parseInt(values[handle])
                })

                elements.slider_duration.noUiSlider.on('change', (values, handle) => {
                    updateResult(parseInt(values[handle]))
                })
                elements.btnSubmit.classList.remove('d-none')
            }
        })

    })

    elements.btnSubmit.addEventListener('click', e => {
        e.preventDefault()
        elements.btnSubmit.setAttribute('data-kt-indicator', 'on')

        $.ajax({
            url: '/api/pret/simulate/personnal/check',
            method: 'POST',
            data: {
                'amount': elements.input_amount.value,
                'customer_id': {{ $customer->id }},
                'duration': elements.input_duration.value
            },
            success: data => {
                elements.btnSubmit.removeAttribute('data-kt-indicator')
                console.log(data)
            },
            error: err => {
                elements.btnSubmit.removeAttribute('data-kt-indicator')
                const errors = err.responseJSON.errors

                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key], "Souscription Impossible", {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    })
</script>
