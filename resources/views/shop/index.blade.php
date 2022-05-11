@extends('layout.index',(['title'=> 'Shop | Lumen 79']))
@section('content')
    <div class="mt-3 p-2 row">
        <h2 class="col">Shop</h2>
        <div class="col-auto mb-3">
            <label for="formFile" class="form-label">Import Data:</label>
            <input class="form-control" type="file" id="formFile" onchange="importData()">
        </div>
    </div>
    <div class="bg-light row justify-content-evenly">
        <table class="table table-striped" id="dataTable">
            <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Code</th>
                    <th scope="col">Product Stock</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            @forelse ($shop as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->price }}</td>
                    <td><input id="qty{{ $item->id }}" type="number" value="0" min="0" max="{{ $item->stock }}"
                            onchange="qtyProduct({{ $item->id }})" />
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
                {{ $shop->links() }}
            </div>
            <div class="col-auto">
                <button class="btn-primary btn-sm" onclick="saveCart()">Submit</button>
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
        let product = [];
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

        function qtyProduct(id) {
            var foundIndex = product.find(v => v.id === id);
            if (foundIndex) {
                product.find(v => v.id === id).qty = $('#qty' + id).val();
            } else {
                product.push({
                    id: id,
                    qty: $('#qty' + id).val()
                });
            }
        }

        function importData() {
            var file = document.getElementById('formFile').files[0];
            var formData = new FormData();
            formData.append('file', file);

            $.ajax({
                url: "{{ url('shop') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: res.success == true ? 'success' : 'error',
                        title: res.message,
                    });
                    if (res.success) {
                        setTimeout(location.reload.bind(location), 3000);
                    }
                }
            })
        }

        function saveCart() {
            console.log(product);
            var formCart = new FormData();
            formCart.append('product', JSON.stringify(product));

            $.ajax({
                url: "{{ url('cart') }}",
                type: 'POST',
                data: formCart,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: res.success == true ? 'success' : 'error',
                        title: res.message,
                    });
                    if (res.success) {
                        setTimeout(() => {
                                window.location.href = "{{ url('cart') }}";
                            },
                            3000);
                    }
                }
            })
        }
    </script>
@endpush
