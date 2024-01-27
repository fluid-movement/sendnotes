<?php

use Livewire\Volt\Component;

new class extends Component {
    public $noteTitle;
    public $noteBody;
    public $noteRecipient;
    public $noteSendDate;

    public function submit()
    {
        $this->validate([
            'noteTitle' => ['required', 'string', 'min:5'],
            'noteBody' => ['required', 'string', 'min:20'],
            'noteRecipient' => ['required', 'email'],
            'noteSendDate' => ['required', 'date'],
        ]);

        auth()->user()->notes()->create([
            'title' => $this->noteTitle,
            'body' => $this->noteBody,
            'recipient' => $this->noteRecipient,
            'send_date' => $this->noteSendDate,
            'is_published' => true
        ]);

        redirect(route('notes.index'));
    }
}; ?>

<div>
    <form wire:submit="submit" class="space-y-4">
        <x-input wire:model="noteTitle" label="Title" placeholder="It's been a great day"/>
        <x-textarea wire:model="noteBody" label="Your note" placeholder="Share all your thoughts with your friend!"/>
        <x-input wire:model="noteRecipient" label="Recipient" placeholder="yourfriend@email.com" type="email" icon="mail"/>
        <x-input wire:model="noteSendDate" type="date" label="Send Date" icon="calendar"/>
        <div class="pt-4">
            <x-button wire:click="submit" primary right-icon="calendar" spinner>Submit</x-button>
        </div>
        <x-errors/>
    </form>
</div>
