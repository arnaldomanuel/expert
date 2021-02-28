

@foreach ($schoolClasses as $schoolClass)
    
<div class="modal fade" id="liststudent{{$schoolClass->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Aprovar token</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-hover table-responsive">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($schoolClass->courseGrants as $courseGrant)
                  <tr>
                    <td>{{$courseGrant->user->id}}</td>
                    <td>{{$courseGrant->user->name}}</td>
                    <td>{{$courseGrant->user->email}}</td>
                  </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
        </div>
    </div>
</div>

  

@endforeach