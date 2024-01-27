<?php

use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'notes' => auth()->user()->notes()->orderBy('send_date', 'desc')->get(),
        ];
    }

    public function delete($id)
    {
        $note = \App\Models\Note::where('id', $id)->first();
        $this->authorize('delete', $note);
        $note->delete();
    }
}; ?>

<div>
    <div class="space-y-2">
        @if ($notes->isEmpty())
            <div class="text-center">
                <p class="text-xl font-bold">No notes yet</p>
                <p class="text-sm">Create your first note by clicking the button below.</p>
                <x-button primary href="{{ route('notes.create') }}" class="mt-6" label="Create Note" icon-right="plus"
                          wire:navigate/>
            </div>
        @else
            <x-button primary href="{{ route('notes.create') }}" class="mb-6" label="Create Note" icon-right="plus"
                      wire:navigate/>
            <div class="grid grid-cols-3 gap-4 mt-12">
                @foreach($notes as $note)
                    <x-card wire:key="{{$note->id}}">
                        <div class="flex justify-between">
                            <div>
                                <a href="{{route('notes.edit', $note)}}" wire:navigate
                                   class="text-xl font-bold hover:underline hover:text-blue-500">{{$note->title}}
                                </a>
                                <p class="mt-2 text-xs">{{ Str::limit($note->body) }}</p>
                            </div>
                            <div class="text-xs text-gray-500">
                                {{\Carbon\Carbon::parse($note->send_date)->format('d/m/Y')}}
                            </div>
                        </div>
                        <div class="flex items-end justify-between mt-4 space-x-1">
                            <p class="text-s">Recipient <span class="font-semibold">{{ $note->recipient }}</span></p>
                            <div>
                                <x-button.circle icon="eye"></x-button.circle>
                                <x-button.circle icon="trash" wire:click="delete('{{$note->id}}')"></x-button.circle>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @endif
    </div>
</div>
