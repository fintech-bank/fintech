<script type="text/javascript">
    let stepperElement = {
        stepperPart: document.querySelector('#stepper_part'),
        stepperPro: document.querySelector('#stepper_pro'),
    }

    // Initialize Stepper
    let stepperInit = {
        stepPart: new KTStepper(stepperElement.stepperPart),
        stepPro: new KTStepper(stepperElement.stepperPro),
    }

    // Handle next step
    stepperInit.stepPart.on("kt.stepper.next", function (stepper) {
        stepper.goNext(); // go next step
        console.log(stepper.getCurrentStepIndex())
    });

    // Handle previous step
    stepperInit.stepPart.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious(); // go previous step
        console.log(stepper.getCurrentStepIndex())
    });

    stepperInit.stepPart.on("kt.stepper.click", function (stepper) {
        stepper.goTo(stepper.getClickedStepIndex()); // go to clicked step
        console.log(stepper.getCurrentStepIndex())
    });

    // Handle next step
    stepperInit.stepPro.on("kt.stepper.next", function (stepper) {
        stepper.goNext(); // go next step
        console.log(stepper.getCurrentStepIndex())
    });

    // Handle previous step
    stepperInit.stepPro.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious(); // go previous step
        console.log(stepper.getCurrentStepIndex())
    });

    stepperInit.stepPro.on("kt.stepper.click", function (stepper) {
        stepper.goTo(stepper.getClickedStepIndex()); // go to clicked step
        console.log(stepper.getCurrentStepIndex())
    });

    $("#part").fadeOut()
    $("#pro").fadeOut()

    const getTypeAccount = () => {
        let type_account = ""
        document.querySelectorAll('[name="type"]').forEach((input => {
            input.checked && (type_account = input.value)
        }))

        if(type_account === 'part') {
            $("#part").fadeIn()
            $("#pro").fadeOut()
        } else {
            $("#part").fadeOut()
            $("#pro").fadeIn()
        }
    }

    let countryBirthOptions = (item) => {
        if ( !item.id ) {
            return item.text;
        }

        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-kt-select2-country');
        let template = '';

        template += '<img src="' + imgUrl + '" class="rounded-circle w-20px h-20px me-2" alt="image" />';
        template += item.text;

        span.innerHTML = template;

        return $(span);
    }

    let cardsOptions = (item) => {
        if ( !item.id ) {
            return item.text;
        }

        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-card-img');
        let template = '';

        template += '<img src="' + imgUrl + '" class="rounded w-auto h-50px me-2" alt="image" />';
        template += item.text;

        span.innerHTML = template;

        return $(span);
    }

    let countryOptions = (item) => {
        if ( !item.id ) {
            return item.text;
        }

        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-kt-select2-country');
        let template = '';

        template += '<img src="' + imgUrl + '" class="rounded-circle w-20px h-20px me-2" alt="image" />';
        template += item.text;

        span.innerHTML = template;

        return $(span);
    }

    let citiesFromCountry = (select) => {
        console.log(select.value)
        let contentCities = document.querySelector('#divCities')
        $.ajax({
            url: '/api/geo/cities',
            method: 'post',
            data: {"country": select.value},
            success: data => {
                console.log(data)
                contentCities.innerHTML = data
                $("#citybirth").select2()
            }
        })
    }

    let citiesFromPostal = (select) => {
        let contentCities = document.querySelector('#divCity')
        let block = new KTBlockUI(contentCities, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement...</div>',
        })
        block.block();

        $.ajax({
            url: '/api/geo/cities/'+select.value,
            success: data => {
                block.release()
                contentCities.innerHTML = data
                $("#city").select2()
            }
        })
    }

    document.querySelectorAll('[name="postal"]').forEach(input => {
        input.addEventListener('keyup', e => {
            console.log(e.target.value.length)
            if(e.target.value.length === 5) {
                citiesFromPostal(e.target)
            }
        })
    })

    $("#countrybirth").select2({
        templateSelection: countryBirthOptions,
        templateResult: countryBirthOptions
    })

    $("#country").select2({
        templateSelection: countryOptions,
        templateResult: countryOptions
    })

    $("#card_support").select2({
        templateSelection: cardsOptions,
        templateResult: cardsOptions
    })

    $("#formAddCustomerPart").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddCustomerPart")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('[data-kt-stepper-action="submit"]')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: () => {
                btn.removeAttr('data-kt-indicator')
                window.location.href='{{ route('agent.customer.index') }}'
            }
        })
    })
</script>
