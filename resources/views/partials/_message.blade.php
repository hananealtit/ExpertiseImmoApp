@if(session('success'))
    <div class="alert alert-success lert-dismissible fade show container" role="alert" dir='rtl'>
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="fa fa-check" aria-hidden="true"></i> {{ session('success') }}
    </div>
@endif
@if(session('danger'))
    <div class="alert alert-danger alert-dismissible fade show container" role="alert" dir='rtl'>
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('danger') }}
    </div>

@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show container" role="alert" dir='rtl'>
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            @foreach($errors->all() as $error)
                <li><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ $error }}</li>
            @endforeach
        </ul>

    </div>

@endif