# Student Management System

This is a comprehensive school management application designed to manage various roles and processes within an educational institution. The system allows administrators, teachers, academic officers, and students to interact with different features, ensuring smooth operations in teaching, grading, and administrative tasks.

## :rocket: **Technologies Used** 

- **Frontend**: HTML, CSS, Bootstrap, JavaScript (AJAX) :art:
- **Backend**: PHP
- **Database**: MySQL 
- **Email Integration**: For sending invitations with verification codes :envelope_with_arrow:

## :computer: **Features Overview**

### 1. **Admin Features**
   - **Login**: Secure login for the admin user.
   - **Manage Administration**: Admin can manage the core functionality of the system.
   - **Send Invitations**: Admin sends registration invitations to teachers and academic officers, containing usernames, passwords, and unique verification codes.
   - **Manage Users**: Admin has the authority to manage teachers, academic officers, and students.
   - **Assign Teachers**: Admin assigns teachers to subjects and grades. Teachers cannot change these assignments.
   - **Check Results**: Admin has access to check results for all users.
   - **Update Profile**: Admin can update their profile details.
   - **Log Out**: Secure logout functionality.

### 2. **Teacher Features**
   - **Login**: Teachers can log in with a username, password, and verification code sent by the admin.
   - **Add Lesson Notes**: Teachers can upload lesson notes for students.
   - **Add Assignments**: Teachers can create assignments for students.
   - **View Submitted Answer Sheets**: Teachers can view the answers submitted by students.
   - **Grade Assignments**: Teachers can grade assignments, but the marks are initially submitted to the academic officer for review before being released to students.
   - **Update Profile**: Teachers can update their personal details.
   - **Log Out**: Secure logout functionality.

### 3. **Student Features**
   - **Login**: Students can log in using the verification code sent by academic officers.
   - **Download Assignments**: Students can download assignments posted by teachers.
   - **View Lesson Notes**: Students can access lesson notes relevant to their grade.
   - **Upload Answers**: Students can upload completed assignments.
   - **Update Profile**: Students can update their personal details.
   - **Log Out**: Secure logout functionality.

### 4. **Academic Officer Features**
   - **Login**: Academic officers can log in using the credentials provided by the admin.
   - **Register Students**: Academic officers can register new students and send them a verification code.
   - **View Assignment Marks**: Academic officers can view marks submitted by teachers.
   - **Release Marks**: Academic officers are responsible for releasing grades to students once approved.
   - **Update Profile**: Academic officers can update their personal details.
   - **Log Out**: Secure logout functionality.

## Key System Functionality

- **Role-Based Access**: Each user (Admin, Teacher, Student, Academic Officer) has specific permissions based on their role.
- **One-Time Verification Code**: A unique, one-time verification code is sent via email for teachers and academic officers to authenticate their initial login.
- **Grade Management**: Only the admin can update student grades.
- **Payment System**: After one month of free access, students will be required to pay an enrollment fee to continue using the system.
- **Trial Period**: Students enjoy free access for one month, after which a payment is required for continued use.
- **Subject Access**: Students only have access to lesson notes and assignments related to their grade, preventing unauthorized access to other grades' materials.



## Usage

- **Admin**: Logs in first and sends out invitations to teachers and academic officers. Admin assigns subjects and grades to teachers.
- **Teacher**: Registers using the invitation code, then adds lesson notes and assignments. Marks are submitted to the academic officer for approval before being released.
- **Academic Officer**: Registers students, verifies accounts with codes, and manages grades.
- **Student**: Logs in with the academic officer’s code, accesses lessons, and submits assignments.


