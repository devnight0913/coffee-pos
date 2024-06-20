<x-card class="mb-3">
    <div class="card-title">{{ $cardTitle }}</div>
    <div class="mb-3 fw-bold h4">{{ currency_format($totalPerMonth->sum('total')) }}</div>
    <canvas id="total-sales-chart"></canvas>
</x-card>
@push('script')
    <script type="text/javascript">
        var sales_chart_element = document.getElementById("total-sales-chart").getContext("2d");
        orders_chart = new Chart(sales_chart_element, {
            type: "line",
            data: {
                labels: [],
                datasets: [{
                    label: "{{ __('Sales') }}",
                    borderColor: "#1A73E8",
                    fill: true,
                    data: []
                }]
            },
            options: {
                layout: {
                    padding: 10
                },
                legend: {
                    position: "bottom"
                },
                title: {
                    display: !0,
                    text: "Total Sales Per Month"
                },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: !0,
                            labelString: "Total Sales Per Month"
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: !0,
                            labelString: "Data"
                        }
                    }]
                },
                responsive: true,
            }
        });
        @for ($k = 0; $k < $totalPerMonth->count(); $k++)
            orders_chart.data.labels.push("{{ $totalPerMonth[$k]->date }}"), orders_chart.data.datasets.forEach(a => {
                a.data.push("{{ $totalPerMonth[$k]->total - $totalDiscountPerMonth[$k]->sum('discount') }}");
            });
        @endfor
        orders_chart.update();
    </script>
@endpush
