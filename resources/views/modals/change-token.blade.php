

@foreach ($courseGrants as $courseGrant)
    
<div class="modal fade" id="changeToken{{$courseGrant->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Alterar estado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form  action="/admin/change-state-token" method="POST">
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-xlg-12">
                    <div class="form-group">
                        <label for="state">Estado</label>
                        <select class="form-control" name="state" id="state">
                            
                                <option value="0">
                                    Não processado
                                </option>
                                <option value="1">
                                    Aprovado
                                </option>
                                <option value="2">
                                   Reprovado
                                </option>
                           
                        </select>
                    </div>
                </div>
            </div>
          
            <div class="row">
                <div class="col-sm-12 col-lg-8 col-xlg-8">
                <button class="btn btn-primary" type="submit">Alterar</button>
                </div>
            </div>
    
            <input type="hidden" value="{{$courseGrant->id}}" name="course_grant_id">
            
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