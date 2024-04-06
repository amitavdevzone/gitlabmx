@php use App\Services\UtilService; @endphp
<div class="flex">
    <div class="w-2/3 bg-white rounded-md shadow-md p-6">
        <div class="pb-8">
            <div class="mb-2 flex items-center">
                <div>
                    <h2 class="font-bold text-xl">#{{ $issue->internal_id }} {{ $issue->title }}</h2>
                </div>
                <div class="material-symbols-outlined ml-2 hover:text-purple-700">
                    <a href="{{ route('time-entries.create', ['issue_id' => $issue->id]) }}" target="_blank">schedule</a>
                </div>
            </div>
            <div class="flex items-center">
                <div class="badge badge-primary text-white rounded-xl">{{ $issue->state }}</div>
                <div class="ml-4">Issue created {{ $issue->created_at->diffForHumans() }} by Amitav Roy</div>
            </div>
        </div>

        <div class="issue-content">
            <x-markdown>{{ $issue->description }}</x-markdown>
        </div>
    </div>
    <div class="w-1/3 bg-white rounded-md shadow-md ml-2 p-6">
        @if($issue->time_entries_sum_time)
            <div class="pb-4 border-b">
                <div class="mb-2">
                    <h2 class="font-bold text-xl">Ticket details</h2>
                </div>
                <div class="flex">
                    <h3 class="text-l mr-4">Total time spent:</h3>
                    <span>{{ UtilService::timeInHours($issue->time_entries_sum_time) }} hours</span>
                </div>
            </div>
        @endif
        <div>
            <div class="mb-2 pt-4">
                <h2 class="font-bold text-xl">For Estimate</h2>
            </div>
            <label>
                <select wire:model.live="estimateId" name="client_id" class="select border-2 w-full rounded shadow px-2 py-2">
                    <option value="">Select option</option>
                    @foreach($estimates as $estimate)
                        <option
                            {{ $issue->estimate_id == $estimate->id ? 'selected': '' }}
                            value="{{ $estimate->id }}">{{ $estimate->title }}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>
</div>
