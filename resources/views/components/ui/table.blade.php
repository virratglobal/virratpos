<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto">
        <div class="py-2 align-middle inline-block min-w-full">
            <div class="shadow-none overflow-hidden border sm:rounded-xl bg-white" style="border-color: #E2E8F0;">
                <table class="min-w-full divide-y dataTable" style="border-color: #E2E8F0;">
                    @if(isset($head) && !empty((string) $head))
                        <thead style="background-color: #eff4ff;">
                            <tr>
                                {{ $head }}
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y" style="border-color: #E2E8F0;">
                            {{ $body ?? '' }}
                        </tbody>
                    @else
                        {{ $slot }}
                    @endif
                </table>
            </div>
            
            @if(isset($pagination))
                <div class="px-4 py-3 bg-white border-t sm:px-6" style="border-color: #E2E8F0;">
                    {{ $pagination }}
                </div>
            @endif
        </div>
    </div>
</div>
