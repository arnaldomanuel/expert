
$(function() {
    let indexSocial = 2;
    $('#addObjective').click(function(){
        $('#objectives').append(`  
            <div class="form-group">
                <label for="objectiive${indexSocial}">Objectivo</label>
                <input maxLength="140" required type="text" class="form-control" name="objective${indexSocial}" id="objective${indexSocial}">
            </div>
  `);

    indexSocial++;
    })
});