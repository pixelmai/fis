<h2>Product Name: </h2>
<p>{{ $tools->name }}</p>

<h3>Product Belongs to</h3>

<ul>
    @foreach($tools->suppliers as $supplier)
    <li>{{ $supplier->name }}</li>
    @endforeach
</ul>