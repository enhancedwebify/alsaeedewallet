<script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
></script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
></script>
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script>
    // let tables = new DataTable('#myTable');
    $(document).ready( function () {

        $("table[id^='mydatatable']").DataTable({
            "language": {
                "search": "بحث ",
                "lengthMenu": "عرض _MENU_",
                "pagingType": "full_numbers",
                "info": "يعرض _START_ الى _END_ من الكل _TOTAL_",
                "paginate": {
                    "previous": "السابق",
                    "next": "التالي"
                }
            },
            "pageLength": 100,
            "lengthMenu": [ [10, 25, 50, 100,200, -1], [10, 25, 50,100,200, "الكل"] ]
        });
    } );
    const lightbox = GLightbox({
        touchNavigation: true,
        loop: false,
        autoplayVideos: false
    });
</script>
