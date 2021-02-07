<div>
    <a href="{{$link}}">
        <div class="card">
            <div class="card-image">
                <img class="height-300" src="{{$imagePath}}">
                <span class="card-title">{{$title}}</span>
                <a href="{{$link}}" class="btn-floating halfway-fab waves-effect waves-light orange"><i class="material-icons">note</i></a>
            </div>
            <div class="card-content">
                <div class="truncate">{!!$description!!}</div>
            </div>
        </div>
    </a>
</div>