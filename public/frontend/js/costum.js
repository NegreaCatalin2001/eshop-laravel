$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.addToCartBtn').click(function (e) {
        e.preventDefault();
        var product_id = $(this).closest('.product_data').find('.prod_id').val();
        var product_qty = $(this).closest('.product_data').find('.qty-input').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            method: "POST",
            url: "/add-to-cart",
            data: {
                'product_id': product_id,
                'product_qty': product_qty,
            },
            success: function (response) {
                swal(response.status);
            },
            error: function (xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).message ||
                    "An error occurred";
                if (xhr.status === 401) {
                    swal({
                        title: "Unauthorized",
                        text: "You must be logged in to add items to the cart.",
                        icon: "error",
                        button: "Login",
                    }).then((value) => {
                        window.location.href =
                            '/login';
                    });
                } else {
                    swal("Error", errorMessage, "error");
                }
            }
        });


    });

    $('.addToWishlist').click(function (e) {
        e.preventDefault();
        var product_id = $(this).closest('.product_data').find('.prod_id').val();

        $.ajax({
            method: "POST",
            url: "/add-to-wishlist",
            data: {
                prod_id: product_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                swal(response.status);
            },
            error: function (xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).message ||
                    "An error occurred";
                if (xhr.status === 401) {
                    swal({
                        title: "Unauthorized",
                        text: "You must be logged in to add items to the cart.",
                        icon: "error",
                        button: "Login",
                    }).then((value) => {
                        window.location.href =
                            '/login';
                    });
                } else {
                    swal("Error", errorMessage, "error");
                }
            }
        });
    });

    $('.increment-btn').click(function (e) {
        e.preventDefault();
        var $qtyInput = $(this).closest('.product_data').find('.qty-input');
        var value = parseInt($qtyInput.val(), 10);
        var stock = parseInt($qtyInput.data('qty-available'));

        value = isNaN(value) ? 0 : value;
        if (value < stock) {
            value++;
            $qtyInput.val(value);
        } else {
            swal({
                title: "Stock Limit Reached",
                text: "You cannot add more than the available stock.",
                icon: "warning",
                button: "OK",
                timer: 1000,
            });
        }
    });


    $('.decrement-btn').click(function (e) {
        e.preventDefault();
        var dec_value = $(this).closest('.product_data').find('.qty-input').val();
        var value = parseInt(dec_value, 10);
        value = isNaN(value) ? 0 : value;
        if (value > 1) {
            value--;
            $(this).closest('.product_data').find('.qty-input').val(value);
        }
    });

    $('.delete-cart-item').click(function (e) {
        e.preventDefault();

        var prod_id = $(this).closest('.product_data').find('.prod_id').val();
        $.ajax({
            method: "POST",
            url: "delete-cart-item",
            data: {
                'prod_id': prod_id,
            },
            success: function (response) {
                swal({
                    title: "Deleted",
                    text: response.status,
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                }).then(function () {
                    window.location.reload();
                }, function (dismiss) {
                    if (dismiss === 'timer') {
                        window.location.reload();
                    }
                });
            }
        });

    });

    $('.remove-wishlist-item').click(function (e) {
        e.preventDefault();
        var prod_id = $(this).closest('.product_data').find('.prod_id').val();

        $.ajax({
            method: "POST",
            url: "delete-wishlist-item",
            data: {
                'prod_id': prod_id,
            },
            success: function (response) {
                swal({
                    title: "Deleted",
                    text: response.status,
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                }).then(function () {
                    window.location.reload();
                }, function (dismiss) {
                    if (dismiss === 'timer') {
                        window.location.reload();
                    }
                });
            }
        });

    });



    $('.changeQuantity').click(function (e) {
        e.preventDefault();

        var prod_id = $(this).closest('.product_data').find('.prod_id').val();
        var qty = $(this).closest('.product_data').find('.qty-input').val();
        data = {
            'prod_id': prod_id,
            'prod_qty': qty,
        }

        $.ajax({
            method: "POST",
            url: "update-cart",
            data: data,
            success: function (response) {
                window.location.reload();
            }
        });
    });


});