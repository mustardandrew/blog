<div class="flex items-center space-x-3">
    <div class="relative {{ $this->getSizeClasses() }} bg-gray-100 rounded-full overflow-hidden">
        <img 
            src="{{ $user->getAvatarUrl() }}" 
            alt="{{ $user->name }}'s avatar"
            class="w-full h-full object-cover"
            loading="lazy"
        >
    </div>
    
    @if($showName)
        <div class="flex flex-col">
            <span class="font-medium text-gray-900 dark:text-gray-100 {{ $this->getTextSizeClasses() }}">
                {{ $user->name }}
            </span>
            <span class="text-gray-500 dark:text-gray-400 text-sm">
                {{ $user->email }}
            </span>
        </div>
    @endif
</div>
