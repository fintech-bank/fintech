<script type="text/javascript">
    // This is your test publishable API key.
    const stripe = Stripe("{{ config('services.stripe.api_key') }}");

    let Elements;

    checkStatus();

    document.querySelector('[name="amount"]').addEventListener('blur', initialize)

    document
        .querySelector("#formRefundAccount")
        .addEventListener("submit", handleSubmit);

    // Fetches a payment intent and captures the client secret
    async function initialize() {
        const items = [{ amount: document.querySelector('[name="amount"]').value }];
        const { clientSecret } = await fetch("/api/wallet/{{ $wallet->id }}/refundAccount", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ items }),
        }).then((r) => r.json());

        Elements = stripe.elements({ clientSecret });

        const paymentElement = Elements.create("payment");
        paymentElement.mount("#payment-element");
    }

    async function handleSubmit(e) {
        e.preventDefault();
        console.log(Elements)
        debugger
        setLoading(true);

        const { error } = await stripe.confirmPayment({
            Elements.getElement('payment'),
            confirmParams: {
                // Make sure to change this to your payment completion page
                return_url: "{{ route('customer.wallet.index', $wallet->id) }}",
            },
        });

        // This point will only be reached if there is an immediate error when
        // confirming the payment. Otherwise, your customer will be redirected to
        // your `return_url`. For some payment methods like iDEAL, your customer will
        // be redirected to an intermediate site first to authorize the payment, then
        // redirected to the `return_url`.
        if (error.type === "card_error" || error.type === "validation_error") {
            showMessage(error.message);
        } else {
            showMessage("An unexpected error occurred.");
        }

        setLoading(false);
    }

    // Fetches the payment intent status after payment submission
    async function checkStatus() {
        const clientSecret = new URLSearchParams(window.location.search).get(
            "payment_intent_client_secret"
        );

        if (!clientSecret) {
            return;
        }

        const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

        switch (paymentIntent.status) {
            case "succeeded":
                showMessage("Payment succeeded!");
                break;
            case "processing":
                showMessage("Your payment is processing.");
                break;
            case "requires_payment_method":
                showMessage("Your payment was not successful, please try again.");
                break;
            default:
                showMessage("Something went wrong.");
                break;
        }
    }

    // ------- UI helpers -------

    function showMessage(messageText) {
        const messageContainer = document.querySelector("#payment-message");

        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;

        setTimeout(function () {
            messageContainer.classList.add("hidden");
            messageText.textContent = "";
        }, 4000);
    }

    // Show a spinner on payment submission
    function setLoading(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#formRefundAccount").querySelector("#spinner").setAttribute('data-kt-indicator', 'on');

        } else {
            document.querySelector("#formRefundAccount").querySelector("#spinner").removeAttribute('data-kt-indicator');
        }
    }
</script>
