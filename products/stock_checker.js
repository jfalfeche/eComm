function checkStock(q,mode) {
    let y = document.getElementById(`quantity`).value;
    $.get('stock_checker.php', // checks stock on update_cart.php
    {
        check:'true',
        action:x, 
        quantity:y
    }, function(d){
        $(`#checker`).html(d); // displays validity of quantity inputted on checker
        if(mode == 'button') { // if button is pressed
            if(parseInt(document.getElementById(`quantity`).value) >= parseInt(checker)) { // if quantity is greater than stock
                alert("Invalid quantity.");
                document.getElementById(`quantity`).value = parseInt(checker);
                document.getElementById(`stock_count`).innerHTML = checker;
            } else {
                document.getElementById(`quantity`).stepUp();
            }
        } else if(mode == 'type') { // if quantity was typed
            if(parseInt(document.getElementById(`quantity`).value) > parseInt(checker)) {
                alert("Invalid quantity.");
                document.getElementById(`quantity`).value =  parseInt(checker);
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", function () 
{
    $('button#0').on('click', function(e)){
        e.preventDefault();
        if(parseInt(document.getElementById(`quantity`).value) <= 1) {
            alert("Invalid quantity.");
            return;
        } else {
            document.getElementById(`quantity`).stepDown();
        }
    }

    $('button#1').on('click', function(e)){
        e.preventDefault();
        checkStock(1,'button');
    }

    $('input').on('keyup', function() {
        q = this.id.substring(8); // id no
        
        if(parseInt(this.value) >= 1){
        } else {
            alert("Invalid quantity.");
            this.value = 1;
        }
        checkStock(q,'type');
    }) 
})