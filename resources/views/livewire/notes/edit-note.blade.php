<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Note;

new #[Layout('layouts.app')] class extends Component {
    public Note $note;

    public $noteTitle;
    public $noteBody;
    public $noteRecipient;
    public $noteSendDate;
    public $noteIsPublished;

    public function mount(Note $note)
    {
        $this->authorize('update', $note);
        $this->fill($note);
        $this->note = $note;
        $this->noteTitle = $note->title;
        $this->noteBody = $note->body;
        $this->noteRecipient = $note->recipient;
        $this->noteSendDate = $note->send_date;
        $this->noteIsPublished = $note->is_published;
    }

    public function saveNote()
    {
        $this->validate([
            'noteTitle' => ['required', 'string', 'min:5'],
            'noteBody' => ['required', 'string', 'min:20'],
            'noteRecipient' => ['required', 'email'],
            'noteSendDate' => ['required', 'date'],
            'noteIsPublished' => ['required', 'boolean'],
        ]);

        $this->note->update([
            'title' => $this->noteTitle,
            'body' => $this->noteBody,
            'recipient' => $this->noteRecipient,
            'send_date' => $this->noteSendDate,
            'is_published' => $this->noteIsPublished
        ]);

        $this->dispatch('note-saved');
    }
}; ?>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Note') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 text-gray-900">
            <div>
                <form wire:submit="saveNote" class="space-y-4">
                    <x-input wire:model="noteTitle" label="Title" placeholder="It's been a great day"/>
                    <x-textarea wire:model="noteBody" label="Your note" placeholder="Share all your thoughts with your friend!"/>
                    <x-input wire:model="noteRecipient" label="Recipient" placeholder="yourfriend@email.com" type="email" icon="mail"/>
                    <x-input wire:model="noteSendDate" type="date" label="Send Date" icon="calendar"/>
                    <x-checkbox label="Note is published" wire:model="noteIsPublished"/>
                    <div class="flex justify-between pt-4">
                        <x-button type="submit" secondary spinner="saveNote">Save</x-button>
                        <x-button secondary href="{{ route('notes.index') }}" flat negative label="Back to Notes"/>
                    </div>
                    <x-errors/>
                </form>
            </div>
            <x-action-message on="note-saved" type="success">
                Note saved!
            </x-action-message>
        </div>
    </div>
</div>
