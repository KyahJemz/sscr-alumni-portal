@extends('master')

@section('content')

<div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col gap-6">
        <div class="flex flex-row gap-6">
            <div class="w-32 h-32">
                <img src="{{ asset('public/images/groups/' . $group->image ?? 'default.jpg') }}" alt="" class="w-32 h-32 bg-gray-200 rounded-lg">
            </div>
            <div class="flex flex-col">
                <p> {{ $group->name }}</p>
                <p> {{ $group->description }}</p>
                <div class="flex gap-4">
                    @if($status === 'not a member')
                        <a href="">Join Group</a>
                    @elseif($condition === 'pending')
                        <a href="">Cancel Request</a>
                    @endif
                    @if($isAdmin)
                        <a href="">Edit</a>
                    @endif
                </div>
            </div>
        </div>
        <div>
            <div>

            </div>
            <div>
                <p>founded <span>gropunfo</span></p>
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
