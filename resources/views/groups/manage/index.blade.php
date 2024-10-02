@extends('master')

@section('content')

<div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
    <div class="rounded-lg flex flex-col gap-6">
        <div class="flex flex-row gap-6 bg-white p-6 shadow-lg rounded-lg">
            <img src="{{ asset('storage/groups/images/' . $group->image ?? 'default.jpg') }}" alt="" class="w-48 h-48 rounded-lg" onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';">
            <div class="flex flex-col relative w-full">
                <p class="text-2xl text-sscr-red font-bold">{{ $group->name }}</p>
                <p class="text-gray-900"> {{ $group->description }}</p>
                <div class="flex gap-4 absolute right-0 bottom-0">
                </div>
            </div>
        </div>
        <div class="bg-white shadow-lg rounded-lg">
            <div id="nav-container" class="flex flex-row gap-4 border-t border-b border-gray-300 p-2 w-full rounded-t-lg">
                <a onclick="changeTab(event, 'about-container')" class="nav-bar text-sscr-red font-bold text-md px-4 py-1 cursor-pointer">About</a>
                <a onclick="changeTab(event, 'members-container')" class="nav-bar text-md px-4 py-1 cursor-pointer">Members</a>
                @if($isAdmin || Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                    <a onclick="changeTab(event, 'members-approval-container')" class="nav-bar text-md px-4 py-1 cursor-pointer">Members Approval</a>
                @endif
                @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                    <a onclick="changeTab(event, 'admins-container')" class="nav-bar text-md px-4 py-1 cursor-pointer">Admins</a>
                @endif
            </div>
            <div id="about-container" class="tab p-6">@include('groups.manage.about')</div>
            <div id="members-container" class="tab hidden p-6">@include('groups.manage.members')</div>
            <div id="members-approval-container" class="tab hidden p-6">@include('groups.manage.members-approval')</div>
            @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                <div id="admins-container" class="tab hidden p-6">@include('groups.manage.admins')</div>
            @endif
        </div>
    </div>
</div>

@if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
    <div id="add-admin-modal"
        class="hidden fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div id="send-feedback-form"
            class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <form action="{{ route('group-admins.store', ['group' => $group->id]) }}" method="POST">
                @csrf
                <h2
                    class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 flex justify-between items-center">
                    Add New Admin
                    <button type="button"
                        onclick="document.getElementById('add-admin-modal').classList.toggle('hidden');"
                        class="text-sscr-red">
                        @include('components.icons.x')
                    </button>
                </h2>
                <div class="flex flex-col flex-1 space-y-4">
                    <div>
                        <label for="admins"
                            class="text-sm font-semibold text-gray-700 dark:text-gray-200">Admins</label>
                        <input list="alumni-list" onchange="handleAdminSelection(event)"
                            type="text"
                            class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm h-12" />
                        <datalist id="alumni-list">
                            @foreach ($alumni_list as $alumni)
                                <option value="{{ $alumni->id }}">
                                    {{ $alumni->alumniInformation->first_name . ' ' . $alumni->alumniInformation->last_name }}
                                </option>
                            @endforeach
                        </datalist>
                        <div id="admin-list"
                            class="flex flex-col gap-2 mt-2 border border-gray-300 dark:border-gray-700 rounded-md">
                        </div>
                        <input id="admin_ids" type="text" class="hidden" name="admin_ids">
                    </div>
                    <div class="mt-6">
                        <input type="submit"
                            class="w-full bg-sscr-red text-white font-light py-2 px-4 rounded-md cursor-pointer hover:bg-red-600 transition duration-150"
                            value="Add">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif

<div id="invite-member-modal"
    class="hidden fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div id=""
        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <h2
                class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 flex justify-between items-center">
                Invite
                <button type="button"
                    onclick="document.getElementById('invite-member-modal').classList.toggle('hidden');"
                    class="text-sscr-red">
                    @include('components.icons.x')
                </button>
            </h2>
            <div class="flex flex-col flex-1 space-y-4">
                <input name="search" id="search-alumni" type="text" oninput="searchAlumni(event)" placeholder="Search alumni..." class="border rounded-lg p-2 w-full text-xs" />
                <div id="alumni-invite-list" class="flex flex-col">
                    @foreach ($alumni_list->slice(0, 5) as $alumni)
                    <div class="invite-list-item flex flex-row justify-between border-y border-gray-300 dark:border-gray-700 py-2 items-center">
                        {{ $alumni->alumniInformation->first_name . ' ' . $alumni->alumniInformation->last_name }}
                        <button onclick="sendInvite(event, {{ $alumni->id }}, {{ $group->id }}, '{{ $alumni->alumniInformation->first_name . ' ' . $alumni->alumniInformation->last_name }}')"
                            class="text-sscr-red text-sm cursor-pointer border border-sscr-red px-3 py-1 rounded active:bg-sscr-red active:text-white transition duration-150 hover:bg-sscr-red/10">
                            Invite
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
    </div>
</div>

@endsection

@section('scripts')

    <script>
        let alumniInviteList = @json($alumni_list);

        function searchAlumni(event) {
            const searchTerm = event.target.value.toLowerCase();

            if (searchTerm === '') {
                displayAlumniList(alumniInviteList.slice(0, 5));
            } else {
                const filteredAlumni = alumniInviteList.filter(alumni => {
                    const fullName = (alumni.alumni_information.first_name + ' ' + alumni.alumni_information.last_name).toLowerCase();
                    return fullName.includes(searchTerm);
                });

                displayAlumniList(filteredAlumni.slice(0, 5));
            }
        }

        function displayAlumniList(alumni) {
            const alumniListContainer = document.getElementById('alumni-invite-list');
            alumniListContainer.innerHTML = '';

            if (alumni.length === 0) {
                alumniListContainer.innerHTML = '<div class="py-2">No alumni found.</div>';
            } else {
                alumni.forEach(alum => {
                    const fullName = alum.alumni_information.first_name + ' ' + alum.alumni_information.last_name;
                    alumniListContainer.innerHTML += `
                        <div class="invite-list-item flex flex-row justify-between border-y border-gray-300 dark:border-gray-700 py-2 items-center">
                            ${fullName}
                            <button onclick="sendInvite(event, ${alum.id}, {{ $group->id }}, '${fullName}')"
                                class="text-sscr-red text-sm cursor-pointer border border-sscr-red px-3 py-1 rounded active:bg-sscr-red active:text-white transition duration-150 hover:bg-sscr-red/10">
                                Invite
                            </button>
                        </div>
                    `;
                });
            }
        }

        async function sendInvite (e, user_id, group_id, name) {
            confirmation(`Invite ${name} to the group?`, async function () {
                const formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("type", "invite");
                formData.append("user_id", user_id);
                formData.append("group_id", group_id);
                const url = `{{route('api.group-members.store')}}`;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    });
                    if (!response.ok) {
                        throw new Error(`Response status: ${response.status}`);
                    }
                    const json = await response.json();
                    alertModal(json.message);
                    e.target.innerHTML = 'Invited';
                    e.target.disabled = true;
                } catch (error) {
                    alertModal(error.message);
                    console.error(error.message);
                }
            });
        }
    </script>

    @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
        <script>
            let admins = [];
            const alumniList = @json($alumni_list).map(alumni => {
                return {
                    id: alumni.id,
                    name: alumni.alumni_information.first_name + ' ' + (alumni.alumni_information.middle_name ? alumni
                        .alumni_information.middle_name + ' ' : '') + alumni.alumni_information.last_name
                };
            });

            function handleAdminSelection(e) {

                const selectedAlumni = alumniList.find(alumni => alumni.id == e.target.value);

                if (selectedAlumni && !admins.includes(selectedAlumni.id)) {
                    admins.push(selectedAlumni.id);

                    let adminList = document.getElementById('admin-list');
                    adminList.innerHTML += `
                    <div id="admin-${selectedAlumni.id}" class="flex justify-between items-center p-2">
                        ${selectedAlumni.name}
                        <button type="button" class="text-red-500 ml-2" onclick="removeAdmin(${selectedAlumni.id})">X</button>
                    </div>
                `;
                }

                document.getElementById('admin_ids').value = JSON.stringify(admins);
                e.target.value = '';
            }

            function removeAdmin(adminId) {
                admins = admins.filter(id => id !== adminId);

                let adminElement = document.getElementById(`admin-${adminId}`);
                if (adminElement) {
                    adminElement.remove();
                }
                document.getElementById('admin_ids').value = JSON.stringify(admins);
            }
        </script>
    @endif

    <script>
        function changeTab(e, tab) {
            let tabs = document.querySelectorAll('.tab');
            tabs.forEach(function(tab) {
                tab.classList.add('hidden');
            });
            let navs = document.querySelectorAll('.nav-bar');
            navs.forEach(function(nav) {
                nav.classList.remove('text-sscr-red', 'font-bold');
            })
            e.target.classList.add('text-sscr-red', 'font-bold');
            document.getElementById(tab).classList.remove('hidden');
        }
    </script>

    <script>
        document.getElementById('image-upload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('image-preview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script>
        document.querySelectorAll('.dropdown-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const dropdown = button.nextElementSibling;
                dropdown.classList.toggle('hidden');
            });
        });

        document.addEventListener('click', function(event) {
            document.querySelectorAll('.dropdown').forEach(function(dropdown) {
                const button = dropdown.previousElementSibling;
                if (!event.target.closest('.dropdown-btn') && !event.target.closest('.dropdown')) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    </script>

    <script>
        function searchMembers(e) {
            const query = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#group-members-table-body tr');
            rows.forEach(row => {
                const fullname = row.cells[2].innerText.toLowerCase();
                const email = row.cells[3].innerText.toLowerCase();
                const username = row.cells[4].innerText.toLowerCase();
                const course = row.cells[5].innerText.toLowerCase();
                const batch = row.cells[6].innerText.toLowerCase();
                if (fullname.includes(query) || email.includes(query) || username.includes(query) || course.includes(query) || batch.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function filterMembers(e) {
            const selectedBatches = Array.from(document.querySelectorAll('.group-members-batch-filter:checked')).map(batch => batch.value);
            const selectedCourses = Array.from(document.querySelectorAll('.group-members-course-filter:checked')).map(course => course.value);

            const rows = document.querySelectorAll('#group-members-table-body tr');

            const shouldDisplayRow = (row) => {
                const rowBatch = row.getAttribute('data-batch');
                const rowCourse = row.getAttribute('data-course');
                const isBatchMatched = selectedBatches.length === 0 || selectedBatches.includes(rowBatch);
                const isCourseMatched = selectedCourses.length === 0 || selectedCourses.includes(rowCourse);
                return isBatchMatched && isCourseMatched;
            };

            rows.forEach(row => {
                row.style.display = shouldDisplayRow(row) ? '' : 'none';
            });
        }

        function searchMembersApproval(e) {
            const query = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#group-members-approval-table-body tr');
            rows.forEach(row => {
                const fullname = row.cells[2].innerText.toLowerCase();
                const email = row.cells[3].innerText.toLowerCase();
                const username = row.cells[4].innerText.toLowerCase();
                const course = row.cells[5].innerText.toLowerCase();
                const batch = row.cells[6].innerText.toLowerCase();
                if (fullname.includes(query) || email.includes(query) || username.includes(query) || course.includes(query) || batch.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function filterMembersApproval(e) {
            const selectedBatches = Array.from(document.querySelectorAll('.group-members-approval-batch-filter:checked')).map(batch => batch.value);
            const selectedCourses = Array.from(document.querySelectorAll('.group-members-approval-course-filter:checked')).map(course => course.value);

            const rows = document.querySelectorAll('#group-members-approval-table-body tr');

            const shouldDisplayRow = (row) => {
                const rowBatch = row.getAttribute('data-batch');
                const rowCourse = row.getAttribute('data-course');
                const isBatchMatched = selectedBatches.length === 0 || selectedBatches.includes(rowBatch);
                const isCourseMatched = selectedCourses.length === 0 || selectedCourses.includes(rowCourse);
                return isBatchMatched && isCourseMatched;
            };

            rows.forEach(row => {
                row.style.display = shouldDisplayRow(row) ? '' : 'none';
            });
        }

        @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
            function searchAdmins(e) {
                const query = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('#group-admins-table-body tr');
                rows.forEach(row => {
                    const fullname = row.cells[2].innerText.toLowerCase();
                    const email = row.cells[3].innerText.toLowerCase();
                    const username = row.cells[4].innerText.toLowerCase();
                    const course = row.cells[5].innerText.toLowerCase();
                    const batch = row.cells[6].innerText.toLowerCase();
                    if (fullname.includes(query) || email.includes(query) || username.includes(query) || course.includes(query) || batch.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        @endif

        function updateMembersTable(account, index) {
            const table = document.getElementById('group-members-table-body');
            const template = `
            <tr class="border-t dark:border-gray-700" data-batch="${account.alumni_information?.batch ?? ''}" data-course="${account.alumni_information?.course ?? ''}">
                <td class="px-6 py-4 whitespace-nowrap text-sm ">${index + 1}</td>
                <td class="px-6 py-4 w-12 whitespace-nowrap text-sm">
                    <img class="h-12 m-auto w-12 rounded-full object-cover" src="{{ asset('storage/profile/images') }}/${account.image ?? 'default.jpg'}" alt="User Image" onerror="this.onerror=null; this.src='{{ asset('storage/profile/images/default.jpg') }}';">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.first_name ?? ''} ${account.alumni_information?.middle_name ?? ''} ${account.alumni_information?.last_name ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.email}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.username}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.batch ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.course ?? ''}</td>
                @if($isAdmin || Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center h-full">
                            <button class="text-xs bg-red-500 hover:bg-red-600  py-1 px-2 rounded-lg underline" onclick="removeMember({{$group->id}},${account.id})">Remove</button>
                        </div>
                    </td>
                @endif
            </tr>
        `;
            table.innerHTML += template;
        }

        function updateMembersApprovalTable(account, index, member) {
            const table = document.getElementById('group-members-approval-table-body');
            const template = `
            <tr class="border-t dark:border-gray-700" data-batch="${account.alumni_information?.batch ?? ''}" data-course="${account.alumni_information?.course ?? ''}">
                <td class="px-6 py-4 whitespace-nowrap text-sm ">${index + 1}</td>
                <td class="px-6 py-4 w-12 whitespace-nowrap text-sm">
                    <img class="h-12 m-auto w-12 rounded-full object-cover" src="{{ asset('storage/profile/images') }}/${account.image ?? 'default.jpg'}" alt="User Image" onerror="this.onerror=null; this.src='{{ asset('storage/profile/images/default.jpg') }}';">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.first_name ?? ''} ${account.alumni_information?.middle_name ?? ''} ${account.alumni_information?.last_name ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.email}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.username}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account?.alumni_information?.batch ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account?.alumni_information?.course ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center h-full">
                        <button class="text-xs bg-red-500 hover:bg-red-600 py-1 px-2 rounded-lg underline" onclick="approveMember(${member.id})">Approve</button>
                        <button class="text-xs bg-red-500 hover:bg-red-600 py-1 px-2 rounded-lg underline" onclick="rejectMember(${member.id})">Reject</button>
                    </div>
                </td>
            </tr>
        `;
            table.innerHTML += template;
        }

        @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
            function updateAdminsTable(account, index) {
                const table = document.getElementById('group-admins-table-body');
                const template = `
                <tr class="border-t dark:border-gray-700" data-batch="${account.alumni_information?.batch ?? ''}" data-course="${account.alumni_information?.course ?? ''}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm ">${index + 1}</td>
                    <td class="px-6 py-4 w-12 whitespace-nowrap text-sm">
                        <img class="h-12 m-auto w-12 rounded-full object-cover" src="{{ asset('storage/profile/images') }}/${account.image ?? 'default.jpg'}" alt="User Image" onerror="this.onerror=null; this.src='{{ asset('storage/profile/images/default.jpg') }}';">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.first_name ?? ''} ${account.alumni_information?.middle_name ?? ''} ${account.alumni_information?.last_name ?? ''}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">${account.email}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">${account.username}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.batch ?? ''}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.course ?? ''}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center h-full">
                            <button class="text-xs bg-red-500 hover:bg-red-600  py-1 px-2 rounded-lg underline" onclick="removeAdmin({{$group->id}},${account.id})">Remove</button>
                        </div>
                    </td>
                </tr>
            `;
                table.innerHTML += template;
            }
        @endif

        async function getMembers() {
            const url = "{{ route('api.group-members.show', ['group' => $group->id]) }}";
            const table1 = document.getElementById('group-members-table-body');
            const table2 = document.getElementById('group-members-approval-table-body');
            @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                const table3 = document.getElementById('group-admins-table-body');
            @endif
            try {
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();

                table1.innerHTML = '';
                table2.innerHTML = '';
                @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                    table3.innerHTML = '';
                @endif
                if (json.members_list.length !== 0) {
                    json.members_list.forEach((account, index) => {
                        updateMembersTable(account.user, index)
                    });
                    json.members_approval_list.forEach((account, index) => {
                        updateMembersApprovalTable(account.user, index, account)
                    });
                    @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                        json.admins_list.forEach((account, index) => {
                            updateAdminsTable(account.user, index)
                        });
                    @endif
                };
            } catch (error) {
                console.error('Error fetching members:', error.message);
            }
        }
        getMembers()

        async function exportTable(id) {
            const data = [];
            const headers = ["#", "Fullname", "Email", "Alumni Id", "Course", "Batch"];

            const rows = document.querySelectorAll(`#${id} tr`);

            rows.forEach(row => {
                if (getComputedStyle(row).display !== 'none') {
                    data.push([
                        row.cells[0].innerText,
                        row.cells[2].innerText,
                        row.cells[3].innerText,
                        row.cells[4].innerText,
                        row.cells[5].innerText,
                        row.cells[6].innerText
                    ]);
                }
            });

            const payload = {
                headers: headers,
                data: data
            };

            confirmation(`Are you sure you want to export (${data.length}) records?`, async function () {
                const url = `{{ route('account.export') }}`;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(payload)
                    });
                    if (!response.ok) {
                        throw new Error(`Response status: ${response.status}`);
                    }
                    const fileName = `export-alumni-${(new Date()).toISOString()}.xlsx`;
                    const blob = await response.blob();
                    const link = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = link;
                    a.download = fileName;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    alertModal('Exported successfully!');
                } catch (error) {
                    alertModal(error.message);
                    console.error(error.message);
                }
            });
        }

        // async function inviteAlumni(e) {
        //     e.preventDefault();
        //     const formData = new FormData(e.target);
        //     const url = "{{ route('api.account.store') }}";
        //     try {
        //         const response = await fetch(url, {
        //             method: 'POST',
        //             body: formData,
        //             headers: {
        //                 'X-Requested-With': 'XMLHttpRequest',
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
        //                     'content')
        //             }
        //         });
        //         if (!response.ok) {
        //             throw new Error(`Response status: ${response.status}`);
        //         }
        //         const json = await response.json();
        //         alertModal(json.message);
        //         getAccounts();
        //     } catch (error) {
        //         alertModal(error.message);
        //         console.error(error.message);
        //     }
        // }

        function removeMember(groupId, userId) {
            confirmation('Are you sure you want to remove this member?', async function () {
                const formData = new FormData();
                formData.append('_method', 'DELETE');
                formData.append("_token", "{{ csrf_token() }}");
                const url = `/api/group-members/${groupId}/${userId}`;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    });
                    if (!response.ok) {
                        throw new Error(`Response status: ${response.status}`);
                    }
                    const json = await response.json();
                    alertModal(json.message);
                    getMembers();
                } catch (error) {
                    alertModal(error.message);
                    console.error(error.message);
                }
            });
        }

        @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
            function removeAdmin(groupId, userId) {
                confirmation('Are you sure you want to remove this admin?', async function () {
                    const formData = new FormData();
                    formData.append('_method', 'DELETE');
                    formData.append("_token", "{{ csrf_token() }}");
                    const url = `/api/group-admins/${groupId}/${userId}`;
                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        });
                        if (!response.ok) {
                            throw new Error(`Response status: ${response.status}`);
                        }
                        const json = await response.json();
                        alertModal(json.message);
                        getMembers();
                    } catch (error) {
                        alertModal(error.message);
                        console.error(error.message);
                    }
                });
            }
        @endif

        function approveMember(groupMemberId) {
            confirmation('Are you sure you want to approve this account?', async function () {
                const formData = new FormData();
                formData.append('_method', 'PATCH');
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("status", "approved");
                const url = `/api/group-members/${groupMemberId}`;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    });
                    if (!response.ok) {
                        throw new Error(`Response status: ${response.status}`);
                    }
                    const json = await response.json();
                    alertModal(json.message);
                    getMembers();
                } catch (error) {
                    alertModal(error.message);
                    console.error(error.message);
                }
            });
        }

        function rejectMember(groupMemberId) {
            confirmation('Are you sure you want to reject this account?', async function () {
                const formData = new FormData();
                formData.append('_method', 'PATCH');
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("status", "rejected");
                const url = `/api/group-members/${groupMemberId}`;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    });
                    if (!response.ok) {
                        throw new Error(`Response status: ${response.status}`);
                    }
                    const json = await response.json();
                    alertModal(json.message);
                    getMembers();
                } catch (error) {
                    alertModal(error.message);
                    console.error(error.message);
                }
            });
        }

    </script>

@endsection
