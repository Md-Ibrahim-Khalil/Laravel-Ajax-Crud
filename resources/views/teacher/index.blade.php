<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 8 Ajax Crud Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Title</label>
                                <input type="text" class="form-control" id="" placeholder="Job Position">
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Institute</label>
                                <input type="text" class="form-control" id="" placeholder="Institute Name">
                              </div>
                              <button type="submit" id="addButton" class="button btn btn-warning">Add</button> 
                              <button type="submit" id="updateButton" class="button btn btn-success">Update</button> 
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
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function allData() {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/teacher/all",
                success:function(response) {

                    var data = ""

                    $.each(response, function(key, value){
                        // console.log(value.name);
                        data = data + "<tr>"
                            data = data + "<td>"+value.id+"</td>"  
                            data = data + "<td>"+value.name+"</td>"  
                            data = data + "<td>"+value.title+"</td>"  
                            data = data + "<td>"+value.institute+"</td>" 
                            data = data + "<td>"
                            data = data + "<button class='btn btn-sm btn-primary mr-2'>Edit</button>"
                            data = data + "<button class='btn btn-sm btn-danger'>Delete</button>"
                            data = data + "</td>" 
                        data = data + "</tr>"
                    });

                    $('tbody').html(data);
                }
            })
        }
        allData();
    </script>
</body>
</html>