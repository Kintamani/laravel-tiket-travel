<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE v4 | Dashboard</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS." />
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard" />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
        integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}" />
    <!--end::Required Plugin(AdminLTE)-->

    @yield('style')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>Invoice</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Customer Details</h5>
                        <p><strong>Name:</strong> {{ $payment->user->name }}</p>
                        <p><strong>Email:</strong> {{ $payment->user->email }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <h5>Invoice Details</h5>
                        <p><strong>Invoice ID:</strong> #{{ $payment->transaction_id }}</p>
                        <p><strong>Date:</strong> {{ $payment->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <hr>

                <h5>Travel Details</h5>
                <p><strong>Pickup Location:</strong> {{ $payment->schedule->pickup->name }}</p>
                <p><strong>Destination:</strong> {{ $payment->schedule->destination->name }}</p>
                <p><strong>Arrival Time:</strong>
                    {{ \Carbon\Carbon::parse($payment->schedule->arrival_time)->format('d M Y, H:i') }}</p>
                <p><strong>Departure Time:</strong>
                    {{ \Carbon\Carbon::parse($payment->schedule->departure_time)->format('d M Y, H:i') }}</p>

                <hr>

                <h5>Payment Details</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Seats Purchased</th>
                            <th>Price per Seat</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $payment->seats_purchased }}</td>
                            <td>Rp {{ number_format($payment->schedule->price, 2, ',', '.') }}</td>
                            <td>Rp {{ number_format($payment->amount, 2, ',', '.') }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $payment->status == 'confirmed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr>

                <div class="text-center">
                    <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print
                        Invoice</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</body>
