<ul>
    @foreach($offer->skills as $skill)
        <li>{{$skill->display_name}}</li>
    @endforeach
</ul>
