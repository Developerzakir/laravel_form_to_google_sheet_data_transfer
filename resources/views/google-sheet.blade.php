<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Google Sheets Laravel</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <form id="googleSheetForm">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="mobile" placeholder="Mobile Number" required>
        <button type="submit">Submit</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="dataTable">
        </tbody>
    </table>

   

<script>

 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});



$(document).ready(function(){
    loadData();

    $('#googleSheetForm').submit(function(e){
        e.preventDefault();
        $.post('/google-sheet/store', $(this).serialize(), function(){
            alert('Data Inserted');
            $('#googleSheetForm')[0].reset(); // Reset the form fields
            loadData();
        });
    });

    function loadData(){
        $.get('/google-sheet', function(data){
            $('#dataTable').empty();
            $.each(data, function(index, row){
                $('#dataTable').append(`
                    <tr>
                        <td>${row[0]}</td>
                        <td>${row[1]}</td>
                        <td>${row[2]}</td>
                        <td><button onclick="deleteRow(${index})">Delete</button></td>
                    </tr>
                `);
            });
        });
    }

    window.deleteRow = function(rowIndex){
        $.ajax({
            url: `/google-sheet/delete/${rowIndex}`,
            type: 'DELETE',
            success: function(){
                alert('Row Deleted');
                loadData();
            }
        });
    }
});
</script>

</body>
</html>
