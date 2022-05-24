jQuery(function ($) {
    if($( ".job-salary-range-slider" ).length) {
        //Salary Range Slider

        $(".job-salary-range-slider").each(function () {
            var min = $(this).attr('data-min');
            var max = $(this).attr('data-max');
            var from = $(this).attr('data-from');
            var to = $(this).attr('data-to');

            $(this).slider({
                range: true,
                min: parseFloat(min),
                max: parseFloat(max),
                values: [parseFloat(from),parseFloat(to) ],
                slide: function (event, ui) {
                    $(".job-salary-amount .min").text(bc_format_money(ui.values[0]));
                    $(".job-salary-amount .max").text(bc_format_money(ui.values[1]));
                    $("input[name=amount_from]").val(ui.values[0]);
                    $("input[name=amount_to]").val(ui.values[1]);
                }
        });

    });

        $(".job-salary-amount .min").text(bc_format_money($(".job-salary-range-slider").slider("values", 0)));
        $(".job-salary-amount .max").text(bc_format_money($(".job-salary-range-slider").slider("values", 1)));
    }
})