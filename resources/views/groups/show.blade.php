@extends('master')

@section('content')

<div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
    <div class="bg-white shadow-md rounded-lg flex flex-col gap-6">
        <div class="flex flex-row gap-6 bg-gray-300 p-6 rounded-lg">
            <img src="{{ asset('storage/images/groups/' . $group->image ?? 'default.jpg') }}" alt="" class="w-48 h-48 rounded-lg">
            <div class="flex flex-col relative w-full">
                <p class="text-2xl text-sscr-red font-bold">{{ $group->name }}</p>
                <p class="text-gray-900"> {{ $group->description }}</p>
                <div class="flex gap-4 absolute right-0 bottom-0">
                    @if($isAdmin | Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                        <a class="cursor-pointer px-4 py-2 bg-sscr-red text-white rounded-lg">Edit</a>
                    @else
                        @if($status === 'not a member')
                            <form action="{{ route('group-members.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <button type="submit" class="px-4 py-2 bg-sscr-red text-white rounded">Join Group</button>
                            </form>
                        @elseif($status === 'pending')
                            <form action="{{ route('group-members.destroy', ['groupMember' => $groupMember->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="px-4 py-2 bg-sscr-red text-white rounded">Cancel Request</button>
                                @if(session('status') && session('errors'))
                                    <p>{{ session('status') }} {{ session('errors') }}</p>
                                @endif
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="px-6 pb-6 flex flex-row">
            <div class="flex flex-1">

            </div>
            <div class="w-96">
                <p class="flex text-sscr-red font-bold flex-row justify-between">Founded {{ $group->created_at->format('F j, Y') }}<a href="">@include('components.icons.more')</a></p>
                <div>
                    <p>members</p>
                    <p>posts</p>
                    <p>events</p>
                    <p>announcements</p>
                </div>
                <div>
                    admins
                    view more
                </div>
                <div>
                    memebrs
                    view more
                </div>
                <div>
                    Leave
                </div>
            </div>
        </div>


    </div>
</div>

@endsection

@section('scripts')


@endsection
