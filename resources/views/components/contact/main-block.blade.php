@props(["src"])

<div>
    <div {{ $attributes->merge(["class" => "flex flex-col gap-y-4 items-center"]) }} >

        <!-- Logo -->
        <img src="{{ $src }}" alt="..." class="w-[400px] h-auto">
    
        <div class="flex gap-x-4">
            {{ $slot }}
        </div>
    </div>
</div>