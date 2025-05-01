<x-app-layout>
<style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background-color: #f9f9f9;
    }
    h1 {
      text-align: center;
      color: #333;
    }
    .table-container {
      width: 80%;
      margin: 20px auto;
    }
    .button-wrapper {
      text-align: right;
      margin-bottom: 10px;
    }
    .btn {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      font-size: 14px;
      cursor: pointer;
    }
    .btn:hover {
      background-color: #45a049;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px 16px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    tr:hover {
      background-color: #f9f9f9;
    }
    .btn-danger{
      background-color:red;
      color:#fff

    }
    .btn-warning{
      background-color:#0940b1;
      color:#fff

    }
  </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="table-container">
            <div class="button-wrapper">
              <a href="{{route('create',['id'=>$id,'type'=>'new'])}}" class="btn">Create Invoice</a>
            </div>
  
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>User</th>
          <th>Email</th>
          <th>Number</th>
          <th>Status</th>
          <th>Total</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($invoices as $key => $client)
        <tr>
          <td>{{$key+1}}</td>
          <td>{{$client['client']['name']}}</td>
          <td>{{$client['client']['email']}}</td>
          <td>{{$client->invoice_number}}</td>
          <td>{{$client->status}}</td>
          <td>{{$client->total}}</td>
          <td>
          <a href="{{route('create',['id'=>$id,'type'=>$client->id])}}" class="btn">Update</a>
          <a href="{{route('delete',['id'=>$client->id])}}" class="btn btn-danger">delete</a>
          <a href="{{ route('send', ['invoice' => $client->id]) }}" class="btn btn-warning">Send</a>
          <a href="{{ route('invoice.download', $client->id) }}" class="btn btn-warning">Pdf</a>
          <a href="{{ route('payment.send', $client->id) }}" class="btn btn-warning">Payment Link</a>

        </td>
        </tr>
        @endforeach
       
      </tbody>
    </table>
  </div>

            </div>
        </div>
    </div>
</x-app-layout>
