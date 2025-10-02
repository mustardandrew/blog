<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('home') }}" wire:navigate>Home</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Settings</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Appearance</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    
    <!-- Page Title -->
    <div class="mb-8">
        <flux:heading size="xl">Appearance Settings</flux:heading>
    </div>
    
    <!-- Main content -->
    <div class="flex gap-6">
        <!-- Sidebar -->
        <x-dashboard-sidebar />

        <!-- Content Area -->
        <div class="flex-1 space-y-6">
            @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading=" __('Update the appearance settings for your account')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
            </flux:radio.group>
        </x-settings.layout>
        </div>
    </div>
</div>
