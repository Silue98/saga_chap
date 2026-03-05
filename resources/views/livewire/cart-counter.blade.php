<div>
    {{-- Toast succès --}}
    @if($flashSuccess)
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => { show = false; $wire.clearFlash() }, 3000)"
             x-transition>
            <div class="toast show align-items-center text-bg-success border-0 shadow">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i>{{ $flashSuccess }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            wire:click="clearFlash"></button>
                </div>
            </div>
        </div>
    @endif

    {{-- Toast erreur --}}
    @if($flashError)
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => { show = false; $wire.clearFlash() }, 3000)"
             x-transition>
            <div class="toast show align-items-center text-bg-danger border-0 shadow">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $flashError }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            wire:click="clearFlash"></button>
                </div>
            </div>
        </div>
    @endif
</div>
