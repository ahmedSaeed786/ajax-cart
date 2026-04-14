@extends('layouts.app')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f9fafb;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .dashboard {
            flex: 1;
            display: flex;
        }

        /* Sidebar */

        .sidebar {
            width: 220px;
            background: linear-gradient(160deg, #ff8a00, #2563eb);
            padding: 30px 20px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .sidebar::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.25);
        }

        .sidebar * {
            position: relative;
            z-index: 1;
        }

        .logo {
            margin-bottom: 40px;
            font-size: 20px;
            font-weight: 600;
        }

        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .sidebar a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            transition: 0.3s ease;
        }

        .sidebar a.active {
            color: #ffffff;
            font-weight: 600;
            position: relative;
        }

        .sidebar a.active::before {
            content: "";
            position: absolute;
            left: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 20px;
            background: #00e676;
            border-radius: 4px;
        }

        .sidebar a:hover {
            transform: translateX(5px);
        }

        /* Main */
        .main {
            flex: 1;
            padding: 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .topbar input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 220px;
        }

        /* Table */
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            font-size: 13px;
            color: #6b7280;
            padding-bottom: 15px;
        }

        td {
            padding: 15px 0;
            border-top: 1px solid #f0f0f0;
            font-size: 14px;
        }

        tr:hover {
            background: #f9fafb;
        }

        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge.active {
            background: #dcfce7;
            color: #15803d;
        }

        .badge.suspended {
            background: #fee2e2;
            color: #ff8a00;
        }

        /* Buttons */
        button {
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            margin-right: 6px;
        }

        .toggle {
            background: #2563eb;
            color: white;
        }

        .delete {
            background: #ff8a00;
            color: white;
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .pagination button {
            background: #e5e7eb;
        }

        .pagination .current {
            background: #2563eb;
            color: white;
        }

        /* Footer */
        footer {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #111827;
            color: #9ca3af;
            font-size: 14px;
        }

        footer {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #111827;
            color: #9ca3af;
            font-size: 14px;
        }
    </style>

    {{-- <div class="mx-auto container bg-white shadow rounded mt-20">

        <div class="w-full overflow-x-scroll xl:overflow-x-hidden">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="w-full h-16 border-gray-300 border-b py-8">


                        <th class="text-gray-600 font-normal pr-6 text-left text-sm tracking-normal leading-4">Customer
                            Name</th>
                        <th class="text-gray-600 font-normal pr-6 text-left text-sm tracking-normal leading-4">Date</th>
                        <th class="text-gray-600 font-normal pr-6 text-left text-sm tracking-normal leading-4">Phone Number
                        </th>
                        <th class="text-gray-600 font-normal pr-6 text-left text-sm tracking-normal leading-4">Total Price
                        </th>


                        <td class="text-gray-600 font-normal pr-8 text-left text-sm tracking-normal leading-4">
                            More
                        </td>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($customers as $item)
                        <tr class="h-24 border-gray-300 border-b">


                            <td class="text-sm pr-6 whitespace-no-wrap text-gray-800 tracking-normal leading-4">
                                {{ $item->name }}</td>
                            <td class="text-sm pr-6 whitespace-no-wrap text-gray-800 tracking-normal leading-4">
                                {{ $item->date }}</td>

                            <td class="text-sm pr-6 whitespace-no-wrap text-gray-800 tracking-normal leading-4">
                                {{ $item->phone }}</td>
                            <td class="text-sm pr-6 whitespace-no-wrap text-gray-800 tracking-normal leading-4">
                                {{ $item->item_sum_total }}
                            </td>

                            <td class="pr-8 relative">
                                <div class="dropdown-content mt-8 absolute left-0 -ml-12 shadow-md z-10 hidden w-32">
                                    <ul class="bg-white shadow rounded py-1">
                                        <li
                                            class="cursor-pointer text-gray-600 text-sm leading-3 tracking-normal py-3 hover:bg-indigo-700 hover:text-white px-3 font-normal">
                                            <a href="">Show</a>

                                        </li>
                                        <li
                                            class="cursor-pointer text-gray-600 text-sm leading-3 tracking-normal py-3 hover:bg-indigo-700 hover:text-white px-3 font-normal">
                                            Edit
                                        </li>
                                        <li
                                            class="cursor-pointer text-gray-600 text-sm leading-3 tracking-normal py-3 hover:bg-indigo-700 hover:text-white px-3 font-normal">
                                            Delete
                                        </li>

                                    </ul>
                                </div>
                                <button
                                    class="text-gray-500 rounded cursor-pointer border border-transparent focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" onclick="dropdownFunction(this)"
                                        class="icon icon-tabler icon-tabler-dots-vertical dropbtn" width="28"
                                        height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <circle cx="12" cy="12" r="1" />
                                        <circle cx="12" cy="19" r="1" />
                                        <circle cx="12" cy="5" r="1" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>



    <script>
        function dropdownFunction(element) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            let list = element.parentElement.parentElement.getElementsByClassName("dropdown-content")[0];
            for (i = 0; i < dropdowns.length; i++) {
                dropdowns[i].classList.add("hidden");
            }
            list.classList.toggle("hidden");
        }
        window.onclick = function(event) {
            if (!event.target.matches(".dropbtn")) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    openDropdown.classList.add("hidden");
                }
            }
        };

        function checkAll(element) {
            let rows = element.parentElement.parentElement.parentElement.nextElementSibling.children;
            for (var i = 0; i < rows.length; i++) {
                if (element.checked) {
                    rows[i].classList.add("bg-gray-100");
                    let checkbox = rows[i].getElementsByTagName("input")[0];
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                } else {
                    rows[i].classList.remove("bg-gray-100");
                    let checkbox = rows[i].getElementsByTagName("input")[0];
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                }
            }
        }

        function tableInteract(element) {
            var single = element.parentElement.parentElement;
            single.classList.toggle("bg-gray-100");
        }
        let temp = 0;

        function pageView(val) {
            let text = document.getElementById("page-view");
            if (val) {
                if (temp === 2) {
                    temp = 0;
                } else {
                    temp = temp + 1;
                }
            } else if (temp !== 0) {
                temp = temp - 1;
            }
            switch (temp) {
                case 0:
                    text.innerHTML = "Viewing 1 - 20 of 60";
                    break;
                case 1:
                    text.innerHTML = "Viewing 21 - 40 of 60";
                    break;
                case 2:
                    text.innerHTML = "Viewing 41 - 60 of 60";
                default:
            }
        }
    </script> --}}



    <div class="dashboard">

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">Momentum</div>
            <nav>
                <a href="#">Dashboard</a>
                <a href="#">Analytics</a>
                <a href="#" class="active">Users</a>
                <a href="#">Settings</a>
            </nav>
        </aside>

        <!-- Main -->
        <main class="main">
            <div class="topbar">
                <h1>Users</h1>
                <input type="text" id="searchInput" placeholder="Search users..." />
            </div>

            <div class="table-container">
                <table id="usersTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mehra Khorshidi</td>
                            <td>Mehra@gmail.com</td>
                            <td>Yearly</td>
                            <td><span class="badge active">Active</span></td>
                            <td>
                                <button class="toggle">Toggle</button>
                                <button class="delete">Delete</button>
                            </td>
                        </tr>

                        <tr>
                            <td>Mitra Mehri</td>
                            <td>Mitra@gmail.com</td>
                            <td>Monthly</td>
                            <td><span class="badge suspended">Suspended</span></td>
                            <td>
                                <button class="toggle">Toggle</button>
                                <button class="delete">Delete</button>
                            </td>
                        </tr>

                        <tr>
                            <td>Pegah Roshan</td>
                            <td>Pegah@gmail.com</td>
                            <td>Quarterly</td>
                            <td><span class="badge active">Active</span></td>
                            <td>
                                <button class="toggle">Toggle</button>
                                <button class="delete">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <button>Previous</button>
                <button class="current">1</button>
                <button>Next</button>
            </div>

        </main>
    </div>

    <footer>
        <p>Momentum ©️ 2026 — Built with attention to detail by <strong>SAMIN SALEHI</strong></p>
    </footer>
