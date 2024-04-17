<div class="px-6 mb-4">
    <div class="text-sm breadcrumbs">
        <ul>
            @foreach($crumbs as $crumb)
                @if(isset($crumb['url']))
                    <li><a href="{{$crumb['url']}}">{{$crumb['name']}}</a></li>
                @else
                    <li><strong>{{$crumb['name']}}</strong></li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
