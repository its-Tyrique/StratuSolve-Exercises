function submitForm() {
    /*var formData = {
        FirstName: $('#FirstNameTxt').val(),
        Surname: $('#SurnameTxt').val(),
        DateOfBirth: $('#DateOfBirth').val(),
        Email: $('#Email').val(),
    };*/

    var formData = new FormData($('#dataForm')[0]);

    $.ajax({
        url: 'foundation_task_7.php',
        method: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        dataType: 'json',
        success: function(response) {
            console.log('Server Response: '+ response);
            fetchPeopleData();
        },
        error: function(xhr, status, error) {
            console.error('Error submitting form: ' + error);
        }
    });
}


function fetchPeopleData() {
    $.ajax({
        url: 'foundation_task_7.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            displayPeople(data);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching people data: ' + error);
        }
    });
}

function displayPeople(people) {
    var tableBody = $('#peopleTable');
    tableBody.empty();

    $.each(people, function(index, person) {
        var newrow = '<tr>' +
            '<td>' + person.Id + '</td>' +
            '<td>' + person.FirstName + '</td>' +
            '<td>' + person.Surname + '</td>' +
            '<td>' + person.DateOfBirth + '</td>' +
            '<td>' + person.EmailAddress + '</td>' +
            '<td>' + person.Age + '</td>' +
            '<td>' +
                '<button class="actions-btn" onclick="editRecord('+person.Id+')">Edit</button>' +
                '<button class="delete-actions-btn" onclick="deleteRecord('+person.Id+')">Delete</button>' +
            '</td>' +
            '</tr>';
        tableBody.append(newrow);
    });
}

function editRecord(recordId) {
    $.ajax({
        url: 'foundation_task_7.php?loadPerson=true&PersonId=' + recordId,
        method: 'GET',
        dataType: 'json',
        success: function(record) {
            // Populate modal with the record data
            $('#EditRecordID').val(record.Id);
            $('#EditFirstNameTxt').val(record.FirstName);
            $('#EditSurnameTxt').val(record.Surname);
            $('#EditDateOfBirth').val(record.DateOfBirth);
            $('#EditEmail').val(record.EmailAddress);

            $('#UpdateBtn').attr('data-record-id', record.Id);

            // Show the modal
            $('#editModal').css('display', 'block');
        },
        error: function(xhr, status, error) {
            console.error('Error fetching record data: ' + error);
        }
    });
}

function updateRecord() {
    var recordId = $('#UpdateBtn').attr('data-record-id');

    var formData ={
        Id: $('#EditRecordID').val(),
        FirstName: $('#EditFirstNameTxt').val(),
        Surname: $('#EditSurnameTxt').val(),
        DateOfBirth: $('#EditDateOfBirth').val(),
        Email: $('#EditEmail').val()
    };

    console.log(formData);

    $.ajax({
        url: 'foundation_task_7.php',
        method: 'POST',
        dataType: 'json',
        data: {
            updatePerson: true,
            PersonId: recordId,
            FirstName: $('#EditFirstNameTxt').val(),
            Surname: $('#EditSurnameTxt').val(),
            DateOfBirth: $('#EditDateOfBirth').val(),
            Email: $('#EditEmail').val(),
        },
        success: function(response) {
            console.log('Server Response: '+ response + ' RecordId: ' + recordId);
            closeEditModal();
            fetchPeopleData();
        },
        error: function(xhr, status, error) {
            console.error('Error updating record: ' + error);
        }
    });
}

function deleteRecord(recordId) {
    if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            url: 'foundation_task_7.php',
            method: 'POST',
            dataType: 'json',
            data: {
                deletePerson: true,
                PersonId: recordId
            },
            success: function(response) {
                console.log('Server Response: '+ response + ' RecordId: ' + recordId);
                fetchPeopleData();
            },
            error: function(xhr, status, error) {
                console.error('Error deleting record: ' + error);
            }
        });
    }
}

function closeEditModal() {
    // Close the modal
    $('#editModal').css('display', 'none');
}

function deleteAllRecords() {
    if (confirm("Are you sure you want to delete all record?")) {
        $.ajax({
            url: 'foundation_task_7.php',
            method: 'POST',
            data: {deleteAllRecords: true},
            dataType: 'json',
            success: function(response) {
                console.log('Server Response: '+ response);
                fetchPeopleData();
            },
            error: function(xhr, status, error) {
                console.error('Error deleting all records: ' + error);
            }
        })
    }
}

$(document).ready(function() {
    fetchPeopleData();
});

