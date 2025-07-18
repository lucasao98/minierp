$(document).ready(() => {
    checkFields();
    verifyStatus();
    $('.input-area .add_product_cart').on('click', function(){
        let parent = $(this).parent();
        let product_quantity_value = (parent.children('.product_quantity').val());

        if(product_quantity_value <= 0){
            Swal.fire({
                title: "Erro na Quantidade de Produto",
                text: "Quantidade do Produto não pode ser nulo",
                icon: "error"
            });
        }else{
            const product = {
                id_product: $(this).data('id'),
                product_name: $(this).data('name'),
                product_price: $(this).data('price'),
                product_variation: $(this).data('variation'),
                product_quantity: parseInt(product_quantity_value)
            };

            setProductCart(product);
            $(this).addClass('d-none');
            let remove_cart_button = $(this).siblings('.remove_product_cart')[0];
            $(remove_cart_button).removeClass('d-none');
        }

    });
    
    $('.input-area .remove_product_cart').on('click', function(){
        let parent = $(this).parent();
        parent.children('.product_quantity').val(0);

        const product = {
            id_product: $(this).data('id'),
            product_name: $(this).data('name'),
            product_price: $(this).data('price'),
            product_variation: $(this).data('variation'),
            product_quantity: $(this).val(),
        };

        removeProductCart(product);
        $(this).addClass('d-none');
        let add_cart_button = $(this).siblings('.add_product_cart')[0];
        $(add_cart_button).removeClass('d-none');

    });
});

function checkFields() {
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            
            form.classList.add('was-validated')
        }, false);
    });
}

function verifyStatus(){
    const url = window.location.href;

    if(url.includes('success')){
        Swal.fire({
            title: "Success",
            text: "Produto Foi Salvo e atualizado no estoque",
            icon: "success"
        });
    }else if(url.includes('exists')){
        Swal.fire({
            title: "Produto Já Existe",
            text: "Esse produto já foi cadastrado.",
            icon: "warning"
        });
    }
}

function setProductCart(product) {
    fetch('/cart?method=add', {
        method: "POST",
        headers: {
            'Content-Type' : 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(product),
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
    }).catch(error => {
        console.error("Erro ao adicionar ao carrinho:", error);
    })
}

function removeProductCart(product) {
    fetch('/cart?method=remove', {
        method: "POST",
        headers: {
            'Content-Type' : 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(product),
    }).then(response => {
        if(!response.ok){
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return response.json();
    }).then( data => {
        Swal.fire({
            title: data['message'],
            text: "Produto foi removido do carrinho.",
            icon: "success"
        });
    }).catch(error => {
        console.error("Erro ao remover produto do carrinho:", error);
    })
}

function initProductQuantity() {
    $(".product_quantity").val(0);
}