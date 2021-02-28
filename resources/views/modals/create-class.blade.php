
<div class="modal fade" id="createclass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Criar turma</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="/admin/school-class" method="post">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-lg-8 col-xlg-8">
                    <div class="form-group">
                        <label for="name">Nome da turma</label>
                        <input required type="text" maxlength="255" value="{{old('class_name')}}"  class="form-control" name="class_name" id="name" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-8 col-xlg-8">
                    <div class="form-group">
                        <label for="course_id">Turma do curso:</label>
                        <select class="form-control" name="course_id" id="course_id">
                            @foreach($courses as $course)
                                <option value="{{$course->id}}">{{$course->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" id="demand">
                    <div class="form-group">
                        <label for="start_lesson">Data de ínicio das aulas</label>
                        <input required type="date"  value="{{old('start_lesson')}}"  
                        class="form-control" name="start_lesson" id="start_lesson"  >
                    </div>
                  </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-8 col-xlg-8">
                    <div class="form-check">
                        <input class="form-check-input" checked  type="checkbox" name="active" value="1" id="active">
                        <label class="form-check-label" for="flexCheckDefault">
                            Turma activa
                        </label>
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-8 col-xlg-8">
                <button class="btn btn-primary" type="submit">Criar turma</button>
                </div>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
        </div>
    </div>
</div>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $("#start_lesson").flatpickr({ enableTime: true,
    dateFormat: "Y-m-d H:i",});    
</script>
