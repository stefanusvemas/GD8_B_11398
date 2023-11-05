@extends('dashboard')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Ticket</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('ticket')}}">Ticket</a>
                    </li>
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('ticket.create') }}" class="btn btn-md btn-success mb-3">TAMBAH TICKET</a>
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-no-wrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Poster</th>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Class</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ticket as $item)
                                    <tr>
                                        <td class="text-center"><img src="{{asset($item->movie->image)}}" alt="" style="width: 120px;"></td>
                                        <td class="text-center">{{$item->movie->title}}</td>
                                        <td class="text-center">{{$item->class}}</td>
                                        <td class="text-center">{{$item->price}}</td>
                                        <td class="text-center">
                                            <form onsubmit="returnconfirm('Apakah Anda Yakin ?');" action="{{ route('ticket.destroy', $item->id) }}" method="POST">
                                                <a href="{{ route('ticket.edit', $item->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <div class="alert alert-danger">
                                        Data Tiket belum tersedia
                                    </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $ticket->links() }}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection