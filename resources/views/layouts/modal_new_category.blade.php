

    <!-- Modal New Category -->
    <div class="modal fade" id="modalNewCategory" tabindex="-1" role="dialog" aria-labelledby="modalNewCategoryLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Nova Categoria</h4>
                </div>
                <div class="modal-body">
                    <div id="divMessage"></div>
                    <div class="form-group">
                        <label for="category">Name da Categoria</label>
                        <input type="text" class="form-control" id="category" name="category" placeholder="Categoria">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="save">Salvar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    
@section('js_modal')

    <script type="text/javascript" src="{{asset('js/bootstrap/modal.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            //Modal for New Category
            $('#modalNewCategory').on('show.bs.modal', function (event) {
                $('#save').removeAttr('disabled');
                $('#divMessage').html('').removeAttr('class');
                $('#category').val('');
            }).modal({'backdrop': 'static', 'show': false});

            $('#save').click(function(){
                var url_save = '{{route('category.store')}}';
                $.ajax({
                    url: url_save,
                    method: 'POST',
                    data: {
                        category: $('#category').val(),
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('#save').attr('disabled', 'disabled');
                    },
                    success: function (dataReturn) {
                        var classAlert = 'alert alert-success';
                        if (dataReturn.success == true) {
                            $.each($('.combo_category'), function(){
                                $(this).append($('<option>', {
                                    value: dataReturn.category_id,
                                    text: dataReturn.category_name
                                }));
                            });
                        } else {
                            $('#save').removeAttr('disabled');
                            classAlert = 'alert alert-info';
                        }

                        $('#divMessage').attr('class', classAlert).html(dataReturn.message);
                    },
                    statusCode: {
                        422: function(dataError) {
                            var errors = dataError.responseJSON;
                            $('#divMessage').attr('class', 'alert alert-danger').html(errors.category[0]);
                            $('#save').removeAttr('disabled');
                        }
                    }
                });

            });
        });
    </script>
@endsection