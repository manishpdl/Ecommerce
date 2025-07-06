@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="grid grid-cols-3 gap-4">
    <div class="bg-blue-100 p-4 shadow-md rounded-lg">
        <h3 class="font-bold text-xl">
            <i class="ri-user-line"></i>
            Total Users
        </h3>
        <p class="text-4xl text-right font-bold">{{ $totaluser }}</p>
    </div>

    <div class="bg-red-100 p-4 shadow-md rounded-lg">
        <h3 class="font-bold text-xl">
            <i class="ri-shopping-cart-2-line"></i>
            Total Orders
        </h3>
        <p class="text-4xl text-right font-bold">{{$totalorders }}</p>
    </div>

    <div class="bg-green-100 p-4 shadow-md rounded-lg">
        <h3 class="font-bold text-xl">
            <i class="ri-exchange-dollar-line"></i>
            Total Revenue
        </h3>
        <p class="text-4xl text-right font-bold">NPR.{{ $totalrevenue }}</p>
    </div>

    <div class="bg-yellow-100 p-4 shadow-md rounded-lg">
        <h3 class="font-bold text-xl">
            <i class="ri-menu-2-line"></i>
            Total Categories
        </h3>
        <p class="text-4xl text-right font-bold">{{$totalcategories}}</p>
    </div>

    <div class="bg-green-100 p-4 shadow-md rounded-lg">
        <h3 class="font-bold text-xl">
            <i class="ri-shopping-cart-fill"></i>
            Total Products
        </h3>
        <p class="text-4xl text-right font-bold">{{$totalproducts}}</p>
    </div>

    <div class="bg-blue-100 p-4 shadow-md rounded-lg">
        <h3 class="font-bold text-xl">
            <i class="ri-shopping-cart-line"></i>
            Pending Orders
        </h3>
        <p class="text-4xl text-right font-bold">{{ $totalpending }}</p>
    </div>
</div>

<div class="grid grid-cols-2 gap-6 mt-4 px-4">
    <!-- Pie Chart -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700 text-center">Product Categories</h2>
        <canvas id="piechart" class="w-full h-6"></canvas>
    </div>

    <!-- Bar/Line Chart -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700 text-center">Monthly Sales by Category ({{ date('Y') }})</h2>
        <canvas id="categorySalesChart" class="w-full h-96"></canvas>
    </div>
</div>


<div class="grid grid-cols-3 gap-4 mt-4">
    More content can go here...
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    // pie chart
  const ctx = document.getElementById('piechart').getContext('2d');

  new Chart(ctx, {
    type: 'pie',
    
    data: {
      labels: {!! $allcategories !!},
      datasets: [{
        label: 'No of Products',
        data: {!! $allproducts !!},
        borderWidth: 1
      }]
    },
  });


  //bar chart
 
const months = {!! $monthsJson !!};
const categories = {!! $categoriesJson !!};
const dataMatrix = {!! $dataMatrixJson !!};

const colors = [
    'rgba(255, 99, 132, 1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)',
];

const datasets = categories.map((category, i) => ({
    label: category,
    data: dataMatrix[category],
    backgroundColor: colors[i % colors.length],
}));

const ctx2 = document.getElementById('categorySalesChart').getContext('2d');

new Chart(ctx2, {
    type: 'bar',   // 👈 Change to 'bar'
    data: {
        labels: months,
        datasets: datasets
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Monthly Sales by Category for ' + new Date().getFullYear()
            },
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Sales (currency)' }
            },
            x: {
                title: { display: true, text: 'Month' }
            }
        }
    }
});
</script>



@endsection