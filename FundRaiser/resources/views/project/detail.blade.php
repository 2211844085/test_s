@php
    use Laravolt\Avatar\Facade as Avatar;
    use Illuminate\Support\Carbon;
    use App\Models\Comment;

    $donations = $project->tiers->flatMap->donations;
    $backers = $donations->map->backer;
    $raised = $donations->sum('amount');
    $fund_percentage = round($raised * 100 / $project->funding_goal);
    $deadline = Carbon::parse($project->deadline);
    $now = Carbon::now();
    $daysLeft = round($now->diffInDays($deadline, false));
    if ($daysLeft < 0) {
        $daysLeft = 0;
    }

    $comments = $project->comments->groupBy('parent_id');
    function buildTree($comments, $parentId = null)
    {
        $branch = [];
        if (!isset($comments[$parentId])) {
            return $branch;
        }
        foreach ($comments[$parentId] as $comment) {
            $children = buildTree($comments, $comment->id);
            if ($children) {
                $comment->children = $children;
            } else {
                $comment->children = collect();
            }
            $branch[] = $comment;
        }
        return $branch;
    }
    $nestedComments = buildTree($comments);

    $comments = Comment::with('author')->where('project_id', $project->id)->get();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $project->title }} - FundRaiser</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navigation>
        <a href="{{ route('projects.index') }}" class="text-gray-700 hover:text-primary transition-colors">Explore
            Projects</a>
    </x-navigation>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Project Header -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="relative">
                <img src="{{ asset('storage/' . $project->image) }}"
                    onerror="this.onerror=null;this.src='https://placehold.co/600x400';" alt="Smart Home Assistant"
                    class="w-full h-96 object-cover">
                <div class="absolute top-4 left-4">
                    @foreach ($project->tags as $tag)
                        <span
                            class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <div class="absolute top-4 right-4 flex space-x-2">
                    @auth
                        @if (auth()->id() != $project->creator->id)
                            <form id="like-form-{{ $project->id }}" action="/like-project" method="POST"
                                data-comment-id="{{ $project->id }}">
                                @csrf
                                <input name="project_id" type="hidden" value="{{ $project->id }}" />
                                <button class="bg-white bg-opacity-90 p-2 rounded-full hover:bg-opacity-100 transition-colors">
                                    <svg class="w-5 h-5 text-gray-600"
                                        fill="{{ auth()->user() && $project->likedUsers->contains(auth()->user()) ? 'red' : 'transparent' }}"
                                        stroke="#ef4444" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        @endif
                        @if (auth()->user()->role != 'admin' && auth()->id() != $project->creator->id)
                            <button onclick="openReportModal()"
                                class="bg-white bg-opacity-90 p-2 rounded-full hover:bg-opacity-100 transition-colors">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                            </button>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $project->title }}</h1>
                        <p class="text-gray-600">{{ $project->short_desc }}</p>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center space-x-2 mb-2">
                            <img src="{{ Avatar::create($project->creator->company_name)->toBase64() }}" alt="Profile"
                                class="w-8 h-8 rounded-full">