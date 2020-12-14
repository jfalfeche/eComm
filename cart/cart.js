function checkStock(q,mode) {
    let x = product[parseInt(q)];
    let y = document.getElementById(`quantity${q}`).value;
    $.get('update_cart.php', // checks stock on update_cart.php
    {
        check:'true',
        action:x, 
        quantity:y
    }, function(d){
        $(`#checker`).html(d); // displays validity of quantity inputted on checker
        let c = document.getElementById('checker'); // gets quantity of checker
        if(mode == 'button') { // if button is pressed
            if(parseInt(document.getElementById(`quantity${q}`).value) >= (quantity[parseInt(q)] + parseInt(c.innerHTML))) { // if quantity is greater than stock
                alert("Invalid quantity.");
            } else {
                document.getElementById(`quantity${q}`).stepUp();
            }
        } else if(mode == 'type') { // if quantity was typed
            if(parseInt(document.getElementById(`quantity${q}`).value) > (quantity[parseInt(q)] + parseInt(c.innerHTML))) {
                alert("Invalid quantity.");
                document.getElementById(`quantity${q}`).value = (quantity[parseInt(q)] + parseInt(c.innerHTML));
            }
        }
        updateAll(q);
    });
}

function updateGrandTotal() {
    grandTotal = 0;
    for(i = 0; i < total.length; i++){
        grandTotal += total[i];
    }
    grandTotal = grandTotal.toFixed(2);
    document.getElementById('grandTotal').innerHTML = grandTotal;
}

function updateTotal(q) {
    var tot = document.getElementById(`total${q}`);
    total[parseInt(q)] = document.getElementById(`quantity${q}`).value * price[parseInt(q)];
    final = (Math.round(total[parseInt(q)] * 100) / 100).toFixed(2);
    tot.innerHTML = final;
}

function updateDatabase(q) {
    var x = product[parseInt(q)];
    var y = document.getElementById(`quantity${q}`).value;
    $.get('update_cart.php',
    {
        update:'true',
        action:x, 
        quantity:y
    }, function(d){
        $(`#quantity${q}`).html(d);
    });
}

function updateAll(q) {
    quantity[parseInt(q)] = parseInt(document.getElementById(`quantity${q}`).value);
    updateTotal(q);
    updateGrandTotal();
    updateDatabase(q);
}

document.addEventListener("DOMContentLoaded", function () 
{
    $('button').on('click', function(e){
        e.preventDefault();
        q = this.id.substring(1);
        if (this.id.charAt(0) == '0') {
            if(parseInt(document.getElementById(`quantity${q}`).value) <= 1) {
                alert("Invalid quantity.");
                return;
            } else {
                document.getElementById(`quantity${q}`).stepDown();
                updateAll(q);
            }
        } else if (this.id.charAt(0) == '1') {
            checkStock(q,'button');
        }
    })

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