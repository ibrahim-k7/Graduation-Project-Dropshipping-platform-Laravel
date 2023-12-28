@extends('Admin.layouts.main')

@section('pageTitle')
    المحفظة
@endsection



@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Wallet</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Data</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Datatables</h5>
                            <p></p>

                            <div class="table-responsive">
                                <!-- Table with stripped rows -->
                                <table id="Supplier_Managment" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th id="id_column">ID</th>
                                            <th id="name_column">Name</th>
                                            <th id="email_column">Email</th>
                                            <th>Address</th>
                                            <th>Phone Number</th>
                                            <th>Balance</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>

                                </table>
                                <!-- End Table with stripped rows -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection

@section('js')
    <script type="text/javascript">
        $(function() {

            var supplier_data = $('#Supplier_Managment').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ Route('admin.suppliers.data') }}",
                columns: [{
                        data: 'sup_id',
                        name: 'sup_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'trens',
                        name: 'SuplierTransactions.balance'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });


        });






        /* $(document).ready(function(){
             $('#wallet_table_id').DataTable({
               

             });
         });*/
    </script>
@endsection
