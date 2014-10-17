$(document).ready(function(){
    $('#change').click(function() {
        $('#lg').find('.suspensor').attr('fill','red')
        $('#lg').find('.vascular-initials').attr('fill','green')
        $('#lg').find('.vascular').attr('fill','blue')
    })
});