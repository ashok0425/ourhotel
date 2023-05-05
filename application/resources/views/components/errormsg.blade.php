<div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@if (session()->has('message'))
<div class="alert @if(session()->get('type')=='success') 
    alert-success @else alert-danger @endif alert-dismissible fade show" role="alert">
            <span>{{ session()->get('message') }}</span>
</div>
@endif
</div>