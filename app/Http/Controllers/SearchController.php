<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Event;
use App\Models\Service;
use App\Models\Giving;
use App\Models\Group;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Global search across all admin resources
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'results' => [],
                'message' => 'Please enter at least 2 characters'
            ]);
        }

        $results = [
            'members' => $this->searchMembers($query),
            'events' => $this->searchEvents($query),
            'services' => $this->searchServices($query),
            'givings' => $this->searchGivings($query),
            'groups' => $this->searchGroups($query),
        ];

        $totalResults = collect($results)->sum(fn($items) => count($items));

        return response()->json([
            'results' => $results,
            'total' => $totalResults,
            'query' => $query
        ]);
    }

    private function searchMembers($query)
    {
        return Member::where(function($q) use ($query) {
            $q->where('full_name', 'LIKE', "%{$query}%")
              ->orWhere('email', 'LIKE', "%{$query}%")
              ->orWhere('phone', 'LIKE', "%{$query}%");
        })
        ->limit(5)
        ->get()
        ->map(function($member) {
            return [
                'id' => $member->id,
                'title' => $member->full_name,
                'subtitle' => $member->email ?: $member->phone,
                'type' => 'member',
                'url' => route('admin.members') . '?search=' . urlencode($member->full_name),
                'icon' => 'user'
            ];
        })
        ->toArray();
    }

    private function searchEvents($query)
    {
        return Event::where(function($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%");
        })
        ->limit(5)
        ->get()
        ->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'subtitle' => \Str::limit($event->description, 50),
                'type' => 'event',
                'url' => route('admin.events'),
                'icon' => 'calendar'
            ];
        })
        ->toArray();
    }

    private function searchServices($query)
    {
        return Service::where(function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%");
        })
        ->limit(5)
        ->get()
        ->map(function($service) {
            return [
                'id' => $service->id,
                'title' => $service->name,
                'subtitle' => \Str::limit($service->description, 50),
                'type' => 'service',
                'url' => route('admin.services'),
                'icon' => 'church'
            ];
        })
        ->toArray();
    }

    private function searchGivings($query)
    {
        return Giving::with('member')
            ->where(function($q) use ($query) {
                $q->where('amount', 'LIKE', "%{$query}%")
                  ->orWhereHas('member', function($mq) use ($query) {
                      $mq->where('full_name', 'LIKE', "%{$query}%");
                  });
            })
            ->limit(5)
            ->get()
            ->map(function($giving) {
                return [
                    'id' => $giving->id,
                    'title' => ($giving->member ? $giving->member->full_name . ' - ' : '') . number_format($giving->amount) . ' ' . $giving->currency,
                    'subtitle' => ucfirst($giving->giving_type) . ' - ' . $giving->created_at->format('M d, Y'),
                    'type' => 'giving',
                    'url' => route('admin.givings'),
                    'icon' => 'money'
                ];
            })
            ->toArray();
    }

    private function searchGroups($query)
    {
        return Group::where(function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%");
        })
        ->limit(5)
        ->get()
        ->map(function($group) {
            return [
                'id' => $group->id,
                'title' => $group->name,
                'subtitle' => \Str::limit($group->description, 50),
                'type' => 'group',
                'url' => route('admin.groups'),
                'icon' => 'group'
            ];
        })
        ->toArray();
    }
}
