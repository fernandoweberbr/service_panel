<!DOCTYPE html>
<html lang="pt">

<?php
    session_start(); // Inicia a session
    include "functions.php"; // arquivo de funções.
    session_checker(); // chama a função que verifica se a session iniciada da acesso à página.
    if ($_SESSION['nivel_usuario'] != 1)
    {
        exit();
    }
    include_once('head.php');
?>

<body>
    <div class="container-fluid">
        <div class="col-sm-0">
            <div class="well clearfix">
                Finalizadas
                <div class="pull-right">
                    <button type="button" class="btn btn-xs btn-primary" id="command-add" data-row-id="0">
                        <span class="glyphicon glyphicon-plus"></span> Adicionar</button>
                </div>
            </div>
            <div class="col-md-0  col-xs-0 table-responsive">
            <table id="atividade_grid" class="table table-hover table-striped" width="100%" cellspacing="0" data-toggle="bootgrid">
                <thead>
                    <tr>
                        <th data-column-id="id" data-type="numeric" data-identifier="true">Id</th>
                        <th data-column-id="ordem">Ordem</th>
                        <th data-column-id="realizada">Real.</th>
                        <th data-column-id="finalizada">Final.</th>
                        <th data-column-id="prioridade">Prioridade</th>
                        <th data-column-id="descricao">Descr.</th>
                        <th data-column-id="setor">Setor</th>
                        <th data-column-id="usuario">Usuario</th>
                        <th data-column-id="inicio">Inicio</th>
                        <th data-column-id="limite">Limite</th>
                        <th data-column-id="aviso">Aviso</th>
                        <th data-column-id="commands" data-formatter="commands" data-sortable="false">Comando</th>
                    </tr>
                </thead>
            </table>
            </div>
        <div id="add_model" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Adicionar Atividade</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="frm_add">
                            <input type="hidden" value="add" name="action" id="action">
                            <!--<input type="hidden" value="0" name="edit_id" id="edit_id">-->
                            <div class="form-group">
                                <label for="id" class="control-label">ID:<input type="text" class="form-control" id="add_id" name="add_id" /></label>
                                
                                <label for="ordem" class="control-label">Ordem: <input type="text" class="form-control" id="add_ordem" name="add_ordem" /></label>
                               
                                <label for="realizada" class="control-label">Realizada:<input type="text" class="form-control" id="add_realizada" name="add_realizada" value="1" size="1"/></label>
                                
                                <label for="finalizada" class="control-label">Finalizada:<input type="text" class="form-control" id="add_finalizada" name="add_finalizada" value="1" size="1" /></label>
                                
                                <label for="importancia" class="control-label">Importancia:<select class="form-control" id="add_importancia" name="add_importancia"></select></label>
                                
                                <label for="descricao" class="control-label">Descricao:<input type="text" class="form-control" id="add_descricao" name="add_descricao" value="1" size="50"/></label>
                                
                                <label for="setor" class="control-label">Setor:<select class="form-control" id="add_setor" name="add_setor"></select></label>
                                
                                <label for="usuario" class="control-label">Usuario:<select class="form-control" id="add_usuario" name="add_usuario"></select></label>
                                
                                <label for="inicio" class="control-label">Inicio:<input type="text" class="form-control" id="add_inicio" name="add_inicio" /></label>
                                
                                <label for="limite" class="control-label">Limite:<input type="text" class="form-control" id="add_limite" name="add_limite" /></label>
                                
                                <label for="aviso" class="control-label">Aviso:<input type="text" class="form-control" id="add_aviso" name="add_aviso" /></label>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <button type="button" id="btn_add" class="btn btn-primary">Salvar</button>
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
                        <h4 class="modal-title">Editar Atividade</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="frm_edit">
                            <input type="hidden" value="edit" name="action" id="action">
                            <!--<input type="hidden" value="0" name="edit_id" id="edit_id">-->
                            <div class="form-group">
                                <label for="id" class="control-label">ID:<input type="text" class="form-control" id="edit_id" name="edit_id"  readonly="true"/></label>
                                <label for="ordem" class="control-label">Ordem:<input type="text" class="form-control" id="edit_ordem" name="edit_ordem" /></label>
                                <label for="realizada" class="control-label">Realizada:<input type="text" class="form-control" id="edit_realizada" name="edit_realizada" value="1" size="1"/></label>
                                <label for="finalizada" class="control-label">Finalizada:<input type="text" class="form-control" id="edit_finalizada" name="edit_finalizada"
                                    value="1" size="1"/></label>
                                <label for="importancia" class="control-label">Importancia:<select class="form-control" id="edit_importancia" name="edit_importancia"></select></label>
                                <label for="descricao" class="control-label">Descricao:<input type="text" class="form-control" id="edit_descricao" name="edit_descricao" value="1" size="55"/></label>
                                <label for="setor" class="control-label">Setor:<select class="form-control" id="edit_setor" name="edit_setor"  ></select></label>
                                <label for="usuario" class="control-label">Usuario:<select class="form-control" id="edit_usuario" name="edit_usuario" ></select></label>
                                <label for="inicio" class="control-label">Inicio:<input type="text" class="form-control" id="edit_inicio" name="edit_inicio" /></label>
                                <label for="limite" class="control-label">Limite:<input type="text" class="form-control" id="edit_limite" name="edit_limite" /></label>
                                <label for="aviso" class="control-label">Aviso:<input type="text" class="form-control" id="edit_aviso" name="edit_aviso" /></label>
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

        $(function () {
            $("#add_inicio").datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $("#add_limite").datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $("#edit_inicio").datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $("#edit_limite").datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });

        $(document).ready(function () {
            var grid = $("#atividade_grid").bootgrid({
                ajax: true,
                rowSelect: true,
                rowCount: [15, 30, 60, 120, -1],
                padding: 2,
                multiSelect: false,
                highlightRows: true,


                post: function () {
                    /* To accumulate custom parameter with the request object */
                    return {
                        id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                    };
                },

                url: "resp_atividade_finalizada.php",
                formatters: {
                    "commands": function (column, row) {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-edit\"></span></button>";
                        // + "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
                    }
                },

                statusMapping: {
                    0: "success",
                    1: "info",
                    2: "warning",
                    3: "danger",
                    4: "loglow",
                    5: "logmediumlow",
                    6: "logmedium",
                    7: "logmediumhigh",
                    8: "loghigh",
                    9: "logcritical",
                    10: "logcatastrophic"
                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                /* Executes after data is loaded and rendered */
                grid.find(".command-edit").on("click", function (e) {
                    //alert("You pressed edit on row: " + $(this).data("row-id"));
                    var ele = $(this).parent();
                    var g_id = $(this).parent().siblings(':first').html();
                    var g_ordem = $(this).parent().siblings(':nth-of-type(2)').html();
                    var g_realizada = $(this).parent().siblings(':nth-of-type(3)').html();
                    var g_finalizada = $(this).parent().siblings(':nth-of-type(4)').html();
                    var g_importancia = $(this).parent().siblings(':nth-of-type(5)').html();
                    var g_descricao = $(this).parent().siblings(':nth-of-type(6)').html();
                    var g_setor = $(this).parent().siblings(':nth-of-type(7)').html();
                    var g_usuario = $(this).parent().siblings(':nth-of-type(8)').html();
                    var g_inicio = $(this).parent().siblings(':nth-of-type(9)').html();
                    var g_limite = $(this).parent().siblings(':nth-of-type(10)').html();
                    var g_aviso = $(this).parent().siblings(':nth-of-type(11)').html();

                    $('#edit_model').modal('show');
                    if ($(this).data("row-id") > 0) {
                        // collect the data
                        $('#edit_id').val(ele.siblings(':first').html()); // in case we're changing the key
                        $('#edit_ordem').val(ele.siblings(':nth-of-type(2)').html());
                        $('#edit_realizada').val(ele.siblings(':nth-of-type(3)').html());
                        $('#edit_finalizada').val(ele.siblings(':nth-of-type(4)').html());
                        let dropdown_importancia = $('#edit_importancia');
                        dropdown_importancia.empty();
                        const url0 = 'sql_json_parse.php?table=importancia';
                        $.getJSON(url0, function (data) {
                            $.each(data, function (key, entry) {
                                var selected_importancia = ele.siblings(':nth-of-type(5)').html();
                                if (entry.nome == selected_importancia) {
                                    dropdown_importancia.append($('<option selected="true"></option>').val(entry.id).html(entry.nome));
                                } else {
                                    dropdown_importancia.append($('<option></option>').val(entry.id).html(entry.nome));
                                }
                            })
                        });

                        $('#edit_descricao').val(ele.siblings(':nth-of-type(6)').html());

                        let dropdown_setor = $('#edit_setor');
                        dropdown_setor.empty();
                        const url1 = 'sql_json_parse.php?table=setor';
                        $.getJSON(url1, function (data) {
                            $.each(data, function (key, entry) {
                                var selected_setor = ele.siblings(':nth-of-type(7)').html();
                                if (entry.nome == selected_setor) {
                                    dropdown_setor.append($('<option selected="true"></option>').val(entry.id).html(entry.nome));
                                } else {
                                    dropdown_setor.append($('<option></option>').val(entry.id).html(entry.nome));
                                }
                            })
                        });

                        let dropdown_user = $('#edit_usuario');
                        dropdown_user.empty();
                        const url2 = 'sql_json_parse.php?table=usuario';
                        $.getJSON(url2, function (data) {
                            $.each(data, function (key, entry) {
                                var selected = ele.siblings(':nth-of-type(8)').html();
                                if (entry.nome == selected) {
                                    dropdown_user.append($('<option selected="true"></option>').val(entry.id).html(entry.nome));
                                } else {
                                    dropdown_user.append($('<option></option>').val(entry.id).html(entry.nome));
                                }
                            })
                        });

                        $('#edit_inicio').val(ele.siblings(':nth-of-type(9)').html());
                        $('#edit_limite').val(ele.siblings(':nth-of-type(10)').html());
                        $('#edit_aviso').val(ele.siblings(':nth-of-type(11)').html());
                    } else {
                        alert('Now row selected! First select row, then click edit button');
                    }
                }).end().find(".command-delete").on("click", function (e) {
                    if ($(this).data("row-id") > 0) {
                        var conf = confirm('Delete ' + $(this).data("row-id") + ' items?');
                        alert(conf);
                        if (conf) {
                            $.post('resp_atividade_finalizada.php', { id: $(this).data("row-id"), action: 'delete' }
                                , function () {
                                    // when ajax returns (callback), 
                                    $("#atividade_grid").bootgrid('reload');
                                });
                        }
                    }
                });
            });

            function ajaxAction(action) {
                data = $("#frm_" + action).serializeArray();
                $.ajax({
                    type: "POST",
                    url: "resp_atividade_finalizada.php",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('#' + action + '_model').modal('hide');
                        $("#atividade_grid").bootgrid('reload');
                    }
                });
            }
            $("#command-add").click(function (e) {
                $('#add_model').modal('show');
                $('#add_id').val(""); // in case we're changing the key
                $('#add_ordem').val("");
                $('#add_realizada').val("0");
                $('#add_finalizada').val("0");
                let dropdown_importancia = $('#add_importancia');
                dropdown_importancia.empty();
                const url0 = 'sql_json_parse.php?table=importancia';
                dropdown_importancia.append($('<option selected="true"></option>').val('').html('Importancia..'));
                $.getJSON(url0, function (data) {
                    $.each(data, function (key, entry) {
                        dropdown_importancia.append($('<option></option>').val(entry.id).html(entry.nome));
                    })
                });
                $('#add_descricao').val("");
                let dropdown_setor = $('#add_setor');
                dropdown_setor.empty();
                const url1 = 'sql_json_parse.php?table=setor';
                dropdown_setor.append($('<option selected="true"></option>').val('').html('Escolha Setor...'));
                $.getJSON(url1, function (data) {
                    $.each(data, function (key, entry) {
                        dropdown_setor.append($('<option></option>').val(entry.id).html(entry.nome));
                    })
                });
                let dropdown_user = $('#add_usuario');
                dropdown_user.empty();
                const url2 = 'sql_json_parse.php?table=usuario';
                dropdown_user.append($('<option selected="true"></option>').val('').html('Escolha Usuario...'));
                $.getJSON(url2, function (data) {
                    $.each(data, function (key, entry) {
                        dropdown_user.append($('<option></option>').val(entry.id).html(entry.nome));
                    })
                });
                $('#add_inicio').val("");
                $('#add_limite').val("");
                $('#edit_aviso').val("");
                //$('#add_model').modal('show');
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