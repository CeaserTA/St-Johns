<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service registrations summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      /* Small helper to make the summary cards look nicer */
      .stat { background: white; border-radius: 0.5rem; padding: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
  <div class="max-w-6xl mx-auto p-6">
    <header class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl font-semibold">Service registrations — summary</h1>
      <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline">Back to dashboard</a>
    </header>

    @php
      // If the controller already supplied a $serviceCounts collection, prefer it.
      // Otherwise, compute counts here as a fallback so the view is self-contained.
      if (!isset($serviceCounts)) {
          $serviceCounts = \App\Models\ServiceRegistration::select('service', \DB::raw('count(*) as total'))
              ->groupBy('service')
              ->orderByDesc('total')
              ->get();
      }
      $overall = $serviceCounts->sum('total') ?? 0;
    @endphp

    <section class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div class="stat">
        <div class="text-sm text-gray-500">Services tracked</div>
        <div class="text-2xl font-bold">{{ $serviceCounts->count() }}</div>
      </div>
      <div class="stat">
        <div class="text-sm text-gray-500">Total registrations</div>
        <div class="text-2xl font-bold">{{ $overall }}</div>
      </div>
      <div class="stat">
        <div class="text-sm text-gray-500">Last update</div>
        <div class="text-2xl font-bold">{{ now()->format('Y-m-d H:i') }}</div>
      </div>
    </section>

    <section class="bg-white shadow rounded overflow-hidden">
      <div class="p-4 border-b">
        <h2 class="text-lg font-medium">Registrations by service</h2>
        <p class="text-sm text-gray-500">Shows how many people have registered for each service so far.</p>
      </div>
      <div class="p-4 overflow-x-auto">
        <table class="min-w-full text-left divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-sm font-medium text-gray-700">Service</th>
              <th class="px-4 py-3 text-sm font-medium text-gray-700">Registrations</th>
              <th class="px-4 py-3 text-sm font-medium text-gray-700">Share</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-100">
            @forelse($serviceCounts as $row)
              @php $pct = $overall ? round(($row->total / $overall) * 100, 1) : 0; @endphp
              <tr>
                <td class="px-4 py-3 text-sm text-gray-800">{{ $row->service }}</td>
                <td class="px-4 py-3 text-sm text-gray-800">{{ $row->total }}</td>
                <td class="px-4 py-3 text-sm text-gray-600">
                  <div class="w-48 bg-gray-100 h-3 rounded overflow-hidden">
                    <div class="h-3 bg-blue-600" style="width: {{ $pct }}%"></div>
                  </div>
                  <div class="text-xs text-gray-500 mt-1">{{ $pct }}%</div>
                </td>
              </tr>
            @empty
              <tr>
                <td class="px-4 py-6 text-center text-gray-500" colspan="3">No registrations yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>

    <footer class="mt-6 text-sm text-gray-500">Tip: You can add more filters in the controller (date range, keywords) and pass them to this view.</footer>
  </div>
</body>
</html>
