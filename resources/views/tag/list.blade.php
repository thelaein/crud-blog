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
    @forelse($tags as $tag)
        <tr>
            <td>{{$tag->id}}</td>
            <td>{{$tag->title}}</td>
            <td>{{Auth::id()}}</td>

            <td>
                <form action="{{route('tag.destroy',$tag->id)}}" method="post" class="d-inline-block" id="deleteTag{{$tag->id}}">
                    @csrf
                    @method('delete')

                </form>

                <div class="btn-group">

{{--                    <a class="btn btn-sm btn-outline-primary" href="{{ route('tag.show',$tag->id) }}">--}}
{{--                        <i class="fas fa-info fa-fw"></i>--}}
{{--                    </a>--}}

                        <a class="btn btn-sm btn-outline-primary" href="{{ route('tag.edit',$tag->id) }}">
                            <i class="fas fa-pencil-alt fa-fw"></i>
                        </a>

                    {{--                                      @if(\Illuminate\Support\Facades\Auth::id() == $post->user_id)--}}
                    {{--                                           --}}
                    {{--                                            @endif--}}

                        <button form="deleteTag{{$tag->id}}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-trash-alt fa-fw"></i>
                        </button>
                </div>
            </td>

            <td>
                <p>
                    <i class="fas fa-calendar"></i>
                    {{$tag->created_at->format('d / m / Y')}}
                </p>
                <p>
                    <i class="fas fa-clock"></i>
                    {{$tag->created_at->format('h:i a')}}
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

{{$tags->links()}}
