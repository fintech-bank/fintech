<script type="text/javascript">
    let tables = {}
    let elements = {
        items: document.querySelector('#documentCat').querySelectorAll('.menu-item')
    }
    let modals = {}
    let forms = {}

    elements.items.forEach(item => {
        item.addEventListener('click', e => {
            e.preventDefault()
            let category = item.dataset.category

            $.ajax({
                url: `/api/documents/lists`,
                method: 'POST',
                data: {'category': category, 'customer_id': {{ $customer->id }}},
                success: data => {
                    $("#documents").html(data.html)
                }
            })
        })
    })
</script>
