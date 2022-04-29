<script type="text/javascript">
    let buttons = {
        btnVerify: document.querySelector('#btnVerify')
    }

    buttons.btnVerify.addEventListener('click', e => {
        e.preventDefault()
        e.target.setAttribute('data-kt-indicator', 'on')

        $.ajax({
            url: e.target.getAttribute('href'),
            success: data => {
                e.target.removeAttribute('data-kt-indicator')
                console.log(data)
            }
        })
    })
</script>
