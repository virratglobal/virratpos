<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow-none overflow-hidden border border-gray-200 sm:rounded-md bg-white">
                <table class="min-w-full divide-y divide-gray-200 dataTable !mb-0">
                    @if(isset($head) && !empty((string) $head))
                        <thead class="bg-gray-50">
                            <tr>
                                {{ $head }}
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{ $body ?? '' }}
                        </tbody>
                    @else
                        {{ $slot }}
                    @endif
                </table>
            </div>
            
            @if(isset($pagination))
                <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    {{ $pagination }}
                </div>
            @endif
        </div>
    </div>
</div>
