@extends('layouts.dashboard_layout')

@section('title', 'Services')
@section('header_title', 'Services')

@section('content')

    {{-- ═══════════════════════════════════════════════════
         MANAGE SERVICES TABLE
    ═══════════════════════════════════════════════════ --}}
    <div class="mb-7">

        {{-- Section toolbar --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-5">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h2 class="font-display font-black text-xl text-primary">Manage Services</h2>
            </div>
            <button id="addServiceBtn"
                    class="bg-secondary hover:bg-secondary/90 text-white px-5 py-2.5 rounded-xl text-sm font-semibold
                           flex items-center gap-2 shadow-sm hover:shadow-card transition-all duration-200 shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add Service
            </button>
        </div>

        {{-- Table card --}}
        <div class="card-base overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-sand/60 border-b border-border">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Title</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Schedule</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Fee</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Description</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/60">
                        @forelse($services as $service)
                            <tr class="group hover:bg-sand/40 transition-colors duration-150">
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <p class="text-sm font-semibold text-primary">{{ $service->name ?? $service->title ?? '—' }}</p>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <p class="text-sm text-primary">{{ $service->schedule ?? '—' }}</p>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if($service->is_free)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-success/10 text-success border border-success/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-success"></span>FREE
                                        </span>
                                    @else
                                        <span class="text-sm font-semibold text-secondary">{{ $service->formatted_fee ?? '—' }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 max-w-[220px]">
                                    <p class="text-sm text-primary truncate">{{ $service->description ?? '—' }}</p>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <button class="edit-btn p-2 rounded-lg text-accent/60 hover:text-accent hover:bg-accent/10 transition-all duration-150"
                                                title="Edit"
                                                data-id="{{ $service->id }}"
                                                data-title="{{ $service->name ?? $service->title ?? '' }}"
                                                data-schedule="{{ $service->schedule ?? '' }}"
                                                data-fee="{{ $service->fee ?? 0 }}"
                                                data-is-free="{{ $service->is_free ? '1' : '0' }}"
                                                data-description="{{ $service->description ?? '' }}">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" class="inline"
                                              onsubmit="return confirm('Delete this service?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    title="Delete"
                                                    class="p-2 rounded-lg text-secondary/50 hover:text-secondary hover:bg-secondary/8 transition-all duration-150">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-14 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 rounded-2xl bg-sand border border-border flex items-center justify-center">
                                            <svg class="w-6 h-6 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-primary">No services added yet</p>
                                        <button id="addServiceBtnEmpty"
                                                class="text-xs text-accent hover:underline font-semibold">
                                            Add your first service
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         SERVICE REGISTRATIONS TABLE
    ═══════════════════════════════════════════════════ --}}
    <div>

        {{-- Section toolbar --}}
        <div class="flex items-center gap-3 mb-5">
            <svg class="w-5 h-5 text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h2 class="font-display font-black text-xl text-primary">Service Registrations</h2>
            @if(isset($serviceRegistrations))
                <span class="text-xs font-semibold text-muted bg-sand border border-border px-2.5 py-1 rounded-full">
                    {{ $serviceRegistrations->count() }} total
                </span>
            @endif
        </div>

        {{-- Table card --}}
        <div class="card-base overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-sand/60 border-b border-border">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Name</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Email</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Phone</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Service</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Amount</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Ref</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Registered</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/60">
                        @forelse($serviceRegistrations ?? [] as $reg)
                            <tr class="group hover:bg-sand/40 transition-colors duration-150">

                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <p class="text-sm font-semibold text-primary">
                                        {{ $reg->guest_full_name ?? $reg->member->full_name ?? '—' }}
                                    </p>
                                </td>

                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <p class="text-sm text-primary">{{ $reg->guest_email ?? $reg->member->email ?? '—' }}</p>
                                </td>

                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <p class="text-sm text-primary">{{ $reg->guest_phone ?? $reg->member->phone ?? '—' }}</p>
                                </td>

                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <p class="text-sm text-primary">{{ $reg->service->name ?? '—' }}</p>
                                </td>

                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if($reg->service && $reg->service->isFree())
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-success/10 text-success border border-success/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-success"></span>FREE
                                        </span>
                                    @else
                                        <span class="text-sm font-semibold text-primary">{{ $reg->service->formatted_fee ?? '—' }}</span>
                                    @endif
                                </td>

                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @php
                                        $statusMap = [
                                            'paid'     => 'bg-success/10 text-success border-success/20',
                                            'pending'  => 'bg-accent/10 text-accent border-accent/20',
                                            'failed'   => 'bg-secondary/10 text-secondary border-secondary/20',
                                            'refunded' => 'bg-muted/10 text-muted border-border',
                                        ];
                                        $cls = $statusMap[$reg->payment_status] ?? 'bg-sand text-muted border-border';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $cls }} uppercase">
                                        {{ $reg->payment_status }}
                                    </span>
                                </td>

                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if($reg->transaction_reference)
                                        <p class="text-xs font-mono text-primary">{{ $reg->transaction_reference }}</p>
                                        <p class="text-xs text-muted mt-0.5">{{ ucfirst(str_replace('_', ' ', $reg->payment_method ?? '')) }}</p>
                                    @else
                                        <span class="text-muted text-xs">—</span>
                                    @endif
                                </td>

                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <p class="text-sm text-primary">{{ optional($reg->created_at)->format('M d, Y') ?? '—' }}</p>
                                </td>

                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if($reg->payment_status === 'pending')
                                        <div class="flex items-center gap-1.5">
                                            <button onclick="confirmPayment({{ $reg->id }})"
                                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold
                                                           bg-success/10 text-success border border-success/20
                                                           hover:bg-success hover:text-white hover:border-success
                                                           transition-all duration-150">
                                                Confirm
                                            </button>
                                            <button onclick="rejectPayment({{ $reg->id }})"
                                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold
                                                           bg-secondary/8 text-secondary border border-secondary/20
                                                           hover:bg-secondary hover:text-white hover:border-secondary
                                                           transition-all duration-150">
                                                Reject
                                            </button>
                                        </div>
                                    @elseif($reg->payment_status === 'paid')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-success">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Verified
                                        </span>
                                    @elseif($reg->payment_status === 'failed')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-secondary">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Rejected
                                        </span>
                                    @else
                                        <span class="text-muted text-xs">—</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-14 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 rounded-2xl bg-sand border border-border flex items-center justify-center">
                                            <svg class="w-6 h-6 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-primary">No registrations yet</p>
                                        <p class="text-xs text-muted">Registrations will appear here once members sign up for services.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         MODAL: ADD / EDIT SERVICE
    ═══════════════════════════════════════════════════ --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-primary/60 backdrop-blur-sm" id="modalBackdrop"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-card-hover w-full max-w-lg modal-enter">

                {{-- Modal header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-border">
                    <h3 id="modalTitle" class="font-display font-bold text-lg text-primary">Add New Service</h3>
                    <button id="cancelEdit" class="p-2 rounded-xl text-muted hover:text-primary hover:bg-sand transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Modal body --}}
                <div class="p-6">
                    <form id="editForm" method="POST" class="space-y-4">
                        @csrf
                        <div id="methodField"></div>

                        <div>
                            <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">
                                Service Name <span class="text-secondary">*</span>
                            </label>
                            <input name="name" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                          placeholder-muted focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all"
                                   placeholder="e.g. Sunday Service"/>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">
                                    Schedule <span class="text-secondary">*</span>
                                </label>
                                <input name="schedule" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                              placeholder-muted focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all"
                                       placeholder="e.g. Sundays 9am"/>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">Fee (UGX)</label>
                                <input name="fee" id="feeInput" type="number" step="0.01" min="0" value="0"
                                       class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                              focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all"/>
                            </div>
                        </div>

                        <label class="flex items-center gap-3 cursor-pointer select-none">
                            <input type="checkbox" name="is_free" value="1"
                                   class="w-4 h-4 rounded border-border text-accent focus:ring-accent/20"/>
                            <span class="text-sm text-primary font-medium">This service is free of charge</span>
                        </label>

                        <div>
                            <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">
                                Description <span class="text-secondary">*</span>
                            </label>
                            <textarea name="description" rows="3" required
                                      class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                             placeholder-muted focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all resize-none"
                                      placeholder="Brief description of this service…"></textarea>
                        </div>

                        {{-- Actions --}}
                        <div class="flex justify-end gap-3 pt-2 border-t border-border">
                            <button type="button" id="cancelEditBtn"
                                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-muted border border-border
                                           hover:border-primary/30 hover:text-primary bg-sand transition-all duration-200">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-primary
                                           hover:bg-primary-light shadow-sm hover:shadow transition-all duration-200">
                                Save Service
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <style>
        .modal-enter { animation: modalIn .25s cubic-bezier(.4,0,.2,1) both; }
        @keyframes modalIn { from { opacity:0; transform:scale(.96) translateY(8px); } to { opacity:1; transform:scale(1) translateY(0); } }
    </style>

    <script>
        /* ── Modal helpers ────────────────────────────── */
        const editModal   = document.getElementById('editModal');
        const editForm    = document.getElementById('editForm');
        const modalTitle  = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');

        function openModal()  { editModal.classList.remove('hidden'); document.body.classList.add('overflow-hidden'); }
        function closeModal() { editModal.classList.add('hidden');    document.body.classList.remove('overflow-hidden'); }

        /* ── Add service ──────────────────────────────── */
        function openAddModal() {
            modalTitle.textContent = 'Add New Service';
            editForm.reset();
            editForm.action = '/admin/services';
            methodField.innerHTML = '';
            openModal();
        }

        document.getElementById('addServiceBtn').addEventListener('click', openAddModal);

        const emptyBtn = document.getElementById('addServiceBtnEmpty');
        if (emptyBtn) emptyBtn.addEventListener('click', openAddModal);

        /* ── Edit service ─────────────────────────────── */
        function openModalWithData(btn) {
            modalTitle.textContent = 'Edit Service';
            editForm.elements['name'].value        = btn.dataset.title       || '';
            editForm.elements['schedule'].value    = btn.dataset.schedule    || '';
            editForm.elements['fee'].value         = btn.dataset.fee         || '0';
            editForm.elements['is_free'].checked   = btn.dataset.isFree === '1';
            editForm.elements['description'].value = btn.dataset.description || '';
            editForm.action   = `/admin/services/${btn.dataset.id}`;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            openModal();
        }

        function attachEditListeners() {
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', () => openModalWithData(btn));
            });
        }
        attachEditListeners();

        /* ── Close triggers ───────────────────────────── */
        document.getElementById('cancelEdit').addEventListener('click', closeModal);
        document.getElementById('cancelEditBtn').addEventListener('click', closeModal);
        document.getElementById('modalBackdrop').addEventListener('click', closeModal);
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

        editForm.addEventListener('submit', e => { e.preventDefault(); editForm.submit(); });

        /* ── Payment actions ──────────────────────────── */
        async function confirmPayment(id) {
            if (!confirm('Confirm this payment? This will mark the registration as paid.')) return;
            try {
                const res  = await fetch(`/admin/service-registrations/${id}/confirm-payment`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const data = await res.json();
                if (data.success) { showToast('Payment confirmed!', 'success'); setTimeout(() => location.reload(), 1200); }
                else showToast(data.message || 'Failed to confirm payment.', 'error');
            } catch { showToast('An error occurred.', 'error'); }
        }

        async function rejectPayment(id) {
            const reason = prompt('Reason for rejection (optional):');
            if (reason === null) return;
            try {
                const res  = await fetch(`/admin/service-registrations/${id}/reject-payment`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ reason })
                });
                const data = await res.json();
                if (data.success) { showToast('Payment rejected.', 'error'); setTimeout(() => location.reload(), 1200); }
                else showToast(data.message || 'Failed to reject payment.', 'error');
            } catch { showToast('An error occurred.', 'error'); }
        }

        /* ── Toast ────────────────────────────────────── */
        function showToast(msg, type) {
            const t = document.createElement('div');
            t.className = `fixed top-5 right-5 z-[100] flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-card-hover text-sm font-semibold border
                ${type === 'success'
                    ? 'bg-success/10 border-success/30 text-success'
                    : 'bg-secondary/10 border-secondary/30 text-secondary'}`;
            t.innerHTML = `
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    ${type === 'success'
                        ? '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                        : '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>'}
                </svg>
                <span>${msg}</span>`;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 3500);
        }

        window.confirmPayment = confirmPayment;
        window.rejectPayment  = rejectPayment;
    </script>

@endsection