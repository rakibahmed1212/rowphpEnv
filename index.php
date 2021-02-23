<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\ProcessDataContainer;

$tableContent = new ProcessDataContainer();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-white">
                <div class="card-body">
                    <div class="card-header">
                        <h2 class="card-title text-center">Todo word</h2>
                    </div>
                    <div id="app">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="New Task..." id="data_insert">
                            <span class="input-group-addon" id="addRow">
                                <img src="asset/tick.jpg" alt="" style="height: 23px;">
                            </span>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>

                                </tr>
                                </thead>
                                <tbody id="todo_data">

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <ul class="nav nav-pills todo-nav">
                                <li role="presentation"><span class="btn" id="allData">All</span></li>
                                <li role="presentation"><span class="btn" id="allDataActive">Active</span>
                                </li>
                                <li role="presentation"><span class="btn" id="allDataComplate">Completed</span>
                                </li>
                                <li role="presentation"><span class="btn" id="removeTodo">Clear
                                    All Completed</span></li>
                                <li role="presentation">Total <span id="countRow"></span> Data</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#data_insert").keyup(function (e) {
            if (e.key === "Enter" && $("#data_insert").val() != '') {
                addData($("#data_insert").val());
            }
        });
        $("#addRow").click(function (e) {
            if ($("#data_insert").val() != '') {
                addData($("#data_insert").val());
                $("#data_insert").val('');
            } else {
                alert('write something')
            }
        });


        $("#allData").click(function (e) {
            $("#todo_data").empty();
            getData();
        });
        $("#allDataActive").click(function (e) {
            $("#todo_data").empty();
            getData(1);
        });
        $("#allDataComplate").click(function (e) {
            $("#todo_data").empty();
            getData(0);
        });
        $("#removeTodo").click(function (e) {
            $("#todo_data").empty();
            remove('status', 0);
            getData();
        });
        getData();
    });

    function editData(obj, data) {
        $('#showText_' + data).css('display', 'none');
        $('#showEdit_' + data).css('display', 'block');
    }

    function doneEdit(obj, data) {
        $('#showText_' + data).css('display', 'block');
        $('#showEdit_' + data).css('display', 'none');
        update(data, -1, $('#showEdit_' + data).val());
    }

    function update(data, status = -1, value = false) {
        $.ajax({
            url: 'processData/editData.php?id=' + data + '&status=' + status + '&value=' + value,
            type: 'GET',
            success: function (response) {
                // getData();
            }
        });
    }

    function deletedata(obj, data) {
        $('#row_data_' + data).css('display', 'none');
        remove('id', data);
    }

    function remove(condition, value) {
        $.ajax({
            url: 'processData/deleteData.php?' + condition + '=' + value,
            type: 'GET',
            success: function (response) {

            }
        });
    }

    function checkComplate(obj, data) {
        if (!$("#check_box_" + data).is(":checked")) {
            $("#showText_" + data).css('text-decoration', 'none');
            update(data, 1);
        } else {
            $("#showText_" + data).css('text-decoration', 'line-through');
            update(data, 0);
        }
    }

    function addData(data) {
        $.ajax({
            url: 'processData/addData.php?data=' + data,
            type: 'GET',
            success: function (response) {
                if (response) {
                    $('#todo_data').append('<tr id="row_data_' + response + '"><td><div class="row"><div class="col-sm-12">' +
                        '<span class="form-control" id="showText_' + response + '" style="display: block;" ondblclick="editData(this,' + response + ')">' +
                        '<input type="checkbox" class="check_box" onclick="checkComplate(this,' + response + ')" id="check_box_' + response + '" value="' + response + '" class="checkbox_class"> ' + data + '</span>' +
                        '<input type="text" class="form-control" style="display: none;" id="showEdit_' + response + '" value="' + data + '" onblur="doneEdit(this,' + response + ')"></div></div></td>' +
                        '<td><button onclick="deletedata(this,' + response + ')" type="button"class="btn btn-danger btn-sm">' +
                        '<i class="fa fa-trash-o "></i> Remove</button></td></tr>');
                    $('#countRow').text(Number($('#countRow').text()) + 1);
                }
            }
        });
    }

    function getData(status = 2) {
        $.ajax({
            url: 'processData/getData.php?status=' + status,
            type: 'GET',
            success: function (response) {
                response = JSON.parse(response);
                if (response.total_data > 0) {
                    $('#countRow').text(response.total_data);
                    var i;
                    var stylede = '';
                    var checkedThakbe = '';
                    for (i = 0; i < response.total_data; ++i) {
                        if (response.data[i].status == 0) {
                            stylede = 'text-decoration:line-through;';
                            checkedThakbe = 'checked';
                        } else {
                            stylede = '';
                            checkedThakbe = '';
                        }
                        $('#todo_data').append('<tr id="row_data_' + response.data[i].id + '"><td><div class="row"><div class="col-sm-12">' +
                            '<span class="form-control" id="showText_' + response.data[i].id + '" style="display: block;' + stylede + '" ondblclick="editData(this,' + response.data[i].id + ')">' +
                            '<input type="checkbox"' + checkedThakbe + ' class="check_box" onclick="checkComplate(this,' + response.data[i].id + ')" id="check_box_' + response.data[i].id + '" value="' + response.data[i].id + '" class="checkbox_class"> ' + response.data[i].name + '</span>' +
                            '<input type="text" class="form-control" style="display: none;" id="showEdit_' + response.data[i].id + '" value="' + response.data[i].name + '" onblur="doneEdit(this,' + response.data[i].id + ')"></div></div></td>' +
                            '<td><button onclick="deletedata(this,' + response.data[i].id + ')" type="button"class="btn btn-danger btn-sm">' +
                            '<i class="fa fa-trash-o "></i> Remove</button></td></tr>');
                    }
                }
            }
        });
    }
</script>
</body>
</html>

