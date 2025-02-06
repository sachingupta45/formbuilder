<x-admin-layout>
    <section class="section">
            <div class="py-12">
                <div  class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-pink-200 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6  border-b border-gray-200 text-black">
                            <div id="fb-editor"></div>
                        </div>
                    </div>
                </div>
            </div>
      </section>
      
    @push('particular-scripts')
    
    @include('scripts.admin.add_form')
    @endpush
</x-admin-layout>
