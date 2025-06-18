$(document).ready(function(){
    
    $('#cep').mask('00000-000');

    $("#submit_coupon").on('click', function (event) {
        let input_coupon = $("#input_coupon").val();

        if(input_coupon.length <= 0 ){
            Swal.fire({
                title: "Código de Cupom inválido",
                text: "Por favor inserir um código de cupom válido",
                icon: "warning"
            });
        }else{
            getCouponDiscount(input_coupon);
        }
    });

    $("#checkout").on("click", function (){
        const checkout_button = $(this).children("#registerOrder");
        
        if(!$(checkout_button).prop('disabled')) {
            checkout();
        }
        
    });

    $("#getCep").on('click', function(){
        const value_cep = $('#cep').val();
        
        if(value_cep == '') {
            Swal.fire({
                title: "CEP requerido",
                text: "Por favor inserir um CEP válido",
                icon: "warning"
            });
        }else{
            let splitted_cep = value_cep.split("-");
            let joinedCep = splitted_cep[0].concat(splitted_cep[1]);

            getCEP(joinedCep);
        }
    });
});

function checkout() {
    fetch('/sell?method=add', {
        method: "GET",
        headers: {
            'Content-Type' : 'application/json',
        },
    }).then(response => {
        if(!response.ok){
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    }).then( data => {
        if(data['status'] == 200){
            Swal.fire({
                title: data['message'],
                text: "Compra foi finalizada com sucesso",
                icon: "success"
            });
            setDiscountInTable(data['coupon']);
        }else{
            Swal.fire({
                title: "Erro na Compra",
                text: "Ocorreu um erro na compra",
                icon: "error"
            });    
        }
    }).catch(error => {
        Swal.fire({
            title: "Erro no Cupom",
            text: "Ocorreu um erro no cupom",
            icon: "error"
        });
    })
}

function getCEP(cep) {
    fetch('/cep?postal_code='+cep, {
        method: "GET",
        headers: {
            'Content-Type' : 'application/json',
            'Accept': 'application/json'
        },
    }).then(response => {
        if(!response.ok){
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return response.json();
    }).then( data => {
        if(data['status'] == 200) {
            Swal.fire({
                title: data['message'],
                text: "Cep encontrado com sucesso",
                icon: "success"
            });
            setAddressScreen(data['data']);
        }else if(data['status'] == 400){
            Swal.fire({
                title: data['message'],
                text: "Erro na busca por cep",
                icon: "error"
            });
        }
    }).catch(error => {
        Swal.fire({
            title: "Erro no CEP",
            text: "Ocorreu um erro na busca pelo cep",
            icon: "error"
        });
    });
}

function getCouponDiscount(coupon_code) {
    fetch('/sell?method=coupon', {
        method: "POST",
        headers: {
            'Content-Type' : 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(coupon_code),
    }).then(response => {
        if(!response.ok){
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return response.json();
    }).then( data => {
        Swal.fire({
            title: data['message'],
            text: "Produto foi adicionado no carrinho.",
            icon: "success"
        });
        setDiscountInTable(data['coupon']);
    }).catch(error => {
        Swal.fire({
            title: "Erro no Cupom",
            text: "Ocorreu um erro no cupom",
            icon: "error"
        });
    })
}

function setDiscountInTable(coupon) {
    let percentage_discount = (coupon['discount'] * 100);

    $("#discount_coupon").removeClass('d-none');
    $("#discount_coupon").children("#percentage_discount").text(percentage_discount+" %");
    setNewTotalValue(coupon['discount']);
}

function setNewTotalValue(percentage_discount) {
    let text_price_value = $("#final_price").text();
    let text_splitted = text_price_value.split(" ");
    let casted_total_value = parseFloat(text_splitted[1]);

    let final_total_value = (casted_total_value - (percentage_discount * casted_total_value)).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    $("#final_price").text(final_total_value);
}

function setAddressScreen(address) {
    const rua = address['logradouro'];
    const bairro = address['bairro'];
    const cidade = address['localidade'];
    const estado = address['estado'];
    
    $("#address").removeClass('d-none');
    $("#address").text('Endereço: ' + rua + ", " + bairro + ", " + cidade + ", " + estado);
}