# Online Educational Environment

Hosted at: https://airaptis.webpages.auth.gr/4007partB/

Login/password for tutor/student:
- **USERNAME (tutor)**: testlogin
- **PASSWORD(tutor)**: 123
- **USERNAME(student)**: testlogin2
- **PASSWORD(student)**: 123

The Online Educational Environment is a PHP-based web application designed to streamline the management of educational resources and facilitate effective communication between tutors and students. This platform supports various functionalities crucial for educational settings, including user authentication, management of announcements, assignments, and documents, as well as a messaging system for enhanced interaction.

## Features
- **User Authentication**: Secure login for both tutors and students.
- **Announcements Management**: Create, edit, and delete announcements to keep users informed.
- **Assignments Management**: Add, edit, and delete assignments with details such as objectives, deliverables, and submission dates.
- **Document Management**: Upload and manage educational materials.
- **Messaging System**: Direct messaging between users with additional tools for tutors.

## Database Tables
- **announcements**: Stores announcements with fields `id`, `date`, `subject`, and `main_text`.
- **assignments**: Contains assignment details with fields `id`, `objectives`, `assignment_text`, `deliverables`, and `submission_date`.
- **documents**: Stores documents with fields `id`, `title`, `description`, and `file_name`.
- **users**: Contains user information with fields `id`, `name`, `surname`, `loginame`, `password`, and `role`.

## Key PHP Files
- **db_connection.php**: Manages database connection.
- **add_announcement.php**: Handles the creation of new announcements.
- **add_assignment.php**: Adds new assignments.
- **add_document.php**: Uploads and adds new documents.
- **announcement.php**: Displays announcements to users.
- **announcement_tutor.php**: Allows tutors to manage announcements.
- **communication.php**: Messaging for general users.
- **communication_tutor.php**: Enhanced messaging tools for tutors.
- **delete_announcement.php**: Deletes announcements.
- **delete_assignment.php**: Deletes assignments.
- **documents.php**: Manages document display and downloads.
- **documents_tutor.php**: Allows tutors to manage documents.
- **edit_announcement.php**: Edits existing announcements.
- **edit_assignment.php**: Edits existing assignments.
- **edit_document.php**: Edits existing documents.
- **edit_user.php**: Edits user profiles.
- **homework.php**: Displays assignments to students.
- **homework_tutor.php**: Manages assignments for tutors.
- **index.php**: Entry point for students.
- **index_tutor.php**: Entry point for tutors.

## Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (e.g., Apache)

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/Sonath21/Online-Educational-Environment.git
