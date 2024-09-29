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
                <a href="#about-container" onclick="changeTab(event, 'about-container')" class="nav-bar text-sscr-red font-bold text-md px-4 py-1">About</a>
                <a href="#members-container" onclick="changeTab(event, 'members-container')" class="nav-bar text-md px-4 py-1">Members</a>
                <a href="#members-approval-container" onclick="changeTab(event, 'members-approval-container')" class="nav-bar text-md px-4 py-1">Members Approval</a>
                <a href="#admins-container" onclick="changeTab(event, 'admins-container')" class="nav-bar text-md px-4 py-1">Admins</a>
            </div>
            <div id="about-container" class="tab p-6">@include('groups.manage.about')</div>
            <div id="members-container" class="tab hidden p-6">@include('groups.manage.members')</div>
            <div id="members-approval-container" class="tab hidden p-6">@include('groups.manage.members-approval')</div>
            <div id="admins-container" class="tab hidden p-6">@include('groups.manage.admins')</div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

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

    </script>

@endsection
