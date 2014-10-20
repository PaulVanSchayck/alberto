$(document).ready(function(){
    $('#change').click(function() {
        testCellTypes($("#lg"));

        testCellTypes($("#eg"));



    })
});

function testCellTypes($img) {
    $img.find('.suspensor').attr('fill','red');
    $img.find('.vascular-initials').attr('fill','green');
    $img.find('.vascular').attr('fill','blue');
    $img.find('.ground-initials').attr('fill','grey');
    $img.find('.ground').attr('fill','purple');
    $img.find('.inner-upper').attr('fill','black');
    $img.find('.protoderm').attr('fill','yellow');
    $img.find('.hypophysis').attr('fill','white');
    $img.find('.qc').attr('fill','gold');
    $img.find('.columella').attr('fill','darkred');
}