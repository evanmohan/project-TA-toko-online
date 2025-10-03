@extends('layouts.app')

@section('content')
    <h3>Kelola User</h3>
    <table class="table mt-3">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Username</th>
            <th>Aksi</th>
        </tr>
        @foreach($users as $u)
            <tr>
                <td>{{ $u->nama }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->username }}</td>
                <td>
                    <form action="{{ route('user.destroy', $u) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
