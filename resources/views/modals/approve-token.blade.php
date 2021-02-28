

@foreach ($courseGrants as $courseGrant)
    
<div class="modal fade" id="approveToken{{$courseGrant->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Aprovar token</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form  id="form{{$courseGrant->id}}" action="/admin/approve-token" method="POST">
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-xlg-12">
                    <div class="form-group">
                        <label for="school_class_id">Turma:</label>
                        <select class="form-control" name="school_class_id" id="school_class_id">
                            @foreach($schoolClasses as $schoolClass)
                                <option value="{{$schoolClass->id}}">
                                    {{$schoolClass->class_name.' do curso: '. $schoolClass->curso}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
          
            <div class="row">
                <div class="col-sm-12 col-lg-8 col-xlg-8">
                <button class="btn btn-primary" type="submit">Aprovar acesso</button>
                </div>
            </div>
    
            <input type="hidden" value="{{$courseGrant->token}}" name="token">
            <input type="hidden" value="{{$courseGrant->user_id}}" name="user_id">
            @csrf
            
        </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
        </div>
    </div>
</div>

  

@endforeach