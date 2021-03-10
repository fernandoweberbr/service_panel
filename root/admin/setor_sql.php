<!DOCTYPE html>
<html>
<?php
    session_start(); // Inicia a session
    include "functions.php"; // arquivo de funções.
    session_checker(); // chama a função que verifica se a session iniciada da acesso à página.
    include_once('head.php');
?>
<body>
    <div class="container-fluid">
        <div class="col-sm-0">
            <div class="well clearfix">
                Setores
                <div class="pull-right"><button type="button" class="btn btn-xs btn-primary" id="command-add"
                        data-row-id="0">
                        <span class="glyphicon glyphicon-plus"></span> Adicionar</button></div>
            </div>
            <table id="setor_grid" class="table table-condensed table-hover table-striped" width="100%" cellspacing="0"
                data-toggle="bootgrid">
                <thead>
                    <tr>
                        <th data-column-id="id" data-type="numeric" data-identifier="true">Id</th>
                        <th data-column-id="nome">Nome</th>
                        <th data-column-id="setor_alias">Alias</th>
                        <th data-column-id="habilita">Habilita</th>
                        <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="add_model" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Adicionar Setor</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="frm_add">
                            <input type="hidden" value="add" name="action" id="action">
                            <div class="form-group">
                                <label for="nome" class="control-label">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" />
                            </div>
                            <div class="form-group">
                                <label for="alias" class="control-label">Alias:</label>
                                <input type="text" class="form-control" id="alias" name="alias" />
                            </div>
                            <div class="form-group">
                                <label for="habilita" class="control-label">habilita:</label>
                                <input type="text" class="form-control" id="habilita" name="habilita" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" id="btn_add" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="edit_model" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Editar Setor</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="frm_edit">
                            <input type="hidden" value="edit" name="action" id="action">
                            <input type="hidden" value="0" name="edit_id" id="edit_id">
                            <div class="form-group">
                                <label for="nome" class="control-label">Nome:</label>
                                <input type="text" class="form-control" id="edit_nome" name="edit_nome" />
                            </div>
                            <div class="form-group">
                                <label for="alias" class="control-label">Alias:</label>
                                <input type="text" class="form-control" id="edit_alias" name="edit_alias" />
                            </div>
                            <div class="form-group">
                                <label for="habilita" class="control-label">Habilita:</label>
                                <input type="text" class="form-control" id="edit_habilita" name="edit_habilita" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <button type="button" id="btn_edit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var grid = $("#setor_grid").bootgrid({
                ajax: true,
                rowSelect: true,
                post: function () {
                    /* To accumulate custom parameter with the request object */
                    return {
                        id: "b0df282a-0d67-40e5-8558-c9e93b7befee"
                    };
                },
                url: "resp_setor.php",
                formatters: {
                    "commands": function (column, row) {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-edit\"></span></button>";
                        // + "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                /* Executes after data is loaded and rendered */
                grid.find(".command-edit").on("click", function (e) {
                    //alert("You pressed edit on row: " + $(this).data("row-id"));
                    var ele = $(this).parent();
                    var g_id = $(this).parent().siblings(':first').html();
                    var g_name = $(this).parent().siblings(':nth-of-type(2)').html();
                    //console.log(g_id);
                    //console.log(g_name);

                    //console.log(grid.data());//
                    $('#edit_model').modal('show');
                    if ($(this).data("row-id") > 0) {

                        // collect the data
                        $('#edit_id').val(ele.siblings(':first').html()); // in case we're changing the key
                        $('#edit_nome').val(ele.siblings(':nth-of-type(2)').html());
                        $('#edit_alias').val(ele.siblings(':nth-of-type(3)').html());
                        $('#edit_habilita').val(ele.siblings(':nth-of-type(4)').html());
                    } else {
                        alert('Now row selected! First select row, then click edit button');
                    }
                }).end().find(".command-delete").on("click", function (e) {
                    if ($(this).data("row-id") > 0) {
                        var conf = confirm('Delete ' + $(this).data("row-id") + ' items?');
                        alert(conf);
                        if (conf) {
                            $.post('resp_setor.php', { id: $(this).data("row-id"), action: 'delete' }
                                , function () {
                                    // when ajax returns (callback), 
                                    $("#setor_grid").bootgrid('reload');
                                });
                        }
                    }
                });
            });
            function ajaxAction(action) {
                data = $("#frm_" + action).serializeArray();
                $.ajax({
                    type: "POST",
                    url: "resp_setor.php",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('#' + action + '_model').modal('hide');
                        $("#setor_grid").bootgrid('reload');
                    }
                });
            }
            $("#command-add").click(function () {
                $('#add_model').modal('show');
            });
            $("#btn_add").click(function () {
                ajaxAction('add');
            });
            $("#btn_edit").click(function () {
                ajaxAction('edit');
            });
        });
    </script>
</body>

</html>