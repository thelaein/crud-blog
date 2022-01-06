<table class="table table-bordered  align-middle">
    <thead>
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Owner</th>
        <th>Control</th>
        <th>created_at</th>
    </tr>
    </thead>
    <tbody>
    @forelse($categories as $category)
        <tr>
            <td>{{$category->id}}</td>
            <td>{{$category->title}}</td>
            <td>{{$category->user->name}}</td>
            <td>
                <form action="{{route('category.destroy',$category->id)}}" method="post" class="d-inline-block">
                    @csrf
                    @method('delete')
                    <button class="btn btn-outline-danger sm">
                        <i class="fas fa-trash-alt fa-fw"></i>
                    </button>
                </form>
                <a href="{{route('category.edit',$category->id)}}" class="btn btn-outline-info">
                    <i class="fas fa-pencil-alt fa-fw"></i>
                </a>
            </td>
            <td>

                <p>
                    <i class="fas fa-calendar"></i>
                    {{$category->created_at->format('d / m / Y')}}
                </p>
                <p>
                    <i class="fas fa-clock"></i>
                    {{$category->created_at->format('h:i a')}}
                </p>
            </td>
        </tr>

    @empty
        <tr>
            <td colspan="5">There is no</td>
        </tr>

    @endforelse
    </tbody>
</table>

{{$categories->links()}}
