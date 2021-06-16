<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 8 Ajax Crud Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.min.js"></script>
</head>

<body>
    <div style="padding: 30px;"></div>
    <div class="container">
        <h2 style="color: red;">
            <marquee behavior="" direction="">Laravel Ajax Crud Application</marquee>
        </h2>
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        All Teacher
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Institute</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>
                                    <button class="btn btn-sm btn-primary mr-2">Edit</button>
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <span id="addT">Add New Teacher</span>
                        <span id="updateT">Update Teacher</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name">
                            <span class="text-danger" id="nameError"></span>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" placeholder="Job Position">
                            <span class="text-danger" id="titleError"></span>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Institute</label>
                            <input type="text" class="form-control" id="institute" placeholder="Institute Name">
                            <span class="text-danger" id="instituteError"></span>
                        </div>
                        <input type="hidden" id="id">
                        <button type="submit" id="addButton" onclick="addData()"
                            class="button btn btn-warning">Add</button>
                        <button type="submit" id="updateButton" onclick="updateData()"
                            class="button btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('#addT').show();
        $('#addButton').show();
        $('#updateT').hide();
        $('#updateButton').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //-------------------------Get All Data From Data Base------------------------------//
        function allData() {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/teacher/all",
                success: function(response) {

                    var data = ""

                    $.each(response, function(key, value) {
                        // console.log(value.name);
                        data = data + "<tr>"
                        data = data + "<td>" + value.id + "</td>"
                        data = data + "<td>" + value.name + "</td>"
                        data = data + "<td>" + value.title + "</td>"
                        data = data + "<td>" + value.institute + "</td>"
                        data = data + "<td>"
                        data = data +
                            "<button class='btn btn-sm btn-primary mr-2' onClick='editData(" + value
                            .id + ")'>Edit</button>"
                        data = data + "<button class='btn btn-sm btn-danger' onClick='deleteData(" +
                            value.id + ")'>Delete</button>"
                        data = data + "</td>"
                        data = data + "</tr>"
                    });

                    $('tbody').html(data);
                }
            })
        }
        allData();

        //-------------------------End Get All Data From Data Base------------------------------//



        //-------------------------Clear Data------------------------------//
        function clearData() {
            $('#name').val('');
            $('#title').val('');
            $('#institute').val('');
            $('#nameError').text('');
            $('#titleError').text('');
            $('#instituteError').text('');
        }
        //-------------------------End Clear Data------------------------------//

        //-------------------------Store Data------------------------------//

        function addData() {
            var name = $('#name').val();
            var title = $('#title').val();
            var institute = $('#institute').val();

            // console.log(name);
            // console.log(title);
            // console.log(institute);

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: name,
                    title: title,
                    institute: institute
                },
                url: "/teacher/store/",
                success: function(data) {
                    clearData();
                    allData();

                    //Start Alert
                    const Msg = Swal.mixin({

                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Msg.fire({
                        icon: 'success',
                        title: 'Data Added Successfully',
                    })
                    //End Alert

                    console.log('Successfully Data Added');
                },
                error: function(error) {

                    $('#nameError').text(error.responseJSON.errors.name);
                    $('#titleError').text(error.responseJSON.errors.title);
                    $('#instituteError').text(error.responseJSON.errors.institute);

                    // console.log(error.responseJSON.errors.name);
                    // console.log(error.responseJSON.errors.title);
                    // console.log(error.responseJSON.errors.institute);
                }
            })
        }
        //-------------------------End Store Data------------------------------//

        //-------------------------Start Edit Data------------------------------//

        function editData(id) {
            // alert(id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/teacher/edit/" + id,
                success: function(data) {
                    $('#addT').hide();
                    $('#addButton').hide();
                    $('#updateT').show();
                    $('#updateButton').show();

                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#title').val(data.title);
                    $('#institute').val(data.institute);

                    console.log(data);
                }
            })
        }

        //-------------------------End Edit Data------------------------------//

        //-------------------------start Update Data------------------------------//
        function updateData() {

            var id = $('#id').val();
            var name = $('#name').val();
            var title = $('#title').val();
            var institute = $('#institute').val();

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: name,
                    title: title,
                    institute: institute
                },
                url: "/teacher/update/" + id,
                success: function(data) {

                    $('#addT').show();
                    $('#addButton').show();
                    $('#updateT').hide();
                    $('#updateButton').hide();
                    clearData();
                    allData();
                    //Start Alert
                    const Msg = Swal.mixin({

                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Msg.fire({
                        icon: 'success',
                        title: 'Data Update Successfully',
                    })
                    //End Alert
                },

                error: function(error) {

                    $('#nameError').text(error.responseJSON.errors.name);
                    $('#titleError').text(error.responseJSON.errors.title);
                    $('#instituteError').text(error.responseJSON.errors.institute);
                }
            })
        }

        //-------------------------End Update Data------------------------------//

        //-------------------------Start Delete Data------------------------------//
        function deleteData(id) {
            swal({
                    title: "Are You Sure To Delete?",
                    text: "Once Deleted, You wil not able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })

                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: "/teacher/destroy/" + id,
                            success: function(data) {
                                $('#addT').show();
                                $('#addButton').show();
                                $('#updateT').hide();
                                $('#updateButton').hide();
                                clearData();
                                allData();

                                //Start Alert
                                const Msg = Swal.mixin({

                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                Msg.fire({
                                    icon: 'success',
                                    title: 'Data Added Successfully',
                                })
                                //End Alert
                            }
                        })
                    } else {
                        swal("Cancled");
                    }
                })
        };


        //-------------------------End Delete Data------------------------------//

    </script>
</body>

</html>
