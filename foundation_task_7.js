$(document).ready(function() {
    fetchPeopleData();

    // Event listener for real-time validation
    $('#Email').on('input', function() {
        validateEmail();
    });

    function validateEmail() {
        var email = $('#Email').val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var isValidEmail = emailRegex.test(email);

        // Update the border color based on the validation result
        $('#Email').css('border-color', isValidEmail ? 'green' : 'red');
    }
});

function addPerson() {
    // Validate the form before submitting
    if (validateFormData()) {
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
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Record added successfully!',
                });
            },
            error: function(xhr, status, error) {
                console.error('Error submitting form: ' + error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add record. Please try again.',
                });
            }
        });
    }
}

function validateFormData() {
    // Get form data
    var formData = new FormData($('#dataForm')[0]);
    var firstName = formData.get('FirstName').trim();
    var surname = formData.get('Surname').trim();
    var dateOfBirth = formData.get('DateOfBirth').trim();
    var email = formData.get('Email').trim();

    // Check if fields are not empty
    if (firstName === '' || surname === '' || dateOfBirth === '' || email === '') {
        showValidationError('All fields are required!');
        return false;
    }

    // Check if the date of birth is in the past
    var currentDate = new Date();
    var selectedDate = new Date(dateOfBirth);
    if (selectedDate >= currentDate) {
        showValidationError('Date of birth must be in the past!');
        return false;
    }

    // Validate email format using a regular expression
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showValidationError('Invalid email format!');
        return false;
    }

    return true;
}

function showValidationError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        text: message,
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
    // Clear the table body
    var tableBody = $('#peopleTable');
    tableBody.empty();

    // Loop through the people array and add each person to the table
    $.each(people, function(index, person) {
        var newrow = '<tr>' +
            // '<td>' + person.Id + '</td>' +
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
    // Fetch the record data from the server
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
    // Validate the form before submitting
    if (validateEditForm()) {
        // Get the record ID from the button attribute
        var recordId = $('#UpdateBtn').attr('data-record-id');

        // Get the form data
        var formData ={
            Id: $('#EditRecordID').val(),
            FirstName: $('#EditFirstNameTxt').val(),
            Surname: $('#EditSurnameTxt').val(),
            DateOfBirth: $('#EditDateOfBirth').val(),
            Email: $('#EditEmail').val()
        };

        // Send the updated data to the server
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
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Person successfully updated!',
                });
            },
            error: function(xhr, status, error) {
                console.error('Error updating record: ' + error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update record. Please try again.',
                });
            }
        });
    }
}

function validateEditForm() {
    var formData = {
        Id: $('#EditRecordID').val(),
        FirstName: $('#EditFirstNameTxt').val(),
        Surname: $('#EditSurnameTxt').val(),
        DateOfBirth: $('#EditDateOfBirth').val(),
        Email: $('#EditEmail').val()
    };

    function showValidationError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: message,
        });
    }

    // Perform validation checks
    if (formData.FirstName.trim() === '') {
        showValidationError('First name is required!');
        return false;
    }

    if (formData.Surname.trim() === '') {
        showValidationError('Surname is required!');
        return false;
    }

    // Validate Date of Birth (optional, adjust as needed)
    if (formData.DateOfBirth.trim() === '') {
        showValidationError('Date of Birth is required!');
        return false;
    }

    // Check if the date of birth is in the past
    var currentDate = new Date();
    var selectedDate = new Date(formData.DateOfBirth);
    if (selectedDate >= currentDate) {
        showValidationError('Date of birth must be in the past!');
        return false;
    }

    // Validate Email
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (formData.Email.trim() === '' || !emailRegex.test(formData.Email)) {
        showValidationError('Enter a valid email address!');
        return false;
    }

    return true;
}

function deleteRecord(recordId) {
    // Prompt the user to confirm the deletion
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#007bff',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
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
    });
}

function closeEditModal() {
    $('#editModal').css('display', 'none');
}

function deleteAllRecords() {
    // Prompt the user to confirm the deletion
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#007bff',
        confirmButtonText: 'Yes, delete ALL people!'
    }).then((result) => {
        if (result.isConfirmed) {
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
            });
        }
    })
}