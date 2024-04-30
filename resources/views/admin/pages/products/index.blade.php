@extends('admin.layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Products</li>
        </ol>
    </nav>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            Bulk Upload
        </button>
    
   
    @include('admin.layouts.error')
    @php 
        $headers = [
            ['label' => 'SKU', 'key' => 'sku', 'sort_by' => true],
            ['label' => 'Title', 'key' => 'title', 'sort_by' => true],
            ['label' => 'EAN', 'key' => 'ean', 'sort_by' => true],
            ['label' => 'UK Only', 'key' => 'uk_only', 'sort_by' => false],
         
        ];
        $sort_by = ''; 
        $api_url='products';
    @endphp
    @include('admin.components.data-table', ['headers' => $headers, 'ap_url' => $api_url,'sort_by'=>$sort_by])
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        @php
            $elements = [
                [   
                    'method'=>'input',
                    'label' => 'Choose File', 
                    'key' => 'file_input', 
                    'place_holder' => 'Choose File', 
                    'type' => 'file',
                    'required'=>true,
                    'readonly'=>false
                ],
            ];
            $modal_name='Upload File';
            $action_name='Upload';
            $route_name='import_products';
        @endphp   
        @include('admin.components.modal-form', ['elements' => $elements,'modal_name'=>$modal_name,'action_name'=>$action_name,'route_name'=>$route_name])

    </div>
@endsection


