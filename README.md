# WIL Project Allocation System

## Introduction
This web application, developed for the IT/Computer Science capstone course, facilitates the allocation of students to Work Integrated Learning (WIL) projects. It allows industry partners to advertise projects and students to apply for them, ultimately assigning students to suitable projects. The project is done with PHP and Laravel

## Key Features
### User Registration and Authentication
- Distinct User Types: Two types of user registrations – Industry Partners (InPs) and Students.
- Secure Authentication: Mandatory login to access application features, enhancing security and user experience.

### Project Management
- CRUD Operations for InPs: InPs can Create, Read, Update, and Delete projects with validation checks.
- Conditional Deletion: Projects with existing student applications cannot be deleted, ensuring data integrity.
- Unique Project Names per Offering: Ensures no duplicate project names within the same trimester and year.

### Student Applications
- Project Application Limit: Students can apply to up to three projects, fostering diverse choices.
- Application Justification: Students provide reasons for project choices, adding depth to the application process.

### Automated Student Assignment
- Teacher-Triggered Algorithm: Teachers initiate the student-to-project assignment process.
- Criteria-Based Assignment: Students are assigned based on GPA, role preference, team size, and project choice.

### Project and User Information Display
- Detailed Project Pages: Shows comprehensive details about projects and the offering InP.
- InP and Student Profile Pages: Dedicated pages displaying profiles and project involvement.

### File Uploads
- Supports Multiple Formats: InPs can upload images and PDFs, providing richer project information.
- Accessible from Project Details: Uploaded files are viewable and downloadable from the project's detail page.

### Student Profiles
- Comprehensive Information: Includes GPA and preferred roles, influencing the assignment algorithm.
- Editable Profiles: Students can update their profiles, ensuring up-to-date information.

### Pagination and Grouping
- Paginated InP Display: Limits the number of InPs per page for better user experience.
- Chronological Project Grouping: Projects are grouped and displayed by year and trimester in reverse chronological order.

## Technical Specifications
### Laravel Framework Utilization
- Migration for Database Structure: Ensures a consistent database schema across different environments.
- Seeders for Initial Data: Populates the database with test data to facilitate initial testing.
- Eloquent ORM: Used for database operations, leveraging Laravel's active record implementation.

### Security and Validation
- Server-Side Validation: All inputs are validated on the server side to prevent invalid data submissions.
- Security Measures: Includes input sanitization and other security best practices to protect against common vulnerabilities.

Coding Formatting
- Consistent Naming Conventions: Ensures code readability and maintainability.
- Code Readability: Well-indented and spaced code for easier understanding and collaboration.
- Commenting: Functions and complex logic are accompanied by comments explaining their purpose.
- Template Usage: Effective use of Laravel's blade templating for a clean and manageable view layer.
