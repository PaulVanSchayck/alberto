$(document).ready(function(){
    $('#change').click(function() {
        $lg = $("#lg");
        $lg.find('.suspensor').attr('fill','red');
        $lg.find('.vascular-initials').attr('fill','green');
        $lg.find('.vascular').attr('fill','blue');
        $lg.find('.ground-initials').attr('fill','grey');
        $lg.find('.ground').attr('fill','purple');
        $lg.find('.inner-upper').attr('fill','black');
        $lg.find('.protoderm').attr('fill','yellow');
        $lg.find('.hypophysis').attr('fill','white');
        $lg.find('.columella').attr('fill','darkred');
    })
});