@foreach ($schoolClasses as $schoolClass)
    
<div class="modal fade" id="createclass{{$schoolClass->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar turma</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{route('school-class.update', $schoolClass->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-sm-12 col-lg-8 col-xlg-8">
                    <div class="form-group">
                        <label for="name">Nome da turma</label>
                        <input required type="text" maxlength="255" value="{{$schoolClass->class_name}}"  class="form-control" name="class_name" id="name" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-8 col-xlg-8">
                    <div class="form-group">
                        <label for="course_id">Turma do curso:</label>
                        <select class="form-control" name="course_id" id="course_id">
                            @foreach($courses as $course)
                                <option @if ($course->id == $schoolClass->course_id) selected @endif 
                                    value="{{$course->id}}">{{$course->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" id="demand">
                    <div class="form-group">
                        <label >Data de ínicio das aulas Actual({{$schoolClass->start_lesson}}) </label>
                        <input required type="date"   
                        class="form-control start_lesson" name="start_lesson" id="start_lesson"  >
                    </div>
                  </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-8 col-xlg-8">
                    <div class="form-check">
                        <input class="form-check-input" name="active"  @if($schoolClass->active===1) checked @endif   type="checkbox" value="1" id="active">
                        <label class="form-check-label" for="active">
                            Turma activa
                        </label>
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-8 col-xlg-8">
                <button class="btn btn-primary" type="submit">Editar turma</button>
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
@endforeach

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(".start_lesson").flatpickr({ enableTime: true,  time_24hr: true,
    dateFormat: "Y-m-d H:i",});    
</script>
