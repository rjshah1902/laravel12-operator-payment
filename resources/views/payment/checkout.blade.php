<x-app-layout>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ $key }}",
            "amount": "{{ $amount }}",
            "currency": "INR",
            "name": "Recharge Payment",
            "description": "Mobile Recharge",
            "order_id": "{{ $order_id }}",
            "handler": function (response){
                fetch("{{ route('payment.verify') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature,
                        recharge_id: "{{ $recharge->id }}"
                    })
                }).then(res => res.json()).then(data => {
                    Swal.fire({
                        title: "Thank you!",
                        text: data.message,
                        icon: "success",
                        }).then((result) => {
                            window.location.href = "{{ route('dashboard') }}";
                    });
                });
            }
        };

        var rzp1 = new Razorpay(options);
        window.onload = function() {
            rzp1.open();
        };
    </script>
</x-app-layout>
