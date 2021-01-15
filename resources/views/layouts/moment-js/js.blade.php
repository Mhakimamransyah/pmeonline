<script src="{{ asset('moment.js/moment-with-locales.min.js') }}"></script>
<script>
    moment.locale('id');
    moment.updateLocale(moment.locale(), { invalidDate: "Pilih Tanggal" })
    $("input").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
                .format( this.getAttribute("data-date-format") )
        )
    }).trigger("change")
</script>