@forelse($friends as $friend)
    <tr>
        <td>{{ $friend->name }}</td>
        <td>{{ $friend->email }}</td>
        <td>
            <form action="/friends/{{ $friend->id }}" method="post">
                @method('DELETE')

                @csrf

                <button class="btn btn-danger">
                    Delete
                </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="3">No Records Found.</td>
    </tr>
@endforelse
<tr>
    <td colspan="3" align="center">
        {!! $friends->links() !!}
    </td>
</tr>