@extends('layout.index',(['title'=> 'Cart | Lumen 79']))
@section('content')
    <div class="mt-3 p-2 row">
        <h2 class="col">Shoping Cart</h2>
    </div>
    <div class="bg-light row justify-content-evenly">
        <table class="table table-striped" id="dataTable">
            <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Code</th>
                    <th scope="col">Price</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Total</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            @forelse ($cart as $item)
                <tr>
                    <td>{{ $item->shop->name }}</td>
                    <td>{{ $item->shop->code }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->total }}</td>
                    <td>
                        <button class="btn-danger btn-sm" onclick="removeCart({{ $item->id }})">Remove</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Data Empty</td>
                </tr>
            @endforelse
        </table>
        <div class="row">
            <div class="col">
                {{ $cart->links() }}
            </div>
            <div class="col-auto">
                <button class="btn-warning btn-sm" onclick="cancelCart()">Cancel</button>
                <button class="btn-primary btn-sm" onclick="submitCart()">Submit</button>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
@endpush
@push('js')
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <script src="{{ url('js/bootstrap-input-spinner.js') }}"></script>
    <script>
        let cart = [];
        $("input[type='number']").inputSpinner();
        $(document).ready(function() {
            $('#dataTable').DataTable({
                dom: 'Brt',
                pagination: false,
                // lengthMenu: [
                //     [5, 25, 50, 100],
                //     [5, 25, 50, 100]
                // ],
            });
        });

        function submitCart() {
            var formCart = new FormData();
            formCart.append('cart', JSON.stringify(cart));

            $.ajax({
                url: "{{ url('cart/submit') }}",
                type: 'POST',
                data: formCart,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: res.success == true ? 'success' : 'error',
                        title: res.message,
                    });
                    setTimeout(() => {
                        window.location.href = "{{ url('shop') }}";
                    }, 3000);
                }
            })
        }

        function removeCart(id) {
            $.ajax({
                url: `{{ url('cart/`+id+`/delete') }}`,
                type: 'delete',
                success: function(res) {
                    Swal.fire({
                        icon: res.success == true ? 'success' : 'error',
                        title: res.message,
                    });
                    setTimeout(() => {
                        window.location.href = "{{ url('cart') }}";
                    }, 3000);
                }
            })
        }

        function cancelCart() {
            $.ajax({
                url: `{{ url('cart/cancel') }}`,
                type: 'delete',
                success: function(res) {
                    Swal.fire({
                        icon: res.success == true ? 'success' : 'error',
                        title: res.message,
                    });
                    setTimeout(() => {
                        window.location.href = "{{ url('shop') }}";
                    }, 3000);
                }
            })
        }
    </script>
@endpush
