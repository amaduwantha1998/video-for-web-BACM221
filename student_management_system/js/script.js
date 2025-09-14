// Function to edit student
function editStudent(student) {
    $('#student_id').val(student.student_id);
    $('#name').val(student.name);
    $('#age').val(student.age);
    $('#gender').val(student.gender);
    $('#class').val(student.class);
    $('#email').val(student.email);
    $('#phone').val(student.phone);
    $('#submit-btn').attr('name', 'update').text('Update');
}

// Similar for subject
function editSubject(subject) {
    $('#subject_id').val(subject.subject_id);
    $('#subject_name').val(subject.subject_name);
    $('#subject_code').val(subject.subject_code);
    $('#description').val(subject.description);
    $('#submit-btn').attr('name', 'update').text('Update');
}

// For enrollment
function editEnrollment(enrollment) {
    $('#enrollment_id').val(enrollment.enrollment_id);
    $('#student_id').val(enrollment.student_id);
    $('#subject_id').val(enrollment.subject_id);
    $('#enrollment_date').val(enrollment.enrollment_date);
    $('#submit-btn').attr('name', 'update').text('Update');
}

// For user
function editUser(user) {
    $('#user_id').val(user.user_id);
    $('#username').val(user.username);
    $('#password').val('');  // Don't prefill password
    $('#role').val(user.role);
    $('#submit-btn').attr('name', 'update').text('Update');
}

// AJAX form submission example (for students; replicate for others if needed)
$(document).ready(function() {
    $('#student-form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'students.php',
            data: $(this).serialize(),
            success: function() {
                location.reload();  // Reload to see changes
            }
        });
    });
    // Add similar for other forms
});