<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bisag Unsa System</title>

    <!-- For favicon.ico error -->
    <link rel="shortcut icon" href="#">

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.jqueryui.js"></script>
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.jqueryui.css">

    <!-- Jconfirm -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Flatpickr CSS and JS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Custom Styles -->
    <style>
        /* Google Fonts Import Link */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 260px;
            background: #11101d;
            z-index: 100;
            transition: all 0.5s ease;
        }

        .sidebar.close {
            width: 78px;
        }

        .sidebar .logo-details {
            height: 60px;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .sidebar .logo-details i {
            font-size: 30px;
            color: #fff;
            height: 50px;
            min-width: 78px;
            text-align: center;
            line-height: 50px;
        }

        .sidebar .logo-details .logo_name {
            font-size: 22px;
            color: #fff;
            font-weight: 600;
            transition: 0.3s ease;
            transition-delay: 0.1s;
        }

        .sidebar.close .logo-details .logo_name {
            transition-delay: 0s;
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-links {
            height: 100%;
            padding: 30px 0 150px 0;
            overflow: auto;
        }

        .sidebar.close .nav-links {
            overflow: visible;
        }

        .sidebar .nav-links::-webkit-scrollbar {
            display: none;
        }

        .sidebar .nav-links li {
            position: relative;
            list-style: none;
            transition: all 0.4s ease;
        }

        .sidebar .nav-links li:hover {
            background: #1d1b31;
        }

        .sidebar .nav-links li .iocn-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar.close .nav-links li .iocn-link {
            display: block
        }

        .sidebar .nav-links li i {
            height: 50px;
            min-width: 78px;
            text-align: center;
            line-height: 50px;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar .nav-links li.showMenu i.arrow {
            transform: rotate(-180deg);
        }

        .sidebar.close .nav-links i.arrow {
            display: none;
        }

        .sidebar .nav-links li a {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .sidebar .nav-links li a .link_name {
            font-size: 18px;
            font-weight: 400;
            color: #fff;
            transition: all 0.4s ease;
        }

        .sidebar.close .nav-links li a .link_name {
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-links li .sub-menu {
            padding: 6px 6px 14px 80px;
            margin-top: -10px;
            background: #1d1b31;
            display: none;
        }

        .sidebar .nav-links li.showMenu .sub-menu {
            display: block;
        }

        .sidebar .nav-links li .sub-menu a {
            color: #fff;
            font-size: 15px;
            padding: 5px 0;
            white-space: nowrap;
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        .sidebar .nav-links li .sub-menu a:hover {
            opacity: 1;
        }

        .sidebar.close .nav-links li .sub-menu {
            position: absolute;
            left: 100%;
            top: -10px;
            margin-top: 0;
            padding: 10px 20px;
            border-radius: 0 6px 6px 0;
            opacity: 0;
            display: block;
            pointer-events: none;
            transition: 0s;
        }

        .sidebar.close .nav-links li:hover .sub-menu {
            top: 0;
            opacity: 1;
            pointer-events: auto;
            transition: all 0.4s ease;
        }

        .sidebar .nav-links li .sub-menu .link_name {
            display: none;
        }

        .sidebar.close .nav-links li .sub-menu .link_name {
            font-size: 18px;
            opacity: 1;
            display: block;
        }

        .sidebar .nav-links li .sub-menu.blank {
            opacity: 1;
            pointer-events: auto;
            padding: 3px 20px 6px 16px;
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-links li:hover .sub-menu.blank {
            top: 50%;
            transform: translateY(-50%);
        }

        .one {
            width: 80%;
            margin-left: 10%;
            background-color: black;
            height: 400px;
        }

        .sidebar .profile-details {
            position: fixed;
            bottom: 0;
            width: 260px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #1d1b31;
            padding: 12px 0;
            transition: all 0.5s ease;
        }

        .sidebar.close .profile-details {
            background: none;
        }

        .sidebar.close .profile-details {
            width: 78px;
        }

        .sidebar .profile-details .profile-content {
            display: flex;
            align-items: center;
        }

        .sidebar .profile-details img {
            height: 52px;
            width: 52px;
            object-fit: cover;
            border-radius: 16px;
            margin: 0 14px 0 12px;
            background: #1d1b31;
            transition: all 0.5s ease;
        }

        .sidebar.close .profile-details img {
            padding: 10px;
        }

        .sidebar .profile-details .profile_name,
        .sidebar .profile-details .job {
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            white-space: nowrap;
        }

        .sidebar.close .profile-details i,
        .sidebar.close .profile-details .profile_name,
        .sidebar.close .profile-details .job {
            display: none;
        }

        .sidebar .profile-details .job {
            font-size: 12px;
        }

        .home-section {
            position: relative;
            background: #f2f2f2;
            height: 100vh;
            left: 260px;
            width: calc(100% - 260px);
            transition: all 0.5s ease;
            overflow-y: scroll;
        }

        .sidebar.close~.home-section {
            left: 78px;
            width: calc(100% - 78px);
        }

        .home-section .home-content {
            height: 60px;
            display: flex;
            align-items: center;
        }

        .home-section .bx-menu,
        .home-section .text {
            color: #11101d;
            font-size: 35px;
        }

        .home-section .bx-menu {
            margin: 0 15px;
            cursor: pointer;
        }

        .home-section .home-content .text {
            font-size: 26px;
            font-weight: 600;
        }

        @media (max-width: 420px) {
            .sidebar.close .nav-links li .sub-menu {
                display: none;
            }
        }

        .supplier-table-container,
        .my-tasks-table-container,
        .contacts-table-container,
        .others-tasks-table-container,
        .category-table-container,
        .location-table-container,
        .all-items-table-container,
        .item-table-container,
        .user-table-container {
            background-color: white;
            padding: 1%;
            border-radius: 5px;
        }

        .btn-fixed-width {
            width: 120px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            font-size: 0.875rem;
        }

        /* Custom styles for contact details and bank details */
        .contact-details,
        .bank-details {
            padding: 10px;
            background-color: #f9f9f9;
            /* Light grey background for better readability */
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .contact-details strong,
        .bank-details strong {
            color: #2c3e50;
            /* Darker color for labels */
        }

        table.dataTable td {
            vertical-align: middle;
            /* Vertically align text to the middle */
        }

        /* Optional: Add zebra striping to rows */
        table.dataTable tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        /* Optional: Add hover effect to rows */
        table.dataTable tbody tr:hover {
            background-color: #e0e0e0;
        }

        /* Custom Modal Styling */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background-color: #e6f7e6;
            /* Light green background color for the modal header */
            padding: 1rem 1.5rem;
            /* Equal padding for top and bottom */
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header .modal-title {
            font-weight: bold;
            font-size: 1.25rem;
            color: #333;
            /* Dark text color for contrast */
        }

        .modal-body {
            padding-top: 2rem;
            /* Added space to move the content away from the header */
        }

        .modal-footer {
            border-top: none;
            justify-content: space-between;
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 0.75rem 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-secondary {
            border-radius: 8px;
        }

        .btn-primary {
            border-radius: 8px;
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Custom Close Button */
        .btn-close {
            background: none;
            border: none;
            font-size: 1.25rem;
        }

        .btn-close:hover {
            color: #dc3545;
            opacity: 0.75;
        }



        /* Custom styles for the user profile */

        .user-profile {
            text-align: center;
            padding: 10px;
            margin-bottom: 10px;
        }

        .sidebar {
            width: 250px;
            /* Width when sidebar is open */
            transition: width 0.3s ease;
            /* Smooth transition for width */
        }

        .sidebar.close {
            width: 78px;
            /* Width when sidebar is closed */
        }

        .sidebar .logo-details {
            height: 60px;
            width: 100%;
            display: flex;
            align-items: center;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            /* Smooth transition for opacity and visibility */
        }

        .sidebar .logo-details i {
            font-size: 30px;
            color: #fff;
            height: 50px;
            min-width: 78px;
            text-align: center;
            line-height: 50px;
            transition: font-size 0.3s ease;
            /* Smooth transition for font size */
        }

        .sidebar .logo-details .logo_name {
            font-size: 22px;
            color: #fff;
            font-weight: 600;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            /* Smooth transition for opacity and visibility */
        }

        .sidebar.close .logo-details .logo_name {
            opacity: 0;
            visibility: hidden;
            /* Hide logo name when sidebar is closed */
        }

        .sidebar .nav-links {
            height: 100%;
            padding: 30px 0 150px 0;
            overflow: auto;
            transition: padding 0.3s ease;
            /* Smooth transition for padding */
        }

        .sidebar.close .nav-links {
            padding: 30px 0 50px 0;
            /* Adjusted padding for closed state */
        }

        .user-profile {
            text-align: center;
            padding: 10px;
            color: #fff;
            margin-bottom: 10px;
            transition: height 0.3s ease, padding 0.3s ease;
            /* Smooth transition for height and padding */
        }

        .user-initials {
            width: 50px;
            height: 50px;
            background-color: #fff;
            color: #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 10px auto;
            font-weight: bold;
            transition: width 0.3s ease, height 0.3s ease, font-size 0.3s ease, margin 0.3s ease;
            /* Smooth transition for size and margin */
        }

        .user-info {
            text-align: center;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            /* Smooth transition for opacity and visibility */
        }

        .user_name {
            display: block;
            font-size: 16px;
            font-weight: bold;
        }

        .user_role {
            display: block;
            font-size: 14px;
            font-weight: normal;
        }

        /* Additional styles for the closed sidebar state */
        .sidebar.close .user-info {
            opacity: 0;
            visibility: hidden;
            /* Hide user info when sidebar is closed */
        }

        .sidebar.close .user-profile {
            height: 70px;
            /* Adjust height as needed */
            padding: 10px 0;
            /* Adjust padding as needed */
        }

        .sidebar .nav-links.logout-link {
            padding: 0 0 30px 0;
            margin-top: 210px;
        }


        /* Override default select2 appearance */
        .select2-selection__rendered {
            line-height: 45px !important;
            padding-left: 10px;
        }

        .select2-container .select2-selection--single {
            height: 45px !important;
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
        }

        .select2-selection__arrow {
            height: 44px !important;
        }
    </style>

</head>

<body>
    <?php $this->load->view('common/sidebar'); ?>

    <section class="home-section">
        <?php echo $content; ?>
    </section>

    <script>
        // Sidebar
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
            });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
        // Sidebar
    </script>
</body>

</html>