@extends('layouts.default')
@section('content')

<div class="container">

<h1>Orders</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>Course ID</td>
        <td>Course Name</td>
        <td>User Email</td>
        <td>Payment ID</td>
        <td>Total Amount</td>
        <td>Status</td>
        <td>Purchase date</td>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $key => $order)
        <tr>
            <td>{{ isset($order->order_details->course_id)?$order->order_details->course_id:'-----'  }}</td>
            <td>{{ isset($order->order_details->course_name)? $order->order_details->course_name:'----' }}</td>
            <td>{{ $order->user->email }}</td>
            <td>{{ $order->payment_id }}</td>
            <td>{{ $order->order_total }}</td>
            <td>{{ $order->success? 'Success':'Fail' }}</td>
            <td>{{ $order->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</div>


@stop
@section('scripts')
@stop

