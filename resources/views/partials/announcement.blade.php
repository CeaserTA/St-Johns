@php
    if (!isset($latestAnnouncement)) {
        try {
            $latestAnnouncement = App\Models\Announcement::orderBy('created_at', 'desc')->first();
        } catch (\Exception $e) {
            $latestAnnouncement = null;
        }
    }
@endphp

@if(!empty($latestAnnouncement))
    <div class="bg-yellow-100 text-yellow-800 py-2 text-center text-sm">
        <strong>Announcement:</strong>
        {{ $latestAnnouncement->title }}
    </div>
@endif
