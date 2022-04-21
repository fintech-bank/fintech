<script type="text/javascript">
    let modal = {
        modalShowSubcategory: document.querySelector("#show_subcategory"),
        modalAddCategory: document.querySelector("#add_category")
    }

    let btn = {
        btnSub: document.querySelectorAll('.sub'),
        btnEdit: document.querySelectorAll('.edit'),
        btnDelete: document.querySelectorAll('.delete'),
    }

    btn.btnSub.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()

            $.ajax({
                url: `/admin/cms/category/${e.target.dataset.category}/subcategory`,
                success: data => {

                }
            })
        })
    })
</script>
