<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<div class="bg-white shadow">
    <div class="py-12 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <table class="table" style="width:100%;border:1px solid" >
            <thead>
            <tr>
                <th>Id</th>
                <th>Barcode</th>
                <th>Qty</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->barcode }}</td>
                    <td>{{ $product->quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-app-layout>
